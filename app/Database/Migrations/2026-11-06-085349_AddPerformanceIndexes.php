<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPerformanceIndexes extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        
        $queries = [
            // Posts table indexes
            "CREATE INDEX idx_posts_slug ON posts (slug)",
            "CREATE INDEX idx_posts_status_id ON posts (status, id)",
            "CREATE INDEX idx_posts_category_id ON posts (category_id)",
            "CREATE INDEX idx_posts_created_at ON posts (created_at)",
            
            // Categories
            "CREATE INDEX idx_categories_slug ON categories (slug)",
            
            // Records table indexes
            "CREATE INDEX idx_records_status ON records (status)",
            "CREATE INDEX idx_records_category_id ON records (category_id)",
            "CREATE INDEX idx_records_person_id ON records (person_id)",
            
            // Post Categories pivot
            "CREATE INDEX idx_post_categories_post_id ON post_categories (post_id)",
            "CREATE INDEX idx_post_categories_cat_id ON post_categories (category_id)"
        ];

        foreach ($queries as $sql) {
            try {
                $db->query($sql);
            } catch (\Throwable $e) {
                // Ignore if index already exists
            }
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        
        $drops = [
            "DROP INDEX idx_posts_slug ON posts",
            "DROP INDEX idx_posts_status_id ON posts",
            "DROP INDEX idx_posts_category_id ON posts",
            "DROP INDEX idx_posts_created_at ON posts",
            "DROP INDEX idx_categories_slug ON categories",
            "DROP INDEX idx_records_status ON records",
            "DROP INDEX idx_records_category_id ON records",
            "DROP INDEX idx_records_person_id ON records",
            "DROP INDEX idx_post_categories_post_id ON post_categories",
            "DROP INDEX idx_post_categories_cat_id ON post_categories"
        ];

        foreach ($drops as $sql) {
            try {
                $db->query($sql);
            } catch (\Throwable $e) {}
        }
    }
}
