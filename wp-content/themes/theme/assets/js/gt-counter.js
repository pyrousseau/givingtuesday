(function(){
  "use strict";
  var MS_DAY=86400000, MS_H=3600000, MS_M=60000;
  var started=false, intId=null;

  function pad(n){ return (n<10?'0':'')+n; }

  function readEnd(el){
    // 1) timestamp prioritaire
    var tsAttr = (el.getAttribute('data-deadline-ts')||'').trim();
    if (tsAttr && /^\d+$/.test(tsAttr)) {
      var ts = Number(tsAttr);
      // seconds → ms
      if (ts < 1e12) ts = Math.round(ts*1000);
      if (isFinite(ts) && ts > 0) return ts;
    }
    // 2) ISO 8601 (avec timezone)
    var iso = (el.getAttribute('data-deadline')||'').trim();
    if (iso){
      var d = new Date(iso);
      if (!isNaN(d.getTime())) return d.getTime();
    }
    // 3) YYYY-MM-DD (minuit local navigateur)
    var ymd = (el.getAttribute('data-deadline-date')||'').trim();
    if (ymd){
      var d2 = new Date(ymd+'T00:00:00');
      if (!isNaN(d2.getTime())) return d2.getTime();
    }
    return NaN;
  }

  function render(el,end){
    var diff = end - Date.now();
    if (diff < 0) diff = 0;
    var d = Math.floor(diff/MS_DAY);
    var h = Math.floor((diff%MS_DAY)/MS_H);
    var m = Math.floor((diff%MS_H)/MS_M);
    var s = Math.floor((diff%MS_M)/1000);

    var t = el.querySelectorAll('.item .time');
    if (t.length >= 4){
      t[0].textContent = d;
      t[1].textContent = pad(h);
      t[2].textContent = pad(m);
      t[3].textContent = pad(s);
    }

    if (diff === 0) el.classList.add('timer--done');
  }

  function start(){
    if (started) return;
    var el = document.getElementById('timer');
    if (!el) return;

    // neutralise d’anciens scripts éventuels
    if (window.timer){ try{ clearInterval(window.timer); }catch(e){} window.timer=null; }
    if (typeof window.dateHtml === 'function'){ window.dateHtml = function(){}; }

    var end = readEnd(el);
    if (!isFinite(end) || !end) return; // rien d’utilisable

    started = true;
    render(el,end);
    if (intId) clearInterval(intId);
    intId = setInterval(function(){ render(el,end); }, 1000);
    el.setAttribute('data-timer-started','1');
  }

  // 1) lancement immédiat
  start();

  // 2) DOM ready
  if (document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', start, {once:true});
  }

  // 3) lazy/fragment injecté plus tard
  try{
    var debounce;
    new MutationObserver(function(muts){
      for (var i=0;i<muts.length;i++){
        if (muts[i].addedNodes && muts[i].addedNodes.length){
          clearTimeout(debounce);
          debounce = setTimeout(start, 120);
          break;
        }
      }
    }).observe(document.documentElement, {childList:true, subtree:true});
  }catch(e){}
})();
