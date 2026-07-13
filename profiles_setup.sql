-- =====================================================================
--  Oweili · profile fields for the people directory + artist verification
--  Run once in phpMyAdmin (DB u405344949_contact).
--  `profile_picture` already exists in the base schema, so it's not re-added.
-- =====================================================================
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `artist_name` VARCHAR(150) NOT NULL DEFAULT '';
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `art_video`   VARCHAR(255) NOT NULL DEFAULT '';
