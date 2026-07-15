-- =====================================================================
--  Oweili · add the sub_admin role
--  Run once in phpMyAdmin (DB u405344949_contact).
--  A sub_admin can approve/reject artworks only — no financials, no bans.
-- =====================================================================
ALTER TABLE `users`
  MODIFY COLUMN `role` ENUM('artist','collector','admin','sub_admin')
  NOT NULL DEFAULT 'collector';
