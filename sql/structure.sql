create table users
(
    userId varchar(255) null,
    personId varchar(255) null,
    username varchar(150) null,
    password varchar(255) null,
    email varchar(255) null
);

create unique index users_userId_uindex
    on users (userId);

alter table users
    add constraint users_pk
        primary key (userId);

