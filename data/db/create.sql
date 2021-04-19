CREATE TABLE flux (
url varchar(255) primary key
);
CREATE TABLE nouvelles (
id integer primary key autoincrement,
date varchar(80),
titre varchar(255),
description varchar(1024),
lien varchar(255),
image varchar(80),
flux varchar(255)
);
CREATE TABLE utilisateurs (
login varchar(80) primary key,
mp varchar(80)
);
CREATE TABLE flux_utilisateur (
flux varchar(255) primary key,
login varchar(80),
nom varchar(80),
categorie varchar(80)
);
