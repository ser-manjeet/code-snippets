<script id="custom-slide-btn">
(function () {
	function attachCustomButtons(slideSec) {
		const customSlidePrev = slideSec.querySelector('.slide-prev');
		const customSlideNext = slideSec.querySelector('.slide-next');
		const splidePrev = slideSec.querySelector('.splide__arrow--prev');
		const splideNext = slideSec.querySelector('.splide__arrow--next');

		if (customSlidePrev && splidePrev) {
			customSlidePrev.addEventListener('click', () => splidePrev.click());
		}
		if (customSlideNext && splideNext) {
			customSlideNext.addEventListener('click', () => splideNext.click());
		}
	}

	function init() {
		const slideSections = document.querySelectorAll('.section--custom-slide');
		if (!slideSections.length) return;

		slideSections.forEach(slideSec => {
			const splideInstance = slideSec.querySelector('.splide')?._splide;
			if (splideInstance) {
				// Splide instance already exists
				attachCustomButtons(slideSec);
			} else {
				// Wait until Splide is mounted
				const observer = new MutationObserver(() => {
					const arrowsExist = slideSec.querySelector('.splide__arrows');
					if (arrowsExist) {
						observer.disconnect();
						attachCustomButtons(slideSec);
					}
				});
				observer.observe(slideSec, { childList: true, subtree: true });
			}
		});
	}

	if (document.readyState === "complete" || document.readyState === "interactive") {
		init();
	} else {
		document.addEventListener("DOMContentLoaded", init);
	}
})();
</script>
