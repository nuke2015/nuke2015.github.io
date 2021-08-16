DELETE FROM mysql.db WHERE Db LIKE 'test%';
DELETE FROM mysql.user WHERE Host LIKE 'localhost%';
FLUSH PRIVILEGES;

