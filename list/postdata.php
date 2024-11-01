<?php
require( dirname(__FILE__) . '/../../../../wp-load.php' );

// Add new contact list
$current_user = wp_get_current_user();

if(isset($_POST['module']) && ($_POST['module']=='list')){
	$createdtime = date('Y-m-d H:i:s');
	$notifycheck = 0;
	if(isset($_POST['notifycheck']) && $_POST['notifycheck'] == 'on'){
		$notifycheck = 1;
	}
	$bounceprocess = 'n';
	if(isset($_POST['bounceprocess']) && $_POST['bounceprocess'] == 'on'){
		$bounceprocess = 'y';
	}
	$getListname = $wpdb->get_results("select name from smack_email_lists");
	$createlist = 'ok';
	foreach($getListname as $listname){
		if($listname->name == $_POST['listname']){
			$createlist = 'not ok';
		}
	}
	// Check before create whether the list is already found or not.
	if($createlist == 'ok'){
		$return = $wpdb->insert('smack_email_lists',array('name'=>$_POST['listname'],'ownername'=>$_POST['listownersname'],'owneremail'=>$_POST['listownersemail'],'bounceemail'=>$_POST['listbounceemail'],'replytoemail'=>$_POST['listreplytoemail'],'createdttime'=>$createdtime,'companyname'=>$_POST['companyname'],'companyaddress'=>$_POST['companyaddress'],'companyphone'=>$_POST['companyphone'],'ownerid'=>$current_user->ID,'notify_subscription'=>$notifycheck,'processbounce'=>$bounceprocess));
		$listid = $wpdb->insert_id;
		foreach($_POST['customfields'] as $customfield){
			$wpdb->insert('smack_customfield_lists',array('fieldid'=>$customfield,'listid'=>$listid));
		}
		$redirect = get_admin_url().'admin.php?page=market_manager&action=lists';
		wp_redirect($redirect);
	}
	else{
		$_SESSION['msgBalloon']='';
		$_SESSION['msgBalloon'] = 'List name already present.Please create again!.';
		$redirect = get_admin_url().'admin.php?page=market_manager&action=lists';
		wp_redirect($redirect);
	}
}
// Edit List information
if(isset($_POST['module']) && ($_POST['module']=='editlist')){
	$listid = $_REQUEST['listid'];
	$createdtime = date('Y-m-d H:i:s');
	$notifycheck = 0;
	if(isset($_POST['notifycheck']) && $_POST['notifycheck'] == 'on'){
		$notifycheck = 1;
	}
	$bounceprocess = 'n';
	if(isset($_POST['bounceprocess']) && $_POST['bounceprocess'] == 'on'){
		$bounceprocess = 'y';
	}
	$getListname = $wpdb->get_results("select name from smack_email_lists");
	$createlist = 'ok';
	foreach($getListname as $listname){
		if($listname->name == $_POST['listname']){
			$createlist = 'not ok';
		}
	}
	// Check before create whether the list is already found or not.
	if($createlist == 'ok'){
		$return = $wpdb->insert('smack_email_lists',array('name'=>$_POST['listname'],'ownername'=>$_POST['listownersname'],'owneremail'=>$_POST['listownersemail'],'bounceemail'=>$_POST['listbounceemail'],'replytoemail'=>$_POST['listreplytoemail'],'createdttime'=>$createdtime,'companyname'=>$_POST['companyname'],'companyaddress'=>$_POST['companyaddress'],'companyphone'=>$_POST['companyphone'],'ownerid'=>$current_user->ID,'notify_subscription'=>$notifycheck,'processbounce'=>$bounceprocess));
		$listid = $wpdb->insert_id;
		foreach($_POST['customfields'] as $customfield){
			$wpdb->insert('smack_customfield_lists',array('fieldid'=>$customfield,'listid'=>$listid));
		}
		$redirect = get_admin_url().'admin.php?page=market_manager&action=lists';
		wp_redirect($redirect);
	}
	else if($createlist == 'not ok'){
		$table = 'smack_email_lists';
		$data_array = array('name'=>$_POST['listname'],'ownername'=>$_POST['listownersname'],'owneremail'=>$_POST['listownersemail'],'bounceemail'=>$_POST['listbounceemail'],'replytoemail'=>$_POST['listreplytoemail'],'companyname'=>$_POST['companyname'],'companyaddress'=>$_POST['companyaddress'],'companyphone'=>$_POST['companyphone']);	
		$where = array('listid'=>$_REQUEST['listid']);
		$wpdb->update( $table, $data_array, $where );
		$getfields = $wpdb->get_results("select *from smack_customfield_lists where listid = $listid");
		//		print_r($getfields);
		foreach($getfields as $getfield){
			$default[]= $getfield->fieldid;
		}
		//		print_r($default);
		foreach($_POST['customfields'] as $customfield){
			if(in_array($customfield,$default)){
				$myfields[] = $customfield;
			}
			else{
				$newfields[]= $customfield;
			}
		}
		foreach($default as $value){
			if(!in_array($value,$myfields)){
				$delfields[] = $value;
			}
		}
		foreach($delfields as $delfield){
			$wpdb->query("delete from smack_customfield_lists where fieldid = $delfield and listid = $listid");
			//			$wpdb->query("delete from smack_customfield_data where fieldid = $delfield and listid = $listid");
		}	
		foreach($newfields as $newfield){
			$wpdb->insert('smack_customfield_lists',array('fieldid'=>$newfield,'listid'=>$listid));
		}
		$_SESSION['msgBalloon']='';
		$_SESSION['msgBalloon'] = 'List information has been updated.';
		$redirect = get_admin_url().'admin.php?page=market_manager&action=lists';
		wp_redirect($redirect);
	}
}

// Delete List Action
if($_POST['action'] == 'delete'){
	$listid = $_POST['listid'];
	$getlistcontacts = $wpdb->get_results("select *from smack_contact_lists where listid = $listid");
	foreach($getlistcontacts as $getlistcontact){
		$contactid = $getlistcontact->contactid;
		$wpdb->query("delete from smack_contacts where contactid = $contactid");
		$wpdb->query("delete from smack_contact_lists where contactid = $contactid and listid = $listid");
	}
	$wpdb->query("delete from smack_customfield_lists where listid = $listid");
	$wpdb->query("delete from smack_email_lists where listid = $listid ");
	$wpdb->query("delete from smack_customfield_data where listid = $listid ");
	$_SESSION['msgBalloon']='';
	$_SESSION['msgBalloon'] = 'Selected list and list contacts has been deleted.';
}
?>
