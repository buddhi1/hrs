/*************** Booking Functions ***************/

var RoomTypes = function() {
  // Room types class which contains id and name

  var self = this;

  self.id = ko.observable();
  self.name = ko.observable();
}

var Services = function() {
  // Room types class which contains id and name

  var self = this;

  self.id = ko.observable();
  self.name = ko.observable();
}

var Booking = function() {
  // booking class

  var self = this;

  self.id = ko.observable();
  self.identificationNo = ko.observable();
  self.startDate = ko.observable();
  self.endDate = ko.observable();
  self.noOfAdults = ko.observable();
  self.noOfKids = ko.observable();
  self.noOfRooms = ko.observable();
  self.promoCode = ko.observable();
  self.roomType = ko.observableArray();
  self.chosenRoomType = ko.observable();
  self.service = ko.observableArray();
  self.chosenService = ko.observable();
  self.totalCharge = ko.observable();
  self.paidAmount = ko.observable();

  self.deleteBooking = function() {
    //delete a booking from the cart

    removeBooking(self.id);
  }

  self.sevicesDrop = function() {
    // console.log(self.chosenRoomType);
    loadServices(self.chosenRoomType()[0].id());
  }
}

function checkAvailability() {
  //send all data to the server and retrive the available room types

  var sendData = ko.toJSON(bookingFirst);

  sendRequestToServerPost('/admin/booking/booking2', sendData, function(res){
    if(res) {

      var rooms = res;
      rooms = JSON.parse(rooms);

      for(var i in rooms) {

        var room = new RoomTypes();
        room.id(i);
        room.name(rooms[i]);
        bookingFirst.roomType.push(room);
      }
    }
  });
}

function getServices(url,variables,callback){
  //get services according to the according to the selected room type

  var headers = variables;
  var xmlHttp = new XMLHttpRequest(); 
  xmlHttp.onreadystatechange = function(){
      if (xmlHttp.readyState==4 && xmlHttp.status==200){
          callback(xmlHttp.responseText);
      }
  };
  xmlHttp.open( "POST", http_url+url, true );
  xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlHttp.send(headers);
}

var handleResponce = function(res){
  //callback
  if(res) {

    var services = res;
    services = JSON.parse(services);
    console.log(services);

    document.getElementById("service").options.length=0;
    for(var i in services) {

      var service = new Service();
      service.id(i);
      service.name(services[i]);
      bookingFirst.service.push(service);
    }
  }
}

function loadServices(ser){
  chosen = ser;
  console.log(chosen);
  // if(chosen!==undefined) {
    getServices('/booking/loaditem','room_type_id='+chosen,handleResponce);
  // }
}