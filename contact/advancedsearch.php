<?php
require_once (dirname(__FILE__) .'/../../../../wp-load.php');
global $wpdb;
if(is_user_logged_in()) { ?>
<div>
<h3>Advanced Search</h3>
<table>
<tr>
<td>
<select name='customfield'>
<?php
$getCustomfields = $wpdb->get_results("select *from smack_customfields");
print_r($getCustomfields);
?>
</select>
</td>
</tr>
</table>
</div>
<?php
} else {
        wp_redirect($siteurl.'/wp-admin');
}
?>
