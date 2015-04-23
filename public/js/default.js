function validateLogin()
{
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var datastring = 'username='+username+'&password='+password;
    var url = '/validateLogin';
    
//    if(username == '')
//    {
//    	alert("Username cannot be empty.");
//    	return false;
//    }
//    
//    if(password == '')
//    {
//    	alert("Password cannot be empty.");
//    	return false;
//    }
    
    var atpos = username.indexOf("@");
    var dotpos = username.lastIndexOf(".");
    if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= username.length) 
    {
        alert("Not a valid e-mail address");
        return false;
    }
    
    
    document.forms['loginform'].action='/validateLogin';
    document.forms['loginform'].submit();
}

function adduser()
{
	var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var name = document.getElementById("name").value;
    var index = document.getElementById("role");
    var role = index.options[index.selectedIndex].text;
   
    if(username == '' || password == '' || name == '')
    {
    	alert("One of the fields in empty.");
    	return false;
    }
    
    var atpos = username.indexOf("@");
    var dotpos = username.lastIndexOf(".");
    
    if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= username.length) 
    {
        alert("Not a valid e-mail address");
        return false;
    }
    
    alert("validation successful.");
    
    //add ajax here
    document.forms['adduserform'].action='/addeduser';
    document.forms['adduserform'].submit();
}

function deleteuser()
{
	var username = document.getElementById("username").value;
	
	if(username == '')
    {
    	alert("Username cannot be empty.");
    	return false;
    }
	
	document.forms['deleteuserform'].action='/deleteuser';
    document.forms['deleteuserform'].submit();
}

function editthisuser(count)
{
	var username;
	for (var i = 0; i < count; i++) 
	{
		username = "username" + i;
		
		if (document.getElementById(username).checked) 
		{
			username = document.getElementById(username).value;
	        break;
	    }
	}
	if(username == '')
    {
    	alert("Please select a user.");
    	return false;
    }
	else
	{
		var datastring = 'username='+username;  
      	var url = '/editthisuser';
      	$.ajax({ 
	     type   : "POST", 
	     url    : url, 
	     data   : datastring,   
	     success: function(responseText)
	     { 
	    	 try
	    	 {
	    		 document.forms['edituserform'].action='/editthisuser';
	    		 document.forms['edituserform'].submit();
	    	 }
	    	 catch(e)
	    	 {
	    		 
	    	 }
	     }});
   }	
}

function updateuser()
{
	var userid = document.getElementById("userid").value;
	var username = document.getElementById("name").value;
	var active = 0;
	if(document.getElementById("active").checked)
		active = 1;
	var index = document.getElementById("role");
	var role = index.options[index.selectedIndex].text;
	
	if(username == '')
    {
    	alert("Username cannot be empty.");
    	return false;
    }
	else
	{
		var datastring = 'userid='+userid+'&username='+username+'&active='+active+'&role='+role;  
      	var url = '/updateuser';
      	$.ajax({ 
	     type   : "POST", 
	     url    : url, 
	     data   : datastring,   
	     success: function(responseText)
	     { 
	    	 try
	    	 {
	    		 document.forms['editthisuserform'].action='/updateuser';
	    		 document.forms['editthisuserform'].submit();
	    	 }
	    	 catch(e)
	    	 {
	    		 
	    	 }
	     }});
	}
}

function addedrole()
{
	var rolename = document.getElementById("rolename").value;
	var roledesc = document.getElementById("roledesc").value;
	
	var active = 0;
	if(document.getElementById("optionsRadios1").checked)
		active = 1;
	
	var checkboxes = document.getElementsByClassName("checkbox");
	var checked = "";
	var count = 0;
	
	if(rolename == '' || roledesc == '')
    {
    	alert("One of the fields in empty.");
    	return false;
    }

	else
	{
		for (var i=0; i<checkboxes.length; i++) 
		{
      		var panelid = 'panel' + i;
      		if(document.getElementById(panelid).checked)
      			checked += document.getElementById(panelid).value + ", ";
     	}
     	checked = checked.substring(0, checked.length - 2);

		var datastring = 'rolename='+rolename+'&roledesc='+roledesc+'&active='+active+'&panels='+checked;
		
      	var url = '/addedrole';
      	$.ajax({ 
	     type   : "POST", 
	     url    : url, 
	     data   : datastring,   
	     success: function(responseText)
	     { 
	    	 try
	    	 {
	    		 alert(responseText);
	    	 }
	    	 catch(e)
	    	 {
	    		 
	    	 }
	     }});
	}
}

function addpanel()
{
	var panelname = document.getElementById("panelname").value;
	var paneldesc = document.getElementById("paneldesc").value;
	var paneltype = document.getElementById("paneltype").value;
	var panelparent = document.getElementById("panelparent").value;
	
	if(panelname == '' || paneldesc == '' || paneltype == '' || panelparent == '')
    {
    	alert("One of the fields in empty.");
    	die();
    }
	
	 alert("validation successful.");
	    
	 document.forms['addpanelform'].action='/addedpanel';
	 document.forms['addpanelform'].submit();
}

function checkPassword(){
    var password = document.getElementById('password').value;
    var username = document.getElementById('userName').value;
   
    if (password=='') {
            alert("Please Enter New Password.");
            document.getElementById('password').value = '';
            document.getElementById('password').focus();
            return false;

    }
    if(password == ""){ 
		alert("Error: Password cannot be blank!"); 
		document.getElementById('password').focus(); 
		return false; 
	}
	if(password == "valyoo@123" || password == "Valyoo@123"){ 
		alert("Error: Password cannot be 'valyoo@123'."); 
		document.getElementById('password').focus(); 
		return false; 
	}
	
	 if(username==password){
   	  alert("Error! Username and  Password can't be same.");
         document.getElementById('password').value = '';
         document.getElementById('password').focus();
         return false;
   }
	/*var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/; 
	if(!password.match(regex)) { 
		alert("Error: Password must contain at least six characters!"); 
		document.getElementById('password').focus(); 
		return false; 
	} 
	*/
	if(password.length < 6) { 
		alert("Error: Password must contain at least six characters!"); 
		document.getElementById('password').focus(); 
		return false; 
	} 

	
	re = /[0-9]/; 
	if(!re.test(password)) { 
		alert("Error:Password must contain one lowercase letter,one uppercase letter and one numeric digit. !"); 
		document.getElementById('password').focus();
		return false; 
	} 
	re = /[a-z]/; 
	if(!re.test(password)) { 
		alert("Error:Password must contain one lowercase letter,one uppercase letter and one numeric digit. !"); 
 
		document.getElementById('password').focus(); 
		return false; 
	} 
	re = /[A-Z]/; 
	if(!re.test(password)) { 
		alert("Error:Password must contain one lowercase letter,one uppercase letter and one numeric digit. !"); 
		document.getElementById('password').focus();
		return false; 
	}
	document.forms['updateNewPassword'].action='/updateNewPassword';
	document.forms['updateNewPassword'].submit();
}
function checkForgotPasswordEmailId(){
var email = document.getElementById('username').value;
    var checkEmail = validateEmail(email);
    if (!checkEmail) {
            alert("Please Enter a valid Email Id.");
	document.getElementById('username').value = '';
            document.getElementById('username').focus();
            return false;

    }
document.forms['forgotPassword'].action='/updatePassword';
document.forms['forgotPassword'].submit();
}

function checkDepartment()
{
var userId = document.getElementById('username').value;
var passwd = document.getElementById('password').value;
document.getElementById("showMsg").innerHTML="";
var dept=0;
var visible= $('#dept').is(':hidden');
if(!visible){;
	if(document.getElementById("selDept").value!=""){
		if(document.getElementById("selDept").value=='Other' && document.getElementById("selOther").value==""){
			document.getElementById("showMsg").innerHTML="Please Enter Department";
			return false;
		}
		dept =1;
	}else{
		document.getElementById("showMsg").innerHTML="Please Select Department";
		return false;
	}
}
if(dept==1){
	document.getElementById("adduser").submit();
}
else if(userId!="" && passwd!=""){
	var datastring = 'userId='+userId+'&passwd='+passwd;  
      	var url = '/checkDepartment';
      	$.ajax({ 
	     type   : "POST", 
	     url    : url, 
	     data   : datastring,   
	     success: function(responseText) { 
		try{
			var obj = JSON.parse(responseText);
			if(obj.result==1)
	        	{
				document.getElementById("adduser").submit();
	        	}
	        	else if(obj.result==0)
	        	{
				var obj2 = JSON.parse(obj.dept); 
				document.getElementById('login').style.padding="105px";
				document.getElementById('dept').style.display="block";
				for(i=0; i<obj2.length; i++){
					if(!(document.getElementById("selDept").options[i+1])){
						var option = document.createElement("option");
						option.text = obj2[i].reason;
						option.value = obj2[i].reason;
						var select = document.getElementById("selDept");
						select.appendChild(option);
					}
			
				}
				
	        	}else{
				document.getElementById("showMsg").innerHTML = "Authentication Failure";
			}
		}catch(e){
		} 
	        
	    } 
       	}); 
}else{
	document.getElementById("showMsg").innerHTML = "Please Enter User Id OR Password";
}
}

function openDepartment()
{
	document.getElementById("showMsg").innerHTML="";
	if(document.getElementById("selDept").value=='Other')
	{
		document.getElementById('selOther').style.display="block";
	}
	else
	{
	document.getElementById('selOther').style.display="none";
	}
}

	function addpanel()
	{
	var panelname = document.getElementById("panelname").value;
    var panelurl = document.getElementById("panelurl").value;
    var paneldesc = document.getElementById("paneldesc").value;
    
    var index = document.getElementById("type");
    var type = index.options[index.selectedIndex].value;
    
    var index = document.getElementById("parent");
    var parent = index.options[index.selectedIndex].value;
   
    if(panelname == '' || panelurl == '')
    {
    	alert("One of the fields in empty.");
    	return false;
    }
    else
	{
		var datastring = 'panelname=' + panelname + '&panelurl=/' + panelurl + '&paneldesc=' + paneldesc + '&type=' + type + '&parent=' + parent;
      	var url = '/addedpanel';
      	$.ajax({ 
	     type   : "POST", 
	     url    : url, 
	     data   : datastring,   
	     success: function(responseText)
	     { 
	    	 try
	    	 {
	    		 alert(responseText);
	    	 }
	    	 catch(e)
	    	 {
	    		 
	    	 }
	     }});
      }
   }

   function deletepanel()
   {
   		var index = document.getElementById("panelid");
    	var panel = index.options[index.selectedIndex].value;
    	var datastring = 'panel=' + panel;
    	var url = '/deletedpanel';
    	$.ajax({ 
	     type   : "POST", 
	     url    : url, 
	     data   : datastring,   
	     success: function(responseText)
	     { 
	    	 try
	    	 {
	    	 	alert(responseText);
	       	 }
	    	 catch(e)
	    	 {
	    		 
	    	 }
	     }});
   }

   function editpanel()
   {
   		var index = document.getElementById("panelid");
    	var panel = index.options[index.selectedIndex].value;
    	var datastring = 'panel=' + panel;
    	var url = '/editthispanel';
    	$.ajax({ 
	     type   : "POST", 
	     url    : url, 
	     data   : datastring,   
	     success: function(responseText)
	     { 
	    	 try
	    	 {
	    	 	document.forms['editpanelform'].action='/editthispanel';
	    	 	document.forms['editpanelform'].submit();
	       	 }
	    	 catch(e)
	    	 {
	    		 
	    	 }
	     }});
   }
   
function updatepanel()
{
   	var panelid = document.getElementById("panelid").value;
   	var panelname = document.getElementById("panelname").value;
   	var panelurl = document.getElementById("panelurl").value;
   	var paneldesc = document.getElementById("paneldesc").value;
   	
   	var index = document.getElementById("type");
   	var type = index.options[index.selectedIndex].value;
   	
   	var index = document.getElementById("parent");
   	var parent = index.options[index.selectedIndex].value;
   	
   	if(panelname == '')
    {
       	alert("Panel name cannot be empty.");
       	return false;
    }
   	else
   	{
   		var datastring = 'panelid='+panelid+'&panelname='+panelname+'&panelurl='+panelurl+'&paneldesc='+paneldesc+'&type='+type+'&parent='+parent; 
         	var url = '/updatepanel';
         	$.ajax({ 
   	     type   : "POST", 
   	     url    : url, 
   	     data   : datastring,   
   	     success: function(responseText)
   	     { 
   	    	 try
   	    	 {
   	    		 alert(responseText);
   	    	 }
   	    	 catch(e)
   	    	 {
   	    		 
   	    	 }
   	     }});
   	}
}

function editrole()
{
	var flag = document.getElementById("flag").value;
	var index = document.getElementById("role");
    var rolename = index.options[index.selectedIndex].text;

	if(rolename == '')
    {
    	alert("Please select a role.");
    	return false;
    }

    document.getElementById("flag").value = 1;
    document.forms['editroleform'].action='/editthisrole';
	document.forms['editroleform'].submit();
}

function updaterole()
{
	var roleid = document.getElementById("roleid").value;
	var rolename = document.getElementById("rolename").value;
	var roledesc = document.getElementById("roledesc").value;
	
	var active = 0;
	if(document.getElementById("optionsRadios1").checked)
		active = 1;
	
	var checkboxes = document.getElementsByClassName("checkbox");
	var checked = "";
	var count = 0;
	
	if(rolename == '' || roledesc == '')
    {
    	alert("One of the fields in empty.");
    	return false;
    }

	else
	{
		for (var i=0; i<checkboxes.length; i++) 
		{
			
      		var panelid = 'panel' + i;
      		if(document.getElementById(panelid).checked)
      		{
      			checked += document.getElementById(panelid).value + ", ";
      		}
     	}
     	checked = checked.substring(0, checked.length - 2);
     	var datastring = 'rolename='+rolename+'&roledesc='+roledesc+'&active='+active+'&panels='+checked;
      	var url = '/updaterole';
      	$.ajax({ 
	     type   : "POST", 
	     url    : url, 
	     data   : datastring,   
	     success: function(responseText)
	     {

	    	 if(responseText == '1')
	    	 {
	    	 	alert("Role update success");
	    	 	location.href="/editrole";
	    	 }
	    	 else if(responseText == '0')
	    	 {
	    	 	alert("Role update failed. Please try again.");
	    	 }
	     }});
	}
}

   function deleterole()
   {
   		var index = document.getElementById("roleid");
    	var role = index.options[index.selectedIndex].value;
    	var datastring = 'role=' + role;
    	var url = '/deletedrole';
    	$.ajax({ 
	     type   : "POST", 
	     url    : url, 
	     data   : datastring,   
	     success: function(responseText)
	     { 
	    	 try
	    	 {
	    	 	
	       	 }
	    	 catch(e)
	    	 {
	    		 
	    	 }
	     }});
   }

   function updateimages()
   {
      	
      	var tag;
   		
   		tag = document.getElementById('tag').value;
   	    
   		if(tag == '')
       	{
       		alert("Please select a role.");
       		return false;
       	}
       	alert(tag);
        document.forms['gettagform'].action='/updateimagesfromtag';
   		document.forms['gettagform'].submit();
   }

   function search()
   {
   		var date = document.getElementById('date').value;
   		var tag = document.getElementById('tag').value;
   		var index = document.getElementById("source");
    	var source = index.options[index.selectedIndex].value;

		document.forms['searchform'].action='/getimages/1';
   		document.forms['searchform'].submit();
   }

   function getinfo(url, page)
   {
   		if(url == 'getimages')
   		{
   			var date = document.getElementById('date').value;
   			var tag = document.getElementById('tag').value;
   			var source = document.getElementById('source').value;
   		}

   		var redirect = "/" + url + "/" + page;
   		
   		document.forms['infoform'].action=redirect;
   		document.forms['infoform'].submit(); 		
   }