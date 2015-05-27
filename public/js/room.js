// ------------------------- Data binding for service view -------------------------

var Facility = function(){
	var self = this;

	this.name = ko.observable();
	this.state = ko.observable();

	this.toggleCheckbox = function(){	
		this.state(!(this.state()));
        return true;
	}
}

var FacilityArray = function(){
	var self = this;

	this.facilityArray = ko.observableArray();
}

var Service = function(){
	var self = this;

	this.name = ko.observable();
	this.state = ko.observable();

	this.toggleCheckbox = function(){
		this.state(!(this.state()));
        return true;
	}
}

var ServiceArray = function(){
	var self = this;

	this.serviceArray = ko.observableArray();
}

var Room = function(){
	var self = this;

	this.name = ko.observable();
	this.no_of_rooms = ko.observable();
	this.facilities = ko.observableArray();
	this.services = ko.observableArray();

	this.addRoom = function(){
		
		if(this.name() != "" || this.no_of_rooms() != ""){
			newRoom.name(this.name());
			newRoom.no_of_rooms(this.no_of_rooms());
			var facilities = [];
			
			for(i=0; i<allFacilities.facilityArray().length; i++){			
				if(allFacilities.facilityArray()[i].state()){
					facilities.push(allFacilities.facilityArray()[i].name());
				}				
			}	
			newRoom.facilities(facilities);	
			var services = [];
			for(i=0; i<allServices.serviceArray().length; i++){
				if(allServices.serviceArray()[i].state()){
					services.push(allServices.serviceArray()[i].name());
				}
			}
			newRoom.services(services);
			saveRoom();
		}else{

		}
		
	}
}

var RoomArray = function(){
	var self = this;

	this.roomArray = ko.observableArray();
}

var allFacilities = new FacilityArray();
var allServices = new ServiceArray();
var newRoom = new Room();

ko.applyBindings(newRoom, document.getElementById('room-container'));
ko.applyBindings(allServices, document.getElementById('service-container'));
ko.applyBindings(allFacilities, document.getElementById('facility-container'));


// ------------------------- service controller functions -------------------------

var loadFacilities = function(){

	for(i=0; i < facilities.length; i++){
		var facility = new Facility();
		facility.name(facilities[i].name); 
		facility.state(false);		
		allFacilities.facilityArray.push(facility);
	}

}

var loadServices = function(){
	for(i=0; i < services.length; i++){
		var service = new Service();
		service.name(services[i].name); 
		service.state(false);		
		allServices.serviceArray.push(service);
	}
}

var loadRooms = function(){

}

var saveRoom = function(){
	var result=-1;
	var url = '/admin/room/create';
	var variables = ko.toJSON(newRoom);

	var callback = function(res){
		return res;	
	}

	sendRequestToServerPost(url,variables,function(res){		
		if(res ==1 ){
			alert('The Room added successfully');
			window.location = http_url+"/admin/room";
			return 1;
		}else{
			newServices.services.pop();
			alert('Something went wrong');
		}
	});
	
}