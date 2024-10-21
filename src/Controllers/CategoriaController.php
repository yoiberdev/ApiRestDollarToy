<?php
namespace app\Controllers;

use app\Business\Categoria\CategoriaAdd;
use app\Business\Categoria\CategoriaGet;
use app\Business\Categoria\CategoriaUpdate;
use app\Business\Categoria\CategoriaDelete;
use app\Data\CategoriaRepository;
use app\Mail\Mailer;
use app\Validators\CategoriaValidator;

class CategoriaController
{
    private CategoriaAdd $create;
    private CategoriaGet $get;
    private CategoriaUpdate $update;
    private CategoriaDelete $delete;
    private Mailer $mailer;

    public function __construct(
        CategoriaAdd $create,
        CategoriaGet $get,
        CategoriaUpdate $update,
        CategoriaDelete $delete,
        Mailer $mailer
    ) {
        $this->create = $create;
        $this->get = $get;
        $this->update = $update;
        $this->delete = $delete;
        $this->mailer = $mailer;
    }

    public function handleRequest(string $method, array $data): string
    {
        switch ($method) {
            case 'find':
                $result = $this->get->find($data);
                return json_encode($result);

            case 'create':
                $result = $this->create->add($data);
                $sendMail =$this->sendEmailNotification(['nombre' => $data['nombre']]);
                return json_encode(['message' => 'Categoria creado exitosamente', 'data' => $result, 'sendMail' => $sendMail]);

            case 'update':
                $result =$this->update->updateById($data['id'], $data);
                return json_encode(['message' => $result]);

            case 'delete':
                $this->delete->deleteById($data['id']);
                return json_encode(['message' => 'Categoria eliminado exitosamente']);

            default:
                return json_encode(['error' => 'Método no soportado']);
        }
    }

    private function sendEmailNotification(array $data): ?bool
    {
        $to = '1476324@senati.pe';
        $subject = 'Nueva categoria creado';
        $body = 'Se ha creado una nueva categoria: ' . $data['nombre'];

        return $this->mailer->sendEmail($to, $subject, $body);
    }

    public static function createInstance(): self
    {
        $repository = new CategoriaRepository();
        $validator = new CategoriaValidator();
        $mailer = new Mailer();

        return new self(
            new CategoriaAdd($repository, $validator),
            new CategoriaGet($repository, $validator),
            new CategoriaUpdate($repository, $validator),
            new CategoriaDelete($repository),
            $mailer
        );
    }
}