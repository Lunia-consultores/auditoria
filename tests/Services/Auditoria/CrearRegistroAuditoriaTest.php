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
    private DatabaseManager $db;

    protected function setUp(): void
    {
        parent::setUp();
        $this->crearRegistroAuditoria = app()->make(CrearRegistroAuditoria::class);
        $this->db = app()->make(DatabaseManager::class);
    }

    public function testDebeCrearRegistroInsert(): void
    {
        $usuarioId = Uuid::uuid4();

        $auditoria = $this->crearRegistroAuditoria->handle(new CrearRegistroAuditoriaRequest(
            'insert into my_table (id) values(?);',
            $usuarioId,
            'http://localhost/manolo',
            [$usuarioId]
        ));

        $this->assertNotNull($auditoria);

        $this->assertEquals('INSERT', $auditoria->accion());
        $this->assertEquals('my_table', $auditoria->tabla());
        $this->assertEquals($usuarioId, $auditoria->usuarioId());
        $this->assertEquals([$usuarioId], $auditoria->payload());
    }

    public function testDebeCrearRegistroUpdate(): void
    {
        $usuarioId = Uuid::uuid4();

        $auditoria = $this->crearRegistroAuditoria->handle(new CrearRegistroAuditoriaRequest(
            'update equipamiento set "codigo" = ?, "descripcion" = ?, "ip_conexion" = ?, "usuario" = ?, "password" = ?, "puerto" = ?," equipamiento.updated_at" = ? where id = ?',
            $usuarioId,
            'http://localhost/manolo',
            [$usuarioId]
        ));

        $this->assertNotNull($auditoria);

        $this->assertEquals('UPDATE', $auditoria->accion());
        $this->assertEquals('equipamiento', $auditoria->tabla());
        $this->assertEquals($usuarioId, $auditoria->usuarioId());
        $this->assertEquals([$usuarioId], $auditoria->payload());
    }

    public function testDebeCrearRegistroDelete(): void
    {
        $usuarioId = Uuid::uuid4();

        $auditoria = $this->crearRegistroAuditoria->handle(new CrearRegistroAuditoriaRequest(
            'delete from equipamiento where id = ?',
            $usuarioId,
            'http://localhost/manolo',
            [$usuarioId]
        ));

        $this->assertNotNull($auditoria);

        $this->assertEquals('DELETE', $auditoria->accion());
        $this->assertEquals('equipamiento', $auditoria->tabla());
        $this->assertEquals($usuarioId, $auditoria->usuarioId());
        $this->assertEquals([$usuarioId], $auditoria->payload());
    }

    public function testDebeDevolverNullSiNoEsNingunaDeLasAccionesPermitidas(): void
    {
        $usuarioId = Uuid::uuid4();

        $auditoria = $this->crearRegistroAuditoria->handle(new CrearRegistroAuditoriaRequest(
            'select * from tabla',
            $usuarioId,
            'http://localhost/manolo',
            [$usuarioId]
        ));

        $this->assertNull($auditoria);
    }

}
