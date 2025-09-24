<div class="block block__text block__text--columns">
    <div class="container container--small">
        <?php if ($contentBlock['titre']) : ?>
        <h2><?php echo $contentBlock['titre']; ?></h2>
        <?php endif; ?>
        <div class="columns">
            <div class="column">
                <article>
                    <?php echo $contentBlock['text_gauche']; ?>
                </article>
            </div>
            <div class="column column-img">
                <img src="<?php echo $contentBlock['image_droite']['url']; ?>" />
            </div>
        </div>
    </div>
</div>