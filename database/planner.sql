CREATE TABLE `events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `theme` varchar(255) NOT NULL,
  `type_id` int(10) NOT NULL,
  `place` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `duration_id` int(10) NOT NULL,
  `comment` varchar(255) NULL DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `duration_id` (`duration_id`),
  KEY `type_id` (`type_id`)
)DEFAULT CHARSET=utf8;

CREATE TABLE `types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
)DEFAULT CHARSET=utf8;

INSERT INTO `types` (`name`) VALUES
('Встреча'), 
('Звонок'), 
('Совещание'),
('Дело');

CREATE TABLE `duration` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
)DEFAULT CHARSET=utf8;

INSERT INTO `duration` (`name`) VALUES
('5 минут'), 
('15 минут'), 
('30 минут'),
('1 час'),
('2 часа'),
('3 часа'),
('Весь день');