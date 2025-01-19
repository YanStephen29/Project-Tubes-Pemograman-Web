document.addEventListener("DOMContentLoaded", () => {
    const body = document.querySelector("body");

    function setBackgroundSize() {
        const width = window.innerWidth;
        const height = window.innerHeight;

        if (width > height) {
            body.style.backgroundSize = "auto 100%";
        } else {
            body.style.backgroundSize = "100% auto";
        }
    }

    setBackgroundSize();
    window.addEventListener("resize", setBackgroundSize);
});
    