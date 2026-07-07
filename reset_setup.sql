-- =====================================================================
--  Resha Art · password-reset columns for the users table
--  Run once in phpMyAdmin (DB u405344949_contact). If your MySQL rejects
--  "IF NOT EXISTS" on ADD COLUMN, drop that clause and skip existing ones.
-- =====================================================================
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `reset_token`   VARCHAR(128) NULL DEFAULT NULL;
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `reset_expires` TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE `users` ADD INDEX IF NOT EXISTS `idx_users_reset` (`reset_token`);

-- Widen artworks.type so all the new art styles fit (was an ENUM of 4).
ALTER TABLE `artworks` MODIFY COLUMN `type` VARCHAR(50) NOT NULL DEFAULT 'other';
