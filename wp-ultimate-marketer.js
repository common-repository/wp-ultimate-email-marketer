function createcontact(){
	var siteurl = document.getElementById('siteurl').value;
	document.getElementById('module').value='addcontact';
	var count = document.getElementById('countcontacts').value;
	if(count == 0){
		alert('create a list first');
		return false;
	}
	else{
		var a = document.getElementById('selectedlist');
		var val = a.options[a.selectedIndex].value;
		var data = "&siteurl="+siteurl+"&listname="+val;
        	jQuery.ajax({
	                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/contact/addcontact.php',
        	        type: 'post',
	                data: data,
        	        success: function(response){
                        	jQuery("#content").html(response);
               		}
	        });
	}
}

function addContacts(siteurl){
	document.getElementById('contactindex').innerHTML='';
	document.getElementById('csv_data').innerHTML = '';
	document.getElementById('module').value='choosinglist';
	var list = "&module=contact&action=listconfig";
	jQuery.ajax({
		url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/contact/selectlist.php',
		type: 'post',
		data: list,
		success: function(response){
			jQuery("#content").html(response);
			document.getElementById('siteurl').value=siteurl;
                        document.getElementById('importform').innerHTML = '';
		}
	});

}

function deletecontact(contactid,action,siteurl){
	var data = "&contact="+contactid+"&action="+action+"&siteurl="+siteurl;
	var r=confirm("Are you sure ?");
	if (r==true)
	{
	  x="You pressed OK!";
	}
	else
	{
	  x="You pressed Cancel!";
	} 
	if(x=="You pressed OK!"){
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/contact/postdata.php',
                type: 'post',
                data: data,
                success: function(response){	
			location.reload()
                }
        });
	}

}

function editcontact(contactid,action,siteurl,listname){
	var data = "&contact="+contactid+"&action="+action+"&siteurl="+siteurl+"&listname="+listname;
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/contact/edit.php',
                type: 'post',
                data: data,
                success: function(response){
			document.getElementById('contactindex').innerHTML='';
                        jQuery("#content").html(response);
                        document.getElementById('module').value='editcontact';
                }
        });
}

function importContacts(siteurl){
        document.getElementById('module').value='import';
	
        var data = "&module=contact&sub_module=import";
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/contact/import.php',
                type: 'post',
                data: data,
                success: function(response){
			document.getElementById('contactindex').innerHTML = ''; 
			document.getElementById('csv_data').innerHTML = '';
                        document.getElementById('content').innerHTML = '';
                        jQuery("#importform").html(response);
                }
        });
}

function exportContacts(siteurl){
	document.getElementById('module').value='export';
        var data = "&module=contact&sub_module=export";
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/contact/export.php',
                type: 'post',
                data: data,
                success: function(response){
                        document.getElementById('contactindex').innerHTML = '';
			document.getElementById('csv_data').innerHTML = '';
			document.getElementById('importform').innerHTML = '';
                        jQuery("#content").html(response);
                }
        });
}

function listingContacts(siteurl){
	document.getElementById('listindex').innerHTML='';
        var data = "&module=list";
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/list/list.php',
                type: 'post',
                data: data,
                success: function(response){
                        jQuery("#content").html(response);
			document.getElementById('module').value='list';
                }
        });
}

function searchContacts(siteurl){
	document.getElementById('module').value='searchContacts';
        var data = "&module=contact&sub_module=search";
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/contact/searchcontacts.php',
                type: 'post',
                data: data,
                success: function(response){
                        document.getElementById('contactindex').innerHTML = '';
		        document.getElementById('csv_data').innerHTML = '';
                        document.getElementById('importform').innerHTML = '';
                        jQuery("#content").html(response);
                }
        });
}

function advancedsearch(siteurl){
        var data = "&module=contact&sub_module=advancedsearch";
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/contact/advancedsearch.php',
                type: 'post',
                data: data,
                success: function(response){
                        document.getElementById('contactindex').innerHTML = '';
                        jQuery("#content").html(response);
                }
        });
}

function pagination(siteurl,page){
        var data = "&pageno="+page+"&siteurl="+siteurl;
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/contact/showcontacts.php',
                type: 'post',
                data: data,
                success: function(response){
                        document.getElementById('contactindex').innerHTML = '';
                        jQuery("#content").html(response);
                }
        });
}

function create_new_list(){
	var listname = document.getElementById('listname').value;
	var listownersname = document.getElementById('listownersname').value;
	var listownersemail = document.getElementById('listownersemail').value;
	var listreplytoemail = document.getElementById('listreplytoemail').value;
	var listbounceemail = document.getElementById('listbounceemail').value;
	if(listname=='' || listownersname=='' || listownersemail=='' || listreplytoemail=='' || listbounceemail==''){
		if(listname==''){
			alert("Don't leave empty the listname.");
			return false;
		}
                if(listownersname==''){
                        alert("Don't leave empty the list owners name.");
			return false;
		}
                if(listownersemail==''){
                        alert("Don't leave empty the list owners email.");
			return false;
		}
                if(listreplytoemail==''){
                        alert("Don't leave empty the list reply-to-email.");
			return false;
		}
                if(listbounceemail==''){
                        alert("Don't leave empty the list bounce email.");
			return false;
		}
		return false;
	}
	else{
		return true;
	}
}

function smackValidate(){
	var module = document.getElementById('module').value;
	if(module == 'addcontact' || module == 'editcontact'){
		var emailaddress = document.getElementById('email').value;
                var ef = document.getElementById('emailformat');
                var mailformat = ef.options[ef.selectedIndex].value;
		var b = document.getElementById('status');
		var contactstatus = b.options[b.selectedIndex].value;
		var c = document.getElementById('activity');
		var activity = c.options[c.selectedIndex].value;
		if(emailaddress == ''){
			alert('Please enter the Email-ID');
			return false;
		}
		if(mailformat == 'select'){
			alert('Choose any mail format');
			return false;
		}
		if(contactstatus == 'select'){
			alert('Choose any status');
			return false;
		}
		if(activity == 'select'){
			alert('Choose any activity');
			return false;
		}
		else{
			return true;
		}
	}
	if(module == 'import'){
		var listcount = document.getElementById('listcount').value;
        	if(listcount == 0){
	                alert('create a list first');
	                return false;
	        }
        	else{
			var csvfile = document.getElementById('csv').value;
			if(listcount == 0 || csvfile == ''){
				alert('Attach a file then proceed');
				return false;
			}
			else{
				return true;
			}
		}
	}
	if(module == 'export'){
                var listcount = document.getElementById('listcount').value;
                if(listcount == 0){
                        alert('You have no list to export contacts!');
                        return false;
                }
                else{
			return true;
		}
	}
	var csvupload = document.getElementById('csvupload').value;
       	// Mapping Fields for Import contacts
	var st = document.getElementById('status');
	var importstatus = st.options[st.selectedIndex].text;
	var mappedfields = document.getElementById('mappedfields').value;
        var manFields=mappedfields.split(",");
        var header_count = document.getElementById('h2').value;
	for(var mc=0 ; mc<manFields.length; mc++){
                var cnt_man = 0;
                for(var j = 0;j<header_count;j++ ){
                        var to_chkobj = document.getElementById('field'+j);
                        var to_chk = to_chkobj.options[to_chkobj.selectedIndex].text;
                        if(manFields[mc] == to_chk){
                                cnt_man++;
                        }
                }
		
                if(cnt_man == 0 ){
                        alert(manFields[mc] + ' is a Mandatory field in Marketer Contacts');
                        return false;
	        }
        }
	if(importstatus == '-- Select --'){
		alert('Status is a Mandatory field in Marketer Contacts');
		return false;
	}
	return true;
}

function mapping(selected_id,count){
        var selected = selected_id.value;
        var header_count = document.getElementById('h2').value;
        var myval =  document.getElementById('field'+count).value;
        for(var j=0;j<header_count;j++){
                var selected_value = document.getElementById('field'+j);
                var value1 = selected_value.options[selected_value.selectedIndex].value;
                if(j != count){
                        if(myval == value1 && myval != 0){
                                var selected_dropdown = document.getElementById('field'+count);
                                selected_dropdown.selectedIndex = '--Select--';
                                var smackfield = document.getElementById('field'+count).selectedIndex;
                                alert('Your mapped field is already selected!');
                                return false;
                        }
                }
        }
}

function editlist(listid,action,siteurl){
	var data = "&listid="+listid+"&action="+action+"&siteurl="+siteurl;
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/list/edit.php',
                type: 'post',
                data: data,
                success: function(response){
                        document.getElementById('listindex').innerHTML='';
                        jQuery("#content").html(response);
                }
        });
}

function deletelist(listid,action,siteurl){
        var data = "&listid="+listid+"&action="+action+"&siteurl="+siteurl;
        var r=confirm("Are you sure ?");
        if (r==true)
        {
          x="You pressed OK!";
        }
        else
        {
          x="You pressed Cancel!";
        }
        if(x=="You pressed OK!"){
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/list/postdata.php',
                type: 'post',
                data: data,
                success: function(response){
                        location.reload()
                }
        });
        }

}

function importcsv(siteurl){
	alert('importcsv');
	var selectedlist = document.getElementById('selectedlist');
	var listname = selectedlist.options[selectedlist.selectedIndex].text; alert(listname);
	var file = document.getElementById('csv').value;alert(file);
	var getdelim = document.getElementById('delimiter');
	var delimiter = getdelim.options[getdelim.selectedIndex].text;alert(delimiter);
	var data = "&action=importcsv&selectedlist="+selectedlist+"&delimiter="+delimiter;
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/contact/importcsv.php',
                type: 'post',
                data: data,
                success: function(response){
                        document.getElementById('contactindex').innerHTML = '';
                        jQuery("#content").html(response);
                }
        });
}

function mailserversettings(){
	var hostname = document.getElementById('hostname').value;
	var username = document.getElementById('username').value;
	var password = document.getElementById('password').value;
	var port = document.getElementById('port').value;
	if(hostname == '' || username == '' || password == '' || port == ''){
		if(hostname == ''){
			alert("Don't leave empty the hostname");
			return false;
		}
		if(username == ''){
			alert("Don't leave empty the username");
                        return false;
		}
		if(password == ''){
			alert("Don't leave empty the password");
                        return false;
			
		}
		if(port == ''){
			alert("Don't leave empty the port");
                        return false;
		}
	}
	return true;
}

function isNumberKey(evt){
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57)){
	    alert('Enter numbers only');
            return false;
	 }
         return true;
}

//for email validation
function emailValidator(elem){
	if (document.campaignsettings.username.value.search( /^[a-zA-Z]+([_\.-]?[a-zA-Z0-9]+)@[a-zA-Z0-9]+([\.-]?[a-zA-Z0-9]+)(\.[a-zA-Z]{2,4})+$/ ) == -1)
	{
		setTimeout(function() {document.campaignsettings.username.focus()} ,10);
		alert("Enter username in correct format");
		document.getElementById('username').style.borderColor="red";
		return false;
	}else{
		document.getElementById('username').style.borderColor="#BBBBBB";
		return true ;
	}
}

function smackcampaign(siteurl){
        var data = "&action=createcampaign&siteurl="+siteurl;
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/campaign/campaignone.php',
                type: 'post',
                data: data,
                success: function(response){
                        document.getElementById('emailcampaignlist').innerHTML = '';
                        jQuery("#emailcampaignlist").html(response);
                }
        });
}

function campaigntwo(siteurl){
	var campaignname = document.getElementById('campaignname').value;
	var getcampaignformat = document.getElementById('campaignformat');
	var campaignformat = getcampaignformat.options[getcampaignformat.selectedIndex].text;
	var format = getcampaignformat.options[getcampaignformat.selectedIndex].value;
	var getemailtemplate = document.getElementById('emailtemplate');
	var emailtemplate = getemailtemplate.options[getemailtemplate.selectedIndex].text;
        var data = "&action=createcampaign&campaignname="+campaignname+"&campaignformat="+campaignformat+"&emailtemplate="+emailtemplate;
	if(campaignname == ''){
		alert('Please enter the campaign name.');
		return false;
	}
	else{
       	 jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/campaign/campaigntwo.php',
                type: 'post',
                data: data,
                success: function(response){
                        document.getElementById('emailcampaignlist').innerHTML = '';
			if(format == 'ht' || format == 'h'){
				document.getElementById('smack_editor').style.display='';
			}
			document.getElementById('savecampaign').style.display='';
                        jQuery("#emailcampaignlist").html(response);
                }
         });
	}
}

function campaignstatus(id,action,siteurl){
	data = "&action="+action+"&id="+id;
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/campaign/action.php',
                type: 'post',
                data: data,
                success: function(response){
                        location.reload()
                }
        });
}

function deletecampaign(id,action,siteurl){
	data = "&action="+action+"&id="+id;
        var r=confirm("Are you sure ?");
        if (r==true)
        {
          x="You pressed OK!";
        }
        else
        {
          x="You pressed Cancel!";
        }
        if(x=="You pressed OK!"){
	        jQuery.ajax({
        	        url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/campaign/action.php',
                	type: 'post',
	                data: data,
        	        success: function(response){
                	        location.reload()
       		        }
	        });
	}
}

function toogleaction(action,siteurl){
	var checkedcampaigns = new Array();
	var campaigns = document.getElementById('campaignscount').value;
        var campaignscount = campaigns.split(",");
        var getchooseaction = document.getElementById('chooseaction');
        var chooseaction = getchooseaction.options[getchooseaction.selectedIndex].text;
	if(chooseaction == 'Choose an action'){
		alert('Please choose one action first.');
		return false;
	}
	var count = 0;
	for(var i=0;i<campaignscount.length;i++){
		var campaigncheck = document.getElementById('campaign'+campaignscount[i]);
		if(campaigncheck.checked == true){
			checkedcampaigns[count] = campaignscount[i];
			count++;
		}
	}
	if(checkedcampaigns.length == 0){
                alert('Please choose one or more email campaigns first.');
                return false;
	}
	data = "&takeaction="+chooseaction+"&checkedcampaigns="+checkedcampaigns;
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/campaign/action.php',
                type: 'post',
                data: data,
                success: function(response){
		        for(var i=0;i<campaignscount.length;i++){
				document.getElementById('checkall').checked = false;
                	        document.getElementById('campaign'+campaignscount[i]).checked = false;
                	}
			var deseleteall = document.getElementById('chooseaction');
			deseleteall.options[deseleteall.selectedIndex].text = 'Choose an action' ;
                        location.reload()
                }
        });
}

function checkallcampaign(){
	var campaigns = document.getElementById('campaignscount').value;
	var checkall = document.getElementById('checkall');
	var campaignscount = campaigns.split(",");
	if(checkall.checked == true){
	        for(var i=0;i<campaignscount.length;i++){
        	      	document.getElementById('campaign'+campaignscount[i]).checked = true;
	        }
	}
	else if(checkall.checked == false){
                for(var i=0;i<campaignscount.length;i++){
                        document.getElementById('campaign'+campaignscount[i]).checked = false;
                }
        }
}

function selectcampaign(e){
	var c = new Array();
	var a = 0;
        var campaigns = document.getElementById('campaignscount').value;
	var campaignscount = campaigns.split(",");
	for(var i=0;i<campaignscount.length;i++){
		var campaign = document.getElementById('campaign'+campaignscount[i]);
		if(campaign.checked == true){
			c[a] = i;
			a++;
		}
        }
	if(c.length == campaignscount.length){
		document.getElementById('checkall').checked = true;
	}
	else{
		document.getElementById('checkall').checked = false;
	}
}	

function save_campaign(){
	var emailsubject = document.getElementById('emailsubject').value;//alert(emailsubject);
	if(emailsubject == '' || emailsubject == null){
		alert("Don't leave empty the email subject.");
		return false;
	}
}
	
function sendCampaign(id,action,siteurl){
        data = "&takeaction="+action+"&campaignid="+id;
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/campaign/selectlistb4send.php',
                type: 'post',
                data: data,
                success: function(response){
                        jQuery("#content").html(response);
                }
        });
}

function campaignconfirmed(siteurl){
	var campaignname = document.getElementById('campaignname').value;
	var campaignsubject = document.getElementById('campaignsubject').value;
	var campaignid = document.getElementById('campaignid').value;
	var selectedcampaigns = new Array();
	var tnl = document.getElementById("contactlist");
	var inc = 0;
        for(i=0;i<tnl.length;i++){  
		if(tnl[i].selected == true){  
	                selectedcampaigns[inc]=tnl[i].value;
			inc++;
	        }  
	}
	data = "&campaignname="+campaignname+"&campaignsubject="+campaignsubject+"&selectedcampaigns="+selectedcampaigns+"&campaignid="+campaignid;
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/campaign/sendCampaign.php',
                type: 'post',
                data: data,
                success: function(response){
                        jQuery("#content").html(response);
                }
        });
}

// Edit Campaign
function editcampaign(id,action,siteurl){
	data ="&campaignid="+id+"&action="+action+"&siteurl="+siteurl;
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/campaign/editcampaign.php',
                type: 'post',
                data: data,
                success: function(response){
                        jQuery("#content").html(response);
                }
        });
}

// Update Campaign
function updatecampaign(siteurl){
	var campaignname = document.getElementById('campaignname').value;
	var campaignid = document.getElementById('campaignid').value;
        var getcampaignformat = document.getElementById('campaignformat');
        var campaignformat = getcampaignformat.options[getcampaignformat.selectedIndex].text;
	var format = getcampaignformat.options[getcampaignformat.selectedIndex].value;
        var data = "&action=updatecampaign&campaignname="+campaignname+"&campaignformat="+campaignformat+"&siteurl="+siteurl+"&campaignid="+campaignid;//+"&emailtemplate="+emailtemplate;
        if(campaignname == ''){
                alert('Please enter the campaign name.');
                return false;
        }
        else{
         jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/campaign/updatecampaign.php',
                type: 'post',
                data: data,
                success: function(response){
                        jQuery("#content").html(response);
                }
         });
        }

}

function toogleadvancedsearch(){
	var check = document.getElementById('advancedsearch').style.display;
	if(check == 'none'){
		document.getElementById('advancedsearch').style.display='';
		document.getElementById('enable_advancedsearch').value='enable_advancedsearch';
	}
	else{
                document.getElementById('advancedsearch').style.display='none';
                document.getElementById('enable_advancedsearch').value='';
	}
}

function campaignpagination(siteurl,page){
        var data = "&pageno="+page+"&siteurl="+siteurl;
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/campaign/index.php',
                type: 'post',
                data: data,
                success: function(response){
                        jQuery("#emailcampaignlist").html(response);
                }
        });
}

function listpagination(siteurl,page){
        var data = "&pageno="+page+"&siteurl="+siteurl;
        jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-ultimate-email-marketer/list/index.php',
                type: 'post',
                data: data,
                success: function(response){
                        jQuery("#listindex").html(response);
                }
        });
}

function cancelaction(){
	location.reload()
}
