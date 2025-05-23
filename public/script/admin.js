document.addEventListener('DOMContentLoaded', function () {
    // Nếu không phải trang load và chưa từng qua trang load trong phiên này
    if (!window.location.pathname.includes('trangload.php') && !sessionStorage.getItem('hasLoaded')) {
        const currentUrl = window.location.href;
        sessionStorage.setItem('hasLoaded', 'true');
        window.location.href = 'trangload.php?redirect=' + encodeURIComponent(currentUrl);
    }
});

// Chuyển trang khi click menu
document.querySelectorAll('.admin-nav a').forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();
        sessionStorage.removeItem('hasLoaded'); // để đảm bảo vẫn đi qua load mỗi lần chuyển trang
        const targetUrl = this.href;
        window.location.href = 'trangload.php?redirect=' + encodeURIComponent(targetUrl);
    });
});
