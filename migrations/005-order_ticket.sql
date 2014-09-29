CREATE  TABLE IF NOT EXISTS `order_ticket` (
  `uid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `ticket_uid` INT UNSIGNED NOT NULL ,
  `order_uid` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`uid`) ,
  INDEX `INDEX_ticket_id` (`ticket_uid` ASC) ,
  INDEX `INDEX_order_id` (`order_uid` ASC) ,
  UNIQUE INDEX `UNIQUE_ticket_order` (`ticket_uid` ASC, `order_uid` ASC) ,
  CONSTRAINT `FK_OT_ORDER_UID`
    FOREIGN KEY (`order_uid` )
    REFERENCES `order` (`uid` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FK_OT_TICKET_UID`
    FOREIGN KEY (`ticket_uid` )
    REFERENCES `ticket` (`uid` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
COMMENT = 'Relationships between ticket and order entities.';


