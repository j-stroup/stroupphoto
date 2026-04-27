// js/main.js
document.addEventListener("DOMContentLoaded", function() {
    const images = document.querySelectorAll('.blur-load img');
    images.forEach(img => {
        if (img.complete) {
            img.parentElement.classList.add('loaded');
        } else {
            img.addEventListener('load', function() {
                this.parentElement.classList.add('loaded');
            });
        }
    });
});