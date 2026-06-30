-- =====================================================================
--  Resha Art · Chat rooms schema + messages.room_id
--  Import via phpMyAdmin (select your DB first), or:
--    mysql -u <user> -p <database> < chat_setup.sql
-- =====================================================================
SET NAMES utf8mb4;

-- ---- Chat rooms ----
CREATE TABLE IF NOT EXISTS `chat_rooms` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug`       VARCHAR(50)  NOT NULL,
  `name_en`    VARCHAR(100) NOT NULL,
  `name_ar`    VARCHAR(100) NOT NULL,
  `icon`       VARCHAR(16)  NOT NULL DEFAULT '',
  `sort_order` INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_chat_rooms_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---- Seed the 8 rooms (idempotent) ----
INSERT INTO `chat_rooms` (`slug`,`name_en`,`name_ar`,`icon`,`sort_order`) VALUES
('general',     'General Discussion',     'نقاش عام',                    '💬', 1),
('watercolor',  'Watercolor',             'الألوان المائية',             '🎨', 2),
('oil',         'Oil Painting',           'الرسم الزيتي',                '🖼️', 3),
('digital',     'Digital Art',            'الفن الرقمي',                 '🖥️', 4),
('charcoal',    'Charcoal & Sketching',   'الفحم والرسم التخطيطي',       '✏️', 5),
('sculpture',   'Sculpture & 3D Art',     'النحت والفن ثلاثي الأبعاد',   '🗿', 6),
('marketplace', 'Marketplace & Sales',    'السوق والمبيعات',             '🛒', 7),
('events',      'Events & Exhibitions',   'الفعاليات والمعارض',          '📅', 8)
ON DUPLICATE KEY UPDATE
  `name_en`=VALUES(`name_en`), `name_ar`=VALUES(`name_ar`),
  `icon`=VALUES(`icon`), `sort_order`=VALUES(`sort_order`);

-- ---- Link messages to a room ----
-- Run these only if the column does not already exist.
ALTER TABLE `messages`
  ADD COLUMN `room_id` INT UNSIGNED NULL DEFAULT NULL AFTER `sender_id`,
  ADD KEY `idx_messages_room` (`room_id`);

-- Point any existing messages at the General room so they aren't orphaned.
UPDATE `messages`
  SET `room_id` = (SELECT id FROM chat_rooms WHERE slug='general' LIMIT 1)
  WHERE `room_id` IS NULL;

-- Optional foreign key (skip if your messages table already has data issues).
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_messages_room`
  FOREIGN KEY (`room_id`) REFERENCES `chat_rooms`(`id`)
  ON DELETE SET NULL ON UPDATE CASCADE;
