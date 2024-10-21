<?php

namespace app\Helpers;

use app\Interfaces\LogHandlerInterface;

class FileLogHandler implements LogHandlerInterface
{
    private $logFile;

    public function __construct($filePath = null)
    {
        if ($filePath === null) {
            $filePath = 'logs/' . date('Y-m-d') . '-log.txt';
        }

        $logDir = dirname($filePath);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $this->logFile = fopen($filePath, 'a');
    }

    public function write(string $message): void
    {
        fputs($this->logFile, $message . "\n");
    }

    public function close(): void
    {
        fclose($this->logFile);
    }
}
