
CREATE DATABASE IF NOT EXISTS `testdb`;
DROP TABLE IF EXISTS `event_streams`;
CREATE TABLE `event_streams` (
  `no` bigint(20) NOT NULL AUTO_INCREMENT,
  `real_stream_name` varchar(150) COLLATE utf8_bin NOT NULL,
  `stream_name` char(41) COLLATE utf8_bin NOT NULL,
  `metadata` json DEFAULT NULL,
  `category` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`no`),
  UNIQUE KEY `ix_rsn` (`real_stream_name`),
  KEY `ix_cat` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `projections`;
CREATE TABLE `projections` (
  `no` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `position` json DEFAULT NULL,
  `state` json DEFAULT NULL,
  `status` varchar(28) COLLATE utf8_bin NOT NULL,
  `locked_until` char(26) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`no`),
  UNIQUE KEY `ix_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(128) DEFAULT NULL,
  `content` varchar(1024) DEFAULT NULL,
  `author` varchar(45) DEFAULT NULL,
  `tags` varchar(45) DEFAULT NULL,
  `publishedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `snapshots`;
CREATE TABLE `snapshots` (
  `aggregate_id` varchar(150) COLLATE utf8_bin NOT NULL,
  `aggregate_type` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_version` int(11) NOT NULL,
  `created_at` char(26) COLLATE utf8_bin NOT NULL,
  `aggregate_root` blob,
  UNIQUE KEY `ix_aggregate_id` (`aggregate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `email` varchar(45) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;