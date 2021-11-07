<?php

declare(strict_types=1);

namespace Tests\Acceptance;

use PHPUnit\Framework\TestCase;

class AcceptanceTestCase extends TestCase
{
    public const WEB_SERVER_HOST = '127.0.0.1:80';
    public const WEB_SERVER_ENTRYPOINT = __DIR__.'/../../public';

    public function setUp(): void
    {
        parent::setUp();
        $webServer = new WebApp(self::WEB_SERVER_HOST, self::WEB_SERVER_ENTRYPOINT);
        $webServer->startWebServer();
    }
}