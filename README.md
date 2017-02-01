# Manage-and-Upload-Files
A PHP program that uploads files to the server and stores the location in MYSQL database. Allows the user to delete files as well.


The files are uploaded to the folder "uploads" with the same file name as selected. If a file with the same name already exists it will show a warning and not upload the file.
List of names of files are stored in the MYSQL database.
MYSQL database name of "printing" is used with a table name of "files".
Two columns "id" and "name". "id" is set to auto_increment and not null. The file name is stored in "name".
