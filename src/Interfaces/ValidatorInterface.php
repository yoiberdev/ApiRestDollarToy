<?php

namespace app\Interfaces;

interface ValidatorInterface
{
    public function getError(): string;
    public function validateFind(array $data): bool;
    public function validateAdd(array $data): bool;
    public function validateUpdate(array $data): bool;
    public function validateId(?int $id): bool;
}