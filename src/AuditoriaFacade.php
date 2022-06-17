<?php

namespace Lunia\Auditoria;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Lunia\Auditoria\Skeleton\SkeletonClass
 */
class AuditoriaFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'auditoria';
    }
}
