<?php 
	// Edit contact details
	require( dirname(__FILE__) . '/../../../../wp-load.php' ); 
	if(is_user_logged_in()) {
        $listname = $_REQUEST['listname'];
        $contactid = $_REQUEST['contact'];
        // Code for Show the custom fields based on the selected list
        $getListId = $wpdb->get_results("select listid from smack_email_lists where name = '$listname' ");
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
        $getcontactinfo = $wpdb->get_results("select * from smack_customfield_data where contactid = $contactid and listid = $listid");
        foreach($getcontactinfo as $contactinfo){
                $contactdetail[$contactinfo->fieldid] = $contactinfo->data;
        } 
	$getrecord = $wpdb->get_results("select *from smack_contacts where contactid = $contactid ");
	foreach($getrecord as $contactinformation){
		if($contactinformation->format == 'h'){
			$contactinfo1['format'] = 'Html';
		}else if($contactinformation->format == 't'){
			$contactinfo1['format'] = 'Text';
		}
                if($contactinformation->confirmed == 'y'){
                        $contactinfo1['confirmed'] = 'Confirmed';
                }else if($contactinformation->confirmed == 'n'){
                        $contactinfo1['confirmed'] = 'Unconfirmed';
                }
                if($contactinformation->activity == '1'){
                        $contactinfo1['activity'] = 'Active';
                }else if($contactinformation->activity == '0'){
                        $contactinfo1['activity'] = 'Inactive';
                }
	}
?>

<div class='import-form'>
<input type='hidden' name='contactid' value='<?php echo $_REQUEST['contact']; ?>' />
<table class="sam-add-content">
<thead>
<tr>
<th style='text-align:left'>Update Contact Details </th>
<th></th>
</tr>
</thead>
<tr>
<td><span class="required">*</span>Email Address: </td>
<td><input type='text' name='email' id='email' value='<?php echo $contactinformation->emailaddress; ?>' /></td>
</tr>
<tr>
<td><span class="required">*</span>Email Format: </td>
<td>
<select name='emailformat' id='emailformat'>
<option value='select'>-- Select --</option>
<option value='html' <?php if($contactinfo1['format']=='Html'){ ?> selected=selected <?php } ?> >Html</option>
<option value='text' <?php if($contactinfo1['format']=='Text'){ ?> selected=selected <?php } ?> >Text</option>
</select>
</td>
</tr>
<tr>
<td><span class="required">*</span>Confirmation Status: </td>
<td>
<select name='status' id='status'>
<option value='select'>-- Select --</option>
<option value='confirmed' <?php if($contactinfo1['confirmed']=='Confirmed'){ ?> selected=selected <?php } ?> >Confirmed</option>
<option value='unconfirmed' <?php if($contactinfo1['confirmed']=='Unconfirmed'){ ?> selected=selected <?php } ?> >Unconfirmed</option>
</select>
</td>
</tr>
<tr>
<td><span class="required">*</span>Activity: </td>
<td>
<select name='activity' id='activity'>
<option value='select'>-- Select --</option>
<option value='active' <?php if($contactinfo1['activity']=='Active'){ ?> selected=selected <?php } ?> >Active</option>
<option value='inactive' <?php if($contactinfo1['activity']=='Inactive'){ ?> selected=selected <?php } ?> >Inactive</option>
</select>
</td>
</tr>
</table>
<br/><br/>

<?php 
	$listname = $_REQUEST['listname'];
	$contactid = $_REQUEST['contact'];
	// Code for Show the custom fields based on the selected list
	$getListId = $wpdb->get_results("select listid from smack_email_lists where name = '$listname' ");
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
	$getcontactinfo = $wpdb->get_results("select * from smack_customfield_data where contactid = $contactid and listid = $listid");
	foreach($getcontactinfo as $contactinfo){
		$contactdetail[$contactinfo->fieldid] = $contactinfo->data;
	}
?>
<input type='hidden' name='listid' value='<?php echo $listid; ?>' />
<?php if(count($contactdetail) > 0){ ?>
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
<option <?php if($contactdetail[1] == 'Ms'){ ?>selected=selected <?php } ?> value='Ms'>Ms</option>
<option <?php if($contactdetail[1] == 'Mrs'){ ?>selected=selected <?php } ?> value='Mrs'>Mrs</option>
<option <?php if($contactdetail[1] == 'Mr'){ ?>selected=selected <?php } ?> value='Mr'>Mr</option>
<option <?php if($contactdetail[1] == 'Dr'){ ?>selected=selected <?php } ?> value='Dr'>Dr</option>
<option <?php if($contactdetail[1] == 'Prof'){ ?>selected=selected <?php } ?> value='Prof'>Prof</option>
</select>
</td>
</tr>
<?php } 
if(in_array(2,$fieldarray)){ ?>
<tr>
<td>First Name:</td>
<td><input type='text' name='field[2]' value='<?php echo $contactdetail[2]; ?>' /></td>
</tr>
<?php }
if(in_array(3,$fieldarray)){ ?>
<tr>
<td>Last Name: </td>
<td><input type='text' name='field[3]' value='<?php echo $contactdetail[3]; ?>' /></td>
</tr>
<?php }
if(in_array(4,$fieldarray)){ ?>
<tr>
<td>Phone :</td>
<td><input type='text' name='field[4]' value='<?php echo $contactdetail[4]; ?>' onkeypress="return isNumberKey(event)" /></td>
</tr>
<?php }
if(in_array(5,$fieldarray)){ ?>
<tr>
<td>Mobile :</td>
<td><input type='text' name='field[5]' value='<?php echo $contactdetail[5]; ?>' onkeypress="return isNumberKey(event)" /></td>
</tr>
<?php }
if(in_array(6,$fieldarray)){ ?>
<tr>
<td>Fax: </td>
<td><input type='text' name='field[6]' value='<?php echo $contactdetail[6]; ?>' onkeypress="return isNumberKey(event)" /></td>
</tr>
<?php }
if(in_array(7,$fieldarray)){ ?>
<tr>
<td>Birth Date: </td>
<td><input type='text' name='field[7]' value='<?php echo $contactdetail[7]; ?>' />&nbsp;&nbsp;(eg:- Use dd-mm-yyyy format)</td>
</tr>
<?php }
if(in_array(8,$fieldarray)){ ?>
<tr>
<td>City: </td>
<td><input type='text' name='field[8]' value='<?php echo $contactdetail[8]; ?>' /></td>
</tr>
<?php }
if(in_array(9,$fieldarray)){ ?>
<tr>
<td>State: </td>
<td><input type='text' name='field[9]' value='<?php echo $contactdetail[9]; ?>' /></td>
</tr>
<?php }
if(in_array(10,$fieldarray)){ ?>
<tr>
<td>Postal/Zip Code: </td>
<td><input type='text' name='field[10]' value='<?php echo $contactdetail[10]; ?>' onkeypress="return isNumberKey(event)" /></td>
</tr>
<?php }
if(in_array(11,$fieldarray)){ ?>
<tr>
<td>Country: </td>
<td><input type='text' name='field[11]' value='<?php echo $contactdetail[11]; ?>' /></td>
</tr>
<?php } ?>
</table>
<?php } ?>
<br/><br/>

<div>
<input type='submit' value='Update'/>
</div>

</div>
<br/><br/>
<?php
} else {
        wp_redirect($siteurl.'/wp-admin');
}
?>
