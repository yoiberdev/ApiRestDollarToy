<?php

namespace app\Controllers;

use app\Business\Rol\RolAdd;
use app\Business\Rol\RolGet;
use app\Business\Rol\RolUpdate;
use app\Business\Rol\RolDelete;
use app\Data\RolRepository;
use app\Validators\RolValidator;

class RolController
{
    private RolAdd $create;
    private RolGet $get;
    private RolUpdate $update;
    private RolDelete $delete;

    public function __construct(
        RolAdd $create,
        RolGet $get,
        RolUpdate $update,
        RolDelete $delete
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
                return json_encode(['message' => 'Rol creado exitosamente', 'data' => $result]);

            case 'update':
                $result =$this->update->updateById($data['id'], $data);
                return json_encode(['message' => $result]);

            case 'delete':
                $this->delete->deleteById($data['id']);
                return json_encode(['message' => 'Rol eliminado exitosamente']);

            default:
                return json_encode(['error' => 'Método no soportado']);
        }
    }

    public static function createInstance(): self
    {
        $repository = new RolRepository();
        $validator = new RolValidator();

        return new self(
            new RolAdd($repository, $validator),
            new RolGet($repository, $validator),
            new RolUpdate($repository, $validator),
            new RolDelete($repository)
        );
    }
}
