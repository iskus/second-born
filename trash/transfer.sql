
CREATE TABLE `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(254) DEFAULT '',
  `balance` decimal(8,0) NOT NULL DEFAULT '0',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

CREATE TABLE `transfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_from_id` int(11) NOT NULL,
  `account_to_id` int(11) NOT NULL,
  `amount` decimal(8,0) NOT NULL DEFAULT '0',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`),
  INDEX account_id ( account_from_id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci'
;

CREATE TABLE `operation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(254) DEFAULT '',
  `price` decimal(8,0) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

CREATE TABLE `transfer_operation` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_id` int(11) NOT NULL,
  `operation_id` int(11) NOT NULL,
  `operation_count` int(11) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`no`),
  KEY `transfer_id` (`transfer_id`),
  KEY `operation_id` (`operation_id`),
  CONSTRAINT `transfer_operation_ibfk_1` FOREIGN KEY (`transfer_id`) REFERENCES `transfer` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `transfer_operation_ibfk_2` FOREIGN KEY (`operation_id`) REFERENCES `operation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';