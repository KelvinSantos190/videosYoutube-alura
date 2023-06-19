<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NewVideoController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParsed = $request->getParsedBody();
        $url = filter_var($queryParsed['url'], FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErrorMessage('URL inválida');
            return new Response(
                302, [
                'Location' => '/novo-video'
            ]);
        }
        $title = filter_var($queryParsed['url']);
        if ($title === false) {
            $this->addErrorMessage('Titulo não informado');
            return new Response(
                302, [
                'Location' => '/novo-video'
            ]);
        }
        $video = new Video($url, $title);
        $files = $request->getUploadedFiles();
        /** @var  UploadedFileInterface $uploadedImage */
        $uploadedImage = $files['image'];
        if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
            $safeFileName = uniqid('upload_') . '_' . pathinfo($_FILES['image']['name'], PATHINFO_BASENAME);
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $tmpFile = $uploadedImage->getStream()->getMetadata('uri');
            $mimeType = $finfo->file($tmpFile);
            if (str_starts_with($mimeType, 'image/')) {
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    __DIR__ . '/../../public/img/uploads/' . $safeFileName
                );
                $video->setPathFile($safeFileName);
            }

        }

        $sucess = $this->videoRepository->add($video);
        if ($sucess === false) {
            $this->addErrorMessage('Erro ao inserir novo vídeo');
            return new Response(
                302, [
                'Location' => '/novo-video'
            ]);
        } else {
            return new Response(
                302, [
                'Location' => '/'
            ]);

        }
    }
}