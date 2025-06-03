<?php include 'views/layouts/header.php'; ?>

<div class="container mx-auto mt-10 p-4">
    <div class="max-w-md mx-auto bg-gray-800 p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-center">Đăng nhập</h1>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="index.php?controller=user&action=login">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium mb-1">Tên đăng nhập</label>
                <input type="text" id="username" name="username" class="w-full p-2 bg-gray-700 rounded-md" required>
            </div>
            
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium mb-1">Mật khẩu</label>
                <input type="password" id="password" name="password" class="w-full p-2 bg-gray-700 rounded-md" required>
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md">
                    Đăng nhập
                </button>
                <!-- <a href="index.php?controller=user&action=login&redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md inline-block">Đăng nhập</a> -->

                <a href="index.php?controller=user&action=register" class="text-blue-400 hover:underline">Chưa có tài khoản?</a>
            </div>
        </form>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>