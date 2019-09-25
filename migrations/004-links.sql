CREATE TABLE `link_repository` (
  `idlink_repository` INT NOT NULL AUTO_INCREMENT,
  `URL` TEXT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idlink_repository`));

  CREATE TABLE `meta_link_repository` (
  `idmeta_link_repository` int(11) NOT NULL AUTO_INCREMENT,
  `entity` int(11) NOT NULL,
  `record` int(11) NOT NULL,
  `link_repository` int(11) NOT NULL,
  PRIMARY KEY (`idmeta_link_repository`),
  KEY `fk_meta_link_repository_link_idx` (`link_repository`),
  KEY `idx_link_repository_record` (`record`),
  CONSTRAINT `fk_meta_link_repository_link` FOREIGN KEY (`link_repository`) REFERENCES `link_repository` (`idlink_repository`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
