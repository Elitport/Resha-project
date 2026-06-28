-- =====================================================================
--  Resha Art · Database Schema (MySQL 8 / MariaDB · Hostinger)
--  Engine: InnoDB · Charset: utf8mb4 (full Unicode incl. Arabic + emoji)
--
--  Import via phpMyAdmin (Hostinger) or:
--    mysql -u <user> -p <database> < setup.sql
-- =====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
--  USERS
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email`            VARCHAR(190) NOT NULL,
  `password`         VARCHAR(255) NOT NULL,            -- BCRYPT hash (password_hash)
  `full_name_en`     VARCHAR(150) NOT NULL DEFAULT '',
  `full_name_ar`     VARCHAR(150) NOT NULL DEFAULT '',
  `role`             ENUM('artist','collector','admin') NOT NULL DEFAULT 'collector',
  `profile_picture`  VARCHAR(255) NOT NULL DEFAULT '',
  `bio_en`           TEXT NULL,
  `bio_ar`           TEXT NULL,
  `city`             VARCHAR(100) NOT NULL DEFAULT '',
  `is_verified`      TINYINT(1) NOT NULL DEFAULT 0,    -- email verified
  `is_approved`      TINYINT(1) NOT NULL DEFAULT 0,    -- approved by admin
  `created_at`       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login_at`    TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_users_email` (`email`),
  KEY `idx_users_role` (`role`),
  KEY `idx_users_approved` (`is_approved`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
--  ARTWORKS
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `artworks` (
  `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `artist_id`        BIGINT UNSIGNED NOT NULL,         -- FK -> users.id
  `title_en`         VARCHAR(200) NOT NULL DEFAULT '',
  `title_ar`         VARCHAR(200) NOT NULL DEFAULT '',
  `description_en`   TEXT NULL,
  `description_ar`   TEXT NULL,
  `price`            DECIMAL(12,2) NOT NULL DEFAULT 0.00,  -- SAR
  `type`             ENUM('abstract','landscape','portrait','other') NOT NULL DEFAULT 'other',
  `status`           ENUM('available','sold','auction') NOT NULL DEFAULT 'available',
  `image_url`        VARCHAR(255) NOT NULL DEFAULT '',
  `is_approved`      TINYINT(1) NOT NULL DEFAULT 0,    -- approved by admin
  `created_at`       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_artworks_artist` (`artist_id`),
  KEY `idx_artworks_status` (`status`),
  KEY `idx_artworks_type` (`type`),
  KEY `idx_artworks_approved` (`is_approved`),
  CONSTRAINT `fk_artworks_artist`
    FOREIGN KEY (`artist_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
--  AUCTIONS
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `auctions` (
  `id`                 BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `artwork_id`         BIGINT UNSIGNED NOT NULL,       -- FK -> artworks.id
  `starting_price`     DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `current_bid`        DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `highest_bidder_id`  BIGINT UNSIGNED NULL,           -- FK -> users.id
  `start_time`         TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time`           TIMESTAMP NULL DEFAULT NULL,
  `status`             ENUM('active','ended') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  KEY `idx_auctions_artwork` (`artwork_id`),
  KEY `idx_auctions_status` (`status`),
  KEY `idx_auctions_bidder` (`highest_bidder_id`),
  CONSTRAINT `fk_auctions_artwork`
    FOREIGN KEY (`artwork_id`) REFERENCES `artworks` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_auctions_bidder`
    FOREIGN KEY (`highest_bidder_id`) REFERENCES `users` (`id`)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
--  BIDS
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `bids` (
  `id`           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `auction_id`   BIGINT UNSIGNED NOT NULL,             -- FK -> auctions.id
  `user_id`      BIGINT UNSIGNED NOT NULL,             -- FK -> users.id
  `bid_amount`   DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `created_at`   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_bids_auction` (`auction_id`),
  KEY `idx_bids_user` (`user_id`),
  CONSTRAINT `fk_bids_auction`
    FOREIGN KEY (`auction_id`) REFERENCES `auctions` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bids_user`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
--  MESSAGES (artist chat room)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `messages` (
  `id`           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `sender_id`    BIGINT UNSIGNED NOT NULL,             -- FK -> users.id
  `message_text` TEXT NOT NULL,
  `created_at`   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_messages_sender` (`sender_id`),
  KEY `idx_messages_created` (`created_at`),
  CONSTRAINT `fk_messages_sender`
    FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
--  NOTIFICATIONS
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `notifications` (
  `id`           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`      BIGINT UNSIGNED NOT NULL,             -- FK -> users.id
  `message_text` TEXT NOT NULL,
  `is_read`      TINYINT(1) NOT NULL DEFAULT 0,
  `created_at`   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_notifications_user` (`user_id`),
  KEY `idx_notifications_read` (`is_read`),
  CONSTRAINT `fk_notifications_user`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
--  SESSIONS (login session tracking)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `sessions` (
  `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`        BIGINT UNSIGNED NOT NULL,           -- FK -> users.id
  `session_token`  VARCHAR(128) NOT NULL,
  `ip_address`     VARCHAR(45) NOT NULL DEFAULT '',    -- IPv4 / IPv6
  `created_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at`     TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_sessions_token` (`session_token`),
  KEY `idx_sessions_user` (`user_id`),
  KEY `idx_sessions_expires` (`expires_at`),
  CONSTRAINT `fk_sessions_user`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
--  LOGIN ATTEMPTS (rate limiting — used by config.php)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id`           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address`   VARCHAR(45) NOT NULL DEFAULT '',
  `email`        VARCHAR(190) NOT NULL DEFAULT '',
  `success`      TINYINT(1) NOT NULL DEFAULT 0,
  `created_at`   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_attempts_ip_time` (`ip_address`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
