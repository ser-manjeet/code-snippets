
(function () {
    function init() {
        // Your custom script initialization logic here
        console.log("Custom script initialized.");
    }

    // Check if the DOM is already loaded
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // DOM is already loaded, initialize immediately
        init();
    } else {
        // DOM is not yet loaded, listen for DOMContentLoaded
        document.addEventListener("DOMContentLoaded", init);
    }
})();
