<?php
require( dirname(__FILE__) . '/../../../../wp-load.php' );
global $wpdb;

$siteurl = $_REQUEST['siteurl'];
$campaignid = $_REQUEST['campaignid'];
$getcampaigndetail = $wpdb->get_results("select *from smack_email_campaigns where campaignid = $campaignid");
foreach($getcampaigndetail as $campaigndetail){
	$campaignname = $campaigndetail->campaignname;
	$campaignformat = $campaigndetail->campaignformat;
}
?>

<h2>Edit an Email Campaign</h2>
<p>Complete the form below to update the email campaign.</p>
<div>
<table>
<th>Email Campaign Details</th>
<tr>
<td><span class='required'>*</span> Email Campaign Name:</span></td>
<td><input type='text' name='campaignname' id='campaignname' value='<?php echo $campaignname; ?>' /></td>
</tr>
<tr>
<td><span class='required'>*</span> Email Campaign Format:</span></td>
<td>
<select name='campaignformat' id='campaignformat'>
<option value='ht' <?php if($campaignformat == 'ht'){ ?> selected <?php } ?> >HTML and Text (Recommended)</option>
<option value='h' <?php if($campaignformat == 'h'){ ?> selected <?php } ?> >HTML</option>
<option value='t' <?php if($campaignformat == 't'){ ?> selected <?php } ?> >Text</option>
</select>
</td>
</tr>
</table>
<br/>
<input type='hidden' name='campaignid' id='campaignid' value="<?php echo $campaignid; ?>" />
<input type='hidden' name='editcampaign' id='editcampaign' value='editcampaign' />
<input type='button' name='next' id='next' value='Next >>' onclick="return updatecampaign('<?php echo $siteurl; ?>')" />&nbsp;&nbsp;  <input type='button' name='cancel' id='cancel' value='Cancel' onclick="cancelaction()" />
</div>

