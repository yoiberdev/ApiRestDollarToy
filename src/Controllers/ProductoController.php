<?php

namespace app\Controllers;

use app\Business\Producto\ProductoAdd;
use app\Business\Producto\ProductoGet;
use app\Business\Producto\ProductoUpdate;
use app\Business\Producto\ProductoDelete;
use app\Data\CategoriaRepository;
use app\Data\ProductoRepository;
use app\Data\SedeRepository;
use app\Mail\Mail;
use app\Mail\Mailer;
use app\Validators\ProductoValidator;

class ProductoController
{
    public function __construct(
        private ProductoAdd $create,
        private ProductoGet $get,
        private ProductoUpdate $update,
        private ProductoDelete $delete,
        private Mailer $mailer
    ) {}

    public function handleRequest(string $method, array $data): string
    {
        switch ($method) {
            case 'find':
                $result = $this->get->find($data);
                return json_encode($result);

            case 'create':
                $result = $this->create->add($data);
                $this->sendEmailNotification($data);
                return json_encode(['message' => 'Producto creado exitosamente', 'data' => $result]);

            case 'update':
                $result = $this->update->updateById($data['id'], $data);
                return json_encode(['message' => $result]);

            case 'delete':
                $this->delete->deleteById($data['id']);
                return json_encode(['message' => 'Producto eliminado exitosamente']);

            default:
                return json_encode(['error' => 'Método no soportado']);
        }
    }

    private function sendEmailNotification(array $data): void
    {
        $to = '1476324@senati.pe';
        $subject = 'Nuevo producto creado';
        $body = 'Se ha creado un nuevo producto: ' . $data['nombre'];

        $this->mailer->sendEmail($to, $subject, $body);
    }

    public static function createInstance(): self
    {
        $repository = new ProductoRepository();
        $validator = new ProductoValidator();
        $categoria = new CategoriaRepository();
        $sede = new SedeRepository();
        $productoGet = new ProductoGet($repository, $validator);

        return new self(
            new ProductoAdd($repository, $validator, $categoria, $sede),
            new ProductoGet($repository, $validator),
            new ProductoUpdate($repository, $validator, $categoria, $productoGet, $sede),
            new ProductoDelete($repository),
            new Mailer()
        );
    }
}
