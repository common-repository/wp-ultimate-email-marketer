<?php
/*
 *Plugin Name: WP Ultimate Email Marketer
 *Plugin URI: http://www.smackcoders.com/category/free-wordpress-plugins.html
 *Description: All-in-one WP email marketing plugin to create, send, schedule, track, automate and analyse your email marketing campaigns.
 *Version: 1.2.0
 *Author: smackcoders.com
 *Author URI: http://www.smackcoders.com
 *
 * Copyright (C) 2012 Smackcoders (www.smackcoders.com)
 *
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License, version 2, as 
 published by the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @link http://www.smackcoders.com/category/free-wordpress-plugins.html

 ***********************************************************************************************
 */

ini_set( 'display_errors', false );

// Global variable declaration
global $data_rows,$wpdb;
$data_rows = array();
global $headers ;
$headers = array();
global $marketer_default;
global $delim;
global $siteurl;
$siteurl=site_url();
session_start();

// Define the marketer_default array
$marketer_default = array(
		'Email Address' => null,
		'Email Format' => null,
		//        'Status' => null,
		'Contact IP Address' => null,
		);
// include wpdb configuration

// Activate the plugin
function wp_ultimate_marketer_activate(){
	include 'smack_config.php'; 
}

// Deactivate the plugin
function wp_ultimate_marketer_deactivate(){
	include 'plugin_deactivate.php';
}

// Script Loader
function LoadWpMarketerScript()
{
	wp_register_script('wp_marketer_scripts', site_url()."/wp-content/plugins/wp-ultimate-email-marketer/wp-ultimate-marketer.js", array("jquery"));
	wp_enqueue_script('wp_marketer_scripts');
}
add_action('admin_enqueue_scripts', 'LoadWpMarketerScript');

// Ckeditor script loader
function Loadckeditorscript(){
	wp_register_script('wp_ckeditor_scripts', site_url()."/wp-content/plugins/wp-ultimate-email-marketer/ckeditor/ckeditor.js", array("jquery"));
	wp_enqueue_script('wp_ckeditor_scripts');
}
add_action('admin_enqueue_scripts', 'Loadckeditorscript');

// Admin menu settings
function wp_ultimate_marketer() {  
	$contentUrl = WP_CONTENT_URL;
	//create ultimate marketer menu
	add_menu_page('Marketer settings', 'WP Ultimate Email Marketer', 'manage_options',  
			'market_manager', 'market_manager', "$contentUrl/plugins/wp-ultimate-email-marketer/images/marketer.png");
}  

add_action("admin_menu", "wp_ultimate_marketer"); 

register_activation_hook( __FILE__ , 'wp_ultimate_marketer_activate');
register_deactivation_hook( __FILE__ , 'wp_ultimate_marketer_deactivate');

// Added script 
//wp_enqueue_script('my_script', WP_CONTENT_URL . '/plugins/wp-ultimate-marketer/wp-ultimate-marketer.js'); 
// Added style
wp_enqueue_style('my_css', WP_CONTENT_URL .'/plugins/wp-ultimate-email-marketer/css/custom-style.css');

// CSV File Reader
function marketer_csv_data($file,$delim)
{
	ini_set("auto_detect_line_endings", true);
	global $data_rows;
	global $headers;
	global $delim;
	$resource = fopen($file, 'r');
	while ($keys = fgetcsv($resource,'',"$delim",'"')) { 
		if ($c == 0) {
			$headers = $keys;
		} else {
			array_push($data_rows, $keys);
		}
		$c ++;
	}
	fclose($resource);
	ini_set("auto_detect_line_endings", false);
}

// Function for market manager
function market_manager(){
	$action = getAction();
	include "main-page-nave.php";
}

// Function for Market dashboard
function dashboard(){

}

// Function for Market contacts
function contacts(){
	global $siteurl,$wpdb,$delim,$marketer_default,$headers,$data_rows;
	$siteurl = site_url();
	include "contact/index.php";
	$content = "<form action='../wp-content/plugins/wp-ultimate-email-marketer/contact/postdata.php' enctype='multipart/form-data' onsubmit='return smackValidate()' method='post' name='Contacts' id='Contacts'><div class='super-nav'>";
	if(isset($_SESSION['searchcontacts']) && !empty($_SESSION['searchcontacts'])){
		$content.= "<input type='submit' name='resetfilter' id='resetfilter' value='Reset Filter' />";
	}
	$content.= "<div id='content'></div>";
	$content.= "</div><input type='hidden' name='module' id='module' /></form>";
	//if($_REQUEST['action'] == 'importcsv'){ ?>
	<div id='importform'></div>
		<form action='#' onsubmit="return smackValidate()" method='post' name='csv_data' id='csv_data'>
		<?php if($_REQUEST['setaction'] == 'importcsv'){ include "contact/importcsv.php"; } ?>
		</form>
		<?php //}
	// CSV data upload (Contacts)
	if(isset($_REQUEST['csvupload']) && $_REQUEST['csvupload']=='csvupload'){
		//print('<pre>');print_r($_POST);
		$upload_dir = wp_upload_dir();
		$dir  = $upload_dir['basedir']."/imported_csv/";
		$csvfile = $dir.$_REQUEST['filepath'];
		$delim = $_REQUEST['delim'];
		marketer_csv_data($csvfile,$delim);
		$ischeck = 0;
		$status = 'y';
		if($_POST['status'] == 'Unconfirmed'){
			$status = 'n';
		}
		$fieldorder = explode(',',$_REQUEST['fieldorder']);
		foreach($_REQUEST['field'] as $fkey => $fval){
			foreach($fieldorder as $fokey => $foval){
				if($fval == $fokey && $foval!='--Select--'){
					$header_array [$fkey]= $foval ;
				}
			}
		}
		for($i=0;$i<count($data_rows);$i++){
			foreach($header_array as $hkey => $hvalue){
				foreach($data_rows[$i] as $datakey => $datavalue){
					if($datavalue == 'HTML'){
						$datavalue = 'h';
					}else if($datavalue == 'Text'){
						$datavalue = 't';
					}
					if($datavalue == 'Confirmed'){
						$datavalue = 'y';
					}else if($datavalue == 'Unconfirmed'){
						$datavalue = 'n';
					}
					if($hkey == $datakey){
						if($hvalue == 'Email Address' || $hvalue == 'Email Format' || $hvalue == 'Status' || $hvalue =='Subscribe Date')
							$contactinfo[$i][$hvalue] = $datavalue;
						else
							$contactcustominfo[$i][$hvalue] = $datavalue;
					}
				}
			}
		}
		for($j=0;$j<count($contactinfo);$j++){
			foreach($contactinfo[$j] as $ckey => $cval){
				if($ckey == 'Email Address' && $cval != null)
					$emailaddress = $cval;
				$getdomain = explode('@',$emailaddress);
				$domain = $getdomain[1];
				if($ckey == 'Email Format')
					$emailformat = $cval;
				if($ckey == 'Status')
					$status = $cval;
				if($ckey == 'Subscribe Date')
					$subscribedate = $cval;
				$getContacts = $wpdb->get_results("select emailaddress from smack_contacts");
				$permission = 'ok';
				foreach($getContacts as $record){
					if($emailaddress == $record->emailaddress){
						$permission = 'not ok';
					}
				}
			}
			if($permission == 'ok'){
				$ischeck ++;
				$time = time();
				$code = 'smack5403'.$time.$j;
				$confirmcode = md5($code);
				$activity = 1;
				if($status == 'y'){
					$requesteddate = $confirmdate = $subscribedate = date('Y-m-d H:i:s');
				}
				else if($status == 'n'){
					$requesteddate = date('Y-m-d H:i:s');
					$confirmdate = $subscribedate = '';
				}
				$wpdb->insert('smack_contacts',array('emailaddress'=>$emailaddress,'domainname'=>$domain,'format'=>$emailformat,'confirmed'=>$status,'confirmedcode'=>$confirmcode,'requestdate'=>$requesteddate,'confirmdate'=>$confirmdate,'subscribedate'=>$subscribedate,'activity'=>$activity));
				$contactid = $wpdb->insert_id;
				$lname = $_REQUEST['listname'];
				$getlistid = $wpdb->get_results("select *from smack_email_lists where name='$lname' ");
				$listid=$getlistid[0]->listid;
				$wpdb->insert('smack_contact_lists',array('contactid'=>$contactid,'listid'=>$listid));
				foreach($contactcustominfo[$j] as $con_cus_key => $con_cus_value){
					$getcontact_custominfo = $wpdb->get_results("select *from smack_customfields");
					foreach($getcontact_custominfo as $record1){
						if($con_cus_key == $record1->name){
							$wpdb->insert('smack_customfield_data',array('contactid'=>$contactid,'fieldid'=>$record1->fieldid,'data'=>$con_cus_value,'listid'=>$listid));
						}
					}
				}
			}
		} 
		// Delete the csv after import data's
		MarketercsvDelete($csvfile);
		if($ischeck >0){
			$_SESSION['msgBalloon'] = 'Contact has been Imported';
		}
		else{
			$_SESSION['msgBalloon'] = 'Check your csv for duplicate entry';
		}?>
		<script>
			var siteurl = document.getElementById('siteurl').value;
		window.location.href = siteurl+"/wp-admin/admin.php?page=market_manager&action=contacts";
		</script>
			<?	}// Code ends for CSV data uploads
		echo $content;
}

// Remove file
function MarketercsvDelete($filename) {
	$success = FALSE;
	if (file_exists($filename)) {
		unlink ($filename);
		$success = TRUE;
	}
	return $success;
}

// Function for Market emailCampaigns
function emailCampaigns(){
	global $wpdb,$siteurl;
	$siteurl = site_url();
	?>
		<form action='../wp-content/plugins/wp-ultimate-email-marketer/campaign/postdata.php' name='emailcampaign' id='emailcampaign' method='post' onsubmit="return save_campaign()">
		<div id='content'>
		<?php
		include "campaign/index.php";
	?>
		</div>
		<div id='smack_editor' style='width:75%; display:none;'>
		<?php
		wp_editor( $content, 'smackeditor', $settings = array() );
	?>
		<br/><br/>
		</div>
		<input type='submit' name='savecampaign' id='savecampaign' value='savecampaign' style="display:none;" />
		</form>
		<?php
}

// Function for Market stats
function stats(){

}

// Function for Market lists
function lists(){
	global $siteurl,$wpdb;
	include "list/index.php";
	$content = "<form action='../wp-content/plugins/wp-ultimate-email-marketer/list/postdata.php' name='lists' id='lists' onsubmit='return create_new_list()' method='post'>";
	$content.= "<div id='content'>";
	$content.= "</div>";
	$content.= "</form>";
	echo $content;
}

// Function for Settings
function settings(){
	$content = "<div id='content'>";
	include "campaign/settings.php";
	$content.= "</div>";
	echo $content;
}

// Function for Market forms
function forms(){

}

// Function for Market autoresponders
function autoresponders(){

}

//Function for dashboard
function mainDashboard()
{
	$content = "<div style='text-align:center;font-weight: bold;text-transform:uppercase;margin-top:25px;font-size:small;'>";
	$content.= "Wp Ultimate Marketer";
	$content.= "</div>";
	echo $content;
}

function getAction()
{
	if(isset($_REQUEST['action']))
	{
		$action = $_REQUEST['action'];
	}
	else
	{
		$action = 'contacts';
	}
	return $action;
}
?>
