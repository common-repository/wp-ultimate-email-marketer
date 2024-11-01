<?php 

global $wpdb;
//require( dirname(__FILE__) . '/../../../wp-load.php' );

$sql1 = "CREATE TABLE `smack_email_lists` (
  `listid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `ownername` varchar(255) NOT NULL,
  `owneremail` varchar(100) NOT NULL,
  `bounceemail` varchar(100) DEFAULT NULL,
  `replytoemail` varchar(100) NOT NULL,
  `createdttime` datetime NOT NULL,
  `companyname` varchar(255) DEFAULT NULL,
  `companyaddress` varchar(255) DEFAULT NULL,
  `companyphone` varchar(20) DEFAULT NULL,
  `processbounce` char(1) NOT NULL,
  `ownerid` int(11) NOT NULL,
  `notify_subscription` int(11) DEFAULT '1',
  PRIMARY KEY (listid)
) ENGINE=InnoDB CHARSET=utf8;";

$sql2 = "CREATE TABLE `smack_customfields` (
  `fieldid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (fieldid)
) ENGINE=InnoDB CHARSET=utf8;";

$sql3 = "CREATE TABLE `smack_customfield_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fieldid` int(11) NOT NULL,
  `listid` int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB CHARSET=utf8;";

$sql4 = "CREATE TABLE `smack_customfield_data` (
  `contactid` int(11) NOT NULL,
  `fieldid` int(11) NOT NULL,
  `data` text,
  `listid` int(11) NOT NULL
) ENGINE=InnoDB CHARSET=utf8;";

$sql5 = "CREATE TABLE `smack_contacts` (
  `contactid` int(11) NOT NULL AUTO_INCREMENT,
  `emailaddress` varchar(200) DEFAULT NULL,
  `domainname` varchar(100) DEFAULT NULL,
  `format` char(1) DEFAULT NULL,
  `confirmed` char(1) DEFAULT NULL,
  `confirmedcode` varchar(32) DEFAULT NULL,
  `requestdate` datetime DEFAULT '0000-00-00 00:00:00',
  `requestip` varchar(20) DEFAULT NULL,
  `confirmdate` datetime DEFAULT '0000-00-00 00:00:00',
  `confirmip` varchar(20) DEFAULT NULL,
  `subscribedate` datetime DEFAULT '0000-00-00 00:00:00',
  `unsubscribed` int(11) DEFAULT '0',
  `activity` tinyint(1) DEFAULT '1',
  PRIMARY KEY (contactid)
) ENGINE=InnoDB CHARSET=utf8;";

$sql6 = "CREATE TABLE `smack_contact_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contactid` int(11) NOT NULL,
  `listid` int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB CHARSET=utf8;";

$sql7 = "CREATE TABLE `smack_email_campaigns` (
  `campaignid` int(11) NOT NULL AUTO_INCREMENT,
  `campaignname` varchar(30) NOT NULL,
  `campaignformat` varchar(10) NOT NULL,
  `campaignsubject` varchar(30) NOT NULL,
  `createdat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastsent` datetime DEFAULT '0000-00-00 00:00:00',
  `owner` varchar(60) DEFAULT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`campaignid`)
) ENGINE=InnoDB CHARSET=utf8;"; 

$sql8 = "CREATE TABLE `smack_emailcampaign_contents` (
  `campaignid` int(11) NOT NULL,
  `campaigncontent` blob NOT NULL,
  `campaigntextcontent` varchar(250) DEFAULT NULL
) ENGINE=InnoDB CHARSET=utf8;";

$sql9 = "CREATE TABLE `smack_mailserver_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostname` varchar(120) NOT NULL,
  `username` varchar(120) NOT NULL,
  `password` varchar(120) NOT NULL,
  `port` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8;";

$sql10 = "CREATE TABLE `smack_uniuqe_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currentdate` varchar(60) DEFAULT NULL,
  `unique_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8;";


require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql1);
dbDelta($sql2);
dbDelta($sql3);
dbDelta($sql4);
dbDelta($sql5);
dbDelta($sql6);
dbDelta($sql7);
dbDelta($sql8);
dbDelta($sql9);
dbDelta($sql10);

$table_name ='smack_customfields';
$wpdb->insert( $table_name, array( 'name' => 'Title'));
$wpdb->insert( $table_name, array( 'name' => 'First Name'));
$wpdb->insert( $table_name, array( 'name' => 'Last Name'));
$wpdb->insert( $table_name, array( 'name' => 'Phone'));
$wpdb->insert( $table_name, array( 'name' => 'Mobile'));
$wpdb->insert( $table_name, array( 'name' => 'Fax'));
$wpdb->insert( $table_name, array( 'name' => 'Birth Date'));
$wpdb->insert( $table_name, array( 'name' => 'City'));
$wpdb->insert( $table_name, array( 'name' => 'State'));
$wpdb->insert( $table_name, array( 'name' => 'Postal/Zip Code'));
$wpdb->insert( $table_name, array( 'name' => 'Country'));

?>
