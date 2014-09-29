CREATE  TABLE IF NOT EXISTS `order_project` (
  `uid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `project_uid` INT UNSIGNED NOT NULL ,
  `order_uid` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`uid`) ,
  INDEX `INDEX_project_id` (`project_uid` ASC) ,
  INDEX `INDEX_order_id` (`order_uid` ASC) ,
  UNIQUE INDEX `UNIQUE_project_order` (`project_uid` ASC, `order_uid` ASC) ,
  CONSTRAINT `FK_OP_ORDER_UID`
    FOREIGN KEY (`order_uid` )
    REFERENCES `order` (`uid` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FK_OP_PROJECT_UID`
    FOREIGN KEY (`project_uid` )
    REFERENCES `project` (`uid` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
COMMENT = 'Relationships between project and order entities.';


