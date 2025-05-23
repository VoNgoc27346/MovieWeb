(function () {
    const currentPath = window.location.pathname;
    const isTrangLoad = currentPath.includes("trangload.php");
    const hasLoaded = sessionStorage.getItem("hasLoaded");

    if (!isTrangLoad && !hasLoaded) {
        const fullURL = window.location.href;
        sessionStorage.setItem("hasLoaded", "true");
        window.location.href = "trangload.php?redirect=" + encodeURIComponent(fullURL);
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", function (e) {
                if (link.href.startsWith(window.location.origin)) {
                    e.preventDefault();
                    sessionStorage.removeItem("hasLoaded");
                    window.location.href = "trangload.php?redirect=" + encodeURIComponent(link.href);
                }
            });
        });

        window.addEventListener("beforeunload", function () {
            sessionStorage.removeItem("hasLoaded");
        });
    });
})();
