<?php

namespace Lunia\Auditoria\Services\Auditoria;

use DateTime;
use Lunia\Auditoria\Exceptions\RangoDeFechasNoValidoException;
use Lunia\Auditoria\Repositories\Auditoria\AuditoriaRepository;

class ArchivaRegistrosAuditoria
{

    private AuditoriaRepository $auditoriaRepository;

    public function __construct(AuditoriaRepository $auditoriaRepository)
    {
        $this->auditoriaRepository = $auditoriaRepository;
    }

    public function handle(ArchivaRegistrosAuditoriaRequest $archivaRegistrosAuditoriaRequest)
    {
        if (!$this->validateDate($archivaRegistrosAuditoriaRequest->fechaDesde()) || !$this->validateDate($archivaRegistrosAuditoriaRequest->fechaHasta())) {
            throw new \InvalidArgumentException();
        }

        if($archivaRegistrosAuditoriaRequest->fechaHasta() < $archivaRegistrosAuditoriaRequest->fechaDesde()){
            throw new RangoDeFechasNoValidoException();
        }

        $this->auditoriaRepository->borrar($archivaRegistrosAuditoriaRequest->fechaDesde(), $archivaRegistrosAuditoriaRequest->fechaHasta());

    }

    private function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}