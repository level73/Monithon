CREATE TABLE `entity_university` (
                                                `iduniversity` INT NOT NULL AUTO_INCREMENT,
                                                `auth` INT NOT NULL,
                                                `university` TEXT NOT NULL,
                                                `degree` TEXT NULL,
                                                `class` TEXT NULL,
                                                `provincia` INT(11) NULL,
                                                `comune` VARCHAR(255) NULL,
                                                PRIMARY KEY (`iduniversity`),
                                                INDEX `fk_university_auth_idx` (`auth` ASC),
                                                INDEX `fk_university_provincia_idx` (`provincia` ASC),
                                                CONSTRAINT `fk_university_auth`
                                                    FOREIGN KEY (`auth`)
                                                        REFERENCES  `auth` (`idauth`)
                                                        ON DELETE CASCADE
                                                        ON UPDATE NO ACTION,
                                                CONSTRAINT `fk_university_provincia`
                                                    FOREIGN KEY (`provincia`)
                                                        REFERENCES `lexicon_provincia` (`idprovincia`)
                                                        ON DELETE NO ACTION
                                                        ON UPDATE NO ACTION);
