CREATE TABLE `lexicon_file_type` (
  `idlexicon_file_type` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `default_disclosure` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`idlexicon_file_type`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `file_repository` (
  `idfile_repository` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` int(11) NOT NULL,
  `disclosure` tinyint(4) NOT NULL DEFAULT '100',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idfile_repository`),
  KEY `fk_file_repository_lexicon_file_type_idx` (`file_type`),
  KEY `fk_file_respository_modified_by` (`modified_by`),
  CONSTRAINT `fk_file_repository_lexicon_file_type` FOREIGN KEY (`file_type`) REFERENCES `lexicon_file_type` (`idlexicon_file_type`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_file_respository_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `auth` (`idauth`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE `meta_file_repository` (
  `idmeta_file_repository` int(11) NOT NULL AUTO_INCREMENT,
  `entity` int(11) NOT NULL,
  `record` int(11) NOT NULL,
  `file_repository` int(11) NOT NULL,
  PRIMARY KEY (`idmeta_file_repository`),
  KEY `fk_meta_file_repository_file_idx` (`file_repository`),
  KEY `idx_file_repository_record` (`record`),
  CONSTRAINT `fk_meta_file_repository_file` FOREIGN KEY (`file_repository`) REFERENCES `file_repository` (`idfile_repository`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

ALTER TABLE `file_repository`
CHANGE COLUMN `disclosure` `disclosure` TINYINT(4) NULL DEFAULT '100' ;

INSERT INTO `lexicon_file_type` (`title`, `default_disclosure`) VALUES ('Avatar', '100');
