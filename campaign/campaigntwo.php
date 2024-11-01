<?php 
global $wpdb,$siteurl;
?>
<br/>
<div>
<table>
<th>Email Campaign Details</th>
<tr>
<td><span class='required'>*</span> Email Subject: </td>
<td><input type='text' name='emailsubject' id='emailsubject' /></td>
</tr>
<tr>
<td><span class='required'>*</span> HTML Content:</td>
<td>
<input type='radio' name='showeditor' value='showeditor' checked/>Create content using the WYSIWYG editor below
</td>
</tr>
<?php
if($_REQUEST['campaignformat'] == 'HTML and Text (Recommended)' || $_REQUEST['campaignformat'] == 'Text'){?>
<tr>
<td> Text Content: </td>
<td>
<textarea rows="4" cols="50" name='textcontent' id='textcontent'>
</textarea>
</td>
</tr>
<?php }
?>
</table>
<input type='hidden' name='action' id='action' value="<?php echo $_REQUEST['action']; ?>" />
<input type='hidden' name='campaignname' id='campaignname' value="<?php echo $_REQUEST['campaignname']; ?>" />
<input type='hidden' name='campaignformat' id='campaignformat' value="<?php echo $_REQUEST['campaignformat']; ?>" />
<input type='hidden' name='emailtemplate' id='emailtemplate' value="<?php echo $_REQUEST['emailtemplate']; ?>" />
<!--<input type='submit' name='savecampaign' id='savecampaign' value='savecampaign' />-->
</div>
<br/>
<br/>


