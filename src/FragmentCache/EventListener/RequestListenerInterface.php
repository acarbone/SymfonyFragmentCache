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

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Request Listener Interface.
 * Representation of the request and response event listener.
 *
 * @author Alessandro Carbone <ale.carbo@gmail.com>
 */
interface RequestListenerInterface {

    /**
     * Controller calls filter.
     * This method gets called every time that a controller's action is requested.
     * Responsibility is to identify the requests to be interpreted as FragmentCache.
     *
     * @param Symfony\Component\HttpKernel\Event\FilterControllerEvent $event
     * @return void
     */
    public function onKernelController(FilterControllerEvent $event);

    /**
     * Responses filter.
     * This method gets called every time that a response is returned.
     * Responsibility is to identify the responses to be retrieved from the cache.
     *
     * @param Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
     * @return void
     */
    public function onKernelResponse(FilterResponseEvent $event);
}