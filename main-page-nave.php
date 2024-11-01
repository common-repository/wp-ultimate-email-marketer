<?php
global $menus;
$menus = array(
//	'mainDashboard'=>__('Dashboard'),
	'lists' => __('Manage List'),
	'contacts' => __('Contacts'),
	'emailCampaigns' => __('Email Campaigns'),
);

function topMenu()
{
global $menus;
	$class = "";
	$top_nav_menu = "<div class= 'top-navigation-wrapper'>";
	$top_nav_menu .= "<ul class='Navigation-menu-bar'>";
	foreach($menus as $links => $text)
	{
		if( $_REQUEST['action'] == $links )
		{
			$class = "navigation-menu-link-active";
		}
		elseif( !isset($_REQUEST['action']) && ($links == "contacts") )
		{
			$class = "navigation-menu-link-active";
		}
		$top_nav_menu .= "<li class='navigation-menu'><a class='navigation-menu-link $class' href='?page=market_manager&action={$links}'>{$text}</a></li>";
		$class = "";
	}
	$top_nav_menu .= "</ul>";
	$top_nav_menu .= "</div>";
	return $top_nav_menu;
}

function mainBody()
{

}
?>
<div id="main-page">
<?php
echo topMenu();
?>
<div id="content-page">
<?php
$action();
?>
</div>
</div>
