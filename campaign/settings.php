<?php
global $wpdb,$siteurl;
$getmailserverdetails = $wpdb->get_results("select * from smack_mailserver_details");
foreach($getmailserverdetails as $getmailserverdetail){
	$hostname = $getmailserverdetail->hostname;
	$username = $getmailserverdetail->username;
	$getpassword = $getmailserverdetail->password;
	$password = base64_decode($getpassword);
	$port = $getmailserverdetail->port;
}
if(isset($_SESSION['msgBalloon'])){ ?>
	<div class='msgBalloon'><p><?php echo $_SESSION['msgBalloon']; unset($_SESSION['msgBalloon']); ?></p></div>
<?php } ?>
<form action='../wp-content/plugins/wp-ultimate-email-marketer/campaign/postdata.php' onsubmit="return mailserversettings()" method='post' name='campaignsettings' id='campaignsettings'>
<div id='settings'>
<h2>Mail Server Settings</h2>
<table>
<tr>
<td><span class='required'>*</span> SMTP Hostname: </td>
<td><input type='text' name='hostname' id='hostname' value="<?php echo $hostname; ?>" /></td>
</tr>
<tr>
<td><span class='required'>*</span> SMTP Username: </td>
<td><input type='text' name='username' id='username' value="<?php echo $username; ?>"  onblur="emailValidator(document.getElementById('username'))" /></td>
</tr>
<tr>
<td><span class='required'>*</span> SMTP PassWord: </td>
<td><input type='password' name='password' id='password' value="<?php echo $password; ?>" /></td>
</tr>
<tr>
<td><span class='required'>*</span> SMTP Port: </td>
<td><input type='text' name='port' id='port' value="<?php echo $port; ?>" onkeypress="return isNumberKey(event)" /></td>
</tr>
<tr>
<td>Send a test email to:</td>
<td><input type='text' name='testmail' id='testmail' />&nbsp;&nbsp;<input type='submit' name='testsettings' id='testsettings' value='Test SMTP Settings' /></td>
</tr>
</table>
<br/>
<?php $admin_email = get_settings('admin_email'); ?>
<input type='hidden' id='adminmail' name='adminmail' value="<?php echo $admin_email; ?>" />
<input type='hidden' id='module' name='module' value='mailserversettings' />
<input type='submit' id='savesettings' value='savesettings' name='savesettings' />
</div>
</form>
