// assets/js/utils.js
export function $ (sel, ctx=document){ return ctx.querySelector(sel); }
export function $$ (sel, ctx=document){ return Array.from(ctx.querySelectorAll(sel)); }
export function toggle(el, cls){ el.classList.toggle(cls); }
