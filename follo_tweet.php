<?php
require("twitteroauth/twitteroauth.php"); 
session_start();
set_time_limit(0);
// TwitterOAuth instance, with two new parameters we got in twitter_login.php
$twitteroauth = new TwitterOAuth('IfspuPtsM2ori27HOE07Kg', 'huSsAI90ObHMD3qtNpR4pLg2ey3YzJVDIT4LwWvy8', $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);


$twt = $twitteroauth->get('https://api.twitter.com/1/statuses/user_timeline.json?include_rts=1&count=10&screen_name='.$_GET['name']);
$user_info = $twitteroauth->get('https://api.twitter.com/1/users/show.json?screen_name='.$_GET['name']);
if(!empty($twt->error))
{
echo '<form id="formElem" name="formElem" action="" method="post">
		<fieldset class="step">
			<legend><img src="'.$user_info->profile_image_url.'"/>&nbsp;&nbsp;'.$user_info->name.'</legend>
			<p style="color:#F00"><b>No more tweets</b></p>
		<fieldset class="step">
		</form>';
}
else {
?>
<form id="formElem" name="formElem" action="" method="post">
	<?php 
		$style_main = '';$style_other = '';
		for ($i=0; $i<=9; $i++) {
			if(empty($twt[$i]->id_str))
			{ 
				echo "<p style='color:#F00'><b>No more tweets</b></p>"; 
				$style_main = 'style="display:none;"';$style_other = 'style="display:none;"';
				break;
			}
			else
			{?>
                <fieldset class="step">
                	<legend><img src="<?php echo $user_info->profile_image_url; ?>"/>&nbsp;&nbsp;<?php echo $user_info->name; ?></legend>
                        <p>
	                        <a href="http://www.twitter.com/<?php echo $user_info->screen_name ?>/status/<?php echo $twt[$i]->id_str ?>" target="_blank"><?php echo $twt[$i]->text; ?></a>
                        </p>
						<?php 
							if(empty($twt[$i+1]->id_str)) 
								{echo "<p style='color:#F00'> <b>No more tweets<b></p>";$style_other = 'style="visibility:hidden;"';break;}
							else{?>
                                <p style="margin-top:15px;">
	                                <a href="http://www.twitter.com/<?php echo $user_info->screen_name ?>/status/<?php echo $twt[$i+1]->id_str ?>"target="_blank"><?php echo $twt[$i+1]->text; ?></a>
                                </p>
                        <?php }?>
                </fieldset>
			<?php }
            };?>
</form>
<?php
};?>