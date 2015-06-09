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

var Room = function(){
	var self = this;

	this.id = ko.observable();
	this.roomType = ko.observable();
	this.service = ko.observable();
}

var CalendarRec = function(){
	var self = this;

	this.id = ko.observable();
	this.from = ko.observable();
	this.to = ko.observable();
	this.discount = ko.observable();
	this.price = ko.observable();
	this.roomType = ko.observable();
	this.service = ko.observable();
	this.sdate = ko.observable();
	this.edate = ko.observable();

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
			alert('Please fill all text fields to add a calendar record');
		}
		
	}

	this.saveEditedCalendarRecord = function(){
		if(document.getElementById('price').value !== "" && document.getElementById('discount').value !== ""){
			calendarRec.discount(this.discount());
			calendarRec.price(this.price());

			saveEditedCalendarRec();
		}else{
			alert('Please fill all text fields to update a calendar record');
		}
	}

	this.saveEditedCalendarTimeline = function(){
		if(document.getElementById('from').value !== "" && document.getElementById('to').value !== "" && document.getElementById('price').value !== "" && document.getElementById('discount').value !== ""){
			calendarRec.discount(this.discount());
			calendarRec.price(this.price());
			calendarRec.from(this.from());
			calendarRec.to(this.to());

			updateEditedCalendarTimeline();
		}else{
			alert('Please fill all text fields to update calendar timeline');
		}
	}

	this.deleteSavedCalendarRec = function(){
		var url = '/admin/calendar/destroy';
		var variables = ko.toJSON(this);

		var callback = function(res){
			return res;	
		}
		
		sendRequestToServerPost(url,variables,function(res){

			if(res == 1){
				window.location = http_url+"/admin/calendar"
			}else{
				alert('Something went wrong. Please try again.');
			}
		});
	}

}

var Calendar = function(){
	var self = this;

	this.calendarRecArray = ko.observableArray();
	this.roomArray = ko.observableArray();

	this.loadSavedCalendar = function(){
		var url = '/admin/calendar/edit';
		var variables = ko.toJSON(this);

		var callback = function(res){
			return res;	
		}
		
		sendRequestToServerPost(url,variables,function(res){

			if(res == 1){
				window.location = http_url+"/admin/calendar/edit"
			}
		});
	}

	this.loadSavedCalendarTimeline = function(){
		var url = '/admin/calendar/edittimeline';
		var variables = ko.toJSON(this);

		var callback = function(res){
			return res;	
		}
		
		sendRequestToServerPost(url,variables,function(res){

			if(res == 1){
				window.location = http_url+"/admin/calendar/edittimeline"
			}
		});
	}

	this.deleteSavedCalendarTimeline = function(){
		var url = '/admin/calendar/destroytimeline';
		var variables = ko.toJSON(this);

		var callback = function(res){
			return res;	
		}
		
		sendRequestToServerPost(url,variables,function(res){

			if(res == 1){
				window.location = http_url+"/admin/calendar"
			}else{
				alert('Something went wrong. Please try again.');
			}
		});
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

var loadCalendar = function(){
	for(i=0; i<calendar.length; i++){
		var calendarRec = new CalendarRec();
		calendarRec.id(calendar[i].id);
		calendarRec.from(calendar[i].start_date);
		calendarRec.to(calendar[i].end_date);
		calendarRec.discount(calendar[i].discount_rate);
		calendarRec.price(calendar[i].price);
		calendarRec.roomType(calendar[i].room_type_id);
		calendarRec.service(calendar[i].service_id);

		calendarArray.calendarRecArray.push(calendarRec);	
	}

	for(i=0; i<rooms.length; i++){
		var room = new Room();
		room.id(rooms[i].id);
		room.roomType(rooms[i].room_type_id);
		room.service(rooms[i].service_id);

		calendarArray.roomArray.push(room);
	}
}

var loadCalendarRec = function(){
	if(record){
		calendarRec.id(record.id);
		calendarRec.from(record.start_date);
		calendarRec.to(record.end_date);
		calendarRec.discount(record.discount_rate);
		calendarRec.price(record.price);
		calendarRec.roomType(record.room_type_id);
		calendarRec.service(record.service_id);
		
	}
}

var loadCalendarTimeline = function(){

	calendarRec.sdate(s_date);
	calendarRec.edate(e_date);
	calendarRec.roomType(room);
	calendarRec.service(service);
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
			window.location = http_url+"/admin/calendar";
		}
	});
}

var saveEditedCalendarRec = function(){
	var result=-1;
	var url = '/admin/calendar/update';
	var variables = ko.toJSON(calendarRec);

	var callback = function(res){
		return res;	
	}

	sendRequestToServerPost(url,variables,function(res){		
		if(res ==1 ){
			alert('The calendar record was updated successfully');
			window.location = http_url+"/admin/calendar";
			return 1;
		}else{			
			alert('Something went wrong');
		}
	});
}

var updateEditedCalendarTimeline = function(){
	var result=-1;
	var url = '/admin/calendar/updatetimeline';
	var variables = ko.toJSON(calendarRec);

	var callback = function(res){
		return res;	
	}

	sendRequestToServerPost(url,variables,function(res){		
		if(res ==1 ){
			alert('The calendar record was updated successfully');
			window.location = http_url+"/admin/calendar";
			return 1;
		}else{			
			alert('Something went wrong');
		}
	});
}