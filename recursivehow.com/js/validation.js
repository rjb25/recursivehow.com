function addUserValidation(){
	var x = document.forms["login"]["username"].value;
	var y = document.forms["login"]["password"].value;
	var z = document.forms["login"]["confirmation"].value;
	if (x == null || x == ""|| y == null || y == ""){
		alert("Must fill all both fields");
		return false;
	}else if(x.length>20 || x.length<4 || y.length>20 || y.length<4){
		alert("Fields must contain at least 4 characters but no more than 20");
		return false;
	}else if (y!=z || z ==""){
		alert("Passwords must match");
		return false;
	} 
}

function loginValidation(){
	var x = document.forms["login"]["username"].value;
	var y = document.forms["login"]["password"].value;
	if (x == null || x == ""|| y == null || y == ""){
		alert("Must fill out both fields");
		return false;
	}else if(x.length>20 || x.length<4 || y.length>20 || y.length<4){
		alert("Fields must contain at least 4 characters but no more than 20");
		return false;
	}
}


