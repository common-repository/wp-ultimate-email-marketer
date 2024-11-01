<?php
require( dirname(__FILE__) . '/../../../../wp-load.php' );
global $wpdb,$siteurl;
$campaignid = $_REQUEST['campaignid'];
$campaigndetails = $wpdb->get_results("select *from smack_email_campaigns where campaignid = $campaignid");
foreach($campaigndetails as $campaigndetail){
	$campaignname = $campaigndetail->campaignname;
	$campaignsubject = $campaigndetail->campaignsubject;
}
?>
<h2>Send an Email Campaign</h2>
<p>Before you can send an email campaign, please select which contact list(s) you want to send to.</p>
<table>
<th>Who Do You Want to Send to? </th>
<tr>
<td>  Select a Contact List(s) </td>
<td>
<select multiple='multiple' name='contactlist' id='contactlist' >
<?php
$getLists = $wpdb->get_results("select name from smack_email_lists");
$listcount = count($getLists);
$i=0;
foreach($getLists as $list){ ?>
        <option <?php if($i==0){ ?> selected=selected <?php $i++; } ?> > <?php echo $list->name; ?></option>
<?php }
?>
</select>
</td>
</tr>
</table>
<br/>
<input type='hidden' name='campaignid' id='campaignid' value="<?php echo $campaignid; ?>" />
<input type='hidden' name='listcount' id='listcount' value="<?php echo $listcount; ?>" />
<input type='hidden' name='campaignname' id='campaignname' value="<?php echo $campaignname; ?>" />
<input type='hidden' name='campaignsubject' id='campaignsubject' value="<?php echo $campaignsubject; ?>" />
<input type='button' name='next' id='next' value='Next >>' onclick="campaignconfirmed('<?php echo $siteurl; ?>')" />
<input type='button' name='cancel' id='cancel' value='Cancel' onclick="cancelaction()" />
