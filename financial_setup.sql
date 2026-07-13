-- =====================================================================
--  Oweili · sold-date column for the artist financial report
--  Run once in phpMyAdmin (DB u405344949_contact).
--  sold_at is stamped when an artwork's status becomes 'sold'.
-- =====================================================================
ALTER TABLE `artworks` ADD COLUMN IF NOT EXISTS `sold_at` TIMESTAMP NULL DEFAULT NULL;
