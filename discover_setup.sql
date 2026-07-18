-- =====================================================================
--  Oweili · Discover: art events + training institutes
--  Run once in phpMyAdmin (DB u405344949_contact).
-- =====================================================================
CREATE TABLE IF NOT EXISTS `events` (
  `id`              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title_en`        VARCHAR(200) NOT NULL DEFAULT '',
  `title_ar`        VARCHAR(200) NOT NULL DEFAULT '',
  `description_en`  TEXT NULL,
  `description_ar`  TEXT NULL,
  `city`            VARCHAR(120) NOT NULL DEFAULT '',
  `event_date`      DATE NULL DEFAULT NULL,
  `is_free`         TINYINT(1) NOT NULL DEFAULT 1,      -- 1 = free, 0 = paid
  `image_url`       VARCHAR(500) NOT NULL DEFAULT '',
  `contact_link`    VARCHAR(500) NOT NULL DEFAULT '',
  `created_at`      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_events_date` (`event_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `training` (
  `id`              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title_en`        VARCHAR(200) NOT NULL DEFAULT '',
  `title_ar`        VARCHAR(200) NOT NULL DEFAULT '',
  `description_en`  TEXT NULL,
  `description_ar`  TEXT NULL,
  `city`            VARCHAR(120) NOT NULL DEFAULT '',
  `price`           DECIMAL(10,2) NOT NULL DEFAULT 0.00,  -- SAR
  `course_date`     DATE NULL DEFAULT NULL,
  `image_url`       VARCHAR(500) NOT NULL DEFAULT '',
  `contact_link`    VARCHAR(500) NOT NULL DEFAULT '',
  `created_at`      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_training_date` (`course_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
