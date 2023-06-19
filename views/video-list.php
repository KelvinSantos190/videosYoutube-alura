<?php
 $this->layout('/layout');
 /** @var \Alura\Mvc\Entity\Video[] $videoList */
 ?>
<ul class="videos__container" alt="videos alura">
        <?php foreach ($videoList as $video){?>
        <li class="videos__item">
            <?php if($video->getFilePath()!== null):?>
            <a href="<?=$video->url?>">
                <img src="/img/uploads/<?=$video->getFilePath();?>" style="width: 100%" alt=""/>
            </a>

                <?php
            else:
                ?>
            <iframe width="100%" height="72%" src="<?=$video->url?>"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
                <?php
            endif;
                ?>
            <div class="descricao-video">
                <img src="img/logo.png" alt="logo canal alura">
                <h3><?=$video->title?></h3>
                <div class="acoes-video">
                    <a href="/edit-video?id=<?=$video->id?>">Editar</a>
                    <a href="/delete-capa?id=<?=$video->id?>">Remover Capa</a>
                    <a href="/delete-video?id=<?=$video->id?>">Excluir</a>
                </div>
            </div>
        </li>
        <?php
               } ?>
    </ul>
