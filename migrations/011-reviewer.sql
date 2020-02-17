ALTER TABLE `monithon`.`entity_report_basic`
ADD COLUMN `reviewed_by` INT NULL AFTER `created_by`,
ADD INDEX `fk_report_basic_reviewer_idx` (`reviewed_by` ASC);
;
ALTER TABLE `monithon`.`entity_report_basic`
ADD CONSTRAINT `fk_report_basic_reviewer`
  FOREIGN KEY (`reviewed_by`)
  REFERENCES `monithon`.`auth` (`idauth`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
