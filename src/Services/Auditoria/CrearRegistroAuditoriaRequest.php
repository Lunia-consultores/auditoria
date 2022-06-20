<?php

namespace Lunia\Auditoria\Services\Auditoria;

use Lunia\Auditoria\Repositories\Auditoria\Auditoria;

class CrearRegistroAuditoriaRequest
{
    public $query;
    public $usuarioId;
    public $url;
    public $payload;
    public $excludedTables;

    public function __construct($query, $usuarioId, $url, $payload, $excludedTables)
    {
        $this->query = $query;
        $this->usuarioId = $usuarioId;
        $this->url = $url;
        $this->payload = $payload;
        $this->excludedTables = $excludedTables;
    }
}