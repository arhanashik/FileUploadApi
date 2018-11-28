# File Upload Api

## An example php api for uploading single/multiple file to server

## Features:
- Very simple to understand(php and oop pattern)
- Upload single/multiple files
- Return url(s) for the uploaded files
- Maintain an entry to database for every file


## How to use:
- Create the database and a table for maintaining the file entry
- For creating table: 
CREATE TABLE `files` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `description` varchar(1000) NOT NULL,
  `url` varchar(500) NOT NULL
);

- Change the db name, password in the Constant.php file
- Call the Api.php file in three varient.
	- 'Api.php?call=upload' for uploading single file(the file and description has to be sent in post method)
	- 'Api.php?call=multiple_upload' for uploading multiple files(the files array and description has to be sent in post method)
	- 'Api.php?call=getFiles' for getting the file entries from the database
	
- And it's easy as these. Goodluck :)