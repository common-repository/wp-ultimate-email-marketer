<?php 
require( dirname(__FILE__) . '/../../../../wp-load.php' );
global $wpdb;

// Save Mailserver Settings
if(isset($_POST['module']) && $_POST['module'] == 'mailserversettings' && isset($_REQUEST['savesettings'])){
	$getmailserverdetails = $wpdb->get_results("select *from smack_mailserver_details");
	$count = count($getmailserverdetails);
	$hostname = $_POST['hostname'];
	$username = $_POST['username'];
	$decrypted_password = base64_encode($_POST['password']);
	$password = $decrypted_password;
	$port = $_POST['port'];
	if($count == 0){
		$wpdb->insert('smack_mailserver_details',array('hostname'=>$hostname,'username'=>$username,'password'=>$password,'port'=>$port));
		$_SESSION['msgBalloon'] = 'Settings Saved Successfully.';
	}
	else{
		$table = 'smack_mailserver_details';
		$data_array = array('hostname'=>$hostname,'username'=>$username,'password'=>$password,'port'=>$port);
		$where = array('id'=>1);
		$wpdb->update($table, $data_array, $where);
		$_SESSION['msgBalloon'] = 'Settings Updated Successfully.';
	}
	$redirect = get_admin_url().'admin.php?page=marketer_settings';
	wp_redirect($redirect);
}

// Save Campaign
if(isset($_POST['action']) && $_POST['action'] == 'createcampaign'){
	$campaignname = $_POST['campaignname'];
	if($_POST['campaignformat'] == 'HTML and Text (Recommended)'){
		$campaignformat = 'ht';
	}else if($_POST['campaignformat'] == 'HTML'){
		$campaignformat = 'h';
		}else if($_POST['campaignformat'] == 'Text'){
		$campaignformat = 't';
	}
	$campaignsubject = $_POST['emailsubject'];
	$createdat = date('Y-m-d H:i:s');	
	$campaigncontent1 = stripslashes($_POST['smackeditor']);
	$campaigncontent = html_entity_decode($campaigncontent1);
	$campaigntextcontent = $_POST['textcontent'];
	global $current_user;
	get_currentuserinfo();
	$username = $current_user->user_login;
	$wpdb->insert('smack_email_campaigns',array('campaignname'=>$campaignname,'campaignformat'=>$campaignformat,'campaignsubject'=>$campaignsubject,'createdat'=>$createdat,'owner'=>$username,'active'=>1));
	$campaignid = $wpdb->insert_id;
	$wpdb->insert('smack_emailcampaign_contents',array('campaignid'=>$campaignid,'campaigncontent'=>$campaigncontent,'campaigntextcontent'=>$campaigntextcontent));
        $campaignredirect = get_admin_url().'admin.php?page=market_manager&action=emailCampaigns';
        wp_redirect($campaignredirect);
}

// Send Campaign
if(isset($_REQUEST['module']) && $_REQUEST['module'] == 'sendcampaign'){
	$currentdate = date('Y-m-d');//print($currentdate);die;
	$getuniqueDetails = $wpdb->get_results("select *from smack_uniuqe_details where currentdate = $currentdate");
	$uniquecount = count($getuniqueDetails)+1;
	if(count($getuniqueDetails) == 0 && count($getuniqueDetails) < 500){
	        if(count($getuniqueDetails) == 0){
        	        $wpdb->insert('smack_uniuqe_details',array('currentdate'=>$currentdate,'unique_count'=>$uniquecount));
	        }
		$admin_email = get_settings('admin_email'); 
		$contactlist = explode(',',$_REQUEST['selectedcampaigns']);
		$inc = $inc1= 0;
		for($i=0;$i<count($contactlist);$i++){
			$listname = $contactlist[$i];
			$getcontacts = $wpdb->get_results("select smack_contact_lists.contactid from smack_contact_lists INNER JOIN smack_email_lists ON smack_contact_lists.listid = smack_email_lists.listid where smack_email_lists.name = '$listname' ");
			foreach($getcontacts as $contact){
				$contacts[$inc] = $contact->contactid;
				$inc++;
			}
			$getlistdetails = $wpdb->get_results("select *from smack_email_lists where name = '$listname' ");
			foreach($getlistdetails as $getlistdetail){
		        	$lists[$inc1]=$getlistdetail->listid;
				$inc1++;
			}
		}
		for($x=0;$x<count($contacts);$x++){
			for($j=0;$j<count($lists);$j++){
				$listid = $lists[$j];
				$contactid = $contacts[$x];
				$getCustomdata = $wpdb->get_results(" select smack_customfields.name,smack_customfield_data.data from smack_customfield_data INNER JOIN smack_customfields ON smack_customfields.fieldid = smack_customfield_data.fieldid where smack_customfield_data.listid = $listid and smack_customfield_data.contactid = $contactid");
		                $getcontactdetails = $wpdb->get_results("select *from smack_contacts where contactid = $contactid and unsubscribed = 0 and confirmed = 'y' and activity = 1");
				if(count($getcontactdetails)>0){
			                foreach($getcontactdetails as $getcontactdetail){
			                        $campaigncontact[$x]['Emailaddress']=$getcontactdetail->emailaddress;
						$campaigncontact[$x]['Emailformat'] =$getcontactdetail->format;
		        	        }
					foreach($getCustomdata as $customdata){
						$campaigncontact[$x][$customdata->name] = $customdata->data;
					}
				}
			}
		}
		$campaignid = $_REQUEST['campaignid'];
		$getCampaigndetails = $wpdb->get_results("select *from smack_emailcampaign_contents INNER JOIN smack_email_campaigns ON smack_email_campaigns.campaignid = smack_emailcampaign_contents.campaignid where smack_email_campaigns.campaignid = $campaignid ");
		foreach($getCampaigndetails as $getCampaigndetail){
			$campaigncontent = $getCampaigndetail->campaigncontent;
			$campaigntextcontent = $getCampaigndetail->campaigntextcontent;
			$campaignformat = $getCampaigndetail->campaignformat;
			$campaignsubject = $getCampaigndetail->campaignsubject;
			$campaignname = $getCampaigndetail->campaignname;
		}
		for($send=0;$send<count($campaigncontact);$send++){
			foreach($campaigncontact[$send] as $key => $value){
				$receivername = 'Subscriber';
				if($key == 'First Name'){
					$firstname = $value;
				}
				if($key == 'Last Name'){
					$lastname = $value;
				}
				if($key == 'Emailaddress'){
					$emailaddress = $value;
				}
				if($firstname != null || $lastname != null){
					$receivername = $firstname.' '.$lastname;
				}
				$headers = "From: Administrator <$admin_email>" . "\r\n";
				if($campaignformat == 'h' || $campaignformat == 'ht'){
					$headers .= "Content-type: text/html\r\n"; 
				}
			}
			$content ="Dear $receivername,<br/><br/>".$campaigncontent;
			if($campaignformat == 'h'){
				wp_mail( $emailaddress, $campaignsubject, $content, $headers);
				$table = 'smack_uniuqe_details';
				$data_array = array('unique_count'=>$uniquecount);
				$where = array('currentdate'=>$currentdate);
				$wpdb->update($table, $data_array, $where);
			}
			else if($campaignformat == 'ht'){
				$content = $content.'<br/><br/>'.$campaigntextcontent;
				wp_mail( $emailaddress, $campaignsubject, $content, $headers);
				$table = 'smack_uniuqe_details';
				$data_array = array('unique_count'=>$uniquecount);
				$where = array('currentdate'=>$currentdate);
				$wpdb->update($table, $data_array, $where);
			}
			else{
				wp_mail( $emailaddress, $campaignsubject, $campaigntextcontent, $headers);
				$table = 'smack_uniuqe_details';
				$data_array = array('unique_count'=>$uniquecount);
				$where = array('currentdate'=>$currentdate);
				$wpdb->update($table, $data_array, $where);
			}
		}
		$_SESSION['msgBalloon'] = $campaignname.' campaign has been sent successfully.';
		$lastsent = date('Y-m-d H:i:s');
		$table = 'smack_email_campaigns';
		$data_array = array('lastsent'=>$lastsent);
		$where = array('campaignid'=>$campaignid);
		$wpdb->update($table, $data_array, $where);
		$redirect = get_admin_url().'admin.php?page=market_manager&action=emailCampaigns';
		wp_redirect($redirect);
	}
	else{
		$_SESSION['msgBalloon'] = 'Limits has been reached.You can send only 500 mails per day.';
		$redirect = get_admin_url().'admin.php?page=market_manager&action=emailCampaigns';
		wp_redirect($redirect);
	}
}

// Test SMTP Settings
if(isset($_REQUEST['testmail']) && isset($_REQUEST['testsettings'])){
        $sendmail = $_REQUEST['testmail'];
        $frommail = $_REQUEST['adminmail'];
        $subject = "Test Mail!.";
        $message = "This is test mail. Your Mail Server Settings configured correctly.";
        $headers = "From: Administrator <$frommail>" . "\r\n";
        wp_mail( $sendmail, $subject, $message, $headers);
	$_SESSION['msgBalloon'] = "Testmail has been send successfuly!.";
        $redirect = get_admin_url().'admin.php?page=marketer_settings';
        wp_redirect($redirect);
}

// Update Campaign
if(isset($_POST['action']) && $_POST['action'] == 'updatecampaign'){
        $campaignname = $_POST['campaignname'];
	$campaignid = $_POST['campaignid'];
        if($_POST['campaignformat'] == 'HTML and Text (Recommended)'){
                $campaignformat = 'ht';
        }else if($_POST['campaignformat'] == 'HTML'){
                $campaignformat = 'h';
        }else if($_POST['campaignformat'] == 'Text'){
                $campaignformat = 't';
        }
        $campaignsubject = $_POST['emailsubject'];
        $campaigncontent1 = stripslashes($_POST['campaigncontent']);
        $campaigncontent = html_entity_decode($campaigncontent1);
        $campaigntextcontent = $_POST['textcontent'];
        global $current_user;
        get_currentuserinfo();
        $username = $current_user->user_login;
	$table = 'smack_email_campaigns';
	$data_array = array('campaignname'=>$campaignname,'campaignformat'=>$campaignformat,'campaignsubject'=>$campaignsubject,'owner'=>$username,'active'=>1);
	$where = array('campaignid'=>$campaignid);
	$wpdb->update($table, $data_array, $where);
        //$campaignid = $wpdb->insert_id;
	$table1 = 'smack_emailcampaign_contents';
	$data_array1 = array('campaigncontent'=>$campaigncontent,'campaigntextcontent'=>$campaigntextcontent);
	$where1 = array('campaignid'=>$campaignid);
	$wpdb->update($table1, $data_array1, $where1);
        $campaignredirect = get_admin_url().'admin.php?page=market_manager&action=emailCampaigns';
        wp_redirect($campaignredirect);
}
?>
