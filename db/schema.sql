PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE spam (username TEXT);
CREATE UNIQUE INDEX username ON spam(username);
CREATE TABLE "username_location" (
    "username" TEXT,
    "latitude" REAL,
    "longitude" REAL
);
CREATE UNIQUE INDEX usernameInLocation ON username_location(username);
COMMIT;

