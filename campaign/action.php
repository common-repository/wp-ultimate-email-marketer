<?php
require( dirname(__FILE__) . '/../../../../wp-load.php' );
global $wpdb;

// Update Campaign status
if($_REQUEST['action'] == 'active'){
	$status = 1;
	$campaignid = $_REQUEST['id'];
        $table = 'smack_email_campaigns';
        $data_array = array('active'=>$status);
        $where = array('campaignid'=>$campaignid);
        $wpdb->update($table, $data_array, $where);
	$_SESSION['msgBalloon'] = 'Campaign has been activated successfully.';
}
else if($_REQUEST['action'] == 'inactive'){
        $status = 0;
        $campaignid = $_REQUEST['id'];
        $table = 'smack_email_campaigns';
        $data_array = array('active'=>$status);
        $where = array('campaignid'=>$campaignid);
        $wpdb->update($table, $data_array, $where);
        $_SESSION['msgBalloon'] = 'Campaign has been deactivate successfully.';
}

// Delete Campaign
if($_REQUEST['action'] == 'delete'){
	$campaignid = $_REQUEST['id'];
	$wpdb->query("DELETE FROM smack_email_campaigns WHERE campaignid= $campaignid");
	$wpdb->query("DELETE FROM smack_emailcampaign_contents WHERE campaignid= $campaignid");
	$_SESSION['msgBalloon'] = 'Campaign has been deleted successfully.';
}

// Do action(Activate) on multiple campaign
if($_REQUEST['takeaction'] == 'Activate'){
	$campaigns = explode(',',$_REQUEST['checkedcampaigns']);
	for($i=0;$i<count($campaigns);$i++){
	        $table = 'smack_email_campaigns';
        	$data_array = array('active'=>1);
	        $where = array('campaignid'=>$campaigns[$i]);
        	$wpdb->update($table, $data_array, $where);
		$_SESSION['msgBalloon'] = 'Selected campaigns has been activated successfully.';
	}
}

// Do action(Deactivate) on multiple campaign
if($_REQUEST['takeaction'] == 'Deactivate'){
        $campaigns = explode(',',$_REQUEST['checkedcampaigns']);
        for($i=0;$i<count($campaigns);$i++){
                $table = 'smack_email_campaigns';
                $data_array = array('active'=>0);
                $where = array('campaignid'=>$campaigns[$i]);
                $wpdb->update($table, $data_array, $where);
		$_SESSION['msgBalloon'] = 'Selected campaigns has been deactivated successfully.';
        }
}

// Do action(Delete) on multiple campaign
if($_REQUEST['takeaction'] == 'Delete'){
        $campaigns = explode(',',$_REQUEST['checkedcampaigns']);
        for($i=0;$i<count($campaigns);$i++){
		$campaignid = $campaigns[$i];
	        $wpdb->query("DELETE FROM smack_email_campaigns WHERE campaignid= $campaignid");
		$_SESSION['msgBalloon'] = 'Selected campaigns has been deleted successfully.';
        }
}
?>
