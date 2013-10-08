Requirements:
php, mysql, composer

Install:
1) curl -sS https://getcomposer.org/installer | php
2) php composer.phar install
3) Log into your RDBM. Create table 'conman' db
4) Use table script located in ./docs/conman_table.sql
5) Collect bacon

Testing:
ConMan uses phpunit for testing. All tests can be found within the ./tests/ dir
To test change to the working dir and run phpunit using the config file.

Action Mapping:
(Source http://en.wikipedia.org/wiki/Create,_read,_update_and_delete)

CRUD Operation		SQL		HTTP

Create				INSERT	POST
Read (Retrieve)		SELECT	GET
Update (Modify)		UPDATE	PUT / PATCH
Delete (Destroy)	DELETE	DELETE