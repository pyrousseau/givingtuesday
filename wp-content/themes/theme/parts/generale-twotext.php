<div class="block block__text block__text--columns">
    <div class="container container--small">
        <?php if ($contentBlock['titre']) : ?>
            <h2><?php echo $contentBlock['titre']; ?></h2>
        <?php endif; ?>
        <div class="two-columns">
            <article>
                <?php echo $contentBlock['fulltext']; ?>
            </article>
        </div>
    </div>
</div>
