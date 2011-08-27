PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE spam (username TEXT);
CREATE UNIQUE INDEX username ON  spam(username);
COMMIT;

