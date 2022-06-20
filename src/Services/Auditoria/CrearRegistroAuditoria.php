<?php

namespace Lunia\Auditoria\Services\Auditoria;

use Lunia\Auditoria\Repositories\Auditoria\AuditoriaRepository;

class CrearRegistroAuditoria
{
    private AuditoriaRepository $auditoriaRepository;

    public function __construct(AuditoriaRepository $auditoriaRepository)
    {
        $this->auditoriaRepository = $auditoriaRepository;
    }

    public function handle(CrearRegistroAuditoriaRequest $crearRegistroAuditoriaRequest): void
    {

    }
}