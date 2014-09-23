CREATE TABLE IF NOT EXISTS `project` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `budget` decimal(12,3) NOT NULL DEFAULT '0.000',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `project_id_UNIQUE` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Projects Table';