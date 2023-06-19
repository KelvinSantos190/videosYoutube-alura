<?php

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\Video;
use PDO;

class VideoRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function add(Video $video): Video
    {
        $sql = "INSERT into videos (title, url,image_path) VALUES (?,?,?)";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(2, $video->url);
        $statement->bindValue(1, $video->title);
        $statement->bindValue(3, $video->getFilePath( $_FILES['image']['name']));
        $statement->execute();
        $id = $this->pdo->lastInsertId();
        $video->setId($id);
        return $video;
    }

    public function remove(int $id): void
    {
        $sql = "DELETE FROM videos WHERE id=?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $id);
        $statement->execute();
    }

    public function update(Video $video): void
    {
        if ($video->getFilePath() !== null){
            $updateImageSql = ',image_path = :image_path';
        }
        $sql = "UPDATE videos SET
                  url = :url,
                  title= :title
                  $updateImageSql
                  WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':url', $video->url);
        $statement->bindValue(':title', $video->title);
        $statement->bindValue(':id', $video->id, PDO::PARAM_INT);
        if ($video->getFilePath() !== null) {
            $statement->bindValue(':image_path', $video->getFilePath());
        }
        $statement->execute();
    }

    public function all(): array
    {
        $videoList = $this->pdo
            ->query('SELECT * FROM videos')
            ->fetchAll(\PDO::FETCH_ASSOC);
        return array_map($this->hydrateVideo(...),$videoList);
    }

    public function find(int $id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM videos WHERE id=?');
        $statement->bindValue(1,$id,PDO::PARAM_INT);
        $statement->execute();
        return $this->hydrateVideo($statement->fetch(\PDO::FETCH_ASSOC));
    }

    public function hydrateVideo(array $videoData):Video
    {
        $video = new Video($videoData['url'],$videoData['title']);
        $video->setId($videoData['id']);
        if ($videoData['image_path'] !== null){
            $video->setPathFile($videoData['image_path']);
        }

        return $video;
    }
    public function removeCapa(int $id):void
    {
        $sql = "UPDATE videos SET image_path = NULL WHERE id=?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $id);
        $statement->execute();
    }

}