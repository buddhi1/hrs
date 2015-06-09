// ------------------------- Data binding for calendar CRUD -------------------------
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

	this.id = ko.observable();
	this.name = ko.observable();
}

var RoomArray = function(){
	var self = this;

	this.roomArray = ko.observableArray();
	this.selected = ko.observable();
}

var Promo = function(){
	var self = this;

	this.id = ko.observable();
	this.from = ko.observable();
	this.to = ko.observable();
	this.price = ko.observable();
	this.stays = ko.observable();
	this.rooms = ko.observable();
	this.code = ko.observable();
	this.services = ko.observableArray();
	this.room = ko.observable();

	this.addPromo = function(){
		if(document.getElementById('from').value !== "" && document.getElementById('to').value !== "" && document.getElementById('price').value !== "" && document.getElementById('stays').value !== ""&& document.getElementById('rooms').value !== ""){
			currPromo.from(this.from());
			currPromo.to(this.to());
			currPromo.price(this.price());
			currPromo.stays(this.stays());
			currPromo.rooms(this.rooms());
			currPromo.code(this.code());

			var services = [];
			for(i=0; i<allServices.serviceArray().length; i++){
				if(allServices.serviceArray()[i].state()){
					services.push(allServices.serviceArray()[i].name());
				}
			}
			currPromo.services(services);

			currPromo.room(allRoomTypes.selected()[0].id());

			savePromo();
		}else{
			alert('Please fill the required fields');
		}
	}
}


// ------------------------- promotion controller functions -------------------------

var loadRooms = function(){
	for(i=0; i < roomTypes.length; i++){
		var room = new Room();
		room.id(roomTypes[i].id);
		room.name(roomTypes[i].name);
		allRoomTypes.roomArray.push(room);
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

var savePromo = function(){
	var result=-1;
	var url = '/admin/promo/create';
	var variables = ko.toJSON(currPromo);

	var callback = function(res){
		return res;	
	}

	sendRequestToServerPost(url,variables,function(res){		
		if(res ==1 ){
			alert('The Promo added successfully');
			window.location = http_url+"/admin/promo";
			return 1;
		}else{
			alert('Something went wrong');
		}
	});
}

