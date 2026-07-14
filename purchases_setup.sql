-- =====================================================================
--  Oweili · purchases table for the collector dashboard
--  Run once in phpMyAdmin (DB u405344949_contact).
--  A row is created when an artwork is sold to a collector.
-- =====================================================================
CREATE TABLE IF NOT EXISTS `purchases` (
  `id`            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `collector_id`  BIGINT UNSIGNED NOT NULL,          -- FK -> users.id (buyer)
  `artwork_id`    BIGINT UNSIGNED NOT NULL,          -- FK -> artworks.id
  `price`         DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `purchased_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_purchases_collector` (`collector_id`),
  KEY `idx_purchases_artwork` (`artwork_id`),
  CONSTRAINT `fk_purchases_collector` FOREIGN KEY (`collector_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_purchases_artwork`  FOREIGN KEY (`artwork_id`)   REFERENCES `artworks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
