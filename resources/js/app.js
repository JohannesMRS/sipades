const $ = (s, c = document) => c.querySelector(s);
const $$ = (s, c = document) => [...c.querySelectorAll(s)];

// Navbar: shadow on scroll + mobile toggle
const nav = $('#navbar'), menu = $('#mobile-menu'), toggle = $('#nav-toggle');
const onScroll = () => nav.classList.toggle('scrolled', scrollY > 8);
onScroll(); addEventListener('scroll', onScroll, { passive: true });
toggle.addEventListener('click', () => {
  const open = menu.classList.toggle('hidden') === false;
  toggle.setAttribute('aria-expanded', open);
});
$$('a', menu).forEach(a => a.addEventListener('click', () => { menu.classList.add('hidden'); toggle.setAttribute('aria-expanded', false); }));

// Active nav link
const links = $$('[data-nav]');
const spy = new IntersectionObserver(es => es.forEach(e => {
  if (e.isIntersecting) links.forEach(l => l.classList.toggle('active', l.getAttribute('href') === '#' + e.target.id));
}), { rootMargin: '-40% 0px -55% 0px' });
$$('section[id]').forEach(s => spy.observe(s));

// Scroll reveal
const rv = new IntersectionObserver(es => es.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); rv.unobserve(e.target); } }), { threshold: .12 });
$$('.reveal').forEach(el => rv.observe(el));

// Gallery filter + lightbox
$$('[data-filter]').forEach(b => b.addEventListener('click', () => {
  $$('[data-filter]').forEach(x => x.setAttribute('aria-pressed', x === b));
  $$('.gal-item').forEach(i => i.classList.toggle('hidden', b.dataset.filter !== 'all' && i.dataset.cat !== b.dataset.filter));
}));
const box = $('#lightbox'), boxImg = $('#lightbox-img');
$$('.gal-item').forEach(i => i.addEventListener('click', () => {
  boxImg.src = i.dataset.full; boxImg.alt = i.dataset.alt; box.showModal();
}));
box.addEventListener('click', e => { if (e.target === box || e.target.closest('[data-close]')) box.close(); });
