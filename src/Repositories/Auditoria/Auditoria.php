<?php

namespace Lunia\Auditoria\Repositories\Auditoria;

use DateTime;

class Auditoria
{
    private string $id;
    private string $accion;
    private string $query;
    private string $usuarioId;
    private string $url;
    private array $payload;
    private string $tabla;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(string $id, string $accion, string $query, string $usuarioId, string $url, array $payload,
                                string $tabla)
    {
        $this->id = $id;
        $this->accion = $accion;
        $this->query = $query;
        $this->usuarioId = $usuarioId;
        $this->url = $url;
        $this->payload = $payload;
        $this->tabla = $tabla;
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function accion(): string
    {
        return $this->accion;
    }

    public function query(): string
    {
        return $this->query;
    }

    public function usuarioId(): string
    {
        return $this->usuarioId;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function payload(): array
    {
        return $this->payload;
    }

    public function tabla(): string
    {
        return $this->tabla;
    }

    public function updatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }
}
