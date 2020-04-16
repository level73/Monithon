ALTER TABLE `monithon`.`meta_file_repository`
    DROP FOREIGN KEY `fk_meta_file_repository_file`;
ALTER TABLE `monithon`.`meta_file_repository`
    ADD CONSTRAINT `fk_meta_file_repository_file`
        FOREIGN KEY (`file_repository`)
            REFERENCES `monithon`.`file_repository` (`idfile_repository`)
            ON DELETE CASCADE
            ON UPDATE NO ACTION;

ALTER TABLE `monithon`.`meta_link_repository`
    DROP FOREIGN KEY `fk_meta_link_repository_link`;
ALTER TABLE `monithon`.`meta_link_repository`
    ADD CONSTRAINT `fk_meta_link_repository_link`
        FOREIGN KEY (`link_repository`)
            REFERENCES `monithon`.`link_repository` (`idlink_repository`)
            ON DELETE CASCADE
            ON UPDATE NO ACTION;

