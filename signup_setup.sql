-- =====================================================================
--  Oweili · separate signup flows + admin "online" + portfolio
--  Run once in phpMyAdmin (DB u405344949_contact).
-- =====================================================================

-- Last-activity timestamp, updated on each authenticated request.
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `last_active` TIMESTAMP NULL DEFAULT NULL;

-- Portfolio images uploaded by artists at registration (up to 5).
CREATE TABLE IF NOT EXISTS `portfolio_images` (
  `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `artist_id`  BIGINT UNSIGNED NOT NULL,
  `image_url`  VARCHAR(500) NOT NULL DEFAULT '',
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_portfolio_artist` (`artist_id`),
  CONSTRAINT `fk_portfolio_artist` FOREIGN KEY (`artist_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
