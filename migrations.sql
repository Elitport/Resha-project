-- =====================================================================
--  Resha Art · migrations.sql
--  Brings an existing live `users` table up to date with every column
--  the current PHP expects, and adds `is_banned` for the admin panel.
--
--  HOW TO RUN (phpMyAdmin): select DB `u405344949_reshaart`, open the SQL
--  tab, paste, Go. If your MySQL/MariaDB rejects "IF NOT EXISTS" on ADD
--  COLUMN (older MySQL 8), remove that clause and skip any column that
--  already exists (check with the query at the bottom first).
-- =====================================================================
SET NAMES utf8mb4;

-- ---- users: columns added across later phases ----
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `verification_token`   VARCHAR(128) NULL DEFAULT NULL;
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `verification_expires` TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `instagram` VARCHAR(255) NOT NULL DEFAULT '';
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `twitter`   VARCHAR(255) NOT NULL DEFAULT '';
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `website`   VARCHAR(255) NOT NULL DEFAULT '';
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `is_banned` TINYINT(1) NOT NULL DEFAULT 0;

-- helpful index for the email-verification lookup
ALTER TABLE `users` ADD INDEX IF NOT EXISTS `idx_users_vtoken` (`verification_token`);

-- ---------------------------------------------------------------------
--  Also required for the chat system (run chat_setup.sql if not done):
--    - CREATE TABLE chat_rooms + seed 8 rooms
--    - ALTER TABLE messages ADD COLUMN room_id
-- ---------------------------------------------------------------------

-- ---- Verify which columns exist afterwards ----
-- SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
--  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users'
--  ORDER BY ORDINAL_POSITION;
