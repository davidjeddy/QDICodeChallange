Requirements:
php (with openssl & cURL enabled), mysql, composer (included)

Install:
1) Change to working dir
2) curl -sS https://getcomposer.org/installer | php
3) php composer.phar install
4) Log into your RDBM. Create table 'conman' db
5) Use table script located in ./docs/conman_table.sql
6) Edit 'settings.php'
7) Collect bacon

Testing:
ConMan uses phpunit for testing. All tests can be found within the ./tests/ dir

Action Mapping:
(Source http://en.wikipedia.org/wiki/Create,_read,_update_and_delete)

CRUD Operation		SQL		HTTP

Create				INSERT	POST
Read (Retrieve)		SELECT	GET
Update (Modify)		UPDATE	PUT / PATCH
Delete (Destroy)	DELETE	DELETE