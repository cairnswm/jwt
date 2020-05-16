# JWT

Simple PHP creation of JWT (JSON Web Token))

## What is a JWT 

https://en.wikipedia.org/wiki/JSON_Web_Token

A JWT has 3 parts, 2 easily accessible by anyone and a third that is the signature that validates the Token

The J in JWT stands for JSON and the header and payload are both JSON structures.

### Header

A JWT header contains information on which algorithm is used to generate the signature.

### Payload

The payload section has a list of fields that mean something in the JWT World, but can take any other values defined by the application, for example username and role level for a web application. (See wikipedia for the list)

### Signature

The signature is created through a hash of the header and payload along with a secret key.

## jwt.php

This small library can create a valid JWT from your source data and a key.

### Usage

```php
include_once("jwt.php");

jwt_set_payload(array("name" => "william", "age" => "50")); 
$jwt = jwt_token();

echo $jwt;
```
### Setting the Secret Key

```php
include_once("jwt.php");

jwt_set_secret("William's super secret key that no one can guess");
jwt_set_payload(array("name" => "william", "age" => "50")); 
$jwt = jwt_token();

echo $jwt;
```
### Setting standard Payload Values

jwt_set_payload also allows a config array to be sent as the second parameter

```php
include_once("jwt.php");

jwt_set_secret("William's super secret key that no one can guess");
jwt_set_payload(array("name" => "william", "age" => "50"), array("issuer"=>"cairnswm","subject"=>"jwt sample", "audience"=>"GITHub users","expiryperiod"=>2*60)); 
$jwt = jwt_token();
echo $jwt;
```

# JWT Validation

I use this site to validate my JWTs

http://jwt.calebb.net/



