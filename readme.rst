###################
What is CodeIgniter
###################

CodeIgniter is an Application Development Framework - a toolkit - for people
who build web sites using PHP. Its goal is to enable you to develop projects
much faster than you could if you were writing code from scratch, by providing
a rich set of libraries for commonly needed tasks, as well as a simple
interface and logical structure to access these libraries. CodeIgniter lets
you creatively focus on your project by minimizing the amount of code needed
for a given task.



*******************
Server Requirements
*******************

PHP version 5.6 or newer is recommended.

It should work on 5.3.7 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.

************************
CodeIgniter Rest Server
************************

A fully RESTful server implementation for CodeIgniter using one library, one config file and one controller.



*************
How To SetUp
*************
1.Get a clone from repository.

2.Now copy it to your PHP and MySQL enabled server. In this tutorial we are using  
WAMP(Windows, Apache, Mysql, PHP). So copy it on C:wampwww

3.Configuring CodeIgniter : 
For running CodeIgniter application you need to setup the right base URL of the app. 
To do this, open up C:/wamp/www/stock-market-bank-service/application/config/config.php and edit 
the base_url array item to point to your server and CodeIgniter folder.
Syntax:

//you can find this at line number 17
$config['base_url'] = "http://localhost/stock-market-bank-service/";


4.Database configuration : 
To connect with database CodeIgniter provides a configuration file in config folder with name database.php. 
Below is the mentioned path:-C:/wamp/www/stock-market-bank-service/application/config/database.php

To setup connectivity with your database you need to do the changes as mentioned in below code:


$db['default']['hostname'] = "localhost";

$db['default']['username'] = "root"; // Your username if required.

$db['default']['password'] = ""; // Your password if any.

$db['default']['database'] = "database_name"; // Your database name.

$db['default']['dbdriver'] = "mysqli";










