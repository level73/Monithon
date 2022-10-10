ALTER TABLE `entity_report_basic`
    ADD COLUMN `gender_objectives` TINYINT(1) NULL AFTER `necessita_interventi_extra`,
ADD COLUMN `gender_objectives_yes_direct_desc` TEXT NULL AFTER `gender_objectives`,
ADD COLUMN `gender_objectives_yes_indirect_desc` TEXT NULL AFTER `gender_objectives_yes_direct_desc`,

ADD COLUMN `gender_finance` TINYINT(1) NULL AFTER `gender_objectives_yes_indirect_desc`,
ADD COLUMN `gender_finance_desc` TEXT NULL AFTER `gender_finance`,
ADD COLUMN `gender_indicators` TINYINT(1) NULL AFTER `gender_finance_desc`,
ADD COLUMN `gender_indicators_desc` TEXT NULL AFTER `gender_indicators`;

ALTER TABLE `entity_report_basic`
    ADD COLUMN `gender_language` TINYINT(1) NULL AFTER `gender_objectives_yes_indirect_desc`;
ALTER TABLE `entity_report_basic`
    ADD COLUMN `is_gender_topic` TINYINT(1) DEFAULT 0 AFTER `necessita_interventi_extra`;
