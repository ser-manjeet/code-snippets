/**
 * Custom navigation button handler for Splide.js sliders.
 * 
 * This script ensures that custom slide buttons (`.slide-prev`, `.slide-next`)
 * correctly trigger Splide's native arrows, even if this script runs before 
 * Splide has initialized and rendered its internal DOM.
 * 
 * Compatible with multiple slider sections on the same page.
 */
(function () {
    /**
     * Attaches click handlers to the custom buttons.
     * These buttons simulate a click on the Splide arrows.
     * 
     * @param {HTMLElement} slideSec - The container element for the slider section.
     */
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

    /**
     * Initializes the script by finding all slider sections
     * and setting up event listeners when Splide is ready.
     */
    function init() {
        const slideSections = document.querySelectorAll('.section--custom-slide');
        if (!slideSections.length) return;

        slideSections.forEach(slideSec => {
            const splideInstance = slideSec.querySelector('.splide')?._splide;

            if (splideInstance) {
                // Splide is already initialized
                attachCustomButtons(slideSec);
            } else {
                // Splide is not yet initialized – use MutationObserver to wait
                const observer = new MutationObserver(() => {
                    const arrowsExist = slideSec.querySelector('.splide__arrows');
                    if (arrowsExist) {
                        observer.disconnect(); // Stop observing once arrows appear
                        attachCustomButtons(slideSec);
                    }
                });

                // Start observing the slider container for DOM changes
                observer.observe(slideSec, { childList: true, subtree: true });
            }
        });
    }

    // Ensure the DOM is fully loaded before initialization
    if (document.readyState === "complete" || document.readyState === "interactive") {
        init();
    } else {
        document.addEventListener("DOMContentLoaded", init);
    }
})();
