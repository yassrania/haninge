// assets/js/utils.js  (نسخة UMD بسيطة بدون export)
(function (w) {
  w.$  = function (sel, ctx) { return (ctx || document).querySelector(sel); };
  w.$$ = function (sel, ctx) { return Array.from((ctx || document).querySelectorAll(sel)); };
  w.toggleClass = function (el, cls) { if (el) el.classList.toggle(cls); };
})(window);
