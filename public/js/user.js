/*************** User Index Functions ***************/

var UserDetails = function() {
	// User class is used to bind variables with display fields

	var self = this;

	self.uid = ko.observable();
	self.uname = ko.observable();
	self.permission_id = ko.observable();
	self.permission_name = ko.observable();

	self.editUser = function() {
		editUser(self.uid);
	}
	self.deleteUser = function() {
		deleteUser(self.uid);
	}
}

var UserDisplay = function() {
	// display the array of users

	var self = this;

	self.user = ko.observableArray();
}

function editUser(uid) {
	// this function send the user id of the user to be edited, to the controller

	var editID = uid;
	var sendData = ko.toJSON({"id": editID});
	sendRequestToServerPost('/admin/user/edit', sendData, function(res){
		if(res === 'success') {

			window.location = http_url+"/admin/user/edit";
		}
	});
}

function deleteUser(uid) {
	// this function send the user id of the user to be deleted, to the controller

	var deleteID = uid;
	var sendData = ko.toJSON({"id": deleteID});
	sendRequestToServerPost('/admin/user/destroy', sendData, function(res){
		if(res === 'success') {

			window.location = http_url+"/admin/user/index";
		}
	});
}


/*************** User Edit Functions ***************/

var UserEdit = function() {
	// UserEdit class is used to bind variables with input fields

	var self = this;

	self.uname = ko.observable('');
	self.password = ko.observable('');
	self.permissions = ko.observableArray();
	self.chosenPermission = ko.observableArray();
	self.userID = ko.observable();
}

var cleanJsonEdit = function(que) {
	//this function remove all the permissions from the userDataEdit object
	
	var copy = ko.toJS(que);

	delete copy.permissions;
	copy.chosenPermission = copy.chosenPermission[copy.chosenPermission.length-1];
	return copy;
}

function saveEditUser() {
	//save the user in the user table

	var clean = cleanJsonEdit(userDataEdit);
	var sendData = ko.toJSON(clean);

	sendRequestToServerPost('/admin/user/update', sendData, function(res){
		if(res === 'success') {
			window.location = http_url+"/admin/user/index";
		}
	});
}

/*************** User Create Functions ***************/

var UserCreate = function() {
	// UserCreate class is used to bind variables with input fields

	var self = this;

	self.uname = ko.observable();
	self.password = ko.observable();
	self.permissions = ko.observableArray();
	self.chosenPermission = ko.observable();
}

var cleanCreateJson = function(que) {
	//this function remove all the permissions from the userDataCreate object
	
	var copy = ko.toJS(que);

	delete copy.permissions;
	return copy;
}

function saveCreateUser() {
	//save the user in the user table

	var clean = cleanCreateJson(userDataCreate);
	var sendData = ko.toJSON(clean);
	sendRequestToServerPost('/admin/user/create', sendData, function(res){
		if(res === 'success') {
			window.location = http_url+"/admin/user/create";
		}
	});
}