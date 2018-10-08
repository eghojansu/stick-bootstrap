-- following is query for sqlite database

CREATE TABLE `config` (
    `name` TEXT NOT NULL PRIMARY KEY,
    `content` TEXT NOT NULL
);

CREATE TABLE `user` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    `fullname` VARCHAR(50) NOT NULL,
    `username` TEXT NOT NULL UNIQUE,
    `password` TEXT NOT NULL,
    `roles` VARCHAR(255) NOT NULL DEFAULT 'ROLE_USER',
    `active` INTEGER NOT NULL DEFAULT 1
);

CREATE TABLE `article` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `title` VARCHAR(100) NOT NULL,
    `content` TEXT NULL DEFAULT NULL,
    `category` VARCHAR(30) NOT NULL DEFAULT 'post',
    `keywords` VARCHAR(200) NULL DEFAULT NULL,
    `publish` INT NOT NULL DEFAULT 1,
    `viewer` INT NOT NULL DEFAULT 0,
    `author` INT NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NULL DEFAULT NULL
);

CREATE TABLE `comment` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `message` TEXT NOT NULL,
    `read` INT NOT NULL DEFAULT 0,
    `article` INT NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NULL DEFAULT NULL
);

CREATE TABLE `guest_book` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `message` TEXT NOT NULL,
    `read` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NULL DEFAULT NULL
);
