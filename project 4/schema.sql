-- 1. Создайте базу данных blog_db в phpMyAdmin, затем выполните этот SQL
 
CREATE TABLE IF NOT EXISTS `users` (
  `id`            INT(11)      NOT NULL AUTO_INCREMENT,
  `email`         VARCHAR(255) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `role`          ENUM('admin','client') NOT NULL DEFAULT 'client',
  `created_at`    DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 
CREATE TABLE IF NOT EXISTS `articles` (
  `id`         INT(11)      NOT NULL AUTO_INCREMENT,
  `title`      VARCHAR(255) NOT NULL,
  `content`    LONGTEXT     NOT NULL,
  `author_id`  INT(11)      NOT NULL,
  `status`     ENUM('draft','published') DEFAULT 'published',
  `created_at` DATETIME     DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`author_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 
CREATE TABLE IF NOT EXISTS `tags` (
  `id`   INT(11)      NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL UNIQUE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 
CREATE TABLE IF NOT EXISTS `article_tags` (
  `article_id` INT(11) NOT NULL,
  `tag_id`     INT(11) NOT NULL,
  PRIMARY KEY (`article_id`, `tag_id`),
  FOREIGN KEY (`article_id`) REFERENCES `articles`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`tag_id`)     REFERENCES `tags`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 
CREATE TABLE IF NOT EXISTS `comments` (
  `id`         INT(11)  NOT NULL AUTO_INCREMENT,
  `article_id` INT(11)  NOT NULL,
  `user_id`    INT(11)  NOT NULL,
  `content`    TEXT     NOT NULL,
  `status`     ENUM('pending','approved','rejected') DEFAULT 'pending',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`article_id`) REFERENCES `articles`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`)    REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 
-- Администратор по умолчанию
-- Хэш пароля генерируется при первом запуске через fix_admin.php
-- Не храните хэши паролей в исходном коде!
INSERT INTO `users` (email, password_hash, role)
VALUES ('admin@blog.ru', 'CHANGE_ME_ON_FIRST_RUN', 'admin');
 
