Requirements:
php 5.3+ (with openssl & cURL enabled), mysql 5.6+, composer (included)

Install:
1) Change to working dir
2) php composer.phar install
3) Log into your RDBM. Create table 'conman' db
4) Use table script located in ./docs/conman_table.sql
5) Edit 'settings.php'
6) Collect bacon

Testing:
ConMan uses phpunit for testing. All tests can be found within the ./tests/ dir

Action Mapping:
(Source http://en.wikipedia.org/wiki/Create,_read,_update_and_delete)

CRUD Operation		SQL		HTTP

Create				INSERT	POST
Read (Retrieve)		SELECT	GET
Update (Modify)		UPDATE	PUT / PATCH
Delete (Destroy)	DELETE	DELETE