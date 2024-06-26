CREATE DATABASE IF NOT EXISTS tasksm_db;
use tasksm_db;

CREATE TABLE if not exists user (
    id_user INT AUTO_INCREMENT,
    id_public VARCHAR(255) NOT NULL,
    `name` VARCHAR(80) NOT NULL CHECK(LENGTH(name) >= 3),
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hashed VARCHAR(255) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT now(),

    PRIMARY KEY(`id_user`)
);

create unique index idx_user_id_public on user(id_public);
create index idx_user_name on user(name);
create unique index idx_user_email on user(email);

create table if not exists task_status (
    id_task_status INT AUTO_INCREMENT,
    name VARCHAR(45) NOT NULL UNIQUE,

    PRIMARY KEY(`id_task_status`)
);

create index idx_task_status_name on task_status(name); 

create table if not exists task (
    id_task INT AUTO_INCREMENT,
    id_public VARCHAR(255) NOT NULL,
    title VARCHAR(45) NOT NULL,
    `desc` TEXT,
    created_at DATETIME DEFAULT now(),

    fk_task_status INT NOT NULL,
    fk_user INT NOT NULL,

    PRIMARY KEY(`id_task`),
    Foreign key(`fk_task_status`) references task_status(id_task_status),
    Foreign key(`fk_user`) references user(id_user)
);

create unique index idx_task_id_public on task(id_public);
create unique index idx_task_title on task(title);
