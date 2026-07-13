-- =====================================================================
--  Oweili · add phone number to users
--  Run once in phpMyAdmin (DB u405344949_contact).
-- =====================================================================
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `phone` VARCHAR(30) NOT NULL DEFAULT '';
