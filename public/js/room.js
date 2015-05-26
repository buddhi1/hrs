// ------------------------- Data binding for service view -------------------------

var Facility = function(){
	var self = this;

	this.name = ko.observable();
}

var FacilityArray = function(){
	var self = this;

	this.facilityArray = ko.observableArray();
}

var Service = function(){
	var self = this;

	this.name = ko.observable();
}

var ServiceArray = function(){
	var self = this;

	this.serviceArray = ko.observableArray();
}

var Room = function(){
	var self = this;

	this.roomDesc = ko.observableArray();

	this.addRoom = function(){
		alert('inside');
	}
}

var allFacilities = new FacilityArray();
var allServices = new ServiceArray();
var newRoom = new Room();

ko.applyBindings(newRoom, document.getElementById('room-container'));
ko.applyBindings(allServices, document.getElementById('service-container'));
ko.applyBindings(allFacilities, document.getElementById('facility-container'));


// ------------------------- service controller functions -------------------------

window.onload = function(){
	loadFacilities();
	loadServices();
}

var loadFacilities = function(){

	for(i=0; i < facilities.length; i++){
		var facility = new Facility();
		facility.name(facilities[i].name); 		
		allFacilities.facilityArray.push(facility);
	}

}

var loadServices = function(){
	for(i=0; i < services.length; i++){
		var service = new Service();
		service.name(services[i].name); 		
		allServices.serviceArray.push(service);
	}
}