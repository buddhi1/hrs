/*************** Facility Functions ***************/

var Facility = function() {
	// Facility class is used to bind variables with display fields

	var self = this;

	self.id = ko.observable();
	self.name = ko.observable();
	self.deleteFacility = function() {
		deleteFac(self.id);
	};
}

var FacilityDisplay = function() {
	// display the array of facilities

	var self = this;

	self.facility = ko.observableArray();
}

function deleteFac(id) {
	// this function send the facility id of the facility to be deleted, to the controller

	var deleteID = id;
	var sendData = ko.toJSON({"id": deleteID});
	sendRequestToServerPost('/admin/facility/destroy', sendData, function(res){
		if(res === 'success') {

			window.location = http_url+"/admin/facility/index";
		}
	});
}

var cleanFacilityJson = function(que) {
	//this function remove facility id from the facData object
	
	var copy = ko.toJS(que);

	delete copy.id;
	return copy;
}

function saveCreateFacility() {
	//save the facility in the facility table

	var clean = cleanFacilityJson(facCreate);
	var sendData = ko.toJSON(clean);
	sendRequestToServerPost('/admin/facility/create', sendData, function(res){
		if(res === 'success') {
			window.location = http_url+"/admin/facility/index";
		} else {
			window.location = http_url+"/admin/facility/index";
		}
	});
}