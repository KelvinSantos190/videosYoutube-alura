<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\HtmlRendererTrait;
use Alura\Mvc\Repository\VideoRepository;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoFormController implements RequestHandlerInterface
{
    use HtmlRendererTrait;
    public function __construct(private VideoRepository $repository, private Engine $templates)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $id = filter_input($queryParams['url'], FILTER_VALIDATE_INT);

        $video = null;
        if ($id !== false && $id !== null) {
            $video= $this->repository->find($id);
        }
        return new Response(
            302,
            body: $this->templates->render('video-form',['video' => $video])
        );
    }
}