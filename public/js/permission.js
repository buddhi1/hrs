/*************** Permission Functions ***************/

var Permission = function() {
	// Permission class is used to bind variables with display fields

	var self = this;

	self.id = ko.observable();
	self.chkName = ko.observable();
	self.name = ko.observable();
	self.state = ko.observable(false);
	self.toggleState = function(){
		self.state(!self.state());
		return true;
	};
	self.deletePer = function() {
		deletePermission(self.id);
	};
	self.editPer = function() {
		editPermission(self.id);
	};
}

var PermissionDisplay = function() {
	// display the array of permissions

	var self = this;
	self.groupID = ko.observable();
	self.perName = ko.observable();
	self.permission = ko.observableArray();
}

var cleanPermissionJson = function(que) {
	//this function remove unwanted properties and unwanted objects from allPermissions object
	
	var copy = ko.toJS(que);

	for(var i=0; i<copy.permission.length; i++) {
		if(copy.permission[i].state !== true) {
			//delete the objects with false state
			delete copy.permission[i];

		} else {
			//remoe the id, chkName & state from objects with true state
			delete copy.permission[i].id;
			delete copy.permission[i].chkName;
			delete copy.permission[i].state;
		}

	}
	//will remove all the undefined values from the array
	copy.permission = copy.permission.filter(function(n){ return n != undefined }); 
	return copy;
}

var savePermission = function() {
	//save the permission in permissions table

	var clean = cleanPermissionJson(allPermissions);
	var sendData = ko.toJSON(clean);
	console.log(sendData);
	sendPermissionsToServerPost('/admin/permission/create', sendData, function(res){
		if(res === 'success') {
			window.location = http_url+"/admin/permission/index";
		} else if(res === 'failure') {
			window.location = http_url+"/admin/permission/index";
		}
	});
}

function sendPermissionsToServerPost(url,variables,callback){
	//this function is added because of a limitation of the sendRequestToServerPost function sending arrays to the controller

    var header =  "variables="+variables;
         
    var xmlHttp = new XMLHttpRequest(); 
    xmlHttp.onreadystatechange = function(){
        if (xmlHttp.readyState==4 && xmlHttp.status==200){
            callback(xmlHttp.responseText);
        }
    };
    xmlHttp.open( "POST", http_url+url, true );
    xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlHttp.send(header);
}

function editPermission(uid) {
	// this function send the permission id of the permission to be edited, to the controller

	var editID = uid;
	var sendData = ko.toJSON({"id": editID});
	sendRequestToServerPost('/admin/permission/edit', sendData, function(res){
		if(res === 'success') {

			window.location = http_url+"/admin/permission/edit";
		}
	});
}

function deletePermission(uid) {
	// this function send the permission id of the permission to be deleted, to the controller

	var deleteID = uid;
	var sendData = ko.toJSON({"id": deleteID});
	sendRequestToServerPost('/admin/permission/destroy', sendData, function(res){
		if(res === 'success') {

			window.location = http_url+"/admin/permission/index";
		}
	});
}