<?php require( dirname(__FILE__) . '/../../../../wp-load.php' );
global $wpdb,$siteurl;
if(is_user_logged_in()) { ?>
<form name='importcontacts' action='' onsubmit='return smackValidate()' method='post' id='importcontacts' enctype='multipart/form-data' >
<div id='importcsv'>
<h3>Import Contacts</h3>
<p>Click <a href="<?php echo $siteurl; ?>/wp-admin/admin.php?page=market_manager&action=lists" class="smacklink">Here</a> to create a list to manage contacts under the list.</p>
<table>
<th>Select a Contact List(s)</th>
<tr>
<td><span class='required'>*</span>Contact List: </td>
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
<input type='hidden' name='listcount' id='listcount' value='<?php echo count($getLists); ?>' />
</td>
</tr>
</table>
<br/><br/>
<table>
<th style='text-align:left'>Import CSV</th>
<tr>
<td>Import your CSV : </td>
<td><input type='file' name='csv' id='csv'></td>
</tr>
<tr>
<td>Delimiter : </td>
<td>
<select name='delimiter'>
<option value=','>,</option>
<option value=';'>:</option>
</select>
</td>
</table>
</div>
<br/>
<div>
<input type='hidden' name='setaction' id='setaction' value='importcsv' />
<input type='submit' name='Import' id='Import' value='Import' />
</div>
</form>
<?php
} else {
        wp_redirect($siteurl.'/wp-admin');
}
?>
