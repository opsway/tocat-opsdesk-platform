CREATE  TABLE IF NOT EXISTS `project` (
  `uid` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` INT(11) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE INDEX `project_id_UNIQUE` (`project_id` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Projects Table';
