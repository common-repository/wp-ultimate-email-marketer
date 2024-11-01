<?php
$listid = $_REQUEST['listid'];
require( dirname(__FILE__) . '/../../../../wp-load.php' );
if(is_user_logged_in()) { 
$getCustomfieldslist = $wpdb->get_results("select fieldid from smack_customfield_lists where listid = $listid");
foreach($getCustomfieldslist as $getCustomfield){
	$fields[] = $getCustomfield->fieldid;
}
$getListinfo = $wpdb->get_results("select *from smack_email_lists where listid = $listid");
foreach($getListinfo as $listvalue){
	$listname = $listvalue->name;
	$listownername = $listvalue->ownername;
	$listownermail = $listvalue->owneremail;
	$listreplymail = $listvalue->replytoemail;
	$listbouncemail = $listvalue->bounceemail;
	$companyname = $listvalue->companyname;
	$companyaddress = $listvalue->companyaddress;
	$companyphone = $listvalue->companyphone;
	$processbounce = $listvalue->processbounce;
}
?>
<br/>
<input type='hidden' name='module' id='module' value='editlist' />
<input type='hidden' name='listid' id='listid' value="<?php echo $listid; ?>" />
<div>
<table class="sam-add-content">
<thead>
<tr>
<th style='text-align:left'>Update List Details</th>
<th></th>
</tr>
</thead>
<tr>
<td><span class='required'>*</span> List Name:</td>
<td><input type='text' name='listname' id='listname' value="<?php echo $listname; ?>" readonly /></td>
</tr>
<tr>
<td><span class='required'>*</span> List Owners Name:</td>
<td><input type='text' name='listownersname' id='listownersname' value="<?php echo $listownername; ?>" /></td>
</tr>
<tr>
<td><span class='required'>*</span> List Owners Email:</td>
<td><input type='text' name='listownersemail' id='listownersemail' value="<?php echo $listownermail; ?>" /></td>
</tr>
<tr>
<td><span class='required'>*</span> List Reply-To Email:</td>
<td><input type='text' name='listreplytoemail' id='listreplytoemail' value="<?php echo $listreplymail; ?>" /></td>
</tr>
<tr>
<td><span class='required'>*</span> List Bounce Email:</td>
<td><input type='text' name='listbounceemail' id='listbounceemail' value="<?php echo $listbouncemail; ?>" /></td>
</tr>
<tr>
<td>Notify the List Owner:</td>
<td><input type='checkbox' name='notifycheck' checked >&nbsp;Yes, send subscribe and unsubscribe notification emails to the list owner</td>
</tr>
<tr>
<td>Process Bounced Emails:</td>
<td><input type='checkbox' <?php if($processbounce == 'y'){ ?> checked <?php } ?> name='bounceprocess' />&nbsp;Yes I want to process bounced emails for this list </td>
</tr>
</table>
</div>
<br/><br/>
<div>
<table class="sam-add-content">
<tr>
<th style='text-align:left'>Custom Fields</th>
<th></th>
</tr>
</thead>
<tr>
<td>Add These Fields to the List:</td>
<td>
<select multiple="multiple" name='customfields[]' >
<?php
$customfields = $wpdb->get_results("select *from smack_customfields");
foreach($customfields as $customfield){ ?>
	<option value="<?php echo $customfield->fieldid; ?>" <?php if(in_array($customfield->fieldid,$fields)) { ?> selected <?php } ?> ><?php echo $customfield->name; ?></option>
<?php
$count++;
}
?>
</select>
</td>
</tr>
</table>
</div>
<br/><br/>
<div>
<table class="sam-add-content">
<thead>
<tr>
<th style='text-align:left;'>Company Details</th>
<th></th>
</tr>
</thead>
<tr>
<td>Company Name:</td>
<td><input type='text' name='companyname' value="<?php echo $companyname; ?>" /></td>
</tr>
<tr>
<td>Company Address:</td>
<td><input type='text' name='companyaddress' value="<?php echo $companyaddress; ?>" /></td>
</tr>
<tr>
<td>Company Phone Number:</td>
<td><input type='text' name='companyphone' value="<?php echo $companyphone; ?>" /></td>
</tr>
</table>
</div>
<br/><br/>
<div>
<input type='submit' name='createlist' value="Update List" />
</div>
<?php
} else {
        wp_redirect($siteurl.'/wp-admin');
}
?>
