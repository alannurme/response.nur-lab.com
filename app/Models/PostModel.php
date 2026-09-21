<?php
namespace App\Models;
use App\Core\Model;

class PostModel extends Model {
    public function getAllPosts($limit = 10, $offset = 0, $include_drafts = false) {
        $statusClause = $include_drafts ? "" : "WHERE p.status = 'published'";
        $stmt = $this->db->prepare("SELECT p.id, p.category_id, p.title, p.slug, p.excerpt, SUBSTRING(p.content, 1, 300) AS content, p.featured_image, p.post_type, p.views, p.fake_views, p.status, p.created_at, 
                                           COALESCE(GROUP_CONCAT(DISTINCT c.name SEPARATOR ', '), c2.name) as category_name,
                                           COALESCE(GROUP_CONCAT(DISTINCT a.name SEPARATOR ', '), p.author, 'Admin') as author_name
                                    FROM posts p 
                                    LEFT JOIN post_categories pc ON p.id = pc.post_id
                                    LEFT JOIN categories c ON pc.category_id = c.id 
                                    LEFT JOIN categories c2 ON p.category_id = c2.id
                                    LEFT JOIN post_authors pa ON p.id = pa.post_id
                                    LEFT JOIN authors a ON pa.author_id = a.id
                                    $statusClause 
                                    GROUP BY p.id
                                    ORDER BY p.created_at DESC 
                                    LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTotalPostsCount($include_drafts = false) {
        $statusClause = $include_drafts ? "" : "WHERE status = 'published'";
        $stmt = $this->db->query("SELECT COUNT(*) FROM posts $statusClause");
        return (int)$stmt->fetchColumn();
    }

    public function getPostBySlug($slug) {
        $stmt = $this->db->prepare("SELECT p.*, COALESCE(GROUP_CONCAT(c.name SEPARATOR ', '), c2.name) as category_name 
                                    FROM posts p 
                                    LEFT JOIN post_categories pc ON p.id = pc.post_id
                                    LEFT JOIN categories c ON pc.category_id = c.id 
                                    LEFT JOIN categories c2 ON p.category_id = c2.id
                                    WHERE p.slug = :slug
                                    GROUP BY p.id");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }

    public function getPostCategories($post_id) {
        $stmt = $this->db->prepare("SELECT c.* FROM categories c 
                                    JOIN post_categories pc ON c.id = pc.category_id 
                                    WHERE pc.post_id = :post_id 
                                    ORDER BY c.order_index ASC, c.name ASC");
        $stmt->execute(['post_id' => $post_id]);
        $cats = $stmt->fetchAll();
        if (empty($cats)) {
            $stmt2 = $this->db->prepare("SELECT c.* FROM categories c 
                                         JOIN posts p ON c.id = p.category_id 
                                         WHERE p.id = :post_id");
            $stmt2->execute(['post_id' => $post_id]);
            $cats = $stmt2->fetchAll();
        }
        return $cats;
    }

    public function getPostAuthors($post_id) {
        $stmt = $this->db->prepare("SELECT a.* FROM authors a 
                                    JOIN post_authors pa ON a.id = pa.author_id 
                                    WHERE pa.post_id = :post_id 
                                    ORDER BY a.name ASC");
        $stmt->execute(['post_id' => $post_id]);
        $authors = $stmt->fetchAll();
        if (empty($authors)) {
            $stmt2 = $this->db->prepare("SELECT author as name FROM posts WHERE id = :post_id");
            $stmt2->execute(['post_id' => $post_id]);
            $author_name = $stmt2->fetchColumn() ?: 'Admin';
            $authors = [['name' => $author_name, 'email' => '']];
        }
        return $authors;
    }

    public function getPostById($id) {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getCategories() {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY order_index ASC, name ASC");
        return $stmt->fetchAll();
    }

    public function getSlides() {
        $stmt = $this->db->query("SELECT * FROM slides ORDER BY order_index ASC");
        return $stmt->fetchAll();
    }

    public function getRelatedPosts($category_id, $current_post_id, $limit = 3) {
        $stmt = $this->db->prepare("SELECT DISTINCT p.id, p.category_id, p.title, p.slug, p.excerpt, SUBSTRING(p.content, 1, 300) AS content, p.featured_image, p.post_type, p.views, p.fake_views, p.status, p.created_at FROM posts p 
                                    JOIN post_categories pc ON p.id = pc.post_id
                                    WHERE pc.category_id = :category_id 
                                    AND p.id != :current_id 
                                    AND p.status = 'published' 
                                    ORDER BY p.created_at DESC 
                                    LIMIT :limit");
        $stmt->bindValue(':category_id', $category_id, \PDO::PARAM_INT);
        $stmt->bindValue(':current_id', $current_post_id, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function incrementViews($id) {
        $stmt = $this->db->prepare("UPDATE posts SET views = views + 1 WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getPostViews($id) {
        $stmt = $this->db->prepare("SELECT views FROM posts WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return (int)$stmt->fetchColumn();
    }

    public function getPopularPosts($limit = 5) {
        $stmt = $this->db->prepare("SELECT p.id, p.category_id, p.title, p.slug, p.excerpt, SUBSTRING(p.content, 1, 300) AS content, p.featured_image, p.post_type, p.views, p.fake_views, p.status, p.created_at, GROUP_CONCAT(c.name SEPARATOR ', ') as category_name 
                                    FROM posts p 
                                    LEFT JOIN post_categories pc ON p.id = pc.post_id
                                    LEFT JOIN categories c ON pc.category_id = c.id 
                                    WHERE p.status = 'published' 
                                    GROUP BY p.id
                                    ORDER BY p.views DESC 
                                    LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPostsByCategoryForAdmin($categoryId = null, $limit = 100, $offset = 0, $showMode = 'all') {
        if ($categoryId === null) {
            $sql = "SELECT p.id, p.category_id, p.title, p.slug, p.excerpt, p.featured_image, p.post_type, p.views, p.fake_views, p.status, p.created_at,
                           c2.name as main_category,
                           GROUP_CONCAT(DISTINCT c.name ORDER BY c.name SEPARATOR ', ') as secondary_categories,
                           COALESCE(GROUP_CONCAT(DISTINCT a.name SEPARATOR ', '), p.author, 'Admin') as author_name
                     FROM posts p
                     LEFT JOIN post_categories pc ON p.id = pc.post_id
                     LEFT JOIN categories c ON pc.category_id = c.id
                     LEFT JOIN categories c2 ON p.category_id = c2.id
                     LEFT JOIN post_authors pa ON p.id = pa.post_id
                     LEFT JOIN authors a ON pa.author_id = a.id
                     GROUP BY p.id
                     ORDER BY p.created_at DESC
                     LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($sql);
        } else {
            $whereClause = ($showMode === 'primary') ? "p.category_id = :category_id" : "(p.category_id = :category_id OR pc.category_id = :category_id)";
            $sql = "SELECT p.id, p.category_id, p.title, p.slug, p.excerpt, p.featured_image, p.post_type, p.views, p.fake_views, p.status, p.created_at,
                            c2.name as main_category,
                            GROUP_CONCAT(DISTINCT c.name ORDER BY c.name SEPARATOR ', ') as secondary_categories,
                            COALESCE(GROUP_CONCAT(DISTINCT a.name SEPARATOR ', '), p.author, 'Admin') as author_name
                    FROM posts p
                    LEFT JOIN post_categories pc ON p.id = pc.post_id
                    LEFT JOIN categories c ON pc.category_id = c.id
                    LEFT JOIN categories c2 ON p.category_id = c2.id
                    LEFT JOIN post_authors pa ON p.id = pa.post_id
                    LEFT JOIN authors a ON pa.author_id = a.id
                    WHERE $whereClause
                    GROUP BY p.id
                    ORDER BY p.created_at DESC
                    LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':category_id', (int)$categoryId, \PDO::PARAM_INT);
        }
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPostsCountByCategoryForAdmin($categoryId = null, $showMode = 'all') {
        if ($categoryId === null) {
            // Root folder = ALL posts
            $sql = "SELECT COUNT(DISTINCT p.id) FROM posts p";
            $stmt = $this->db->prepare($sql);
        } else {
            $whereClause = ($showMode === 'primary') ? "p.category_id = :category_id" : "(p.category_id = :category_id OR pc.category_id = :category_id)";
            $sql = "SELECT COUNT(DISTINCT p.id) 
                    FROM posts p
                    LEFT JOIN post_categories pc ON p.id = pc.post_id
                    WHERE $whereClause";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':category_id', (int)$categoryId, \PDO::PARAM_INT);
        }
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function getTreePosts() {
        $stmt = $this->db->query("
            SELECT p.id, p.title, p.slug, COALESCE(pc.category_id, p.category_id) as category_id 
            FROM posts p
            LEFT JOIN post_categories pc ON p.id = pc.post_id
            ORDER BY p.title ASC
        ");
        return $stmt->fetchAll();
    }
}
