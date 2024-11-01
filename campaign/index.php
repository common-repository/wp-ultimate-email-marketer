<?php
require( dirname(__FILE__) . '/../../../../wp-load.php' ); 
global $wpdb,$siteurl; 

if(isset($_SESSION['msgBalloon'])){ ?>
<div class='msgBalloon'><p><?php echo $_SESSION['msgBalloon']; unset($_SESSION['msgBalloon']); ?></p></div>
<?php } 
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
$getCampaignscount = $wpdb->get_results("select *from smack_email_campaigns ");
$getCampaigns = $wpdb->get_results("select *from smack_email_campaigns limit $limit,$offset");
$campaignscount = count($getCampaignscount);
?>
<div id='emailcampaignlist'>
<div class="sam-camp-cont">
<h2>View Email Campaigns</h2>
<p>Email campaigns are messages that are sent to your contacts. Use email campaigns to send newsletters, promotions or notification emails.</p>
<input type='button' class='button-primary' name='createcampaign' id='createcampaign' value='Create an Email Campaign' onclick="smackcampaign('<?php echo $siteurl; ?>')" />
<br/><br/>
<select name='chooseaction' id='chooseaction'>
<option>Choose an action</option>
<option>Delete</option>
<option>Activate</option>
<option>Deactivate</option>
</select>
<input type='button' class='button-primary' name='takeaction' id='takeaction' value='Go' onclick="toogleaction('selectall','<?php echo $siteurl; ?>')" />
</div>
<table class='emaillists widefat'>
<thead>
<tr class='header'>
<th class='tiny'><input type='checkbox' name='checkall' id='checkall' onclick="checkallcampaign()" /></th>
<th>Name</th>
<th>Subject</th>
<th class='small'>Created</th>
<th class='small'>Last Sent</th>
<th class='small'>Owner</th>
<th class='tiny'>Active</th>
<th>Action</th>
</tr>
</thead>
<?php
	foreach($getCampaigns as $campaigndetail){
		$campaignid = $campaigndetail->campaignid; 
		$createdat = explode(' ',$campaigndetail->createdat);
		$lastsent = explode(' ',$campaigndetail->lastsent);
		$active = $campaigndetail->active;?>
		<tr class='content'>
		<td class='tiny'><input type='checkbox' name="campaign[<?php echo $campaignid; ?>]" id="campaign<?php echo $campaignid; ?>" onclick="selectcampaign(this)" /></td>
                <td><?php echo $campaigndetail->campaignname; ?></td>
                <td><?php echo $campaigndetail->campaignsubject; ?></td>
                <td class='small'><?php echo $createdat[0]; ?></td>
                <td class='small'><?php echo $lastsent[0]; ?></td>
                <td class='small'><?php echo $campaigndetail->owner; ?></td>
                <td class='tiny' style='text-align:center'>
		<?php if($active == 1){ ?> <img src="<?php echo WP_CONTENT_URL; ?>/plugins/wp-ultimate-email-marketer/images/tick.gif" alt="Active" height="16" width="16" onclick="campaignstatus('<?php echo $campaignid; ?>','inactive','<?php echo $siteurl; ?>')"> </td> <?php } else{ ?> <img src="<?php echo WP_CONTENT_URL; ?>/plugins/wp-ultimate-email-marketer/images/cross.gif" alt="Active" height="16" width="16" onclick="campaignstatus('<?php echo $campaignid; ?>','active','<?php echo $siteurl; ?>')"> </td> <?php } ?>
                <td><a onclick="editcampaign('<?php echo $campaignid; ?>','editcampaign','<?php echo $siteurl; ?>')">View & Edit</a>&nbsp;&nbsp;<?php if($active == 0){ ?><label>Send</label><?php }else{ ?><a id="send" onclick="sendCampaign('<?php echo $campaignid; ?>','send','<?php echo $siteurl; ?>')" >Send</a><?php } ?>&nbsp;&nbsp;<a id="delete" onclick="deletecampaign('<?php echo $campaignid; ?>','delete','<?php echo $siteurl; ?>')">Delete</a></td>
		</tr>
<?php
$campaigns = $campaigns.','.$campaignid;
}
?>
        <tr>
        <td colspan=8 style='text-align:center;'>
        <?php $pagecount = ceil($campaignscount/10);
        if(isset($_REQUEST['pageno']) && $_REQUEST['pageno']>1){
                $prev = $_REQUEST['pageno']-1;
        }
        else if($_REQUEST['pageno']==1){
                $prev = $pagecount;
        }
        ?>
        <a class="smacklink" onclick="campaignpagination('<?php echo $siteurl; ?>',1)" >|< First</a>
        <?php if($prev !=$pagecount && $pagecount !=1 ){ ?>
        <a class="smacklink" onclick="campaignpagination('<?php echo $siteurl; ?>','<?php echo $prev; ?>')" ><< Prev</a>
        <?php } ?>
        <?php for($page = 1;$page<= $pagecount; $page++){ ?>
                <a class="smacklink" onclick="campaignpagination('<?php echo $siteurl; ?>','<?php echo $page; ?>')" ><?php echo $page; ?></a>
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
        <a class="smacklink" onclick="campaignpagination('<?php echo $siteurl; ?>','<?php echo $next; ?>')" >Next >></a>
        <?php } ?>
        <a class="smacklink" onclick="campaignpagination('<?php echo $siteurl; ?>','<?php echo $pagecount; ?>')" >Last >|</a>
        </td>
        </tr>

</table>
<?php $smackcampaigns = substr($campaigns,'1');?>
<input type='hidden' name='campaignscount' id='campaignscount' value="<?php echo $smackcampaigns; ?>" />
</div>
