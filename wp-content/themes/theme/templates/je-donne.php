<?php
$buttons = get_field('buttons');
?>
<div class="block block--propos block--propos__intro block-size-a">
    <h1 class="block--propos__intro__title"><?php echo get_the_title(); ?></h1>
    <p><?php echo get_field('texte') ?></p>
    <div class="faq__btn btns-group2">
        <?php
        $i = 0;
        $totalButtons = count($buttons);
        foreach ($buttons as $button) {
            $i++;
            $class = "";
            if ($i % 2 == 1) {
                $class = " w-50-r";
            } elseif ($i % 2 == 0) {
                $class = " w-50-l";
            }
            if ($i == $totalButtons) {
                $class = "";
            }
        ?>
        <div class="w-50<?php echo $class; ?>">
            <a href="<?php echo $button['button']['texte']["url"]; ?>"
                target="<?php echo $button['button']['texte']["target"]; ?>"
                class="bnt-action-page-footer<?php if ($button['button']['couleur'] == "Rouge") { echo " bnt-action-page-footer-red"; } else { echo " bnt-action-page-footer-blue";} ?>"><span><?php echo $button['button']['texte']["title"]; ?></span></a>
        </div>
        <?php
        }
        ?>
        <div class="centermyBtn">
            <a href="<?php echo get_field('bottom_btn')["url"]; ?>"
                target="<?php echo get_field('bottom_btn')["target"]; ?>"
                class="bnt-action-page-footer bnt-action-page-footer-blue"><span><?php echo get_field('bottom_btn')["title"]; ?></span></a>
        </div>
    </div>
    
</div>