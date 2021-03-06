# Installation instructions

## Install PHP and necessary modules

### On Ubuntu
 
sudo apt-get install php5 php5-cli php5-mysql php5-pgsql php5-sqlite php5-memcache \
php5-mcrypt php5-gd php-apc php5-curl php5-tidy php-soap memcached unzip mysql-server

### On a hosted service (e.g. crazydomains.com.au) add the following lines to your /php.ini file:

```
memory_limit = 64M
extension=pdo.so
extension=pdo_sqlite.so
extension=sqlite.so
extension=pdo_mysql.so 
```

Enable "RewriteEngine" command in Apache2:

```
sudo a2enmod rewrite
sudo service apache2 restart
```

## Installing / upgrading cake

If uploading cakephp files to server, then remove the lib/Cake/Test directory before doing so
Install cakephp (currently using v2.1.3):

```
cd <path_to_html_dir>
sudo unzip cakephp-cakephp*.zip
```

Rename the cakepphp-cakephp directory to "mentor":

```
sudo mv cakephp-cakephp* mentor
```

Remove (or delete) the default cake app directory:

```
cd mentor
sudo mv app app.cakephp_orig
```

Install the mentor code from the repository:

```
sudo cp -r <path_to_git_repo>/mentor/app <path_to_html_dir>/mentor
```

### If running a test system within a Vagrant machine

After the first vagrant up, run ```sudo -i bash /vagrant/server/provision.sh``` to install the correct environment

### Create the following temporary directories

Replace <path_to_temp_dir> with app/tmp for non-vagrant machines and with /tmp/cakephp for vagrant machines:

```
<path_to_temp_dir>/logs
<path_to_temp_dir>/cache/persistent
<path_to_temp_dir>/cache/models
```

Ensure that the web server (here assumed to be group www-data) has write access to the app/tmp directory
(This is not necessary on Vagrant machines or some hosted domains, e.g. crazydomains.com.au)

```
cd <path_to_html_dir>/mentor
sudo chgrp -R www-data app/tmp
sudo chmod -R g+w  app/tmp
```

Create a VERSION.txt file in the app directory containing the application version number that you wish to show
echo "1.2.3" > <path_to_html_dir>/mentor/app/VERSION.txt

### If upgrading from a previous release

Check for any differences between mentor.php and mentor.php-default as well as between
core.php and core.php-default and take the changes over if necessary.

### Configuration setup on first time install only

#### Database setup

```
mysql> create database <your_database_name>;
Setup the database using the file app/Config/Schema/mentor.sql
mysql -uroot -p <your_database_name> < app/Config/Schema/mentor.sql
mysql -uroot -p 
mysql> grant all privileges on <your_database_name>.* to <databaseuser>@localhost IDENTIFIED by '<password>';
mysql> flush privileges;
```

Copy the ```app/Config/database.php-default``` to ```database.php``` and setup the same values for database_name, user and
password

If no ```app/Config/mentor.php``` configuration file exists, setup one up:
Copy the app/Config/mentor.php-default to mentor.php and setup the values as desired:
- Configure the salt and cipherSeed values (or if cloning a system copy it from the other system) using php gen:String.php
- Configure the google-analytics.tracker-code

If running more than one copy of the application on the same server, then change the $prefix in core.php

## Setup superadmin password (test and rewrite!!)

Use the Console/cake mentor gethash <your_password> to get the hashed value of your password

enable debug level 2 in core.php
Try to log in with your desired e-mail address and password (it will fail - but that is OK!)
Copy the hashed password value that appears on the last line of the debug at the bottom of the screen
Now update the database with your e-mail address and the hashed_password:

```
echo "update users set email = '<your_email_address>', password = '<your_hashed_password_value>' where id = 1; \
 | mysql -u<your_database_user> -p'<your_database_password>' <your_database_name>
 
 ```

Try again to login. This time it should work.

IMPORTANT: Set the debug level in core.php to 0 when finished!

Enjoy ... :)

Mark Waite
Business Mentors Noosa
in association with CCIQ Noosa (Noosa Chamber of Commerce)
