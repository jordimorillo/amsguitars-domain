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

create table guitars
(
    guitarId varchar(255) null,
    personId varchar(255) not null,
    modelId varchar(255) not null,
    interventionCollection json not null
);

create unique index guitars_guitarId_uindex
    on guitars (guitarId);

alter table guitars
    add constraint guitars_pk
        primary key (guitarId);

