CREATE TABLE `monithon`.`entity_comment` (
  `idcomment` INT NOT NULL AUTO_INCREMENT,
  `entity` INT(11) NOT NULL,
  `record` INT(11) NOT NULL,
  `field` VARCHAR(255) NOT NULL,
  `comment` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT(11) NOT NULL,
  PRIMARY KEY (`idcomment`),
  INDEX `fk_entity_comment_auth_idx` (`created_by` ASC),
  CONSTRAINT `fk_entity_comment_auth`
    FOREIGN KEY (`created_by`)
    REFERENCES `monithon`.`auth` (`idauth`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
