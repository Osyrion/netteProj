Nette test Project 
==================

User registration to database via registration form and printout all users to list

## Required:
- Apache 2.4
- MySQL (MariaDB 10.4)

- or use XAMPP (e.g. LAMPP if Linux)

## How to:

1) run server and database

2) create database:
```
CREATE DATABASE example CHARACTER SET UTF8;
```

3) create table:
```
CREATE TABLE example.users (
  email VARCHAR(255) NOT NULL UNIQUE,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(4096) NOT NULL,
  role VARCHAR(255),
  PRIMARY KEY(email)
);
```
4) run in web browser:
```
localhost/netteProj/www
```


## Troubleshooting

If you have some problems with database connection, go to
```
app/config/common.neon
app/config/local.neon
```
and update your DB credentials
