ALTER TABLE `monithon`.`entity_report_basic`
ADD COLUMN `intervista_autorita_gestione` TINYINT NULL AFTER `intervista_altri_utenti`,
ADD COLUMN `intervista_soggetto_programmatore` TINYINT NULL AFTER `intervista_autorita_gestione`;
