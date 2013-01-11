<?php 
/*Profile page here tweets from time-line and follower list well show*/
require("twitteroauth/twitteroauth.php");
session_start();
set_time_limit(0); //Limits the maximum execution time If set to zero,no time limit is imposed
if(!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret']))
{
	/*build a new TwitterOAuth object using the temporary credentials. */
	$connection = new TwitterOAuth('IfspuPtsM2ori27HOE07Kg', 'huSsAI90ObHMD3qtNpR4pLg2ey3YzJVDIT4LwWvy8', $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
	
	/* requesting the access token, act like password to make future requests */
	$_SESSION['oauth_verifier'] = $_GET['oauth_verifier'];
	$access_token = $connection->getAccessToken($_GET['oauth_verifier']);
	$_SESSION['access_token'] = $access_token;
	
	/* getting the user's information from twitter */
	$user_info = $connection->get('account/verify_credentials');
	$_SESSION['user_info'] = $user_info;
	
	// fetching tweets from user_timeline
	$twt = $connection->get('https://api.twitter.com/1/statuses/user_timeline.json?include_rts=1&count=10&screen_name='.$user_info->screen_name);
	$_SESSION['twt'] = $twt;
}
else 
    header('location:twitter_login.php'); //if error start form login
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Twitter Application</title>
        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="css/jquery-ui.css" type="text/css" media="screen"/>
		<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
        <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
		<!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script-->
        <script type="text/javascript" src="js/sliding.form.js"></script>
        
    </head>
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
            font-size:36px;
            text-shadow:1px 1px 1px #fff;
            padding:20px;
        }
    </style>
    <body>
        <div>
            <span class="reference">
                <a href="http://tympanus.net/codrops/2010/06/07/fancy-sliding-form-with-jquery/">Design from Codrops</a>
            </span>
        </div>
        <div id="content">
	        <h1>Twitter Application</h1> 
            <div style="float:right; font-size:25px">
	            <b><a href="logout.php" title="Logout from here">Logout</a></b>
            </div>
            <div id="wrapper">
                <div id="steps">
                    <div id="tweet_">
                        <form id="formElem" name="formElem" action="" method="post">
							<?php /*Load tweets from time-line*/
								for ($i=0; $i<=9; $i++) 
								{
									if(empty($twt[$i]->id_str))
									{ 
										echo "<p style='color:#F00'><b>No more tweets</b></p>"; 
										break; // last tweets break the loop
									}
									else{
                            ?>
                            <fieldset class="step">
	                            <legend><img src="<?php echo $user_info->profile_image_url; ?>"/>&nbsp;&nbsp;<?php echo $user_info->name; ?></legend>
                                <p>
	                                <a href="http://www.twitter.com/<?php echo $user_info->screen_name ?>/status/<?php echo $twt[$i]->id_str ?>" target="_blank"><?php echo $twt[$i]->text; ?></a>
                                </p>
								<?php 
									if(empty($twt[$i+1]->id_str))
									{ echo "<p style='color:#F00'> <b>No more tweets<b></p>";break;}
									else{
                                ?>
                                <p style="margin-top:15px;">
	                                <a href="http://www.twitter.com/<?php echo $user_info->screen_name ?>/status/<?php echo $twt[$i+1]->id_str ?>"target="_blank"><?php echo $twt[$i+1]->text; ?></a>
                                </p>
                            </fieldset>
							<?php 
										} 
                            	}
                            };?>
                        </form>
                    </div>
	                <div id="tweet_follo"></div>
                </div>
                <div id="navigation" style="display:none;">
                    <ul>
                        <li class="selected"><a href="#">Twitter 1</a></li>
                        <li><a href="#">Twitter 2</a></li>
                        <li><a href="#">Twitter 3</a></li>
                        <li><a href="#">Twitter 4</a></li>
	                    <li><a href="#">Twitter 5</a></li>
                    </ul>
                </div>
                <div id="btd">
                    <center>
                        <a href="pdf/pdf.php" class="btn3" id="download" title="Download All twits">Download</a>
                        <a href="profile.php" class="btn3" id="home" title="Home" style="display:none">Home</a>                            
                        <div class="ui-widget">
                            <input type="text" placeholder="search follower" id="tags" style="float:right;border:1px solid black;" name="search" />
                        </div>
                    </center>
                </div>
                <div  id="menu" style=" margin-top:30px; margin-left:50px;"> Follower Names List&nbsp;&nbsp;
                    <div id="navMenu"> 
                        <ul>
                        <?php /*Load 10 follower */
							$follower_list_id = $connection->get('https://api.twitter.com/1/followers/ids.json?cursor=-1&screen_name='.$user_info->screen_name);
							$followers = array();
							$count = 10; //counter var for 10 follower
							foreach($follower_list_id as $index => $value)
							{
								if($value != 0000)
								{
									echo '<li>';
									foreach ($value as $index_id => $id)
									{
										if($count == 0)
											break;

										$get_url = "https://api.twitter.com/1/users/lookup.json?include_entities=true&user_id=".$id;
										$follower_info = $connection->get($get_url);
										echo '<li>';
										foreach($follower_info as $index_info_value => $follo_value)
										{
											foreach($follo_value as $index_info => $info)
											{
												if($index_info == "screen_name")
												{
													echo '<a href="#" onclick="myValue(\''. $info .'\');">'.'<b>'.$info.'</b>'.'</a>&nbsp; &nbsp;';
													$followers[] = $info;
												}
												if($index_info == "profile_image_url" )
													echo '<img src="'.$info.'"/>';
					                        }
											echo '</li>';
				                        }
				                        $count = $count  - 1; // decrement counter for 10 followers
			                        }
		                        }
	                        }
	                        $_SESSION['followers'] = $followers;
                        ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
		<script>
			$(function(){
				var availableTags = <?php echo json_encode($_SESSION['followers'] ); ?>;
				$( "#tags" ).autocomplete({
											source: availableTags,
											minchar:2,
											delay:1000, // in milliseconds
											select: function( event, ui ) {myValue(ui.item.value);}});
						});
			function myValue(value)
			{
				document.getElementById('tweet_').style.display='none';
				document.getElementById('download').style.display='none';
				document.getElementById('home').style.display='';				
				$(document).ready(function() { 
				$("#tweet_follo").html('<form id="formElem" name="formElem"method="post"><fieldset class="step"><p><img src="spinner.gif"/></p></fieldset></form>').load('follo_tweet.php?name='+value); //load follower tweets
				});	
			}
        </script>       
	    <div id="mydiv"></div> 
    </body>
</html>