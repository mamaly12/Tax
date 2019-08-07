
• MySQL 8. ( http://dev.mysql.com/downloads/ )

• IDE (like PhpStorm). (https://www.jetbrains.com/phpstorm/download/)

INSTALLATION
============
1- Download and Extract the Source Code.

2- Create DataBase:

   - in the terminal of the IDE type the following commands:

		a. composer update
		
		b. according to env file of the root of the project DATABASE_URL=mysql://mohammad:mohammad@127.0.0.1:3306/usersmanegement
		
		create a user with password which has access to the database: DATABASE_URL=mysql://user_db:user_password@127.0.0.1:3306/dbName
		
		c. php bin/console doctrin:database:create

    note: you can also use hcompetition.sql which is located in the root of project

3- Create Table:

    -in the terminal of the IDE type these commands to create tables for the entities of the project:
    
    a. php bin/console doctrine:migrations:diff

    b. php bin/console doctrine:migrations:migrate
        
