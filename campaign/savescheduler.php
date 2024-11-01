<?php
require( dirname(__FILE__) . '/../../../../wp-load.php' );
global $wpdb;

$data = array(
        'ID' => NULL,
        'campaignid' => $_REQUEST['campaignid'],
	'listid' => $_REQUEST['listid'],
        'scheduleddate' => $_REQUEST['date'],
        'schduledtime' => $_REQUEST['hour'].':'.$_REQUEST['minute'],
    );
$today = date("Y-m-d");
$date_diff = $_REQUEST['date'] - $today;
if($date_diff <= 0 )
{
	echo "$date_diff";
	echo "date less than today";
	die();
}
$result = $wpdb->insert("smack_emailcampaign_scheduler", (array) $data );
if($result)
{
	echo "success";
}
else
{
	echo "failure";
}
?>
