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
        $this->db->connection(config('auditoria.db_connection'))->table($this->tabla)->insert([
            'id' => $auditoria->id(),
            'accion' => $auditoria->accion(),
            'query' => $auditoria->query(),
            'usuario_id' => $auditoria->usuarioId(),
            'url' => $auditoria->url(),
            'payload' => json_encode($auditoria->payload()),
            'tabla' => $auditoria->tabla(),
            'created_at' => $auditoria->createdAt(),
            'updated_at' => $auditoria->updatedAt(),
        ]);

        $auditoriaCreada = $this->db->table($this->tabla)->find($auditoria->id());

        return new Auditoria(
            $auditoriaCreada->id,
            $auditoriaCreada->accion,
            $auditoriaCreada->query,
            $auditoriaCreada->usuario_id,
            $auditoriaCreada->url,
            json_decode($auditoriaCreada->payload),
            $auditoriaCreada->tabla,
        );
    }

    public function borrar(string $fechaDesde, string $fechaHasta):void{
        $this->db->connection(config('auditoria.db_connection'))->table($this->tabla)->whereBetween('created_at',[$fechaDesde,$fechaHasta])->delete();
    }
}