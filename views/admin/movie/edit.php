<style>
    body {
        background: linear-gradient(135deg, #232526 0%, #414345 100%);
        min-height: 100vh;
        margin: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
    }
    form {
        max-width: 400px;
        margin: 40px auto;
        padding: 28px 36px;
        background: rgba(30, 30, 40, 0.92);
        border-radius: 14px;
        box-shadow: 0 8px 32px 0 rgba(32, 4, 192, 0.45), 0 1.5px 8px rgba(71, 135, 224, 0.18);
        font-family: inherit;
        border: 1.5px solid rgba(120, 0, 180, 0.18);
        position: relative;
        overflow: hidden;
    }
    form::before {
        content: "";
        position: absolute;
        top: -60px; left: -60px;
        width: 180px; height: 180px;
        background: radial-gradient(circle,rgba(15, 75, 163, 0.71) 0%, transparent 70%);
        z-index: 0;
        pointer-events: none;
    }
    label {
        font-weight: 500;
        color: #e0d7ff;
        margin-bottom: 7px;
        display: block;
        letter-spacing: 0.5px;
        text-shadow: 0 1px 8px #6c3cff44;
    }
    input[type="text"], input[type="number"], textarea {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 18px;
        border: 1.5px solid #6c3cff55;
        border-radius: 7px;
        font-size: 15px;
        background: rgba(40, 30, 60, 0.85);
        color: #f3eaff;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-shadow: 0 1px 8px #6c3cff11;
    }
    input[type="text"]:focus, input[type="number"]:focus, textarea:focus {
        border-color: #a259ff;
        outline: none;
        background: #2d1e3a;
        box-shadow: 0 0 8px #a259ff55;
    }
    textarea {
        resize: vertical;
        min-height: 80px;
    }
    button[type="submit"] {
        background: linear-gradient(90deg, #a259ff 0%, #6c3cff 100%);
        color: #fff;
        border: none;
        padding: 11px 32px;
        border-radius: 7px;
        font-size: 17px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 2px 12px #6c3cff33;
        transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
        letter-spacing: 1px;
        margin-top: 8px;
    }
    button[type="submit"]:hover {
        background: linear-gradient(90deg, #6c3cff 0%, #a259ff 100%);
        box-shadow: 0 4px 20px #a259ff44;
        transform: translateY(-2px) scale(1.03);
    }
    h2 {
        text-align: center;
        color: #fff;
        text-shadow: 0 2px 16px #a259ff55;
        letter-spacing: 2px;
        margin-top: 36px;
        margin-bottom: 0;
        font-weight: 700;
    }
</style>
<h2>Chỉnh sửa phim</h2>
<form method="post" action="?controller=admin&action=update&id=<?= $movie['movie_id'] ?>">
    <label>Tiêu đề:</label><br>
    <input type="text" name="title" value="<?= $movie['title'] ?>" required><br><br>

    <label>Mô tả:</label><br>
    <textarea name="description" rows="4"><?= $movie['description'] ?></textarea><br><br>

    <label>Poster URL:</label><br>
    <input type="text" name="poster" value="<?= $movie['poster'] ?>"><br><br>

    <label>Năm phát hành:</label><br>
    <input type="number" name="release_year" value="<?= $movie['release_year'] ?>"><br><br>

    <button type="submit">Cập nhật</button>
</form>
