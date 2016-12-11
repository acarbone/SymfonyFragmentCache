<?php
/*
 * This file is part of the FragmentCache package.
 *
 * (c) Alessandro Carbone <ale.carbo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FragmentCache\Cache;

use FragmentCache\Cache\CacheInterface;
use Stash\Interfaces\PoolInterface;

/**
 * Cache Pool storage
 *
 * @author Alessandro Carbone <ale.carbo@gmail.com>
 */
class Cache implements CacheInterface {

    /**
     * @var Stash\Interfaces\PoolInterface
     */
    protected $cache;

    /**
     * Initializer
     *
     * @param Stash\Interfaces\PoolInterface $cache
     */
    public function __construct(PoolInterface $cache) {
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key) {
        $item = $this->getItem($key);
        if ( $item->isMiss() )
            return false;

        return $item->get();
    }

    /**
     * Retrive entry from the cache
     *
     * @param string $key The key of the entry
     *
     * @return mixed
     */
    protected function getItem($key) {
        return $this->cache->getItem($key);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value) {
        $item = $this->getItem($key);
        $item->set($value);
        return $value;
    }
}