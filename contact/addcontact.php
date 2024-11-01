<?php require( dirname(__FILE__) . '/../../../../wp-load.php' ); 
if(is_user_logged_in()) { 
?>
<div class='import-form'>
<table class="sam-add-content">
<thead>
<tr>
<th style='text-align:left'>New Contact Details </th>
<th></th>
</tr>
</thead>
<tr>
<td><span class="required">*</span>Email Address: </td>
<td><input type='text' name='email' id='email'/></td>
</tr>
<tr>
<td><span class="required">*</span>Email Format: </td>
<td>
<select name='emailformat' id='emailformat'>
<option value='select'>-- Select --</option>
<option value='html'>Html</option>
<option value='text'>Text</option>
</select>
</td>
</tr>
<tr>
<td><span class="required">*</span>Confirmation Status: </td>
<td>
<select name='status' id='status'>
<option value='select'>-- Select --</option>
<option value='confirmed'>Confirmed</option>
<option value='unconfirmed'>Unconfirmed</option>
</select>
</td>
</tr>
<tr>
<td><span class="required">*</span>Activity: </td>
<td>
<select name='activity' id='activity'>
<option value='select'>-- Select --</option>
<option value='active'>Active</option>
<option value='inactive'>Inactive</option>
</select>
</td>
</tr>
</table>
<br/><br/>

<?php
	// Code for Show the custom fields based on the selected list
	$getListId = $wpdb->get_results("select listid from smack_email_lists where name = '$_REQUEST[listname]' ");
	foreach($getListId as $id){
		$listid = $id->listid;
	}
	$getListCustomfields = $wpdb->get_results("select fieldid from smack_customfield_lists where listid = $listid");
	foreach($getListCustomfields as $field){
		$fieldarray[] = $field->fieldid;
		$getListCustomfieldsName = $wpdb->get_results("select name from smack_customfields where fieldid = $field->fieldid ");
		foreach($getListCustomfieldsName as $fieldname){
			$fieldnamearray[$field->fieldid] = $fieldname->name;
		}
	}
?>
<input type='hidden' name='listid' value='<?php echo $listid; ?>' />
<table class="sam-add-content">
<thead>
<tr>
<th style='text-align:left'>Custom Field Details</th>
<th></th>
</tr>
</thead>
<?php if(in_array(1,$fieldarray)){ ?>
<tr>
<td>Title: </td>
<td>
<select name='field[1]'>
<option>-- Select --</option>
<option>Ms</option>
<option>Mrs</option>
<option>Mr</option>
<option>Dr</option>
<option>Prof</option>
</select>
</td>
</tr>
<?php } 
if(in_array(2,$fieldarray)){ ?>
<tr>
<td>First Name:</td>
<td><input type='text' name='field[2]' /></td>
</tr>
<?php }
if(in_array(3,$fieldarray)){ ?>
<tr>
<td>Last Name: </td>
<td><input type='text' name='field[3]' /></td>
</tr>
<?php }
if(in_array(4,$fieldarray)){ ?>
<tr>
<td>Phone :</td>
<td><input type='text' name='field[4]' onkeypress="return isNumberKey(event)" /></td>
</tr>
<?php }
if(in_array(5,$fieldarray)){ ?>
<tr>
<td>Mobile :</td>
<td><input type='text' name='field[5]' onkeypress="return isNumberKey(event)" /></td>
</tr>
<?php }
if(in_array(6,$fieldarray)){ ?>
<tr>
<td>Fax: </td>
<td><input type='text' name='field[6]' onkeypress="return isNumberKey(event)" /></td>
</tr>
<?php }
if(in_array(7,$fieldarray)){ ?>
<tr>
<td>Birth Date: </td>
<td><input type='text' name='field[7]' />&nbsp;&nbsp;(eg:- Use dd-mm-yyyy format)</td>
</tr>
<?php }
if(in_array(8,$fieldarray)){ ?>
<tr>
<td>City: </td>
<td><input type='text' name='field[8]' /></td>
</tr>
<?php }
if(in_array(9,$fieldarray)){ ?>
<tr>
<td>State: </td>
<td><input type='text' name='field[9]' /></td>
</tr>
<?php }
if(in_array(10,$fieldarray)){ ?>
<tr>
<td>Postal/Zip Code: </td>
<td><input type='text' name='field[10]' onkeypress="return isNumberKey(event)" /></td>
</tr>
<?php }
if(in_array(11,$fieldarray)){ ?>
<tr>
<td>Country: </td>
<td><input type='text' name='field[11]' /></td>
</tr>
<?php } ?>
</table>
<br/><br/>

<div>
<input type='submit' value='Add Contact'/>
</div>

</div>
<br/><br/>
<?php
} else {
        wp_redirect($siteurl.'/wp-admin');
}
?>
