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
