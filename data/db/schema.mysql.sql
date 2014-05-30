CREATE TABLE `roles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(128) NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci;

CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(256) DEFAULT NULL,
  `email` VARCHAR(128) DEFAULT NULL,
  `uuid` VARCHAR(40) DEFAULT NULL,
  `username` VARCHAR(128) DEFAULT NULL,
  `password` VARCHAR(128) DEFAULT NULL,
  `enabled` TINYINT(1) NOT NULL DEFAULT '1',
  `role_id` INT DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `uuid_UNIQUE` (`uuid`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_users_1_idx` (`role_id`),
  CONSTRAINT `fk_users_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci;

CREATE TABLE `sessions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `token` VARCHAR(256) NOT NULL,
  `valid` TINYINT(1) NOT NULL DEFAULT 1,
  `expiration_date` DATETIME NOT NULL,
  `ip_address` VARCHAR(50) NULL,
  `user_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_sessions_1_idx` (`user_id` ASC),
  CONSTRAINT `fk_sessions_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci;

CREATE TABLE `bookmark_categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(256) NULL,
  `user_id` INT NOT NULL,
  `parent_id` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_bookmark_categories_1_idx` (`user_id` ASC),
  INDEX `fk_bookmark_categories_2_idx` (`parent_id` ASC),
  CONSTRAINT `fk_bookmark_categories_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bookmark_categories_2` FOREIGN KEY (`parent_id`) REFERENCES `bookmark_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci;

CREATE TABLE `bookmarks` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(256) NOT NULL,
  `url` VARCHAR(1024) NULL,
  `favicon` VARCHAR(1024) NULL,
  `category_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_bookmarks_1_idx` (`category_id` ASC),
  CONSTRAINT `fk_bookmarks_1` FOREIGN KEY (`category_id`) REFERENCES `bookmark_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci;

CREATE TABLE `config_params` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(256) NOT NULL,
  `type` SET('integer', 'string', 'boolean') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci;

CREATE TABLE `users_have_config_params` (
  `user_id` INT NOT NULL,
  `config_param_id` INT NOT NULL,
  `value` VARCHAR(256) NULL,
  PRIMARY KEY (`user_id`, `config_param_id`),
  INDEX `fk_users_have_config_params_1_idx` (`config_param_id` ASC),
  INDEX `fk_users_have_config_params_2_idx` (`user_id` ASC),
  CONSTRAINT `fk_users_have_config_params_1` FOREIGN KEY (`config_param_id`) REFERENCES `config_params` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_users_have_config_params_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci;

CREATE TABLE `feed_folders` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(256) NOT NULL,
  `parent_id` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_feed_folders_1_idx` (`parent_id` ASC),
  CONSTRAINT `fk_feed_folders_1` FOREIGN KEY (`parent_id`) REFERENCES `feed_folders` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
);