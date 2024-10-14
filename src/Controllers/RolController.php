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
            case 'create':
                $result = $this->create->add($data);
                return json_encode(['message' => 'Rol creado exitosamente', 'data' => $result]);

            case 'get':
                $result = $this->get->getAll();
                return json_encode($result);

            case 'getById':
                $result = $this->get->getById($data['id']);
                if ($result === null) {
                    return json_encode(['error' => 'Rol no encontrado']);
                }
                return json_encode($result);

            case 'update':
                $this->update->updateById($data['id'], $data);
                return json_encode(['message' => 'Rol actualizado exitosamente']);

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
            new RolGet($repository),
            new RolUpdate($repository, $validator),
            new RolDelete($repository)
        );
    }
}
