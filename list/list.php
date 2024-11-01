<?php
require( dirname(__FILE__) . '/../../../../wp-load.php' );
if(is_user_logged_in()) { 
?>
<br/>
<input type='hidden' name='module' id='module' />
<h2> Create New List </h2>
<div>
<table class="sam-add-content">
<thead>
<tr>
<th style='text-align:left'>New List Details</th>
<th></th>
</tr>
</thead>
<tr>
<td><span class='required'>*</span> List Name:</td>
<td><input type='text' name='listname' id='listname'/></td>
</tr>
<tr>
<td><span class='required'>*</span> List Owners Name:</td>
<td><input type='text' name='listownersname' id='listownersname' /></td>
</tr>
<tr>
<td><span class='required'>*</span> List Owners Email:</td>
<td><input type='text' name='listownersemail' id='listownersemail' /></td>
</tr>
<tr>
<td><span class='required'>*</span> List Reply-To Email:</td>
<td><input type='text' name='listreplytoemail' id='listreplytoemail' /></td>
</tr>
<tr>
<td><span class='required'>*</span> List Bounce Email:</td>
<td><input type='text' name='listbounceemail' id='listbounceemail' /></td>
</tr>
<tr>
<td>Notify the List Owner:</td>
<td><input type='checkbox' name='notifycheck' checked >&nbsp;Yes, send subscribe and unsubscribe notification emails to the list owner</td>
</tr>
<tr>
<td>Process Bounced Emails:</td>
<td><input type='checkbox' name='bounceprocess' />&nbsp;Yes I want to process bounced emails for this list </td>
</tr>
</table>
</div>
<br/><br/>
<div>
<table class="sam-add-content">
<thead>
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
global $wpdb;
$customfields = $wpdb->get_results("select *from smack_customfields");
foreach($customfields as $customfield){?>
	<option value="<?php echo $customfield->fieldid; ?>" ><?php echo $customfield->name; ?></option>
<?php
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
<td><input type='text' name='companyname' /></td>
</tr>
<tr>
<td>Company Address:</td>
<td><input type='text' name='companyaddress' /></td>
</tr>
<tr>
<td>Company Phone Number:</td>
<td><input type='text' name='companyphone' /></td>
</tr>
</table>
</div>
<br/><br/>
<div>
<input type='submit' name='createlist' value='Create List' />
</div>
<?php
} else {
        wp_redirect($siteurl.'/wp-admin');
}
?>
