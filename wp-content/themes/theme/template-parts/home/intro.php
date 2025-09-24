<?php
/**
 * Fragment INTRO — ancien markup restauré (sans header/footer)
 * - Conserve les classes & la structure d’origine (top + bottom + mentions)
 * - Lit depuis ACF Options via $o_fields (comme avant)
 * - Ajoute des data-* pour un compteur robuste (#timer)
 */

$tz  = wp_timezone();
$raw = get_field('home_intro_date','option');
if ($raw instanceof DateTimeInterface) {
  $ymd = $raw->format('Y-m-d');
} elseif (is_string($raw)) {
  $ymd = substr($raw, 0, 10);
} elseif (is_array($raw)) {
  $ymd = $raw['date'] ?? $raw['value'] ?? '2025-12-02';
} else {
  $ymd = '2025-12-02';
}

$dt = DateTimeImmutable::createFromFormat('!Y-m-d H:i', "$ymd 05:00", $tz);
$deadline_iso = $dt->format('c');
$deadline_ts  = $dt->getTimestamp() * 1000;


$o_fields = function_exists('get_fields') ? (get_fields('option') ?: []) : [];

// 1) Date affichée (texte) = ton ancien champ $o_fields['date']
$date_txt = isset($o_fields['date']) && is_string($o_fields['date']) ? $o_fields['date'] : '2 décembre 2025';

// 2) Deadline réelle (pour le JS)
//    essaie 'home_intro_date' (Y-m-d), puis 'date' / 'date_copie', sinon fallback 2025-12-02
$tz  = wp_timezone();
$raw = function_exists('get_field') ? get_field('home_intro_date','option') : '';
if (!$raw) {
  $raw = !empty($o_fields['date']) ? $o_fields['date'] : (!empty($o_fields['date_copie']) ? $o_fields['date_copie'] : '2025-12-02');
}
if ($raw instanceof DateTimeInterface) { $ymd = $raw->format('Y-m-d'); }
elseif (is_array($raw)) { $ymd = $raw['date'] ?? $raw['value'] ?? $raw['formatted_value'] ?? '2025-12-02'; }
elseif (preg_match('/^\d{4}-\d{2}-\d{2}/', (string)$raw, $m)) { $ymd = $m[0]; }
else { $ymd = '2025-12-02'; }

// Cible : 05:00 heure de Paris (évite le décalage d’un jour)
$dt = DateTimeImmutable::createFromFormat('!Y-m-d H:i', "$ymd 05:00", $tz);
if (!$dt) { $dt = new DateTimeImmutable('2025-12-02 05:00:00', $tz); }
$deadline_iso = $dt->format('c');
$deadline_ts  = $dt->getTimestamp() * 1000;

// Helpers
function gt_img_url($img){
  if (!$img) return '';
  if (is_array($img) && !empty($img['url'])) return $img['url'];
  if (is_numeric($img)) { $src = wp_get_attachment_image_src($img, 'full'); return $src ? $src[0] : ''; }
  if (is_string($img)) return $img;
  return '';
}
?>
<div class="block block__frontpage block__frontpage--intro">
  <div class="block__frontpage--intro__top">
    <h2>Rendez-vous le <?php echo esc_html($date_txt); ?> pour la huitième édition&nbsp;!</h2>

    <!-- ID et classes conservés : #timer + .item -->
<div id="timer" class="counter"
     data-deadline="<?= esc_attr($deadline_iso) ?>"
     data-deadline-date="<?= esc_attr($dt->format('Y-m-d')) ?>"
     data-deadline-ts="<?= esc_attr($deadline_ts) ?>"
     data-count-inclusive="0">
      <div class="item">
        <span class="time">0</span>
        <span class="time-text">jours</span>
      </div>
      <div class="item">
        <span class="time">0</span>
        <span class="time-text">heures</span>
      </div>
      <div class="item">
        <span class="time">0</span>
        <span class="time-text">min.</span>
      </div>
      <div class="item">
        <span class="time">0</span>
        <span class="time-text">sec.</span>
      </div>
    </div>
  </div>

  <div class="block__frontpage--intro__bottom">
    <img class="block__frontpage--intro__logo" src="<?php echo esc_url(get_field('logo','option')); ?>" alt="Giving Tuesday">
    <div class="block__frontpage--intro__left" style="background-image:url('<?php echo esc_url($o_fields['sb_deux_bg'] ?? ''); ?>')"></div>

    <div class="block__frontpage--intro__right">
      <?php echo !empty($o_fields['sb_gros_texte']) ? wp_kses_post($o_fields['sb_gros_texte']) : ''; ?>

      <div class="block__frontpage--intro__logos">
        <?php
        // SOUTENANTS (jusqu’à 3), fallback home si option vide
        $g = get_field('mention-label-soutenants','option');
        if (!$g) { $front_id = (int) get_option('page_on_front'); if ($front_id) $g = get_field('mention-label-soutenants',$front_id); }
        if ($g):
          $items = [];
          for ($i=1; $i<=3; $i++) {
            $s  = ($i===1)? '' : (string)$i;  // image, image2, image3
            $su = ($i===1)? '' : '_'.$i;      // image, image_2, image_3
            $img = $g['image'.$s] ?? ($g['image'.$su] ?? null);
            $lnk = $g['lien'.$s]  ?? ($g['lien'.$su]  ?? '');
            $src = gt_img_url($img);
            if (!$src) continue;
            $alt = is_array($img)&&!empty($img['alt']) ? $img['alt'] : '';
            $items[] = ['src'=>$src,'alt'=>$alt,'href'=>$lnk];
          }
          if (!empty($items)): ?>
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
        if (!$g) { $front_id = (int) get_option('page_on_front'); if ($front_id) $g = get_field('mention-label-porteurs',$front_id); }
        if ($g):
          $img = $g['image'] ?? ($g['image_1'] ?? null);
          $src = gt_img_url($img);
          $alt = is_array($img)&&!empty($img['alt']) ? $img['alt'] : '';
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
      <?php echo !empty($o_fields['mention_texte']) ? wp_kses_post($o_fields['mention_texte']) : ''; ?>
      <ul class="block__frontpage--intro__logos"></ul>
    </div>
    <div class="block__frontpage--intro__leftinverted" style="background-image:url('<?php echo esc_url($o_fields['mention_background'] ?? ''); ?>')"></div>
  </div>
</div>
