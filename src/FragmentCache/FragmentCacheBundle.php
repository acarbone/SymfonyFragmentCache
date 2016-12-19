<?php

namespace FragmentCache;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use FragmentCache\DependencyInjection\FragmentCacheExtension;

/**
 * Bundle.
 *
 * @author Josh Hall-Bachner <jhallbachner@gmail.com>
 */
class FragmentCacheBundle extends Bundle
{

    public function getContainerExtension()
    {
        return new FragmentCacheExtension();
    }
}
