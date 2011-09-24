<?php

session_start();

if($_GET['token'])
{
$thetoken=$_GET['token'];
echo($thetoken."<br>");
include('httpreq/Request.php');

$req = &new HTTP_Request('https://www.google.com/accounts/AuthSubSessionToken');
$req->setMethod(HTTP_REQUEST_METHOD_GET);
$tokenprm='AuthSub token="'.$thetoken.'"';
$req->addHeader('Authorization', $tokenprm);
$req->sendRequest();
$response1 = $req->getResponseBody();

echo($tokenprm."<br>");
echo $response1;

echo("<h1>Hurray! Got token ".$_GET['token']."</h1>");
echo("<br>");
echo("The referer= ".$HTTP_REFERER."<br>");
echo("The session id= ".$_SESSION['myuser']."<br>");
echo("<hr>");
}
else
{
$_SESSION['myuser']="anon:".uniqid();
$jax_session=$_SESSION['myuser'];
echo($jax_session."<br>");
$BaseRequestURL="https://www.google.com/accounts/AuthSubRequest";
$scopeURL="http%3A%2F%2Fwww.google.com%2fcalendar%2Ffeeds%2F";
echo($BaseRequestURL."<br>");
$nextURL=urlencode("http://cafecamp.com/ideas/clientauthtest.php");

$RequestURL=$BaseRequestURL."?scope=".$scopeURL."&next=".$nextURL."&session=1";
echo("<a href=\"$RequestURL\">Login with Google!</a>");
}

?>