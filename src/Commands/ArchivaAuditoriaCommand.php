<?php

namespace Lunia\Auditoria\Commands;

use Illuminate\Console\Command;
use Lunia\Auditoria\Services\Auditoria\ArchivaRegistrosAuditoria;
use Lunia\Auditoria\Services\Auditoria\ArchivaRegistrosAuditoriaRequest;

class ArchivaAuditoriaCommand extends Command
{
    protected $signature = 'auditoria:archiva-antiguos {fechaInicio} {fechaFin}';

    protected $description = 'Borrar registros antiguos entre dos fechas {fechaInicio}  {fechaFin}';
    private ArchivaRegistrosAuditoria $archivaRegistrosAuditoria;

    public function __construct(ArchivaRegistrosAuditoria $archivaRegistrosAuditoria)
    {
        parent::__construct();
        $this->archivaRegistrosAuditoria = $archivaRegistrosAuditoria;
    }

    public function handle(){
        $this->archivaRegistrosAuditoria->handle(
            new ArchivaRegistrosAuditoriaRequest(
                $this->argument('fechaInicio'),
                $this->argument('fechaFin')
            )
        );
    }
}