<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteCapaController implements RequestHandlerInterface
{
    public function __construct(private VideoRepository $repository)
    {
    }
    public function handle(ServerRequestInterface $request):ResponseInterface
    {
        // TODO: Implement handle() method.
        $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
        if($id === false || $id === null){
            header('Location: /?sucess=0');
        }
        $sucess = $this->repository->removeCapa($id);
        if ($sucess === false){
            header('Location: /?sucess=0');
        }
        else{
            unlink( __DIR__ . '/../../public/img/uploads/' . $_FILES['image']['name']);
            header('Location: /?sucess=1');
        }
    }
}