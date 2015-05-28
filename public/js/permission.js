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
}

var PermissionDisplay = function() {
	// display the array of permissions

	var self = this;
	self.perName = ko.observable();
	self.permission = ko.observableArray();
}

var cleanPermissionJson = function(que) {
	//this function remove facility id from the facData object
	
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

	var clean = cleanPermissionJson(allPermissions);
	var sendData = ko.toJSON(clean);
	console.log(sendData);
	sendRequestToServerPost('/admin/permission/create', sendData, function(res){
		if(res === 'success') {
			window.location = http_url+"/admin/permission/index";
		}
	});
}