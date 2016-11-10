CREATE TABLE image (
id int primary key,
path varchar(1024),
category varchar(64),
comment varchar(1024)
);

CREATE TABLE user (
  name varchar(64) NOT NULL,
  password varchar(64) NOT NULL,
  PRIMARY KEY (name, password)
);
