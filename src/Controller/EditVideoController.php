<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EditVideoController implements RequestHandlerInterface
{
    use FlashMessageTrait;
    public function __construct(private VideoRepository $repository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $queryParsed = $request->getParsedBody();
        $id = filter_var($queryParams['id'],  FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            return new Response(
                302, [
                'Location' => '/'
            ]);
        }
        $url = filter_var($queryParsed['url'],  FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErrorMessage('URL inválida');
            return new Response(
                302, [
                'Location' => '/'
            ]);
        }
        $title = filter_input(INPUT_POST, 'title');
        if ($title === false) {
            $this->addErrorMessage('Titulo inválido');
            return new Response(
                302, [
                'Location' => '/'
            ]);
        }
        $video = new Video($url, $title);
        $video->setId($id);
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $safeFileName = uniqid('upload_') . '_' . pathinfo($_FILES['image']['name'], PATHINFO_BASENAME);
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($_FILES['image']['tmp_name']);
            if (str_starts_with($mimeType, 'image/')) {
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    __DIR__ . '/../../public/img/uploads/' . $safeFileName
                );
                $video->setPathFile($safeFileName);
            }

            $sucess = $this->repository->update($video);
            if ($sucess === false) {
                $this->addErrorMessage();
                return new Response(
                    302, [
                    'Location' => '/'
                ]);
            } else {
                return new Response(
                    302, [
                    'Location' => '/'
                ]);
            }
        }

    }
}
