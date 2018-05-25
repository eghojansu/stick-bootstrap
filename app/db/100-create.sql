-- following is query for sqlite database
-- config table
CREATE TABLE IF NOT EXISTS `config` (
    `name` TEXT NOT NULL PRIMARY KEY,
    `content` TEXT NOT NULL
);

-- user table
CREATE TABLE IF NOT EXISTS `user` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    `username` TEXT NOT NULL UNIQUE,
    `password` TEXT NOT NULL,
    `roles` TEXT NOT NULL DEFAULT 'ROLE_USER',
    `active` INTEGER NOT NULL DEFAULT 1
);

-- user profile
CREATE TABLE IF NOT EXISTS `profile` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    `user_id` INTEGER NOT NULL UNIQUE,
    `fullname` TEXT NOT NULL
);