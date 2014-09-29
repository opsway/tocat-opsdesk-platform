CREATE TABLE IF NOT EXISTS `ticket` (
  `uid` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ticket_id` INT UNSIGNED NOT NULL,
  `budget` DECIMAL(12,3) NOT NULL DEFAULT 0.000,
  PRIMARY KEY (`uid`),
  UNIQUE INDEX `ticket_id_UNIQUE` (`ticket_id` ASC)
) ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'List of ticket with budgets';
