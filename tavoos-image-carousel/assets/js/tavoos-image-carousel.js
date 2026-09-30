/* Tavoos Image Carousel — https://tavoosweb.ir/free-wordpress-plugins/ */
(function () {
	'use strict';

	function init(s) {
		if (s.dataset.tavoosReady) return;
		s.dataset.tavoosReady = '1';

		var t = s.querySelector('.tavoos-slider__track'),
			sl = [].slice.call(t.children),
			n = sl.length,
			i = 0,
			timer,
			sp = parseInt(s.dataset.speed, 10) || 5000,
			auto = s.dataset.autoplay !== 'no',
			fade = s.classList.contains('tavoos-slider--fade'),
			// In RTL the track flows right-to-left, so it moves the other way.
			dir = getComputedStyle(s).direction === 'rtl' ? 1 : -1,
			dots = s.querySelectorAll('.tavoos-slider__dots button');

		if (n < 2) return;

		function go(k) {
			i = (k + n) % n;
			if (!fade) t.style.transform = 'translateX(' + (dir * i * 100) + '%)';
			sl.forEach(function (x, j) { x.classList.toggle('is-active', j === i); });
			dots.forEach(function (d, j) { d.classList.toggle('is-on', j === i); });
		}
		function stop() { clearInterval(timer); }
		function play() {
			stop();
			if (auto) timer = setInterval(function () { go(i + 1); }, sp);
		}

		var nx = s.querySelector('.tavoos-slider__next'),
			pr = s.querySelector('.tavoos-slider__prev');
		if (nx) nx.addEventListener('click', function () { go(i + 1); play(); });
		if (pr) pr.addEventListener('click', function () { go(i - 1); play(); });
		dots.forEach(function (d, j) { d.addEventListener('click', function () { go(j); play(); }); });

		s.addEventListener('mouseenter', stop);
		s.addEventListener('mouseleave', play);
		s.addEventListener('focusin', stop);
		s.addEventListener('focusout', play);
		document.addEventListener('visibilitychange', function () {
			if (document.hidden) stop(); else play();
		});

		s.addEventListener('keydown', function (e) {
			if (e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') return;
			// ArrowRight means "next" in LTR and "previous" in RTL.
			go((e.key === 'ArrowRight') === (dir < 0) ? i + 1 : i - 1);
			e.preventDefault();
		});

		var x0 = null;
		s.addEventListener('touchstart', function (e) { x0 = e.touches[0].clientX; }, { passive: true });
		s.addEventListener('touchend', function (e) {
			if (x0 === null) return;
			var dx = e.changedTouches[0].clientX - x0;
			if (Math.abs(dx) > 40) {
				// Swipe left (LTR) or right (RTL) shows the next slide.
				go((dx * dir) > 0 ? i + 1 : i - 1);
				play();
			}
			x0 = null;
		}, { passive: true });

		play();
	}

	// Scrollbar width, so full-width sliders (100vw) never overflow the page.
	function setScrollbar() {
		var w = window.innerWidth - document.documentElement.clientWidth;
		document.documentElement.style.setProperty('--tavoos-sbw', (w > 0 ? w : 0) + 'px');
	}
	window.addEventListener('resize', setScrollbar);

	function initAll() {
		setScrollbar();
		document.querySelectorAll('.tavoos-slider').forEach(init);
	}

	window.tavoosSliderInit = initAll;
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initAll);
	} else {
		initAll();
	}
})();
