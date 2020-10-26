ALTER TABLE `monithon`.`entity_report_basic`
ADD COLUMN `tab_3_created_at` TIMESTAMP NULL AFTER `status_tab_3`,
ADD COLUMN `author_type` VARCHAR(150) NULL AFTER `tab_3_created_at`,
ADD COLUMN `legacy_id` INT NULL AFTER `author_type`;

ALTER TABLE `monithon`.`entity_report_basic`
ADD COLUMN `immagine_monitoraggio_daASOC` VARCHAR(255) NULL AFTER `legacy_id`,
ADD COLUMN `video_daASOC` VARCHAR(255) NULL AFTER `immagine_monitoraggio_daASOC`,
ADD COLUMN `immagine_team1_daASOC` VARCHAR(255) NULL AFTER `video_daASOC`,
ADD COLUMN `immagine_team2_daASOC` VARCHAR(255) NULL AFTER `immagine_team1_daASOC`,
ADD COLUMN `immagine_team3_daASOC` VARCHAR(255) NULL AFTER `immagine_team2_daASOC`;


ALTER TABLE `monithon`.`entity_report_basic`
CHANGE COLUMN `autore` `autore` TEXT NULL DEFAULT NULL ;