// ------------------------- Data binding for calendar CRUD -------------------------

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

var Service = function(){
	var self = this;

	this.id = ko.observable();
	this.name = ko.observable();
}

var ServiceArray = function(){
	var self = this;

	this. serviceArray = ko.observableArray();
	this.selected = ko.observable();
}

var CalendarRec = function(){
	var self = this;

	this.from = ko.observable();
	this.to = ko.observable();
	this.discount = ko.observable();
	this.price = ko.observable();
	this.roomType = ko.observable();
	this.service = ko.observable();

	this.addCalendareRec = function(){

		if(document.getElementById('from').value !== "" && document.getElementById('to').value !== "" && document.getElementById('price').value !== "" && document.getElementById('discount').value !== ""){
			calendarRec.from(this.from());
			calendarRec.to(this.to());
			calendarRec.discount(this.discount());
			calendarRec.price(this.price());

			calendarRec.roomType(allRoomTypes.selected()[0].id());
			calendarRec.service(allServices.selected()[0].id());

			saveCalendarRec();
		}else{
			alert('Please fill all text fields to add a calendar record')
		}
		
	}
}

// ------------------------- promotion controller functions -------------------------

var loadRoomTypes = function(){
	for(i=0; i < roomTypes.length; i++){
		var roomType = new RoomType();
		roomType.id(roomTypes[i].id);
		roomType.name(roomTypes[i].name);
		allRoomTypes.roomTypeArray.push(roomType);
	}
}

var loadServices = function(){	
	for(i=0; i < services.length; i++){
		var service = new Service();
		service.id(services[i].id);
		service.name(services[i].name);
		allServices.serviceArray.push(service);
	}
}

var saveCalendarRec = function(){
	var result=-1;
	var url = '/admin/calendar/create';
	var variables = ko.toJSON(calendarRec);

	var callback = function(res){
		return res;	
	}

	sendRequestToServerPost(url,variables,function(res){		
		if(res ==1 ){
			alert('The calendar record was added successfully');
			window.location = http_url+"/admin/calendar";
			return 1;
		}else if( res ==2 ){
			alert('Calendar records overlapping for given date range. Please refer to edit time line');
		}else{			
			alert('Something went wrong');
		}
	});
}
