<?php include 'views/layouts/header.php'; ?>

<div class="container mx-auto mt-10 p-4">
    <div class="max-w-md mx-auto bg-gray-800 p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-center">Đăng ký</h1>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="index.php?controller=user&action=register">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium mb-1">Tên đăng nhập</label>
                <input type="text" id="username" name="username" class="w-full p-2 bg-gray-700 rounded-md" required>
            </div>
            
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                <input type="email" id="email" name="email" class="w-full p-2 bg-gray-700 rounded-md" required>
            </div>
            
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium mb-1">Mật khẩu</label>
                <input type="password" id="password" name="password" class="w-full p-2 bg-gray-700 rounded-md" required>
            </div>
            
            <div class="mb-6">
                <label for="confirm_password" class="block text-sm font-medium mb-1">Xác nhận mật khẩu</label>
                <input type="password" id="confirm_password" name="confirm_password" class="w-full p-2 bg-gray-700 rounded-md" required>
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-md">
                    Đăng ký
                </button>
                <a href="index.php?controller=user&action=login" class="text-blue-400 hover:underline">Đã có tài khoản?</a>
            </div>
        </form>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>