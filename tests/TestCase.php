<?php
namespace Lunia\Auditoria\Tests;

use Orchestra\Testbench\Concerns\CreatesApplication;
use \PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
