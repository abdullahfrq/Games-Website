drop table appuser cascade;

create table appuser (
	userid varchar(50) primary key,
	password varchar(100),
	firstname varchar(30),
	lastname varchar(30),
	campus varchar(20)
);

insert into appuser values('auser', 'apassword', 'afirstname', 'alastname', 'acampus');

