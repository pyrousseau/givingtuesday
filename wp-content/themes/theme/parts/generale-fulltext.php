<div class="block block__text">
    <div class="container container--small">
        <?php if ($contentBlock['titre']) : ?>
        <h2><?php echo $contentBlock['titre']; ?></h2>
        <?php endif; ?>
        <article>
            <?php echo $contentBlock['fulltext']; ?>
        </article>
        <?php if ($contentBlock['fichier'])  { ?>
        <div class="faq_download-block">
            <a class="download-link download-link__big" href="<?php echo home_url().'/download.php?file='.$contentBlock['fichier'];  ?>">
                <span><?php echo $contentBlock['bouton_texte']; ?></span>
            </a>
        </div>
        
        <?php } ?>
    </div>
</div>