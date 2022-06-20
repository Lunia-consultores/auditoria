<?php

namespace Lunia\Auditoria\Services\Auditoria;

use Lunia\Auditoria\Repositories\Auditoria\Auditoria;
use Lunia\Auditoria\Repositories\Auditoria\AuditoriaRepository;
use Ramsey\Uuid\Uuid;

class CrearRegistroAuditoria
{
    private AuditoriaRepository $auditoriaRepository;

    public function __construct(AuditoriaRepository $auditoriaRepository)
    {
        $this->auditoriaRepository = $auditoriaRepository;
    }

    /**
     * @param CrearRegistroAuditoriaRequest $crearRegistroAuditoriaRequest
     * @return Auditoria|void
     */
    public function handle(CrearRegistroAuditoriaRequest $crearRegistroAuditoriaRequest)
    {
        $query = strtolower($crearRegistroAuditoriaRequest->query);
        $accion = null;
        $tablaExtraida = null;

        if (str_contains($query, 'insert into')) {
            $accion = 'INSERT';
            $tabla = trim(str_replace('insert into', '', $query));
        } else if (str_contains($query, 'update')) {
            $accion = 'UPDATE';
            $tabla = trim(str_replace('update', '', $query));
        } else if (str_contains($query, 'delete')) {
            $accion = 'DELETE';
            $tabla = trim(str_replace('delete from', '', $query));
        }

        if (!is_null($accion) && !is_null($tablaExtraida)) {
            $tablaExtraida = explode(' ', $tabla);

            $auditoria = $this->auditoriaRepository->create(new Auditoria(
                Uuid::uuid4(),
                $accion,
                $query,
                $crearRegistroAuditoriaRequest->usuarioId,
                $crearRegistroAuditoriaRequest->url,
                $crearRegistroAuditoriaRequest->payload,
                $tablaExtraida[0],
            ));
            return $auditoria;
        }
    }
}