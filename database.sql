 /*
	Replace `user` and `password` below with your preferred sql server user and password and
	run the script below in shell as root user and enter:
	
	CREATE USER 'user'@'localhost' IDENTIFIED BY 'password';
	GRANT ALL PRIVILEGES ON *.* TO 'user'@'localhost';
	FLUSH PRIVILEGES;

	The script above will create a username and password for the application.


	for this page to work you have to create a database named login and a table named users in your mysql server.
	To do this, enter following in your mysql server:

	CREATE DATABASE login; 
	USE login;

	Still in the shell as root, run:

	SOURCE table.sql;
*/

CREATE TABLE users(
	id int not null auto_increment,
	user_name varchar(255) not null,
	full_name varchar(255) not null,
	email varchar(255) not null,
	password varchar(255) not null,
	PRIMARY KEY (id)
);