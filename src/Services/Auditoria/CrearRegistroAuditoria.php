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

        if (str_contains($query, 'insert into')) {
            $accion = 'INSERT';
            $tabla = trim(str_replace('insert into', '', $query));
            $queryFormateadaEnArray = explode(' ', $tabla);
        } else if (str_contains($query, 'update ')) {
            $accion = 'UPDATE';
            $tabla = trim(str_replace('update', '', $query));
            $queryFormateadaEnArray = explode(' ', $tabla);
        } else if (str_contains($query, 'delete')) {
            $accion = 'DELETE';
            $tabla = trim(str_replace('delete from', '', $query));
            $queryFormateadaEnArray = explode(' ', $tabla);
        } else {
            return;
        }
        
        $tablaExtraida = str_replace('`',"", str_replace('"','',$queryFormateadaEnArray[0]));

        if(in_array($tablaExtraida,['auditoria','migrations']) === true){
            return;
        }

        if (!is_null($accion) && !is_null($queryFormateadaEnArray)) {

            if (in_array($tablaExtraida, $crearRegistroAuditoriaRequest->excludedTables)) {
                return;
            }

            $auditoria = $this->auditoriaRepository->create(new Auditoria(
                Uuid::uuid4(),
                $accion,
                $query,
                $crearRegistroAuditoriaRequest->usuarioId,
                $crearRegistroAuditoriaRequest->url,
                $crearRegistroAuditoriaRequest->payload,
                $tablaExtraida,
            ));
            return $auditoria;
        }
    }
}