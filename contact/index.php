<?php
require_once (dirname(__FILE__) .'/../../../../wp-load.php');
global $wpdb; 
if(is_user_logged_in()) {
if(isset($_SESSION['msgBalloon'])){ ?>
<div class='msgBalloon'><p><?php echo $_SESSION['msgBalloon']; unset($_SESSION['msgBalloon']); ?></p></div>
<?php } ?>
<br/>
<div class='navigation'>
	<span><input type='button' class='button-primary' value='Add Contact' id='add' onclick='addContacts("<?php echo $siteurl; ?>")' /></span>
        <span><input type='button' class='button-primary' value='Import Contacts' id='import' onclick='importContacts("<?php echo $siteurl; ?>")' /></span>
        <span><input type='button' class='button-primary' value='Export Contacts' id='export' onclick='exportContacts("<?php echo $siteurl; ?>")' /></span>
        <span><input type='button' class='button-primary' value='Search Contacts' id='search' onclick='searchContacts("<?php echo $siteurl; ?>")' /></span>
</div>
<input type='hidden' name='siteurl' id='siteurl' value="<?php echo $siteurl; ?>" />
<div id="contactindex">
<?php include 'showcontacts.php' ?>
</div>
<?php
} else {
	wp_redirect($siteurl.'/wp-admin');
}
?>
