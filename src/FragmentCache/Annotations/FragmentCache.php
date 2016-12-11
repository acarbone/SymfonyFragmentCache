<?php
/*
 * This file is part of the FragmentCache package.
 *
 * (c) Alessandro Carbone <ale.carbo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FragmentCache\Annotations;

/**
 * @Annotation
 *
 * @author Alessandro Carbone <ale.carbo@gmail.com>
 */
class FragmentCache {
    public $cacheFragment = true;
}