<?php
require( dirname(__FILE__) . '/../../../../wp-load.php' );
include_once( dirname(__FILE__) . '/../../../../wp-includes/class-wp-editor.php' );
global $wpdb;

$siteurl = $_REQUEST['siteurl'];
$campaignid = $_REQUEST['campaignid'];
$getcampaigndetail = $wpdb->get_results("select *from smack_email_campaigns where campaignid = $campaignid");
foreach($getcampaigndetail as $campaigndetail){
        $campaignsubject = $campaigndetail->campaignsubject;
}
$getcampaigncontent = $wpdb->get_results("select *from smack_emailcampaign_contents where campaignid = $campaignid");
foreach($getcampaigncontent as $campaigncontent){
	$content = $campaigncontent->campaigncontent;
	$campaigntextcontent = $campaigncontent->campaigntextcontent;
}
?>
<h2>Update Campaign Details</h2>
<div>
<table>
<th>Email Campaign Details</th>
<tr>
<td><span class='required'>*</span> Email Subject: </td>
<td><input type='text' name='emailsubject' id='emailsubject' value="<?php echo $campaignsubject;?>" /></td>
</tr>
<tr>
<td><span class='required'>*</span> HTML Content:</td>
<td>
<input type='radio' name='showeditor' value='showeditor' checked/>Create content using the WYSIWYG editor below
</td>
</tr>
<?php
if($_REQUEST['campaignformat'] == 'HTML and Text (Recommended)' || $_REQUEST['campaignformat'] == 'Text'){?>
<tr>
<td> Text Content: </td>
<td>
<textarea rows="4" cols="50" name='textcontent' id='textcontent'><?php print_r($campaigntextcontent); ?>
</textarea>
</td>
</tr>
<?php }
?>
</table>
</div>
<br/>
<div style="width:80%">
<textarea rows="4" cols="50" name='campaigncontent' id='campaigncontent' ><?php print_r($content); ?>
</textarea>
<script>
CKEDITOR.replace( 'campaigncontent');
</script>
</div>
<br/>
<input type='hidden' name='campaignid' id='campaignid' value="<?php echo $campaignid; ?>" />
<input type='hidden' name='action' id='action' value="<?php echo $_REQUEST['action']; ?>" />
<input type='hidden' name='campaignname' id='campaignname' value="<?php echo $_REQUEST['campaignname']; ?>" />
<input type='hidden' name='campaignformat' id='campaignformat' value="<?php echo $_REQUEST['campaignformat']; ?>" />
<input type='submit' name='updatecampaign' id='updatecampaign' value='Update Campaign' />
