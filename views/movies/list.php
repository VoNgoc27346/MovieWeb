<?php include('../layouts/header.php'); ?>

<!-- Form tìm kiếm và lọc -->
<section class="px-8 mt-10">
    <h2 class="text-xl font-bold mb-4 text-white">Tìm kiếm và lọc sản phẩm</h2>
    <form method="GET" class="bg-[#222232] p-6 rounded-lg shadow-lg">
        <input type="hidden" name="controller" value="product">
        <input type="hidden" name="action" value="list">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Tìm kiếm theo tên -->
            <div>
                <label class="block text-sm font-medium mb-2 text-gray-300">Tìm kiếm</label>
                <input type="text" name="search" value="<?= htmlspecialchars($filters['search']) ?>" placeholder="Nhập tên sản phẩm..." class="w-full p-2 rounded bg-gray-800 text-white border border-gray-600">
            </div>
            <!-- Lọc theo danh mục -->
            <div>
                <label class="block text-sm font-medium mb-2 text-gray-300">Danh mục</label>
                <select name="category" class="w-full p-2 rounded bg-gray-800 text-white border border-gray-600">
                    <option value="">Tất cả</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['name']) ?>" <?= $filters['category'] === $category['name'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Lọc theo thương hiệu -->
            <div>
                <label class="block text-sm font-medium mb-2 text-gray-300">Thương hiệu</label>
                <select name="brand" class="w-full p-2 rounded bg-gray-800 text-white border border-gray-600">
                    <option value="">Tất cả</option>
                    <?php foreach ($brands as $brand): ?>
                        <option value="<?= htmlspecialchars($brand['name']) ?>" <?= $filters['brand'] === $brand['name'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($brand['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Lọc theo giá -->
            <div>
                <label class="block text-sm font-medium mb-2 text-gray-300">Khoảng giá (VNĐ)</label>
                <div class="flex gap-2">
                    <input type="number" name="price_min" value="<?= htmlspecialchars($filters['price_min']) ?>" placeholder="Từ" class="w-1/2 p-2 rounded bg-gray-800 text-white border border-gray-600">
                    <input type="number" name="price_max" value="<?= htmlspecialchars($filters['price_max']) ?>" placeholder="Đến" class="w-1/2 p-2 rounded bg-gray-800 text-white border border-gray-600">
                </div>
            </div>
        </div>
        <button type="submit" class="mt-4 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Lọc
        </button>
    </form>
</section>

<!-- Hiển thị danh sách sản phẩm -->
<section class="px-8 mt-10">
    <h2 class="text-xl font-bold mb-4 text-white">Danh sách sản phẩm</h2>
    <div class="grid grid-cols-2 md:grid-cols-6 gap-6">
        <?php foreach ($products as $product): ?>
            <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
                <img src="<?= htmlspecialchars($product['image']) ?>" class="w-full h-36 object-cover img-hover" alt="<?= htmlspecialchars($product['name']) ?>">
                <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
                    <a href="/MovieWeb/index.php?controller=product&action=detail&slug=<?= htmlspecialchars($product['slug']) ?>" class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem chi tiết</a>
                </div>
                <div class="p-4">
                    <span class="bg-[#51b17e] text-xs font-semibold px-2 py-1 rounded"><?= htmlspecialchars($product['category']) ?></span>
                    <h3 class="mt-2 text-base font-semibold"><?= htmlspecialchars($product['name']) ?></h3>
                    <p class="text-xs text-gray-400 mt-1"><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php include('../layouts/footer.php'); ?>