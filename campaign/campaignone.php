<?php
?>
<h2>Create an Email Campaign</h2>
<p>Type a name for your campaign and optionally choose a format and template below to get started. Click Next when you are ready to continue.</p>
<div>
<table>
<th>Email Campaign Details</th>
<tr>
<td><span class='required'>*</span> Email Campaign Name:</span></td>
<td><input type='text' name='campaignname' id='campaignname' /></td>
</tr>
<tr>
<td><span class='required'>*</span> Email Campaign Format:</span></td>
<td>
<select name='campaignformat' id='campaignformat'>
<option value='ht'>HTML and Text (Recommended)</option>
<option value='h'>HTML</option>
<option value='t'>Text</option>
</select>
</td>
</tr>
<tr>
<td>&nbsp;&nbsp; Email Template:</td>
<td>
<select name='emailtemplate' id='emailtemplate' size='5' style='width:250px;height:100px;'>
<option selected>No Template</option>
<optgroup label="View Built In Email Templates" class="templategroup"></optgroup>
</select>
</td>
</tr>
</table>
<br/>
<input type='button' name='next' id='next' value='Next >>' onclick="return campaigntwo('<?php echo $_REQUEST['siteurl']; ?>')" />&nbsp;&nbsp;  <input type='button' name='cancel' id='cancel' value='Cancel' onclick="cancelaction()" />
</div>
