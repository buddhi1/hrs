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

var Room = function(){
	var self = this;

	this.id = ko.observable();
	this.room_type_id = ko.observable();
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
	this.sdate = ko.observable();
	this.edate = ko.observable();
	this.room_name = ko.observable();
	this.serviceArray = ko.observableArray();

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

	this.editSavedPromotionTimeline = function(){
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
				currPromotion.services(services);
				saveEditedPromotion();
			}
			
		}else{
			alert('Please fill required fields to add a promotion');
		}
	}

	this.editSavedPromotion = function(){
		if(document.getElementById('stays').value !== "" && document.getElementById('rooms').value !== "" && document.getElementById('price').value !== "" && document.getElementById('discount').value !== ""){
		
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
				currPromotion.services(services);
				saveEditedPromotionRec();
			}
			
		}else{
			alert('Please fill required fields to add a promotion');
		}
	}

	this.deleteSavedPromotion = function(){
		
		var url = '/admin/promotion/destroy';
		var variables = ko.toJSON(this);

		var callback = function(res){
			return res;	
		}
		
		sendRequestToServerPost(url,variables,function(res){

			if(res == 1){
				window.location = http_url+"/admin/promotion"
			}else if(res==0){
				alert('There are promotions available for this room type. Please remove promotions to remove the room type.');
			}else{
				alert('Something went wrong. Please try again.')
			}
		});
	}
}

var PromotionArray = function(){
	var self = this;

	this.promotionArray = ko.observableArray();
	this.roomArray = ko.observableArray();

	this.loadSavedPromoTimeline = function(){
		
		var url = '/admin/promotion/edittimeline';
		var variables = ko.toJSON(this);

		var callback = function(res){
			return res;	
		}
		
		sendRequestToServerPost(url,variables,function(res){

			if(res == 1){
				window.location = http_url+"/admin/promotion/edittimeline";
			}
		});
	}

	this.loadSavedPromotion = function(){
		var url = '/admin/promotion/edit';
		var variables = ko.toJSON(this);

		var callback = function(res){
			return res;	
		}
		
		sendRequestToServerPost(url,variables,function(res){

			if(res == 1){
				window.location = http_url+"/admin/promotion/edit"
			}
		});
	}

	this.deleteSavedPromotionTimeline = function(){
		var url = '/admin/promotion/destroytimeline';
		var variables = ko.toJSON(this);

		var callback = function(res){
			return res;	
		}
		
		sendRequestToServerPost(url,variables,function(res){

			if(res == 1){
				window.location = http_url+"/admin/promotion"
			}else if(res==0){
				alert('There are promotions available for this room type. Please remove promotions to remove the room type.');
			}else{
				alert('Something went wrong. Please try again.')
			}
		});
	}

}

// ------------------------- promotion controller functions -------------------------

var loadServices = function(){
	for(i=0; i < services.length; i++){
		var service = new Service();
		service.name(services[i].name); 
		service.state(false);
		if("currPromotion" in window){			
			var savedServices = currPromotion.services();				
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


var loadPromotions = function(){

	for(i=0; i<calendar.length; i++){			
		var promotion = new Promotion();
		promotion.id(calendar[i].id);
		promotion.from(calendar[i].start_date);
		promotion.to(calendar[i].end_date);
		promotion.stays(calendar[i].days)
		promotion.price(calendar[i].price);-
		promotion.discount(calendar[i].discount_rate);
		promotion.room_id(calendar[i].room_type_id);
		promotion.rooms(calendar[i].days);		
		promotion.services.push(JSON.parse(calendar[i].services));

		promotions.promotionArray.push(promotion);		
	}

	for(i=0; i<rooms.length; i++){		
		var room = new Room();
		room.id(rooms[i].id);
		room.room_type_id(rooms[i].room_type_id);			
				
		promotions.roomArray.push(room);
	}
}

var loadPromotion = function(){
	currPromotion.from(promotion.start_date);
	currPromotion.to(promotion.end_date);
	currPromotion.stays(promotion.days);
	currPromotion.price(promotion.price);
	currPromotion.discount(promotion.discount_rate);
	currPromotion.room_id(promotion.room_type_id);
	currPromotion.rooms(promotion.no_of_rooms);
	currPromotion.services(JSON.parse(promotion.services));	
	currPromotion.sdate = promotion.start_date;
	currPromotion.edate = promotion.end_date;
	currPromotion.room_name(room_name.name);
	currPromotion.serviceArray(JSON.parse(promotion.services));
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

var saveEditedPromotion = function(){
	var result=-1;
	var url = '/admin/promotion/updatetimeline';
	var variables = ko.toJSON(currPromotion);

	var callback = function(res){
		return res;	
	}

	sendRequestToServerPost(url,variables,function(res){		
		if(res ==1 ){
			alert('The Promotion updated successfully');
			window.location = http_url+"/admin/promotion";
			return 1;
		}else{			
			alert('Something went wrong');
		}
	});
}

var saveEditedPromotionRec = function(){
	var result=-1;
	var url = '/admin/promotion/update';
	var variables = ko.toJSON(currPromotion);

	var callback = function(res){
		return res;	
	}

	sendRequestToServerPost(url,variables,function(res){		
		if(res ==1 ){
			alert('The Promotion updated successfully');
			window.location = http_url+"/admin/promotion";
			return 1;
		}else{			
			alert('Something went wrong');
		}
	});
}