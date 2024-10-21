<?php

namespace app\Controllers;

use app\Business\Sede\SedeAdd;
use app\Business\Sede\SedeGet;
use app\Business\Sede\SedeUpdate;
use app\Business\Sede\SedeDelete;
use app\Data\SedeRepository;
use app\Validators\SedeValidator;

class SedeController
{
    private SedeAdd $create;
    private SedeGet $get;
    private SedeUpdate $update;
    private SedeDelete $delete;

    public function __construct(
        SedeAdd $create,
        SedeGet $get,
        SedeUpdate $update,
        SedeDelete $delete
    ) {
        $this->create = $create;
        $this->get = $get;
        $this->update = $update;
        $this->delete = $delete;
    }

    public function handleRequest(string $method, array $data): string
    {
        switch ($method) {
            case 'find':
                $result = $this->get->find($data);
                return json_encode($result);

            case 'create':
                $result = $this->create->add($data);
                return json_encode(['message' => 'Sede creado exitosamente', 'data' => $result]);

            case 'update':
                $result =$this->update->update($data['id'], $data);
                return json_encode(['message' => $result]);

            case 'delete':
                $this->delete->deleteById($data['id']);
                return json_encode(['message' => 'Sede eliminado exitosamente']);

            default:
                return json_encode(['error' => 'Método no soportado']);
        }
    }

    public static function createInstance(): self
    {
        $repository = new SedeRepository();
        $validator = new SedeValidator();

        return new self(
            new SedeAdd($repository, $validator),
            new SedeGet($repository, $validator),
            new SedeUpdate($repository, $validator),
            new SedeDelete($repository)
        );
    }
}