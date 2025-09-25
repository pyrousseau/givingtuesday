<?php
/**
 * Plugin Name: GT Partners Lite (site-wide)
 * Description: Carrousel de logos sans dépendances. Détection auto sur tout le site.
 * Version: 1.0
 */

add_action('wp_head', function(){
  echo "\n<!-- GT Partners Lite active -->\n"; // marqueur de debug dans le source HTML
});

/* 1) Détecte et taggue les UL/OL avec >=3 <img> dans the_content */
add_filter('the_content', function ($html) {
  if (is_admin() || empty($html)) return $html;
  if (stripos($html, '<img') === false) return $html;

  $modified = false;
  $html = preg_replace_callback('#<(ul|ol)(\s[^>]*)?>(.*?)</\1>#is', function ($m) use (&$modified) {
    $tag   = $m[1]; $attrs = $m[2] ?? ''; $inner = $m[3] ?? '';
    if (substr_count(strtolower($inner), '<img') < 3) return $m[0];
    if (preg_match('#class=["\'][^"\']*js-gt-partners[^"\']*["\']#i', $attrs)) { $modified = true; return $m[0]; }
    if (preg_match('#class=["\']([^"\']*)["\']#i', $attrs)) {
      $newAttrs = preg_replace('#class=["\']([^"\']*)["\']#i', 'class="$1 js-gt-partners"', $attrs);
    } else {
      $newAttrs = ($attrs ?: '') . ' class="js-gt-partners"';
    }
    $modified = true;
    return "<{$tag}{$newAttrs}>{$inner}</{$tag}>";
  }, $html);

  if ($modified) { $GLOBALS['gt_partners_on_page'] = true; }
  return $html;
}, 12);

/* 2) Enqueue CSS/JS minimal (vanilla carousel) uniquement s’il y a des listes tagguées */
add_action('wp_enqueue_scripts', function () {
  if (empty($GLOBALS['gt_partners_on_page'])) return;
  // CSS
  $css = <<<CSS
  .gt-partners{display:flex;gap:16px;align-items:center;overflow:auto;scroll-snap-type:x mandatory;
               padding:0;margin:1rem 0;list-style:none}
  .gt-partners>li{flex:0 0 auto;scroll-snap-align:start;list-style:none}
  .gt-partners img{display:block;height:auto;max-height:60px;width:auto}
  .gt-partners--mask{mask-image:linear-gradient(to right, transparent 0, black 24px, black calc(100% - 24px), transparent 100%);
                     -webkit-mask-image:linear-gradient(to right, transparent 0, black 24px, black calc(100% - 24px), transparent 100%)}
  .gtp-nav{position:relative}
  .gtp-btn{position:absolute;top:50%;transform:translateY(-50%);border:0;background:rgba(0,0,0,.4);
           color:#fff;width:36px;height:36px;border-radius:999px;cursor:pointer}
  .gtp-btn[disabled]{opacity:.35;cursor:default}
  .gtp-prev{left:4px}.gtp-next{right:4px}
  @media(hover:none){.gtp-btn{display:none}}
  CSS;
  wp_register_style('gt-partners-lite', false);
  wp_enqueue_style('gt-partners-lite');
  wp_add_inline_style('gt-partners-lite', $css);

  // JS
  $js = <<<JS
  (function(){
    var MIN=3, STEP_MS=3500;
    function isLogoList(el){
      if(!el||!/^(UL|OL)$/.test(el.tagName)) return false;
      if(el.classList.contains('gt-partners')||el.dataset.gtpBound) return false;
      var imgs=el.querySelectorAll('img'); if(imgs.length<MIN) return false;
      var ok=0; el.querySelectorAll(':scope>li').forEach(function(li){ if(li.querySelector('img')) ok++; });
      return ok>=Math.min(MIN, el.children.length);
    }
    function find(root){
      var nodes=(root||document).querySelectorAll('ul.js-gt-partners,ol.js-gt-partners,ul,ol');
      var out=[]; nodes.forEach(function(n){ if(isLogoList(n)) out.push(n); }); return out;
    }
    function wrapNav(list){
      var wrap=document.createElement('div'); wrap.className='gtp-nav';
      list.parentNode.insertBefore(wrap,list); wrap.appendChild(list);
      var prev=document.createElement('button'); prev.className='gtp-btn gtp-prev'; prev.setAttribute('aria-label','Précédent'); prev.innerHTML='‹';
      var next=document.createElement('button'); next.className='gtp-btn gtp-next'; next.setAttribute('aria-label','Suivant');   next.innerHTML='›';
      wrap.appendChild(prev); wrap.appendChild(next); return {prev:prev,next:next};
    }
    function slideW(list){
      var first=list.querySelector(':scope>li'); if(!first) return 0;
      var w=first.getBoundingClientRect().width; var gap=parseFloat(getComputedStyle(list).gap||0); return w+gap;
    }
    function throttle(fn,ms){var t=0;return function(){var n=Date.now();if(n-t>ms){t=n;fn();}}}
    function debounce(fn,ms){var a;return function(){clearTimeout(a);a=setTimeout(fn,ms);}}

    function initOne(list){
      if(list.dataset.gtpBound) return;
      list.classList.add('gt-partners','gt-partners--mask'); list.dataset.gtpBound='1';
      var items=[].slice.call(list.querySelectorAll(':scope>li'));
      if(items.length<6){ items.map(function(li){return li.cloneNode(true)}).forEach(function(c){list.appendChild(c)}); }
      var ui=wrapNav(list);
      function can(dir){ return dir<0 ? list.scrollLeft>0 : list.scrollLeft+list.clientWidth<list.scrollWidth-1; }
      function go(dir){ var w=slideW(list)||200; list.scrollBy({left:dir*w,behavior:'smooth'}); }
      ui.prev.onclick=function(){go(-1)}; ui.next.onclick=function(){go(+1)};
      function upd(){ ui.prev.disabled=!can(-1); ui.next.disabled=!can(+1); }
      list.addEventListener('scroll',throttle(upd,200)); window.addEventListener('resize',debounce(upd,150)); setTimeout(upd,400);
      var t=null, paused=false; function tick(){ if(paused||STEP_MS<=0)return; if(!can(+1)) list.scrollTo({left:0,behavior:'smooth'}); else go(+1); }
      function start(){ if(STEP_MS>0&&!t) t=setInterval(tick,STEP_MS); }
      function stop(){ if(t){clearInterval(t);t=null;} }
      list.addEventListener('mouseenter',function(){paused=true}); list.addEventListener('mouseleave',function(){paused=false});
      list.addEventListener('focusin',function(){paused=true});   list.addEventListener('focusout',function(){paused=false});
      start();
    }

    function boot(root){ find(root).forEach(initOne); }
    function ready(fn){ if(document.readyState==='loading') document.addEventListener('DOMContentLoaded',fn,{once:true}); else fn(); }

    ready(function(){
      boot(document);
      var tries=0,max=10;(function retry(){ if(++tries>max) return; setTimeout(function(){boot(document);retry();},400); })();
    });

    try{
      var mo=new MutationObserver(function(muts){
        for(var i=0;i<muts.length;i++){ var m=muts[i];
          if(m.addedNodes&&m.addedNodes.length){
            for(var j=0;j<m.addedNodes.length;j++){ var n=m.addedNodes[j]; if(n.nodeType===1) boot(n); }
          }
        }
      });
      mo.observe(document.documentElement,{childList:true,subtree:true});
    }catch(e){}
    document.addEventListener('gt:partners:ready',function(){ boot(document); });
  })();
  JS;
  wp_register_script('gt-partners-lite', false, [], null, false); // en <head>
  wp_enqueue_script('gt-partners-lite');
  wp_add_inline_script('gt-partners-lite', $js);
});
