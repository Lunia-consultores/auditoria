<?php

namespace Lunia\Auditoria\Tests\Services\Auditoria;

use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Lunia\Auditoria\Services\Auditoria\CrearRegistroAuditoria;
use Lunia\Auditoria\Services\Auditoria\CrearRegistroAuditoriaRequest;
use Lunia\Auditoria\Tests\TestCase;
use Ramsey\Uuid\Uuid;

class CrearRegistroAuditoriaTest extends TestCase
{
    private CrearRegistroAuditoria $crearRegistroAuditoria;
    private mixed $db;

    protected function setUp(): void
    {
        parent::setUp();
        $this->crearRegistroAuditoria = app()->make(CrearRegistroAuditoria::class);
        $this->db = app()->make(DatabaseManager::class);
    }

    public function testPrueba(): void
    {
        $usuarioId = Uuid::uuid4();

        $auditoria = $this->crearRegistroAuditoria->handle(new CrearRegistroAuditoriaRequest(
            'insert into my_table (id) values(?);',
            $usuarioId,
            'http://localhost/manolo',
            [$usuarioId]
        ));

        $auditoria = $this->db->table('auditoria')->first();
        $this->assertNotNull($auditoria);
    }

}
