<?php if(isset($_SESSION['msgBalloon'])){ ?>
<div class='msgBalloon'><p><?php echo $_SESSION['msgBalloon']; unset($_SESSION['msgBalloon']); ?></p></div>
<?php } 

// Upload directory
$upload_dir = wp_upload_dir();
$importdir  = $upload_dir['basedir']."/imported_csv/";
// Create directory if not found
if(!is_dir($importdir))
{
	wp_mkdir_p($importdir);
}
// Csv data process for upload
if ($_FILES["csv"]["error"] == 0) {
	$tmp_name = $_FILES["csv"]["tmp_name"];
	$path = $importdir.$_FILES["csv"]["name"];
        $name = $_FILES["csv"]["name"];
        $delim = $_REQUEST['delimiter'];
        marketer_csv_data($tmp_name,$delim);
	move_uploaded_file($tmp_name, "$path");
	// Mapping the fields
	$listname=$_REQUEST['selectedlist'];
	$getlistid = $wpdb->get_results("select *from smack_email_lists where name='$listname'");
	$listid = $getlistid[0]->listid;
	$getCustomfields = $wpdb->get_results("select smack_customfield_lists.fieldid as list_fieldid,smack_customfields.name from smack_customfield_lists INNER JOIN smack_email_lists ON smack_customfield_lists.listid = smack_email_lists.listid JOIN smack_customfields on  smack_customfield_lists.fieldid = smack_customfields.fieldid where smack_customfield_lists.listid = $listid");
	foreach($getCustomfields as $customfield){
		$custom_array[]=$customfield->name;
     	}
        foreach($marketer_default as $datakey => $datavalue){
                $custom_array[]=$datakey;
        }
	foreach($custom_array as $customkey => $customvalue){
		if($customvalue == 'Email Address' || $customvalue == 'Email Format' ){ // || $customvalue == 'Status'){
			$mappedfields = $mappedfields.$customvalue.',';
		}
	}
	$mappedfields = substr($mappedfields,0,-1); 	
?>

<input type='hidden' name='mappedfields' id='mappedfields' value="<?php echo $mappedfields; ?>" />
<input type='hidden' name='h2' id='h2' value="<?php echo count($headers); ?>" />
<br/>
<h4>Select the status to cantact(s)</h4>
<table>
<tr>
<td><span class='required'>*</span> Status</td>
<td>
<select name='status' id='status'>
<option>-- Select --</option>
<option>Confirmed</option>
<option>Unconfirmed</option>
</select>
</td>
</tr>
</table>
<h3>Mapping the Fields</h3>
<table>	
<?php 
$count =0;
foreach($headers as $headerkey => $headervalue){ ?>
<tr>
	<td><?php echo $headervalue; ?></td>
	<td>
	<select name='field[]' id="field<?php echo $count; ?>" onchange="mapping(this,<?php echo $count; ?>);">
		<option value='0' id='select' name='select'>--Select--</option>
	<?php for($i=0;$i<count($custom_array);$i++){ ?>
		<option value='<?php echo $i+1; ?>'><?php echo $custom_array[$i]; ?></option>
	<?php } ?>
	</select>
	</td>
</tr>
<?php $count++; } ?>
</table>	
<?php } ?>
<input type='hidden' name='csvupload' id='csvupload' value='csvupload' />
<input type='hidden' name='listname' id='listname' value="<?php echo $_REQUEST['selectedlist']; ?>" />
<input type='hidden' name='delim' id='delim' value="<?php echo $delim; ?>" />
<?php 
$fieldorder=',--Select--';
foreach($custom_array as $custom_key => $custom_value){
	$fieldorder = $fieldorder.','.$custom_value;
}
$fieldorder = substr($fieldorder,1);
?>
<input type='hidden' name='fieldorder' id='fieldorder' value="<?php echo $fieldorder; ?>" />
<input type='hidden' name='filepath' id='filepath' value="<?php echo $name; ?>" />
<br/>
<div>
<input type='submit' name='submit' id='submit' value='Import' />
</div>
