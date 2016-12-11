<?php
/*
 * This file is part of the FragmentCache package.
 *
 * (c) Alessandro Carbone <ale.carbo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FragmentCache\EventListener;

use Doctrine\Common\Annotations\Reader;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Response;

use FragmentCache\Cache\CacheInterface;
use FragmentCache\EventListener\RequestListenerInterface;

/**
 * Interpreting FragmentCache annotations and retrieve entries from cache, preventing method's execution.
 *
 * @author Alessandro Carbone <ale.carbo@gmail.com>
 */
class RequestListener implements RequestListenerInterface {
    /**
     * @var Doctrine\Common\Annotations\Reader
     *
     * Reader component for annotation retrieving.  
     */
    protected $reader;

    /**
     * @var FragmentCache\Cache\CacheInterface
     *
     * Reader component for annotation retrieving.  
     */
    protected $cache;

    /**
     * @var boolean
     *
     * Define the analyzed request/response interaction as cached or not.
     * If cached, the response is taken from cache.
     */
    protected $isCached = false;

    /**
     * @var boolean
     *
     * Define whether or not the action must be cached.
     */
    protected $toBeCached = false;

    /**
     * @var string
     *
     * Stored key for the actual request identified in the cache.
     * The key is composed by controller and methods name joined with ":"
     */
    protected $key;

    /**
     * @var array
     *
     * Container for methods set as FragmentCache items.
     */
    protected $info = [];

    /**
     * Initializing the driver.
     *
     * @param Doctrine\Common\Annotations\Reader $reader
     * @param FragmentCache\Cache\CacheInterface $cache
     * @return void
     */
    public function __construct(Reader $reader, CacheInterface $cache) {
        $this->reader = $reader;
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function onKernelController(FilterControllerEvent $event) {
        // If it's not a Controller request,
        // the getController method doesn't return an array.
        if (!is_array($controller = $event->getController()))
            return;

        // The getController method has returned ['controller-name', 'method-name'].
        $object = new \ReflectionObject($controller[0]);
        $method = $object->getMethod($controller[1]);

        // Analysis of method's annotations.
        foreach ($this->reader->getMethodAnnotations($method) as $annotation) {
            if (isset($annotation->cacheFragment)) {
                $this->key = $this->getKey($method);

                if ($this->cache->get($this->key) !== false) {
                    $event->setController(function() { return new Response(''); });
                    $this->isCached = true;
                } else {
                    $this->toBeCached = true;
                }
                //$this->info []= [$key];
             }
         }
    }

    /**
     * Retrieve key to be used for cache storage, from the given method.
     *
     * @param ReflectionMethod $method
     * @return string
     */
    protected function getKey(\ReflectionMethod $method) {
        return $method->class . ":" . $method->name;
    }

    /**
     * {@inheritdoc}
     */
    public function onKernelResponse(FilterResponseEvent $event) {
        if ($this->toBeCached) {
            $response = $event->getResponse();
            $this->cache->set($this->key, $response);
            $this->toBeCached = false;
        }

        if ($this->isCached === true) {
            $event->setResponse($this->cache->get($this->key));
            $this->isCached = false;
        }
    }
}