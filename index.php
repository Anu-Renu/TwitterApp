<?php
session_start();
if(isset($_SESSION['user_info']))
    header("location:profile.php"); //if already logged in
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Twitter Application</title>
        <link rel="stylesheet" href="css/style.css">
		<style>
			span.reference{
				position:fixed;
				left:5px;
				top:5px;
				font-size:10px;
				text-shadow:1px 1px 1px #fff;
			}
			span.reference a{
				color:#555;
				text-decoration:none;
				text-transform:uppercase;
			}
			span.reference a:hover{
				color:#000;
				
			}
			h1{
				color:#ccc;
				font-size:40px;
				text-shadow:1px 1px 1px #fff;
				padding:20px;
			}
			body{ font-size:20px;}
			#step{ width:auto !important} #wrapper{width:600px !important}
			#image{float:right;}
		</style>
   </head>
    <body>
        <div>
            <span class="reference">
                <a href="http://tympanus.net/codrops/2010/06/07/fancy-sliding-form-with-jquery/">Design from Codrops</a> <!--Thank You for tutorial-->
            </span>
        </div>
          <div style="margin-left:300px; margin-top:50px;">
            <h1>Twitter Application</h1>
            <div id="wrapper">
                <div id="steps">
					<center> <h3> Welcome </h3></center>
                    Simple Twitter API demo<br/>
                    Working :
                    <ul style="margin-left:50px;">
                    	<li>Login with twitter !</li>
                        <li>It shows 10 random tweets from your time line</li>
                      	<li>And 10 random followers</li>
                        <li>You can download Tweets</li>
                        <li>You can search for follower or See their tweets from their time line</li>
                     </ul>
                     	<br/>
                        <center>
	                      <span>Click twitter to go inside</span>
                        </center>
                   </div><div id="image"><a href="twitter_login.php" title="Login"><img src="images/twitter.gif" width="130" height="90"/></a></div>
             </div>
         </div>
    </body>
</html>
