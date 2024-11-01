<?php 
//if(isset($_REQUEST['siteurl']))
//{
	require_once( dirname(__FILE__) . '/../../../../wp-load.php' );
//}
 global $wpdb;
if(is_user_logged_in()) { 
?>
<?php if(!isset($_FILES) || $_FILES['csv']==''){ ?>
<table class='emaillists widefat'>
<thead>
<tr class='header'>
<th>Email Address </th>
<th class='small'>Date Added </th>
<th class='small'>Email Format </th>
<!--<td class='small'>Activity Status </td>-->
<th class='small'>Confirmed</th>
<th>Contact List </th>
<th>Action </th>
</tr>
</thead>
<?php
	$offset = 10;
	if(isset($_REQUEST['pageno']))
	{
		$pageno = $_REQUEST['pageno'];
	}
	else
	{
		$pageno = 1;
	}
	$limit = $pageno*$offset-$offset;
	if(isset($_SESSION['searchcontacts']) && !empty($_SESSION['searchcontacts'])){
		$enabler = $_SESSION['searchcontacts']['enable_advancedsearch'];
		$emailaddress = $_SESSION['searchcontacts']['emailaddress'];
		$emailformat = $_SESSION['searchcontacts']['format'];
		$status = $_SESSION['searchcontacts']['status'];
		$subscription = $_SESSION['searchcontacts']['subscription'];
		if($enabler != '' || $enabler != null){
			$get_contacts_count = $wpdb->get_results("select * from smack_contacts where emailaddress like '%$emailaddress%' and format = '$emailformat' and confirmed = '$status' and unsubscribed = $subscription ");
			$getContacts = $wpdb->get_results("select * from smack_contacts where emailaddress like '%$emailaddress%' and format = '$emailformat' and confirmed = '$status' and unsubscribed = $subscription limit $limit,$offset");
		}
		else{
                        $get_contacts_count = $wpdb->get_results("select * from smack_contacts where emailaddress like '%$emailaddress%' ");
                        $getContacts = $wpdb->get_results("select * from smack_contacts where emailaddress like '%$emailaddress%' limit $limit,$offset");
		}
	}
	else{
		$get_contacts_count = $wpdb->get_results("select * from smack_contacts");
		$getContacts = $wpdb->get_results("select * from smack_contacts limit $limit,$offset");
	}
	$no_of_contacts = count($get_contacts_count);
	foreach($getContacts as $contactdetail){
		$getListdetail = $wpdb->get_results("select *from smack_contact_lists where contactid = $contactdetail->contactid" );
		foreach($getListdetail as $listdetail){
			$getListname = $wpdb->get_results("select *from smack_email_lists where listid = $listdetail->listid ");
			$lists='';
			foreach($getListname as $listname){
				$lists = $lists.$listname->name.',';
			}	
		}
		$contact_in_list = substr($lists, 0, -1);
		$emailformat = 'HTML';
		if($contactdetail->format == 't')
		$emailformat = 'Text';
		$confirmed = 'Confirmed';
		if($contactdetail->confirmed == 'n')
		$confirmed = 'Unconfirmed';
		$activity = 'Active';
		if($contactdetail->activity == 0)
		$activity = 'Inactive'; 
		$getrequestdate = explode(' ',$contactdetail->requestdate);
		$requestdate = $getrequestdate[0];?>
		<tr class='content'>
		<td><?php echo $contactdetail->emailaddress; ?></td>
		<td class='small'><?php echo $requestdate; ?></td>
		<td class='small'><?php echo $emailformat; ?></td>
<!--		<td class='small'><?php echo $activity; ?></td>-->
		<td class='small'><?php echo $confirmed; ?></td>
		<td><?php echo $contact_in_list; ?></td>
		<td><a onclick="editcontact('<?php echo $contactdetail->contactid; ?>','edit','<?php echo $siteurl; ?>','<?php echo $contact_in_list; ?>')" >Edit</a>&nbsp;<a onclick="deletecontact('<?php echo $contactdetail->contactid; ?>','delete','<?php echo $siteurl; ?>')">Delete</a></td>
		</tr>
	<?php }
?>
	<tr>
	<td colspan=7 style='text-align:center;'>
	<?php $pagecount = ceil($no_of_contacts/10);
        if(isset($_REQUEST['pageno']) && $_REQUEST['pageno']>1){
                $prev = $_REQUEST['pageno']-1;
        }
        else if($_REQUEST['pageno']==1){
                $prev = $pagecount;
        }
	?>
	<a class="smacklink" onclick="pagination('<?php echo $siteurl; ?>',1)" >|< First</a>
	<?php if($prev !=$pagecount && $pagecount != 1){ ?>
	<a class="smacklink" onclick="pagination('<?php echo $siteurl; ?>','<?php echo $prev; ?>')" ><< Prev</a>
	<?php } ?>
	<?php for($page = 1;$page<= $pagecount; $page++){ ?>
		<a class="smacklink" onclick="pagination('<?php echo $siteurl; ?>','<?php echo $page; ?>')" ><?php echo $page; ?></a>
	<?php } 
	if(isset($_REQUEST['pageno']) && $_REQUEST['pageno']<$pagecount){
		$next = $_REQUEST['pageno']+1;
	}
	else if($_REQUEST['pageno']==$pagecount){
		$next = 1;
	}
	else{
		$next = 2;
	}if($next <= $pagecount && $next!=1){
	?>
	<a class="smacklink" onclick="pagination('<?php echo $siteurl; ?>','<?php echo $next; ?>')" >Next >></a>
	<?php } ?>
	<a class="smacklink" onclick="pagination('<?php echo $siteurl; ?>','<?php echo $pagecount; ?>')" >Last >|</a>
	</td>
	</tr>
</table>
<?php } 
} else {
        wp_redirect($siteurl.'/wp-admin');
}
?>
