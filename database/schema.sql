-- MySQL schema for the Task List application
-- Prefer: php artisan migrate --seed
-- Or run this script after the default Laravel users/cache/jobs/sessions tables exist.

CREATE TABLE IF NOT EXISTS `tasks` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `completed` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT `tasks_user_id_foreign`
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
