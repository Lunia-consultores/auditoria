<?php

namespace Lunia\Auditoria\Services\Auditoria;

class ArchivaRegistrosAuditoriaRequest
{
    private $fechaDesde;
    private $fechaHasta;

    /**
     * @param $fechaDesde
     * @param $fechaHasta
     */
    public function __construct($fechaDesde, $fechaHasta)
    {
        $this->fechaDesde = $fechaDesde;
        $this->fechaHasta = $fechaHasta;
    }

    /**
     * @return mixed
     */
    public function fechaDesde()
    {
        return $this->fechaDesde;
    }

    /**
     * @return mixed
     */
    public function fechaHasta()
    {
        return $this->fechaHasta;
    }



}