<?php

namespace Lunia\Auditoria\Tests;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Lunia\Auditoria\Providers\AuditoriaApplicationServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp():void
    {
        parent::setUp();
        $this->artisan('migrate', [
            '--realpath' =>realpath(__DIR__.'/../database/migrations'),
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [AuditoriaApplicationServiceProvider::class];
    }
}
