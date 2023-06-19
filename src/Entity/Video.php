<?php

namespace Alura\Mvc\Entity;

use http\Exception\InvalidArgumentException;

class Video
{
    public readonly string $url;
    public readonly int $id;
    private ?string $filePath=null;
 public function __construct(
     string $url,
     public readonly string $title
 )
 {
     $this->setUrl($url);
 }
 private function setUrl(string $url): void
 {
    if (!filter_var($url,FILTER_VALIDATE_URL)){
        throw new InvalidArgumentException();
    }
    $this->url = $url;
 }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setPathFile(string $filePath):void
    {
        $this->filePath = $filePath;
    }

    /**
     * @return string|null
     */
    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

}