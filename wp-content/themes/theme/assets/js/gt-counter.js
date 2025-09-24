(function(){
  "use strict";
  var MS_DAY=86400000, MS_H=3600000, MS_M=60000;
  var started=false, intId=null;

  function pad(n){ return (n<10?'0':'')+n; }
  function getEnd(el){
    var ts = parseInt(el.getAttribute('data-deadline-ts')||'',10);
    return Number.isFinite(ts) ? ts : NaN;
  }
  function render(el,end){
    var diff=end-Date.now(); if(diff<0) diff=0;
    var d=Math.floor(diff/MS_DAY);
    var h=Math.floor((diff%MS_DAY)/MS_H);
    var m=Math.floor((diff%MS_H)/MS_M);
    var s=Math.floor((diff%MS_M)/1000);
    var t=el.querySelectorAll('.item .time');
    if(t.length>=4){ t[0].textContent=d; t[1].textContent=h; t[2].textContent=pad(m); t[3].textContent=pad(s); }
  }
  function start(){
    if(started) return;
    var el=document.getElementById('timer');
    if(!el) return;
    // neutralise l'ancien script s'il existe
    if(window.timer){ try{clearInterval(window.timer);}catch(e){} window.timer=null; }
    if(typeof window.dateHtml==='function'){ window.dateHtml=function(){}; }

    var end=getEnd(el);
    if(!Number.isFinite(end)) return;
    started=true;
    render(el,end);
    intId && clearInterval(intId);
    intId=setInterval(function(){ render(el,end); },1000);
  }

  // démarrage initial
  if(document.readyState==='loading'){ document.addEventListener('DOMContentLoaded', start, {once:true}); }
  else { start(); }

  // si l’intro est injectée en AJAX, on retente calmement
  try{
    var t=null;
    new MutationObserver(function(muts){
      for(var i=0;i<muts.length;i++){
        if(muts[i].addedNodes && muts[i].addedNodes.length){ clearTimeout(t); t=setTimeout(start,150); break; }
      }
    }).observe(document.body,{childList:true,subtree:true});
  }catch(e){}
})();
