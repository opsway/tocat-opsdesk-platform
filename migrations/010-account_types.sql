CREATE  TABLE IF NOT EXISTS `account_type_uid` (
  `uid` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Accounts types';