<?php

namespace Lunia\Auditoria\Services\Auditoria;

use Lunia\Auditoria\Repositories\Auditoria\Auditoria;

class CrearRegistroAuditoriaRequest
{
    public $query;
    public $usuarioId;
    public $url;
    public $payload;

    public function __construct($query, $usuarioId, $url, $payload)
    {
        $this->query = $query;
        $this->usuarioId = $usuarioId;
        $this->url = $url;
        $this->payload = $payload;
    }
}