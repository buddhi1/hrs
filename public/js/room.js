// ------------------------- Data binding for room CRUD -------------------------

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
	this.id = ko.observable();
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

			if("room" in window){
				saveEditedRoom();
			}else{
				saveRoom();
			}
			
		}else{
			alert('Please fill the required fields');
		}
		
	}
}

var RoomArray = function(){
	var self = this;

	this.roomArray = ko.observableArray();

	this.loadEditSavedRoom = function(){
		
		var url = '/admin/room/edit';
		var variables = ko.toJSON(this);

		var callback = function(res){
			return res;	
		}
		
		sendRequestToServerPost(url,variables,function(res){

			if(res == 1){
				window.location = http_url+"/admin/room/edit"
			}
		});
	}

	this.deleteSavedRoom = function(){
		var url = '/admin/room/destroy';
		var variables = ko.toJSON(this);

		var callback = function(res){
			return res;	
		}
		
		sendRequestToServerPost(url,variables,function(res){

			if(res == 1){
				window.location = http_url+"/admin/room"
			}else if(res==0){
				alert('There are promotions available for this room type. Please remove promotions to remove the room type.');
			}else{
				alert('Something went wrong. Please try again.')
			}
		});
	}
}


// ------------------------- room controller functions -------------------------

var loadFacilities = function(){

	for(i=0; i < facilities.length; i++){
		var facility = new Facility();
		facility.name(facilities[i].name); 
		facility.state(false);
		if("room" in window){
			var savedFacilities = JSON.parse(room.facilities);		
			for(j=0; j<savedFacilities.length; j++){				
				if(facility.name() == savedFacilities[j]){
					facility.state(true);
				}
			}			
		}	
		allFacilities.facilityArray.push(facility);
	}

}

var loadServices = function(){
	for(i=0; i < services.length; i++){
		var service = new Service();
		service.name(services[i].name); 
		service.state(false);
		if("room" in window){
			var savedServices = JSON.parse(room.services);		
			for(j=0; j<savedServices.length; j++){
				if(service.name() == savedServices[j]){
					service.state(true);
				}
			}	
		}		
		allServices.serviceArray.push(service);
	}
}

var loadRooms = function(){
	for(i=0; i<rooms.length; i++){
			var roomFacilities = new FacilityArray();
			var savedFacilities = JSON.parse(rooms[i].facilities);
			
			for(j=0; j<savedFacilities.length; j++){
				roomFacilities.facilityArray.push(savedFacilities[j]);
			}

			var roomServices = new ServiceArray();
			var savedServices = JSON.parse(rooms[i].services);
			
			for(k=0; k<savedServices.length; k++){
				roomServices.serviceArray.push(savedServices[k]);
			}
			
			var saveRoom = new Room();
			saveRoom.name(rooms[i].name);
			saveRoom.no_of_rooms(rooms[i].no_of_rooms);
			saveRoom.id(rooms[i].id);
			saveRoom.facilities(roomFacilities.facilityArray());
			saveRoom.services(roomServices.serviceArray());
			savedRooms.roomArray.push(saveRoom);
	}
}

var loadRoom = function(){	
	newRoom.name(room.name);
	newRoom.no_of_rooms(room.no_of_rooms);
	newRoom.id(room.id);
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
			alert('Something went wrong');
		}
	});
	
}

var saveEditedRoom = function(){
	var result=-1;
	var url = '/admin/room/update';
	var variables = ko.toJSON(newRoom);

	var callback = function(res){
		return res;	
	}

	sendRequestToServerPost(url,variables,function(res){		
		if(res ==1 ){
			alert('The Room edited successfully');
			window.location = http_url+"/admin/room";
			return 1;
		}else{			
			alert('Something went wrong');
		}
	});
	
}