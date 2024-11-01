<?php require( dirname(__FILE__) . '/../../../../wp-load.php' );
global $wpdb;
if(is_user_logged_in()) { ?>
<div id='exportcontacts'>
<br/>
<h3>Export Contacts</h3>
<p class='export'>Export all Contacts to click<input class='export' type='submit' name='exportall' id='exportall' value='Here!' /> </p>
<h2>(OR)</h2>
<table>
<th>Select a Contact List(s)</th>
<tr>
<td><span class='required'>*</span> Contact List:</td>
<td>
<select name='selectedlist' id='selectedlist' size='5' style='width:350px;height:100px;'>
<?php
$getLists = $wpdb->get_results("select listid,name from smack_email_lists");
$i=0;
foreach($getLists as $list){ ?>
        <option value=' <?php echo $list->listid; ?>' <?php if($i==0){ ?> selected=selected <?php $i++; } ?> > <?php echo $list->name; ?></option>
<?php }
?>
</select>
<input type='hidden' name='listcount' id='listcount' value='<?php echo count($getLists); ?>' />
</td>
</tr>
</table>
</div>
<div>
<?php foreach($marketer_default as $key => $value){
	$header = $header.','.$key;
      }
$csvheader = substr($header,1);
?>
<input type='hidden' name='csvheader' id='csvheader' value='<?php echo $csvheader; ?>' />
<input type='submit' name='export' id='export' value='Export Contacts' />
</div>
<?php
} else {
        wp_redirect($siteurl.'/wp-admin');
}
?>
