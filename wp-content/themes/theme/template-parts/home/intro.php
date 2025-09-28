<?php
/**
 * Fragment INTRO — avec prise en charge d’un champ ACF de type DateTime (retour Y-m-d H:i:s)
 */
defined('ABSPATH') || exit;

// CONFIG
$PARIS_TZ     = 'Europe/Paris';
$FALLBACK_DATETIME = '2025-12-02 05:00:00';

// HELPERS
function gt_intro_opts() {
  return function_exists('get_fields') ? (get_fields('option') ?: []) : [];
}
function gt_img_url($img){
  if (!$img) return '';
  if (is_array($img) && !empty($img['url'])) return $img['url'];
  if (is_numeric($img)) { $src = wp_get_attachment_image_src($img, 'full'); return $src ? $src[0] : ''; }
  if (is_string($img)) return $img;
  return '';
}
function gt_intro_date_fr(DateTimeInterface $dt) {
  static $mois = ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];
  return (int)$dt->format('j').' '.$mois[(int)$dt->format('n')-1].' '.$dt->format('Y');
}

// Lecture du champ ACF "home_intro_date"
try {
  $tz = new DateTimeZone($PARIS_TZ);
} catch(Throwable $e) {
  $tz = new DateTimeZone('UTC');
}

$raw = function_exists('get_field') ? get_field('home_intro_date', 'option') : null;

$dt = null;

if (is_string($raw) && preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}/', $raw)) {
  $dt = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $raw, $tz);
} elseif ($raw instanceof DateTimeInterface) {
  $dt = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $raw->format('Y-m-d H:i:s'), $tz);
} elseif (is_array($raw) && isset($raw['value'])) {
  $dt = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $raw['value'], $tz);
}

// Fallback si rien n'est valide
if (!$dt) {
  $dt = new DateTimeImmutable($FALLBACK_DATETIME, $tz);
}

$deadline_iso = $dt->format('c');            // Pour data-deadline
$deadline_ts  = $dt->getTimestamp() * 1000;  // Pour data-deadline-ts (en ms)
$o = gt_intro_opts();

// H2 : texte explicite ou format automatique
$date_txt = (!empty($o['date']) && is_string($o['date'])) ? $o['date'] : gt_intro_date_fr($dt);
?>

<div class="block block__frontpage block__frontpage--intro">
  <div class="block__frontpage--intro__top">
    <h2>Rendez-vous le <?php echo esc_html($date_txt); ?> pour la huitième édition&nbsp;!</h2>

    <!-- Compteur -->
    <div id="timer" class="counter"
         data-deadline="<?php echo esc_attr($deadline_iso); ?>"
         data-deadline-date="<?php echo esc_attr($dt->format('Y-m-d')); ?>"
         data-deadline-ts="<?php echo esc_attr($deadline_ts); ?>"
         data-count-inclusive="0">
      <div class="item">
        <span class="time">0</span>
        <span class="time-text">jours</span>
      </div>
      <div class="item">
        <span class="time">00</span>
        <span class="time-text">heures</span>
      </div>
      <div class="item">
        <span class="time">00</span>
        <span class="time-text">min.</span>
      </div>
      <div class="item">
        <span class="time">00</span>
        <span class="time-text">sec.</span>
      </div>
    </div>
  </div>

  <div class="block__frontpage--intro__bottom">
    <img class="block__frontpage--intro__logo" src="<?php echo esc_url(get_field('logo','option')); ?>" alt="Giving Tuesday">

    <div class="block__frontpage--intro__left"
         style="background-image:url('<?php echo esc_url($o['sb_deux_bg'] ?? ''); ?>')"></div>

    <div class="block__frontpage--intro__right">
      <?php echo !empty($o['sb_gros_texte']) ? wp_kses_post($o['sb_gros_texte']) : ''; ?>

      <div class="block__frontpage--intro__logos">
        <?php
        // SOUTENANTS (jusqu’à 3)
        $g = get_field('mention-label-soutenants','option');
        if (!$g) { $front = (int) get_option('page_on_front'); if ($front) $g = get_field('mention-label-soutenants',$front); }
        if ($g):
          $items=[];
          for ($i=1; $i<=3; $i++) {
            $s  = ($i===1)? '' : (string)$i;   // image, image2, image3
            $su = ($i===1)? '' : '_'.$i;       // image, image_2, image_3
            $img = $g['image'.$s] ?? ($g['image'.$su] ?? null);
            $lnk = $g['lien'.$s]  ?? ($g['lien'.$su]  ?? '');
            $src = gt_img_url($img); if (!$src) continue;
            $alt = is_array($img)&&!empty($img['alt']) ? $img['alt'] : '';
            $items[] = ['src'=>$src,'alt'=>$alt,'href'=>$lnk];
          }
          if ($items): ?>
            <div class="gt-supporters">
              <div class="gt-supporters__label"><?php echo esc_html($g['texte'] ?? 'Mouvement soutenu par'); ?></div>
              <div class="gt-supporters__row">
                <?php foreach ($items as $it): ?>
                  <div class="gt-supporters__logo">
                    <?php if (!empty($it['href'])): ?>
                      <a href="<?php echo esc_url($it['href']); ?>" target="_blank" rel="noopener">
                        <img src="<?php echo esc_url($it['src']); ?>" alt="<?php echo esc_attr($it['alt']); ?>">
                      </a>
                    <?php else: ?>
                      <img src="<?php echo esc_url($it['src']); ?>" alt="<?php echo esc_attr($it['alt']); ?>">
                    <?php endif; ?>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; endif; ?>
      </div>

      <div class="block__frontpage--intro__logos">
        <?php
        // PORTEUR (1 logo)
        $g = get_field('mention-label-porteurs','option');
        if (!$g) { $front = (int) get_option('page_on_front'); if ($front) $g = get_field('mention-label-porteurs',$front); }
        if ($g):
          $img = $g['image'] ?? ($g['image_1'] ?? null);
          $src = gt_img_url($img); $alt = is_array($img)&&!empty($img['alt']) ? $img['alt'] : '';
          $lnk = !empty($g['lien']) ? $g['lien'] : ($g['lien_1'] ?? '');
          if ($src): ?>
            <div class="gt-porteur">
              <div class="gt-porteur__label"><?php echo esc_html($g['texte'] ?? 'Porté par'); ?></div>
              <div class="gt-porteur__logo">
                <?php if ($lnk): ?>
                  <a href="<?php echo esc_url($lnk); ?>" target="_blank" rel="noopener">
                    <img src="<?php echo esc_url($src); ?>" alt="<?php echo esc_attr($alt); ?>">
                  </a>
                <?php else: ?>
                  <img src="<?php echo esc_url($src); ?>" alt="<?php echo esc_attr($alt); ?>">
                <?php endif; ?>
              </div>
            </div>
          <?php endif; endif; ?>
      </div>
    </div>
  </div>

  <div class="block__frontpage--intro__mention">
    <div class="block__frontpage--intro__rightinverted">
      <?php echo !empty($o['mention_texte']) ? wp_kses_post($o['mention_texte']) : ''; ?>
      <ul class="block__frontpage--intro__logos"></ul>
    </div>
    <div class="block__frontpage--intro__leftinverted"
         style="background-image:url('<?php echo esc_url($o['mention_background'] ?? ''); ?>')"></div>
  </div>
</div>
