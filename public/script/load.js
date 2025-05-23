
document.addEventListener("DOMContentLoaded", function () {
   const urlParams = new URLSearchParams(window.location.search);
   const redirectUrl = urlParams.get("redirect") || "trangAdmin.php";

    setTimeout(() => {
       window.location.href = decodeURIComponent(redirectUrl);
    }, 2000);
});