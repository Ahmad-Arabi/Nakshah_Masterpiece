"use strict";

const buyNowButton = document.getElementById("buyNow");

buyNowButton.addEventListener("click", function () {
    document.getElementById("action_type").value = "buyNow";
});

document.addEventListener("DOMContentLoaded", function () {
    const toastElement = document.querySelector(".toast-cart");

    if (toastElement) {
        const cartToast = new bootstrap.Toast(toastElement);
        setTimeout(() => {
            cartToast.show();
        }, 1500);
    }
});
