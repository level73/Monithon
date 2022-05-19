ALTER TABLE `entity_comment`
    ADD COLUMN `status` TINYINT(1) NOT NULL DEFAULT 1 AFTER `created_by`;