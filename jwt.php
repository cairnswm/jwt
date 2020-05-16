<?php

$SecretKey = "SuperSecretKeyDontShare";
$defaultConfig = array("issuer"=>"phpjwt","subject"=>"jwt","audience"=>"testing");

// https://base64.guru/developers/php/examples/base64url
/**
 * Encode data to Base64URL
 * @param string $data
 * @return boolean|string
 */
function base64url_encode($data)
{
  // First of all you should encode $data to Base64 string
  $b64 = base64_encode($data);

  // Make sure you get a valid result, otherwise, return FALSE, as the base64_encode() function do
  if ($b64 === false) {
    return false;
  }

  // Convert Base64 to Base64URL by replacing “+” with “-” and “/” with “_”
  $url = strtr($b64, '+/', '-_');

  // Remove padding character from the end of line and return the Base64URL result
  return rtrim($url, '=');
}

/**
 * Decode data from Base64URL
 * @param string $data
 * @param boolean $strict
 * @return boolean|string
 */
function base64url_decode($data, $strict = false)
{
  // Convert Base64URL to Base64 by replacing “-” with “+” and “_” with “/”
  $b64 = strtr($data, '-_', '+/');

  // Decode Base64 string and return the original data
  return base64_decode($b64, $strict);
}
//====================================================

function jwt_header() {
    return [
        "alg" => "HS256",
        "typ" => "JWT"
    ];
}

function jwt_set_secret($secret) {
    global $SecretKey;
    $SecretKey = $secret;
}


function jwt_secret() {
    global $SecretKey;
    return $SecretKey;
}

$jwtpayload = array();
function jwt_set_payload($payload, $config = NULL) {   
  make_payload($payload, $config);
}

function jwt_payload() {
    global $jwtpayload;
    return $jwtpayload;
}

function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
        return $uuid;
    }
}

function make_payload($payload, $config = NULL) {
    if ($config == NULL) {
        global $defaultConfig;
        $config = $defaultConfig;
    };
    array_key_exists("issuer",$config) ? $iss = $config["issuer"] : $iss = "";
    array_key_exists("subject",$config) ? $sub = $config["subject"] : $sub = "";
    array_key_exists("audience",$config) ? $aud = $config["audience"] : $aud = "";
    $datetime = new DateTime();
    $nbf = $datetime->getTimestamp();
    $iat = $datetime->getTimestamp();
    if (array_key_exists("expiryperiod", $config)) {
        $exp = $datetime->getTimestamp() + $config["expiryperiod"];
    } else {
        $exp = $datetime->getTimestamp() + 60480000; // 2 years

    }
    $jti = getGUID();
    
    global $jwtpayload;
    $jwtpayload = array("iss" => $iss, "sub" => $sub, "aud" => $aud, "exp" => $exp, "nbf" => $nbf, "iat" => $iat, "jti" => $jti, "data" => $payload);
    return $jwtpayload;
}

function jwt_token() {
    $header = base64url_encode(json_encode(jwt_header()));
    //echo "Header: $header <br/>";
    $payload = base64url_encode(json_encode(jwt_payload()));
    //echo "Payload: $payload <br/>";
    $secret = jwt_secret();
    $raw = $header.".".$payload;
    $signature = hash_hmac("sha256",$raw,$secret);
    $jwt_token = $raw.".".base64url_encode($signature);
    return $jwt_token;

}

?>