ALTER TABLE `monithon`.`entity_report_basic`
ADD COLUMN `api_data` TEXT NULL AFTER `id_open_coesione`;

ALTER TABLE `monithon`.`entity_report_basic`
ADD COLUMN `parte_di_piano` TEXT NULL AFTER `descrizione`;
