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

/**
 * Cache Spool interface.
 * Grouping all cached result to abstract actual cache layer.
 *
 * @author Alessandro Carbone <ale.carbo@gmail.com>
 */
interface CacheInterface {

    /**
     * Retrive entry from the cache.
     *
     * @param string $key The key of the entry
     *
     * @return mixed
     */
    public function get($key);

    /**
     * Store entry in the cache.
     *
     * @param string $key The key of the entry
     * @param mixed $value The value of the entry
     *
     * @return mixed The stored value
     */
    public function set($key, $value);
}