-- following is query for sqlite database

CREATE TABLE `user` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    `fullname` VARCHAR(50) NOT NULL,
    `username` TEXT NOT NULL UNIQUE,
    `password` TEXT NOT NULL,
    `roles` VARCHAR(255) NOT NULL DEFAULT 'Operator',
    `active` INTEGER NOT NULL DEFAULT 1
);
