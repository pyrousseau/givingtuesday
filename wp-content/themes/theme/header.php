<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
<!--        <meta name="twitter:image:src" content="--><?php //the_field('share_image_actions','option'); ?><!--">-->
        <meta property="og:image" content="<?php the_field('share_image_actions','option'); ?>">
        <?php if (is_page(39)) { ?>
<!--            <meta property="og:image" content="--><?php //the_field('share_image_actions','option'); ?><!--">-->
            <?php if (isset($_GET['action'])) { ?>
<!--                <meta property="og:title" content="--><?php //echo get_the_title($_GET['action']); ?><!--">-->
                <!--                <title><?php //echo get_the_title($_GET['action']); ?></title>-->
                <title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
            <?php } ?>
        <?php } else { ?>
            <title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
        <?php } ?>

        <link href="<?php echo get_template_directory_uri(); ?>/images/favicon.png" rel="shortcut icon">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://www.googletagmanager.com" crossorigin>
        <link rel="preconnect" href="https://www.google-analytics.com" crossorigin>
        <link rel="preconnect" href="https://connect.facebook.net" crossorigin>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script type="text/javascript">
            var templateUrl = '<?php echo home_url(); ?>';
        </script>
	<?php wp_head(); ?>
    <script>
/**
 * Post-render analytics: charge GA4, (optionnel) UA, FB SDK + Pixel
 * après le 'load' pour ne pas bloquer le LCP/INP mobile.
 * En prod, tu peux descendre le setTimeout à 0–100ms si tu veux.
 */
window.addEventListener('load', function () {
  setTimeout(function () {
    // ——— Google Analytics (GTAG) ———
    (function(idGA4, idUA){
      // loader gtag
      var s = document.createElement('script');
      s.async = true;
      s.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(idGA4);
      document.head.appendChild(s);

      window.dataLayer = window.dataLayer || [];
      function gtag(){ dataLayer.push(arguments); }
      window.gtag = gtag; // exposer au besoin
      gtag('js', new Date());

      // GA4
      gtag('config', idGA4);

      // (optionnel) UA via le même gtag (si tu tiens à garder l’ancienne propriété)
      if (idUA) {
        gtag('config', idUA, { 'send_page_view': true });
      }
    })('G-J4FQ1MXHQE', null /* 'UA-91362292-3' si tu veux le garder */);

    // ——— Facebook SDK ———
    (function(){
      window.fbAsyncInit = function() {
        FB.init({
          appId: '1929952473751618',
          autoLogAppEvents: true,
          xfbml: true,
          version: 'v3.1'
        });
      };
      var js = document.createElement('script');
      js.async = true;
      js.src = 'https://connect.facebook.net/en_US/sdk.js';
      document.head.appendChild(js);
    })();

    // ——— Facebook Pixel ———
    (function(){
      !function(f,b,e,v,n,t,s){
        if(f.fbq) return;
        n=f.fbq=function(){ n.callMethod ? n.callMethod.apply(n,arguments) : n.queue.push(arguments) };
        if(!f._fbq) f._fbq=n;
        n.push = n; n.loaded = true; n.version='2.0';
        n.queue = [];
        t=b.createElement(e); t.async = true;
        t.src = v; s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s);
      }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

      fbq('init', '1029178910881669');
      fbq('track', 'PageView');
    })();

  }, 250); // laisse le héros se peindre avant de charger les trackers
});
</script>
<noscript>
  <img height="1" width="1" style="display:none"
       src="https://www.facebook.com/tr?id=1029178910881669&ev=PageView&noscript=1"/>
</noscript>

   </head>

    <body <?php body_class(); ?>>

    <?php
    $o_fields = get_fields('options');
    ?>

    <div class="container">
        <header class="header header--closed">
            <div class="header-sticky">
                <div class="wrap">
                    <div class="nav__logo">
                        <a href="<?php echo home_url(); ?>">
                            <img src="<?php echo get_field('logo', 'option'); ?>" alt="Giving Tuesday">
                        </a>
                    </div>
                    <div class="header__block-mobile">
                        <a href="<?php echo home_url(); ?>">
                            <img src="<?php the_field('logo-top','option'); ?>" alt="#GIVINGTUESDAY">
                        </a>
                        <!--<div class="date"><?php //echo $o_fields['date'];//echo get_the_date(); ?>
                        </div>-->
                    </div>
                    <div class="header__share">
                        <span class="header__share__title">Je partage :</span>
                        <ul class="header__share__list">
                            <li><a class="header__share__item facebook" href="https://www.facebook.com/sharer.php?u=<?php echo home_url(); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a class="header__share__item twitter" href="https://twitter.com/intent/tweet?url=https://givingtuesday.fr/&text=%E2%9D%A4%20Mouvement%20mondial%20qui%20c%C3%A9l%C3%A8bre%20et%20encourage%20la%20g%C3%A9n%C3%A9rosit%C3%A9,%20l%E2%80%99engagement%20et%20la%20solidarit%C3%A9,%20je%20participe%20cette%20ann%C3%A9e%20au%20%23GivingTuesdayFR.%20Et%20vous%20?%20Rdv%20le%2001%20d%C3%A9cembre%20%F0%9F%98%81" target="_blank"><i class="fab fa-x-twitter"></i></a></li>
                            <li><a class="header__share__item whatsapp" href="https://api.whatsapp.com/send?text=Cette%20ann%C3%A9e%2C%20je%20m%E2%80%99engage%20pour%20le%20Giving%20Tuesday%2C%20la%20journ%C3%A9e%20mondiale%20de%20la%20g%C3%A9n%C3%A9rosit%C3%A9%20%F0%9F%92%99%0AUn%20moment%20pour%20c%C3%A9l%C3%A9brer%20le%20don%2C%20l%E2%80%99engagement%20et%20la%20solidarit%C3%A9%20sous%20toutes%20leurs%20formes.%0AEt%20toi%2C%20tu%20rejoins%20le%20mouvement%20%3F%20%F0%9F%A4%9D%0A%F0%9F%91%89%20www.givingtuesday.fr" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                            <li>
                                <a class="header__share__item linkedin" href="https://www.linkedin.com/sharing/share-offsite/?url=https%3A%2F%2Fgivingtuesday.fr%2F" target="_blank">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="nav">
                <div class="select-content">
                    <div class="select-content__title">
                        <?php echo $o_fields['header_select_title']; ?>
                    </div>
                    <div class="select-content__select">
                        <div class="select-content__select__title"><?php echo $o_fields['header_select_subtitle']; ?></div>
                        <ul class="select-content__select__list">
                            <?php foreach ($o_fields['header_select'] as $field): ?>
                                <li><a href="<?php echo $field['lien'];?>">
                                        <img src="<?php echo $field['image'];?>" alt="<?php echo $field['texte'];?>"><?php echo $field['texte'];?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php
                wp_nav_menu( array(
                        'container'=> false,
                        'theme_location'=> 'header-menu',
                        'menu_id'=> 'menu-general_navigation',
                        'menu_class'=> 'nav1',
                        'link_before' => '<span><span>',
                        'link_after'  => '</span></span>'
                    )
                );

                ?>
                <?php //theme_nav('header-menu', 'nav1'); ?>
<!--                    <li class="nav__btn">-->
<!--                        <a href="--><?php //echo get_field('bouton_lien','option'); ?><!--" class="form-scroll-link">-->
<!--                            <span>--><?php //echo get_field('bouton_text','option'); ?><!--</span>-->
<!--                        </a>-->
<!--                    </li>-->
                <!-- <li class="nav__partage">
                    Je&nbsp;partage
                    <span class="picto">
                        <a href="http://twitter.com/share?url=http%3A%2F%2Fgivingtuesday.fr&amp;text=Lib%C3%A9rez%20votre%20g%C3%A9n%C3%A9rosit%C3%A9%20%23givingtuesdayfr%20%3A" target="p" onclick="p=window.open('','p','width=640,height=480');p.focus();"><i class="fab fa-twitter">
                            </i>
                        </a>
                        <a href="http://www.facebook.com/sharer.php?u=http%3A%2F%2Fgivingtuesday.fr%2F" target="p" onclick="p=window.open('','p','width=640,height=480');p.focus();">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="mailto:?subject=%23givingtuesdayfr&amp;body=Lib%C3%A9rez%20votre%20g%C3%A9n%C3%A9rosit%C3%A9%20%23givingtuesdayfr%20%3A%20http%3A%2F%2Fgivingtuesday.fr">
                            <i class="fa fa-envelope fa-solid"></i>
                        </a>
                    </span>

                </li> -->
            </div>
            <div class="burger">
                <span></span>
            </div>
        </header>
