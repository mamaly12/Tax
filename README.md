# Tax

STORIES
============
• Develop a software that can be used to calculate statistics about the tax income of a country. The country is organized in 5 states and theses states are devided into counties.
• Each county has a different tax rate and collects a different amount of taxes.

TODO
============
The software should have the following features:

- Output the overall amount of taxes collected per state
- Output the average amount of taxes collected per state
- Output the average county tax rate per state
- Output the average tax rate of the country 
- Output the collected overall taxes of the country

REQUIREMENTS
============
• Symfony 4.3. (https://symfony.com/download)

• Apache WEB server, version 2.0 or higher. ( http://httpd.apache.org/download.cgi )

• PHP 7.3. ( http://www.php.net/ )

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
        
