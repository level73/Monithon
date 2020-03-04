CREATE TABLE `monithon`.`auth_role` (
  `idrole` INT NOT NULL AUTO_INCREMENT,
  `role` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`idrole`));

insert into auth_role (idrole, role) VALUES (1, 'Admin');
insert into auth_role (idrole, role) VALUES (2, 'Editor');
insert into auth_role (idrole, role) VALUES (3, 'Reporter');
insert into auth_role (idrole, role) VALUES (4, 'ASOC 19/20');


CREATE TABLE `monithon`.`entity_asoc` (
  `idasoc` INT NOT NULL AUTO_INCREMENT,
  `remote_id` INT NOT NULL,
  `auth` INT NOT NULL,
  `istituto` TEXT NULL,
  `tipo_istituto` VARCHAR(255) NULL,
  `regione` INT NULL,
  `provincia` INT NULL,
  `comune` VARCHAR(255) NULL,
  `link_blog` TEXT NULL,
  `link_elaborato` TEXT NULL,
  PRIMARY KEY (`idasoc`),
  INDEX `fk_profile_region_idx` (`regione` ASC),
  INDEX `fk_profile_province_idx` (`provincia` ASC),
  INDEX `fk_profile_auth_idx` (`auth` ASC),
  CONSTRAINT `fk_profile_region`
    FOREIGN KEY (`regione`)
    REFERENCES `monithon`.`lexicon_region` (`idregion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_profile_province`
    FOREIGN KEY (`provincia`)
    REFERENCES `monithon`.`lexicon_provincia` (`idprovincia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_profile_auth`
    FOREIGN KEY (`auth`)
    REFERENCES `monithon`.`auth` (`idauth`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
