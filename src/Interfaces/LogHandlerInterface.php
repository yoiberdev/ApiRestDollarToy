<?php

namespace app\Interfaces;

interface LogHandlerInterface
{
    public function write(string $message): void;
    public function close(): void;
}