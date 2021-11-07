<?php

declare(strict_types=1);

namespace Tests\Acceptance;

use GuzzleHttp\Client;

class WebApp
{
    private $host;
    private $entryPoint;

    private static $localWebServerId = null;

    public function __construct(string $host, string $entryPoint)
    {
        $this->host = $host;
        $this->entryPoint = $entryPoint;
    }

    public function startWebServer()
    {
        if ($this->isRunning()) {
            return;
        }

        $this->launchWebServer();
        $this->waitUntilWebServerAcceptsRequests();
        $this->stopWebserverOnShutdown();
    }

    private function isRunning(): bool
    {
        return isset(self::$localWebServerId);
    }

    private function launchWebServer()
    {
        $command = sprintf(
            'php -S %s -t %s >/dev/null 2>&1 & echo $!',
            $this->host,
            __DIR__ . '/../../' . $this->entryPoint
        );

        $output = array();
        exec($command, $output);
        self::$localWebServerId = (int)$output[0];
    }

    private function waitUntilWebServerAcceptsRequests()
    {
        exec('bash ' . __DIR__ . '/wait-for-it.sh ' . $this->host);
    }

    private function stopWebServerOnShutdown()
    {
        register_shutdown_function(function () {
            exec('kill ' . self::$localWebServerId);
        });
    }

    public function makeClient(): Client
    {
        return new Client(
            [
                'base_uri' => 'http://' . $this->host,
                'http_errors' => false,
            ]
        );
    }
}