
(()=>{ 
  const KEY = '__fragmentLoaded';
  const $frags = document.querySelectorAll('.ssr-fragment[data-fragment]');
  if (!$frags.length) return;

  const load = async el => {
    if (el[KEY]) return; el[KEY] = true;
    const url = el.getAttribute('data-fragment');
    const ctrl = new AbortController();
    const to = setTimeout(()=>ctrl.abort(), +(el.dataset.timeout||8000));
    try {
      const res = await fetch(url, {signal: ctrl.signal, credentials:'same-origin'});
      if (!res.ok) throw new Error(res.status);
      const html = await res.text();
      el.innerHTML = html;
      el.removeAttribute('aria-busy');
      // Option: déclencher une event si un slider à initialiser
      el.dispatchEvent(new CustomEvent('fragment:loaded', {detail:{url}}));
    } catch(e) {
      el.innerHTML = '<p class="frag-error">⚠️ Contenu indisponible.</p>';
      el.removeAttribute('aria-busy');
      console.error('[Fragment]', url, e);
    } finally { clearTimeout(to); }
  };

  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver(entries=>{
      entries.forEach(e=>{ if (e.isIntersecting) { io.unobserve(e.target); load(e.target); } });
    }, {rootMargin:'600px 0px'});
    $frags.forEach(el=>io.observe(el));
  } else {
    // Fallback ancien navigateur
    $frags.forEach(el=>load(el));
  }
})();

function initSliderOnce(root=document){
  const el = root.querySelector('.js-slider');
  if (!el || el.dataset.init === '1') return;
  el.dataset.init = '1';
  // … init slider …
}
document.addEventListener('fragment:loaded', e => initSliderOnce(e.target));
document.addEventListener('DOMContentLoaded', ()=> initSliderOnce());
