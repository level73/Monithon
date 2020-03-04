CREATE TABLE `entity_report_basic` (
  `idreport_basic` INT NOT NULL AUTO_INCREMENT,
  `titolo` TEXT NULL,
  `autore` VARCHAR(255) NULL,
  `id_open_coesione` VARCHAR(255) NULL,
  `descrizione` TEXT NULL,
  `giudizio_sintetico` TEXT NULL,
  `avanzamento` TEXT NULL,
  `risultato_progetto` TEXT NULL,
  `punti_di_forza` TEXT NULL,
  `punti_deboli` TEXT NULL,
  `rischi` TEXT NULL,
  `soluzioni_progetto` TEXT NULL,
  `raccolta_informazioni` TEXT NULL,
  `visita_diretta` TINYINT NULL,
  `intervista_responsabili_progetto` TINYINT NULL,
  `intervista_utenti_beneficiari` TINYINT NULL,
  `intervista_altri_utenti` TINYINT NULL,
  `raccolta_info_web` TINYINT NULL,
  `raccolta_info_attuatore` TINYINT NULL,
  `referenti_politici` TINYINT NULL,
  `lat_` VARCHAR(255) NULL,
  `lon_` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL,
  `modified_at` TIMESTAMP NULL,
  PRIMARY KEY (`idreport_basic`));

ALTER TABLE `entity_report_basic`
CHANGE COLUMN `giudizio_sintetico` `giudizio_sintetico` ENUM('Appena iniziato', 'In corso e procede bene', 'Procede con difficoltà', 'Bloccato', 'Concluso e utile', 'Concluso e inefficace') NULL DEFAULT NULL ;

ALTER TABLE `entity_report_basic`
ADD COLUMN `status` INT NOT NULL DEFAULT 1 AFTER `modified_at`;

ALTER TABLE `entity_report_basic`
ADD COLUMN `indirizzo` TEXT NULL AFTER `id_open_coesione`,
ADD COLUMN `intervista_intervistati` TEXT NULL AFTER `referenti_politici`,
ADD COLUMN `intervista_domande` TEXT NULL AFTER `intervista_intervistati`,
ADD COLUMN `intervista_risposte` TEXT NULL AFTER `intervista_domande`,
CHANGE COLUMN `lat_` `lat_` VARCHAR(255) NULL DEFAULT NULL AFTER `indirizzo`,
CHANGE COLUMN `lon_` `lon_` VARCHAR(255) NULL DEFAULT NULL AFTER `lat_`;
ALTER TABLE `entity_report_basic`
CHANGE COLUMN `status` `status` INT(11) NOT NULL DEFAULT '1' COMMENT 'This field can have the following values: \n1 = Draft\n3 = Pending Review\n5 = In Review\n7 = Published' ;
ALTER TABLE `entity_report_basic`
ADD COLUMN `created_by` INT NOT NULL AFTER `modified_at`,
CHANGE COLUMN `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `modified_at` `modified_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
ADD INDEX `fk_report_basic_creator_idx` (`created_by` ASC);
;
ALTER TABLE `entity_report_basic` 
ADD CONSTRAINT `fk_report_basic_creator`
  FOREIGN KEY (`created_by`)
  REFERENCES `monithon`.`auth` (`idauth`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
