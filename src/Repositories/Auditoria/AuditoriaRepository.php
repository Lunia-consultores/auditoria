<?php

namespace Lunia\Auditoria\Repositories\Auditoria;

use Illuminate\Database\DatabaseManager;

class AuditoriaRepository
{

    private DatabaseManager $db;
    private string $tabla;

    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
        $this->tabla = 'auditoria';
    }

    public function create(Auditoria $auditoria): Auditoria
    {
        $this->db->table($this->tabla)->insert([
            'id' => $auditoria->id(),
            'accion' => $auditoria->accion(),
            'query' => $auditoria->query(),
            'usuarioId' => $auditoria->usuarioId(),
            'url' => $auditoria->url(),
            'payload' => json_encode($auditoria->payload()),
            'tabla' => $auditoria->tabla(),
            'createdAt' => $auditoria->createdAt(),
            'updatedAt' => $auditoria->updatedAt(),
        ]);

        $auditoriaCreada = $this->db->table($this->tabla)->find($auditoria->id());
    }
}