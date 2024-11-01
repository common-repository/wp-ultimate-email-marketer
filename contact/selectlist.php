<?php
require( dirname(__FILE__) . '/../../../../wp-load.php' );
global $wpdb,$siteurl;
if(is_user_logged_in()) { ?>
<div>
<p>Click <a href="<?php echo $siteurl; ?>/wp-admin/admin.php?page=market_manager&action=lists" class="smacklink">Here</a> to create a list to manage contacts under the list.</p>
<table>
<th>Select a Contact List(s)</th>
<tr>
<td><span class="required">*</span>Contact List: </td>
<td>
<select name='selectedlist' id='selectedlist' size='5' style='width:350px;height:100px;'>
<?php
$getLists = $wpdb->get_results("select name from smack_email_lists");
$i=0;
foreach($getLists as $list){ ?>
	<option <?php if($i==0){ ?> selected=selected <?php $i++; } ?> > <?php echo $list->name; ?></option>	
<?php }
?>
</select>
</td>
</tr>
<tr>
<td></td>
<td>
<div>
<input type='hidden' name='countcontacts' id='countcontacts' value='<?php echo count($getLists); ?>' />
<input type='hidden' name='siteurl' id='siteurl' />
<input type='button' name='selectlist' id='selectlist' onclick="createcontact()" value='Next >>' />&nbsp;&nbsp;
<input type='button' name='cancel' value='Cancel' onclick="cancelaction()" />
</div>
</td>
</tr>
</table>
</div>
<?php
} else {
        wp_redirect($siteurl.'/wp-admin');
}
?>
