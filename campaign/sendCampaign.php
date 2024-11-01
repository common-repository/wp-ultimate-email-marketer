<?php
require( dirname(__FILE__) . '/../../../../wp-load.php' );
global $wpdb;
$campaignid = $_REQUEST['campaignid'];
$contactlist = explode(',',$_REQUEST['selectedcampaigns']);
for($i=0;$i<count($contactlist);$i++){
	$listname = $contactlist[$i];
	$getcontacts = $wpdb->get_results("select smack_contact_lists.contactid from smack_contact_lists INNER JOIN smack_email_lists ON smack_contact_lists.listid = smack_email_lists.listid where smack_email_lists.name = '$listname' ");
	$contactcount = $contactcount+count($getcontacts);
}
?>

<h2>Send an Email Campaign </h2>
<p>To send your email campaign now, simply click the Send My Email Campaign Now button below. </p>
<div>
<li>Your email campaign is called <b><?php echo $_REQUEST['campaignname']; ?></b></li>
<li>The subject line of your email campaign is <b><?php echo $_REQUEST['campaignsubject']; ?></b></li>
<li>Your email campaign will be sent to <b><?php echo $_REQUEST['selectedcampaigns']; ?></b></li>
<li>It will be sent to a total of <b><?php echo $contactcount; ?></b> contact(s)</li>
<input type='hidden' name='campaignid' id='campaignid' value="<?php echo $campaignid; ?>" />
<input type='hidden' name='module' id='module' value='sendcampaign' />
<input type='hidden' name='campaignname' id='campaignname' value="<?php echo $_REQUEST['campaignname']; ?>" />
<input type='hidden' name='campaignsubject' id='campaignsubject' value="<?php echo $_REQUEST['campaignsubject']; ?>" />
<input type='hidden' name='selectedcampaigns' id='selectedcampaigns' value="<?php echo $_REQUEST['selectedcampaigns']; ?>" />
</div>
<br/>
<input type="submit" name="sendcampaign" id="sendcampaign" value="Send My Email Campaign Now" />
<input type="button" name="cancel" id="cancel" value="Cancel" onclick="cancelaction()" />
