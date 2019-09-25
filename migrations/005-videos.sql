CREATE TABLE `video_repository` (
  `idvideo_repository` INT NOT NULL AUTO_INCREMENT,
  `URL` TEXT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idvideo_repository`));

  CREATE TABLE `meta_video_repository` (
  `idmeta_video_repository` int(11) NOT NULL AUTO_INCREMENT,
  `entity` int(11) NOT NULL,
  `record` int(11) NOT NULL,
  `video_repository` int(11) NOT NULL,
  PRIMARY KEY (`idmeta_video_repository`),
  KEY `fk_meta_video_repository_video_idx` (`video_repository`),
  KEY `idx_video_repository_record` (`record`),
  CONSTRAINT `fk_meta_video_repository_video` FOREIGN KEY (`video_repository`) REFERENCES `video_repository` (`idvideo_repository`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
