<?php
require("twitteroauth/twitteroauth.php"); //Twitter authentication library for login
session_start();
set_time_limit(0); //Limits the maximum execution time If set to zero,no time limit is imposed
$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].'/profile.php';// to get 
$connection = new TwitterOAuth('IfspuPtsM2ori27HOE07Kg', 'huSsAI90ObHMD3qtNpR4pLg2ey3YzJVDIT4LwWvy8'); // provide api key to library

$request_token = $connection->getRequestToken($url); //call back URL

$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];  //set session variable 

if($connection->http_code==200)
{
    $url = $connection->getAuthorizeURL($request_token['oauth_token']);     // generate the URL and redirect to twitter login page
    header('Location: '. $url);
}
else
{
	print "<script type=\"text/javascript\">"; 
	print "alert('Something goes wrong. Please try again.')"; 
	print "</script>";
    die('Connection is Slow. <br> Or maybe Twitter is down');
}
?>
