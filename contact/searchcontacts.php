<?php  
require_once (dirname(__FILE__) .'/../../../../wp-load.php');
global $wpdb;
if(is_user_logged_in()) { ?>
<div class='searchcontacts'>
<h3>Search Contacts</h3>
<div>
<p class='searchcontacts'>
<!--<input type='button' name='advancedsearch' id='advancedsearch' value='Advanced Search' />-->
<!--<a href='#' onclick="advancedsearch('<?php echo $siteurl; ?>')">Advanced Search</a>-->
</p>
<table>
<tr>
<td>Email Address :</td>
<td><input type='text' name='emailaddress' id='emailaddress' /></td>
</tr>
<tr>
<td><a class='smacklink' onclick="toogleadvancedsearch()">Advanced Search</a></td>
</tr>
</table>
<input type="hidden" id="enable_advancedsearch" name="enable_advancedsearch" />
<table id="advancedsearch" style="display:none;">
<tr>
<td>Format :</td>
<td>
<select name='format'>
<option value='html'>HTML</option>
<option value='text'>Text</option>
</select>
</td>
</tr>
<tr>
<td>Status :</td>
<td>
<select name='status'>
<option value='Confirmed'>Confirmed</option>
<option value='Unconfirmed'>Unconfirmed</option>
</select>
</td>
</tr>
<tr>
<td>Subscription Status :</td>
<td>
<select name='subscription'>
<option value='Subscribed'>Subscribed</option>
<option value='Unsubscribed'>Unsubscribed</option>
</select>
</td>
</tr>
</table>
</div>
<div>
<input type='submit' name='search' id='search' value='Search Contacts' />
</div>
<?php 
} else {
        wp_redirect($siteurl.'/wp-admin');
}
?>
