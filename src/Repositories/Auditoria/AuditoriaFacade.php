<?php

namespace Lunia\Auditoria\Repositories\Auditoria;

use Illuminate\Support\Facades\Facade;

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
