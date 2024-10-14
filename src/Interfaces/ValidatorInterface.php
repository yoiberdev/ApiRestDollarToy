<?php

namespace app\Interfaces;

interface ValidatorInterface
{
    public function getError(): string;
    public function validateAdd(array $data): bool;
    public function validateUpdate(array $data): bool;
}