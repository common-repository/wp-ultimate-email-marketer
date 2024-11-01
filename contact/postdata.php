<?php 
require( dirname(__FILE__) . '/../../../../wp-load.php' );

if($_REQUEST['module'] == 'choosinglist'){
	$_SESSION['smackmodule']=$_REQUEST['module'];
	$_SESSION['selectedlist']=$_REQUEST['selectedlist'];
}

// Clear Filter
if(isset($_REQUEST['resetfilter']) && $_REQUEST['resetfilter'] == 'Reset Filter' ){
	$_SESSION['searchcontacts'] = array();
        $redirect = get_admin_url().'admin.php?page=market_manager&action=contacts';
        wp_redirect($redirect);

}
// Add contact
if($_REQUEST['module'] == 'addcontact'){
	$listid = $_REQUEST['listid'];
	$email = $_REQUEST['email'];
	$getdomainfromemail = explode("@", $email);
	$domainname = $getdomainfromemail[1];
	$time = time();
	$code = 'smack5403'.$time;
	$confirmcode = md5($code);
	$activity = 1;
	if($_REQUEST['activity'] == 'inactive')
	$activity = 0;
	if($_REQUEST['emailformat'] == 'html'){
		$emailformat = 'h';
	}
	else if($_REQUEST['emailformat'] == 'text'){
		$emailformat = 't';
	}
	if($_REQUEST['status'] == 'confirmed'){
		$confirmed = 'y';
		$requesteddate = $confirmdate = $subscribedate = date('Y-m-d H:i:s');
	}
	else if($_REQUEST['status'] == 'unconfirmed'){
		$confirmed = 'n';
		$requesteddate = date('Y-m-d H:i:s');
		$confirmdate = $subscribedate = '';
	}

	$getContactinfo = $wpdb->get_results("select emailaddress from smack_contacts");
	$contactcheck = 'ok';
	foreach($getContactinfo as $contactinfo){
		if($contactinfo->emailaddress == $email){
			$contactcheck = 'not ok';
			$_SESSION['msgBalloon'] = 'Contact has been already present';
		}
	}
	if($contactcheck == 'ok'){
		$wpdb->insert('smack_contacts',array('emailaddress'=>$email,'domainname'=>$domainname,'format'=>$emailformat,'confirmed'=>$confirmed,'confirmedcode'=>$confirmcode,'requestdate'=>$requesteddate,'confirmdate'=>$confirmdate,'subscribedate'=>$subscribedate,'activity'=>$activity));
		$contactid = $wpdb->insert_id;
		$wpdb->insert('smack_contact_lists',array('contactid'=>$contactid,'listid'=>$listid));
	}
	// Add the customfields datas in "smack_customfield_data".
	if(isset($_REQUEST['field']) && $contactcheck == 'ok'){
		foreach($_REQUEST['field'] as $listkey => $listvalue){
			$wpdb->insert('smack_customfield_data',array('contactid'=>$contactid,'fieldid'=>$listkey,'data'=>$listvalue,'listid'=>$listid));
			$_SESSION['msgBalloon'] = 'Contact has been Saved';
		}
	}
        $redirect = get_admin_url().'admin.php?page=market_manager&action=contacts';
        wp_redirect($redirect);
}

// Delete Contacts 
if($_REQUEST['action']=='delete'){
	$contactid =$_REQUEST['contact'];
	$wpdb->query("DELETE FROM smack_contacts WHERE contactid= $contactid");
        $wpdb->query("DELETE FROM smack_contact_lists WHERE contactid= $contactid");
        $wpdb->query("DELETE FROM smack_customfield_data WHERE contactid= $contactid");
	$_SESSION['msgBalloon'] = 'Contact has been Deleted';
}

// Edit Contact Information
if($_REQUEST['module']=='editcontact'){
        $listid = $_REQUEST['listid'];
        $email = $_REQUEST['email'];
        $getdomainfromemail = explode("@", $email);
        $domainname = $getdomainfromemail[1];
        $activity = 1;
        if($_REQUEST['activity'] == 'inactive')
        $activity = 0;
        if($_REQUEST['emailformat'] == 'html'){
                $emailformat = 'h';
        }
        else if($_REQUEST['emailformat'] == 'text'){
                $emailformat = 't';
        }
        if($_REQUEST['status'] == 'confirmed'){
                $confirmed = 'y';
        }
        else if($_REQUEST['status'] == 'unconfirmed'){
                $confirmed = 'n';
        }

	// Update contact information
	$table = 'smack_contacts';
	$data_array = array('emailaddress'=>$email,'domainname'=>$domainname,'format'=>$emailformat,'confirmed'=>$confirmed,'activity'=>$activity);	
	$where = array('contactid'=>$_REQUEST['contactid']);
	$wpdb->update( $table, $data_array, $where );
	$_SESSION['msgBalloon'] = 'Contact has been Updated';
	// Update contact customfield information
	$table1 = 'smack_customfield_data';
	foreach($_REQUEST['field'] as $key => $customfielddetail){
		if($customfielddetail == '-- Select --'){
			$customfielddetail = '';
		}
		$data_array1 = array('data' => $customfielddetail);
		$where1 = array('contactid'=>$_REQUEST['contactid'],'listid'=>$listid,'fieldid'=>$key);
//print_r($data_array1);
		$wpdb->update( $table1, $data_array1, $where1);
	}
        $redirect = get_admin_url().'admin.php?page=market_manager&action=contacts';
        wp_redirect($redirect);
}

// Export Contacts by selected list

if(isset($_REQUEST['export']) && $_REQUEST['export']=='Export Contacts' || $_REQUEST['exportall']=='Here!' && $_REQUEST['module']=='export'){
	$listid = $_REQUEST['selectedlist'];
	$csvheader = $_REQUEST['csvheader'].','.'Created at';
        $getCustomfields = $wpdb->get_results("select *from smack_customfields");
        foreach($getCustomfields as $fieldkey => $fieldvalue){
	        $csvheader = $csvheader.','.$fieldvalue->name;
        }

	// Get the Custom Fields data
	if($_REQUEST['exportall']=='Here!'){
		$getCustomfieldsdata = $wpdb->get_results("select *from smack_contact_lists");
	}
	else if($_REQUEST['export']=='Export Contacts'){
		$getCustomfieldsdata = $wpdb->get_results("select *from smack_contact_lists where listid = $listid");
	}
	for($i=0;$i<count($getCustomfieldsdata);$i++){
		$contactid = $getCustomfieldsdata[$i]->contactid;
		if($_REQUEST['exportall']=='Here!'){
			$getContact_customdata = $wpdb->get_results("select *from smack_customfield_data where contactid = $contactid");
		}
		else if($_REQUEST['export']=='Export Contacts'){
                        $getContact_customdata = $wpdb->get_results("select *from smack_customfield_data where contactid = $contactid and listid = $listid ");
		}
		if($contactid == $getCustomfieldsdata[$i]->contactid){
		   if(count($getContact_customdata)!=0){
			foreach($getContact_customdata as $customfielddata){
				$fielddata_array[$customfielddata->fieldid]=$customfielddata->data;
		 	       // Get the Custom Fields data
			        $getCustomfields = $wpdb->get_results("select *from smack_customfields");
			        foreach($getCustomfields as $fieldkey => $fieldvalue){
		                	$customfieldsheader[$fieldvalue->fieldid]=$fieldvalue->name;
        			}
				foreach($customfieldsheader as $cfkey => $cfvalue){
					$customfield_data_array[$cfvalue]='';
					foreach($fielddata_array as $fdkey => $fdvalue){
						if($cfkey == $fdkey){
							$customfield_data_array[$cfvalue]=$fdvalue;
						}
					}
				}
			} 
		    }else{
  	                   $getCustomfields = $wpdb->get_results("select *from smack_customfields");
                           foreach($getCustomfields as $fieldkey => $fieldvalue){
        	                   $customfield_data_array[$fieldvalue->name]='';
                           }
		    }
		    $getContactinfo = $wpdb->get_results("select *from smack_contacts where contactid = $contactid");
		    $baseheader = explode(',',$csvheader);
		    foreach($getContactinfo as $cinfovalue){
		    	if($cinfovalue->format == 'h'){
				$format = 'HTML';
			}else if($cinfovalue->format == 't'){
				$format = 'Text';
			}
			if($cinfovalue->confirmed == 'y'){
				$status = 'Confirmed';
			}else if($cinfovalue->confirmed == 'n'){
                                $status = 'Unconfirmed';
                        }
			foreach($baseheader as $bkey => $bvalue){
				if($bvalue =='Email Address')
					$smack_arr[$i] = $smack_arr[$i].',"'.$cinfovalue->emailaddress.'"';
                                if($bvalue =='Email Format')
                         	        $smack_arr[$i] = $smack_arr[$i].',"'.$format.'"';
                                if($bvalue =='Status')
                                        $smack_arr[$i] = $smack_arr[$i].',"'.$status.'"';
                                if($bvalue =='Contact IP Address')
                                        $smack_arr[$i] = $smack_arr[$i].',"'.$cinfovalue->confirmip.'"';
                                if($bvalue =='Created at')
                                        $smack_arr[$i] = $smack_arr[$i].',"'.$cinfovalue->requestdate.'"';
			}
		    }
		    foreach($customfield_data_array as $cdkey =>$cdvalue){
			$smack_arr[$i] = $smack_arr[$i].',"'.$cdvalue.'"';
		    }
		}
	}
	for($datacount = 0; $datacount<count($smack_arr); $datacount++){
		$csvdata_array[$datacount] = substr($smack_arr[$datacount],1);
	}
	$filename = "contacts".date('Y-m-d H:i:s');

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename="'.$filename.'.csv"');

	// create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');
	print($csvheader);print("\n");
	// output the column headings
	fputcsv($output, $csvheader);
	
	foreach($csvdata_array as $csvvalue){
		print($csvvalue);print("\n");
		fputcsv($output,$csvvalue);
	}
}

// Search Contacts

if($_REQUEST['module'] == 'searchContacts'){
	$emailaddress = $_REQUEST['emailaddress'];
	$format = 't';
	$status = 'n';
	$subscription = 0;
	if($_REQUEST['format'] == 'html'){
		$format = 'h';
	}
	if($_REQUEST['status'] == 'Confirmed'){
		$status = 'y';
	}
	if($_REQUEST['subscription'] == 'Unsubscribed'){
		$subscription = 1;
	}
	if($_REQUEST['enable_advancedsearch'] == 'enable_advancedsearch'){
		$_SESSION['searchcontacts']['enable_advancedsearch'] = 'enable_advancedsearch';
	}
	$_SESSION['searchcontacts']['emailaddress'] = $emailaddress;
	$_SESSION['searchcontacts']['format'] = $format;
	$_SESSION['searchcontacts']['status'] = $status;
	$_SESSION['searchcontacts']['subscription'] = $subscription;
        $redirect = get_admin_url().'admin.php?page=market_manager&action=contacts';
        wp_redirect($redirect);
}
?>

