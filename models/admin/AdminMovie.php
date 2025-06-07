<?php
require_once __DIR__ . '/../Database.php';

class AdminMovie {
        public static function all() {
        $db = Database::getInstance();
        return $db->query("SELECT * FROM movies ORDER BY movie_id DESC"); 
    }

        public static function find($id) {
        $db = Database::getInstance();
        return $db->querySingle("SELECT * FROM movies WHERE movie_id = ?", [$id]); 
    }

    public static function create($data) {
        $db = Database::getInstance();
        $slug = self::generateUniqueSlug($data['title']);

        return $db->execute("INSERT INTO movies (title, slug, description, poster, release_year) VALUES (?, ?, ?, ?, ?)", [
            $data['title'],
            $slug,
            $data['description'],
            $data['poster'],
            $data['release_year']
        ]);
    }
    private static function generateUniqueSlug($title) {
        $db = Database::getInstance();
        $baseSlug = self::toSlug($title);
        $slug = $baseSlug;
        $i = 1;

        while (!self::isSlugUnique($slug)) {
            $slug = $baseSlug . '-' . $i;
            $i++;
        }

        return $slug;
    }

    private static function isSlugUnique($slug) {
        $db = Database::getInstance();
        $result = $db->querySingle("SELECT * FROM movies WHERE slug = ?", [$slug]);
        return $result === false || $result === null;
    }



    private static function toSlug($str) {
        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9-]+/', '-', $str);
        $str = preg_replace('/-+/', '-', $str);
        return trim($str, '-');
    }

    public static function update($id, $data) {
        $db = Database::getInstance();
        return $db->execute("UPDATE movies SET title = ?, description = ?, poster = ?, release_year = ? WHERE movie_id = ?", [
            $data['title'],
            $data['description'],
            $data['poster'],
            $data['release_year'],
            $id
        ]);
    }

    public static function delete($id) {
        $db = Database::getInstance();
        return $db->execute("DELETE FROM movies WHERE movie_id = ?", [$id]);
    }
    


}
