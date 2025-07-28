
 document.addEventListener("DOMContentLoaded", function () {
    function wrapPagination() {
        document.querySelectorAll(".custom-carousel-arrows").forEach(function (sliderWrap) {
            const slider = sliderWrap.querySelector('.splide');
            let pagination = slider.querySelector(".splide__pagination");
            const originalArrowPrev = slider.querySelector('.splide__arrow--prev');
            const originalArrowNext = slider.querySelector('.splide__arrow--next');
            

            if (pagination && !pagination.closest(".slider-toggle-wrap")) {
                // Create wrapper div
                let wrapper = document.createElement("div");
                wrapper.classList.add("slider-toggle-wrap");

                // Create left arrow
                let customLeftArrow = document.createElement("div");
                customLeftArrow.classList.add("slider-arrow", "slide-left");
                customLeftArrow.innerHTML = '<svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M9.17097 18.5511C9.35306 18.5511 9.53514 18.4821 9.67889 18.3342C9.95681 18.0484 9.95681 17.5752 9.67889 17.2894L4.36972 11.8285L9.67889 6.36765C9.95681 6.08179 9.95681 5.60865 9.67889 5.32279C9.40097 5.03693 8.94097 5.03693 8.66306 5.32279L2.84597 11.3061C2.56806 11.5919 2.56806 12.0651 2.84597 12.3509L8.66306 18.3342C8.80681 18.4821 8.98889 18.5511 9.17097 18.5511Z" fill="#252525"/> <path d="M3.51706 12.5678H19.6458C20.0387 12.5678 20.3646 12.2327 20.3646 11.8285C20.3646 11.4244 20.0387 11.0892 19.6458 11.0892H3.51706C3.12415 11.0892 2.79831 11.4244 2.79831 11.8285C2.79831 12.2327 3.12415 12.5678 3.51706 12.5678Z" fill="#252525"/> </svg>'; // Replace with icon if needed
                
                // Create right arrow
                let customRightArrow = document.createElement("div");
                customRightArrow.classList.add("slider-arrow", "slide-right");
                 customRightArrow.innerHTML = '<svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M13.829 18.5511C13.6469 18.5511 13.4649 18.4821 13.3211 18.3342C13.0432 18.0484 13.0432 17.5752 13.3211 17.2894L18.6303 11.8285L13.3211 6.36765C13.0432 6.08179 13.0432 5.60865 13.3211 5.32279C13.599 5.03693 14.059 5.03693 14.3369 5.32279L20.154 11.3061C20.4319 11.5919 20.4319 12.0651 20.154 12.3509L14.3369 18.3342C14.1932 18.4821 14.0111 18.5511 13.829 18.5511Z" fill="#252525"/> <path d="M19.4829 12.5678H3.35419C2.96127 12.5678 2.63544 12.2327 2.63544 11.8285C2.63544 11.4244 2.96127 11.0892 3.35419 11.0892H19.4829C19.8759 11.0892 20.2017 11.4244 20.2017 11.8285C20.2017 12.2327 19.8759 12.5678 19.4829 12.5678Z" fill="#252525"/> </svg>'; // Replace with icon if needed

                // Wrap pagination with arrows
                pagination.parentNode.insertBefore(wrapper, pagination);
                wrapper.appendChild(customLeftArrow);
                wrapper.appendChild(pagination);
                wrapper.appendChild(customRightArrow);

                
                customLeftArrow?.addEventListener("click", function () {
                    originalArrowPrev?.click();
                });
                customRightArrow?.addEventListener("click", function () {
                    originalArrowNext?.click();
                });
            }
        });
    }

    // Run the function after Splide initializes (delayed execution)
    setTimeout(wrapPagination, 1000);
});
