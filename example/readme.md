To create this example I did a very short search for "ajax php login" and found this page:
http://talkerscode.com/webtricks/ajax-login-form-using-jquery-php-and-mysql.php

Most of the code in the example is copy/paste from the linked tutorial, please follow the tutorial for more info.


# JWT Example

A very simple example of using a JWT token as part of a login process.

## Setup

Create a mysql database called jwtexample. with a user with same name and same test as password. (else change the connection details within do_login.php)

Run the mysql_script to populate the database.

Copy all the other files into a directory on a web server that runs php.
(I use xampp locally).

## Access the file

Open your web browser to http://localhost/jwtexample/login.html

The database is seeded with 2 users
username: user1@test.co password: user1
username: user2@test.co password: user2

Login with either user. The server will return a result object that contains a JWT. The object is also written to the consoile to make it easier to copy.

Copy the JWT and validate it through: http://jwt.calebb.net/

The token should contain the following dataset that is visible when validated:

```json
...
data: {
  name: "william",
  age: "50",
  email: "user1@test.co"
 }
 ...
 ```

 This token can now be saved locally (localstorage) and sent in the headers to the server on each subsequent ajax call. The token can be validated by the server each time a call is executed in php.

 