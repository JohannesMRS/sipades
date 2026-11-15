const $ = (s, c = document) => c.querySelector(s);
const $$ = (s, c = document) => [...c.querySelectorAll(s)];

// Navbar: solid after scroll or while the mobile menu is open
const nav = $('#navbar'), menu = $('#mobile-menu'), toggle = $('#nav-toggle');
const sync = () => nav.classList.toggle('solid', scrollY > 40 || !menu.classList.contains('hidden') || nav.dataset.solid !== undefined);
sync(); addEventListener('scroll', sync, { passive: true });
const setMenu = open => {
  menu.classList.toggle('hidden', !open);
  toggle.setAttribute('aria-expanded', open);
  sync();
};
toggle.addEventListener('click', () => setMenu(menu.classList.contains('hidden')));
$$('a', menu).forEach(a => a.addEventListener('click', () => setMenu(false)));
addEventListener('resize', () => { if (innerWidth >= 1024) setMenu(false); });

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


// If a placeholder image fails to load, fall back to the local village photo
const fallback = img => {
  if (img.dataset.fb) return;
  img.dataset.fb = '1';
  img.src = '/images/desa.jpg';
};
document.addEventListener('error', e => { if (e.target.tagName === 'IMG') fallback(e.target); }, true);
$$('img').forEach(i => { if (i.complete && i.naturalWidth === 0) fallback(i); });
