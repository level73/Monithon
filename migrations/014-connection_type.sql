ALTER TABLE `monithon`.`entity_report_basic`
    ADD COLUMN `diffusione_twitter` TINYINT(4) NULL AFTER `necessita_interventi_extra`,
    ADD COLUMN `diffusione_facebook` TINYINT(4) NULL AFTER `diffusione_twitter`,
    ADD COLUMN `diffusione_instagram` TINYINT(4) NULL AFTER `diffusione_facebook`,
    ADD COLUMN `diffusione_eventi` TINYINT(4) NULL AFTER `diffusione_instagram`,
    ADD COLUMN `diffusione_open_admin` TINYINT(4) NULL AFTER `diffusione_eventi`,
    ADD COLUMN `diffusione_blog` TINYINT(4) NULL AFTER `diffusione_open_admin`,
    ADD COLUMN `diffusione_offline` TINYINT(4) NULL AFTER `diffusione_blog`,
    ADD COLUMN `diffusione_incontri` TINYINT(4) NULL AFTER `diffusione_offline`,
    ADD COLUMN `diffusione_interviste` TINYINT(4) NULL AFTER `diffusione_incontri`,
    ADD COLUMN `diffusione_altro` TEXT NULL AFTER `diffusione_interviste`,
    ADD COLUMN `media_connection` TINYINT(4) NULL AFTER `diffusione_altro`,
    ADD COLUMN `tv_locali` TINYINT(4) NULL AFTER `media_connection`,
    ADD COLUMN `tv_nazionali` TINYINT(4) NULL AFTER `tv_locali`,
    ADD COLUMN `giornali_locali` TINYINT(4) NULL AFTER `tv_nazionali`,
    ADD COLUMN `giornali_nazionali` TINYINT(4) NULL AFTER `giornali_locali`,
    ADD COLUMN `blog_online` TINYINT(4) NULL AFTER `giornali_nazionali`,
    ADD COLUMN `media_other` TEXT NULL AFTER `blog_online`,
    ADD COLUMN `admin_response_no` TINYINT(4) NULL AFTER `media_other`,
    ADD COLUMN `admin_response_formal` TINYINT(4) NULL AFTER `admin_response_no`,
    ADD COLUMN `admin_response_some` TINYINT(4) NULL AFTER `admin_response_formal`,
    ADD COLUMN `admin_response_promises` TINYINT(4) NULL AFTER `admin_response_some`,
    ADD COLUMN `admin_response_unlocked` TINYINT(4) NULL AFTER `admin_response_promises`,
    ADD COLUMN `admin_response_flagged` TINYINT(4) NULL AFTER `admin_response_unlocked`,
    ADD COLUMN `admin_altro` TEXT NULL AFTER `admin_response_flagged`,
    ADD COLUMN `impact_description` TEXT NULL AFTER `admin_altro`,
    CHANGE COLUMN `problemi_tecnici` `problemi_tecnici` INT(11) NULL DEFAULT NULL AFTER `intervista_risposte`,
    CHANGE COLUMN `risultato_insoddisfacente` `risultato_insoddisfacente` INT(11) NULL DEFAULT NULL AFTER `problemi_tecnici`,
    CHANGE COLUMN `non_efficace` `non_efficace` INT(11) NULL DEFAULT NULL AFTER `risultato_insoddisfacente`,
    CHANGE COLUMN `non_sufficiente` `non_sufficiente` INT(11) NULL DEFAULT NULL AFTER `non_efficace`,
    CHANGE COLUMN `necessita_interventi_extra` `necessita_interventi_extra` INT(11) NULL DEFAULT NULL AFTER `non_sufficiente`;

ALTER TABLE `monithon`.`entity_report_basic`
    ADD COLUMN `admin_connection` TINYINT(4) NULL AFTER `media_other`;


CREATE TABLE `monithon`.`lexicon_connection_type` (
                                                      `idconnection_type` INT NOT NULL AUTO_INCREMENT,
                                                      `connection_type` VARCHAR(255) NULL,
                                                      PRIMARY KEY (`idconnection_type`));

INSERT INTO `monithon`.`lexicon_connection_type` (`connection_type`) VALUES ('Intervista (fatta o ricevuta)');
INSERT INTO `monithon`.`lexicon_connection_type` (`connection_type`) VALUES ('Partecipazione congiunta a evento pubblico');
INSERT INTO `monithon`.`lexicon_connection_type` (`connection_type`) VALUES ('Partecipazione a audizione / riunione a porte chiuse');
INSERT INTO `monithon`.`lexicon_connection_type` (`connection_type`) VALUES ('Email o contatto telefonico');
INSERT INTO `monithon`.`lexicon_connection_type` (`connection_type`) VALUES ('Partecipazione a evento istituzionale (es. Riunione Comitato di sorveglianza, Consiglio comunale, etc.)');
INSERT INTO `monithon`.`lexicon_connection_type` (`connection_type`) VALUES ('Altro: specificare');




CREATE TABLE `monithon`.`meta_connection` (
                                              `idmeta_connection` INT NOT NULL AUTO_INCREMENT,
                                              `report` INT NOT NULL,
                                              `connection_type` INT NULL,
                                              `subject` VARCHAR(255) NULL,
                                              `role` VARCHAR(255) NULL,
                                              `organisation` VARCHAR(255) NULL,
                                              PRIMARY KEY (`idmeta_connection`),
                                              INDEX `fk_meta_connection_report_idx` (`report` ASC),
                                              INDEX `fk_meta_connection_connection_type_idx` (`connection_type` ASC),
                                              CONSTRAINT `fk_meta_connection_report`
                                                  FOREIGN KEY (`report`)
                                                      REFERENCES `monithon`.`entity_report_basic` (`idreport_basic`)
                                                      ON DELETE CASCADE
                                                      ON UPDATE NO ACTION,
                                              CONSTRAINT `fk_meta_connection_connection_type`
                                                  FOREIGN KEY (`connection_type`)
                                                      REFERENCES `monithon`.`lexicon_connection_type` (`idconnection_type`)
                                                      ON DELETE NO ACTION
                                                      ON UPDATE NO ACTION);
ALTER TABLE `monithon`.`meta_connection`
    ADD COLUMN `connection_type_other` VARCHAR(255) NULL AFTER `connection_type`;




