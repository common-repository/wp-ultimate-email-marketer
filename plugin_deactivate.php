<?php

global $wpdb;	//required global declaration of WP variable

$sql1 = "DROP TABLE smack_contact_lists";
$wpdb->query($sql1);

$sql2 = "DROP TABLE smack_contacts";
$wpdb->query($sql2);

$sql3 = "DROP TABLE smack_customfield_data";
$wpdb->query($sql3);

$sql4 = "DROP TABLE smack_customfield_lists";
$wpdb->query($sql4);

$sql5 = "DROP TABLE smack_customfields";
$wpdb->query($sql5);

$sql6 = "DROP TABLE smack_email_lists";
$wpdb->query($sql6);

$sql7 = "DROP TABLE smack_email_campaigns";
$wpdb->query($sql7);

$sql8 = "DROP TABLE smack_emailcampaign_contents";
$wpdb->query($sql8);

$sql9 = "DROP TABLE smack_mailserver_details";
$wpdb->query($sql9);

$sql10 = "DROP TABLE smack_uniuqe_details";
$wpdb->query($sql10);

?>
