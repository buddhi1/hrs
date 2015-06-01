// ------------------------- Data binding for promotion CRUD -------------------------

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

var RoomType = function(){
	var self = this;

	this.id = ko.observable();
	this.name = ko.observable();	
}

var RoomTypeArray = function(){
	var self = this;

	this.roomTypeArray = ko.observableArray();
	this.selected = ko.observable();
}

var Promotion = function(){
	var self = this;

	this.id = ko.observable();
	this.room_id = ko.observable();
	this.services = ko.observableArray();
	this.from = ko.observable();
	this.to = ko.observable();
	this.stays = ko.observable();
	this.rooms = ko.observable();
	this.price = ko.observable();
	this.discount = ko.observable();

	this.addPromotion = function(){
	
		if(document.getElementById('from').value !== "" && document.getElementById('to').value !== "" && document.getElementById('stays').value !== "" && document.getElementById('rooms').value !== "" && document.getElementById('price').value !== "" && document.getElementById('discount').value !== ""){
			currPromotion.from(this.from());
			currPromotion.to(this.to());
			currPromotion.stays(this.stays());
			currPromotion.rooms(this.rooms());
			currPromotion.price(this.price());
			currPromotion.discount(this.discount());

			var services = [];
			for(i=0; i<allServices.serviceArray().length; i++){
				if(allServices.serviceArray()[i].state()){
					services.push(allServices.serviceArray()[i].name());
				}
			}
			if(services.length <= 0 || services === undefined){
				alert('You must select atleast a single service to add a promotion');				
			}else{
				currPromotion.room_id(allRoomTypes.selected()[0].id());
				currPromotion.services(services);
				savePromotion();
			}
			
		}else{
			alert('Please fill required fields to add a promotion');
		}
		
	}
}

var PromotionArray = function(){
	var self = this;

	this.promotionArray = ko.observableArray();
}

// ------------------------- promotion controller functions -------------------------

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

var loadRoomTypes = function(){
	for(i=0; i < roomTypes.length; i++){
		var roomType = new RoomType();
		roomType.id(roomTypes[i].id);
		roomType.name(roomTypes[i].name);
		allRoomTypes.roomTypeArray.push(roomType);
	}
}


var savePromotion = function(){
	var result=-1;
	var url = '/admin/promotion/create';
	var variables = ko.toJSON(currPromotion);

	var callback = function(res){
		return res;	
	}

	sendRequestToServerPost(url,variables,function(res){		
		if(res ==1 ){
			alert('The Promotion added successfully');
			window.location = http_url+"/admin/promotion";
			return 1;
		}else if( res ==2 ){
			alert('The Promotion already exists');
		}else{			
			alert('Something went wrong');
		}
	});
	
}