<?php if(isset($_SESSION['msgBalloon'])){ ?>
<div class='msgBalloon'><p><?php echo $_SESSION['msgBalloon']; unset($_SESSION['msgBalloon']); ?></p></div>
<?php } 
require( dirname(__FILE__) . '/../../../../wp-load.php' ); 
global $wpdb,$siteurl; 
if(is_user_logged_in()) { 
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
$getLists = $wpdb->get_results("select * from smack_email_lists limit $limit,$offset");
$getListCount = $wpdb->get_results("select * from smack_email_lists");
$listcount = count($getListCount);
?>
<br/>
<div id="listindex">
<input type="button" class='button-primary' value="Create a Contact List" onclick="listingContacts('<?php echo $siteurl; ?>')" />

<table class='emaillists widefat'>
<thead>
<tr class='header'>
<th>List Name</th>
<th>Created at</th>
<th>Contacts</th>
<th>List Owner Name</th>
<th>Action</th>
</tr>
</thead>
<?php
	foreach($getLists as $listdetail){
		$getcontactdetails = $wpdb->get_results("select *from smack_contact_lists where listid = $listdetail->listid "); 
		$no_of_contacts = count($getcontactdetails);
		$getcreatedttime = explode(' ',$listdetail->createdttime);
                $createdttime = $getcreatedttime[0]; ?>
		<tr class='content'>
		<td><?php echo $listdetail->name; ?></td>
		<td><?php echo $createdttime; ?></td>
		<td><?php echo '('.$no_of_contacts.') Contacts'; ?></td>
		<td><?php echo $listdetail->ownername; ?></td>
		<td><a onclick="editlist('<?php echo $listdetail->listid; ?>','edit','<?php echo $siteurl; ?>')" >Edit</a>&nbsp;<a onclick="deletelist('<?php echo $listdetail->listid; ?>','delete','<?php echo $siteurl; ?>')">Delete</a><!--<a>Edit</a>&nbsp;<a>Delete</a>--></td>
		</tr>
	<?php }
?>
        <tr>
        <td colspan=8 style='text-align:center;'>
        <?php $pagecount = ceil($listcount/10);//print($pagecount);print("<br/>listscount: $listscount");
        if(isset($_REQUEST['pageno']) && $_REQUEST['pageno']>1){
                $prev = $_REQUEST['pageno']-1;
        }
        else if($_REQUEST['pageno']==1){
                $prev = $pagecount;
        }
        ?>
        <a class="smacklink" onclick="listpagination('<?php echo $siteurl; ?>',1)" >|< First</a>
        <?php if($prev !=$pagecount && $pagecount !=1 ){ ?>
        <a class="smacklink" onclick="listpagination('<?php echo $siteurl; ?>','<?php echo $prev; ?>')" ><< Prev</a>
        <?php } ?>
        <?php for($page = 1;$page<= $pagecount; $page++){ ?>
                <a class="smacklink" onclick="listpagination('<?php echo $siteurl; ?>','<?php echo $page; ?>')" ><?php echo $page; ?></a>
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
        <a class="smacklink" onclick="listpagination('<?php echo $siteurl; ?>','<?php echo $next; ?>')" >Next >></a>
        <?php } ?>
        <a class="smacklink" onclick="listpagination('<?php echo $siteurl; ?>','<?php echo $pagecount; ?>')" >Last >|</a>
        </td>
        </tr>
</table>
</div>
<?php
} else {
        wp_redirect($siteurl.'/wp-admin');
}
?>
