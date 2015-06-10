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
	this.selected = ko.observableArray();
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
	this.room_name = ko.observable();

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

	this.saveEditedPromo = function(){
		if(document.getElementById('from').value !== "" && document.getElementById('to').value !== "" && document.getElementById('price').value !== "" && document.getElementById('stays').value !== ""&& document.getElementById('rooms').value !== ""){
			currPromo.from(this.from());
			currPromo.to(this.to());
			currPromo.price(this.price());
			currPromo.stays(this.stays());
			currPromo.rooms(this.rooms());

			var services = [];
			for(i=0; i<allServices.serviceArray().length; i++){
				if(allServices.serviceArray()[i].state()){
					services.push(allServices.serviceArray()[i].name());
				}
			}
			currPromo.services(services);

			saveEdPromo();
		}else{
			alert('Please fill the required fields');
		}
	}
}

var PromoArray = function(){
	var self = this;

	this.promoArray = ko.observableArray();

	this.loadEditSavedPromo = function(){
		var url = '/admin/promo/edit';
		var variables = ko.toJSON(this);

		var callback = function(res){
			return res;	
		}
		
		sendRequestToServerPost(url,variables,function(res){

			if(res == 1){
				window.location = http_url+"/admin/promo/edit"
			}
		});
	}

	this.deleteSavedPromo = function(){
		var url = '/admin/promo/destroy';
		var variables = ko.toJSON(this);

		var callback = function(res){
			return res;	
		}
		
		sendRequestToServerPost(url,variables,function(res){

			if(res == 1){
				window.location = http_url+"/admin/promo";
			}else{
				alert('Something went wrong. Please try again.');
			}
		});
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

var loadPromos = function(){
	for(i=0; i<promos.length; i++){
		var promo = new Promo();
		promo.id(promos[i].id);
		promo.from(promos[i].start_date);
		promo.to(promos[i].end_date);
		promo.price(promos[i].price);
		promo.stays(promos[i].days);
		promo.rooms(promos[i].no_of_rooms);
		promo.code(promos[i].promo_code);
		promo.room(promos[i].room_type_id);

		for(j=0; j<roomTypes.length; j++){
			if(roomTypes[j].id == promos[i].room_type_id){
				promo.room_name(roomTypes[j].name);
				break;
			}
		}
		promo.services(JSON.parse(promos[i].services));

		allPromo.promoArray.push(promo);
	}
}

var loadPromo = function(){
	currPromo.id(promo.id);
	currPromo.from(promo.start_date);
	currPromo.to(promo.end_date);
	currPromo.price(promo.price);
	currPromo.stays(promo.days);
	currPromo.rooms(promo.no_of_rooms);
	currPromo.code(promo.promo_code);

	
	roomType.id(promo.room_type_id);
	console.log(roomTypes);
	for(k=0; k<roomTypes.length; k++){
		if (roomTypes[k].id == promo.room_type_id) {
			roomType.name(roomTypes[k].name);
			break;
		}
	}
	var currServices = JSON.parse(promo.services);
	
	for(i=0; i<allServices.serviceArray().length; i++){
		for(j=0; j<currServices.length; j++){
			
			if(allServices.serviceArray()[i].name() == currServices[j]){				
				allServices.serviceArray()[i].state(true);
			}
		}
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

var saveEdPromo = function(){
	var result=-1;
	var url = '/admin/promo/update';
	var variables = ko.toJSON(currPromo);

	var callback = function(res){
		return res;	
	}

	sendRequestToServerPost(url,variables,function(res){		
		if(res ==1 ){
			alert('The Promo updated successfully');
			window.location = http_url+"/admin/promo";
			return 1;
		}else{
			alert('Something went wrong');
		}
	});
}
