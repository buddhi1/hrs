/*************** Booking Functions ***************/

var RoomTypes = function() {
  // Room types class which contains id and name

  var self = this;

  self.id = ko.observable();
  self.name = ko.observable();
}

var SearchByID = function() {
  // This class is used to Search a booking by booking ID

  var self = this;

  self.id = ko.observable();

  self.searchBookingByID = function() {
    
    bookingSearch(self.id(), 'booking');
  }
}

var SearchByUserID = function() {
  // This class is used to Search a booking by booking ID

  var self = this;

  self.userID = ko.observable();

  self.searchBookingByUserID = function() {
    
    bookingSearch(self.userID(), 'user');
  }
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
  self.services = ko.observableArray();
  self.chosenService = ko.observable();
  self.paidAmount = ko.observableArray();
  self.chosenAmount = ko.observable();
  self.totalPrice = ko.observable();

  self.deleteBooking = function() {
    //delete a booking from the cart

    removeBooking(self.id);
  }

  self.sevicesDrop = function() {

    loadServices(self.chosenRoomType()[0].id());
  }

  self.removeItem = function() {
    //remove an item from the cart

    removeCartItem(self.id());
  }
}

var BookingDisplay = function() {
  var self = this;

  self.cartItems = ko.observableArray();
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
  var pay_option1 = {
    id: 'first',
    name: 'First Night'
  };
  var pay_option2 = {
    id: 'full',
    name: 'Full Payment'
  }

  bookingFirst.paidAmount.push(pay_option1);
  bookingFirst.paidAmount.push(pay_option2);
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
    bookingFirst.services([]);
    services = JSON.parse(services);

    for(var i in services) {

      var service_obj = new Services();
      service_obj.id(services[i].service_id);
      service_obj.name(services[i].name);
      bookingFirst.services.push(service_obj);
    }
  }
}

function loadServices(ser){
  // send the request to retrieve the required room types

  chosen = ser;
  getServices('/booking/loaditem','room_type_id='+chosen,handleResponce);
}

var cleanBookingJson = function(que) {
  //this function remove unwanted properties and unwanted objects from allPermissions object
  
  var copy = ko.toJS(que);

  delete copy.roomType;
  delete copy.services;
  delete copy.paidAmount;

  return copy;
}

function sendBookingToServerPost(url,variables,callback){
  //this function is added because of a limitation of the sendRequestToServerPost function sending arrays to the controller

    var header =  "variables="+variables;
         
    var xmlHttp = new XMLHttpRequest(); 
    xmlHttp.onreadystatechange = function(){
        if (xmlHttp.readyState==4 && xmlHttp.status==200){
            callback(xmlHttp.responseText);
        }
    };
    xmlHttp.open( "POST", http_url+url, true );
    xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlHttp.send(header);
}

function saveBooking() {
  //save a booking in the cart
  
  var clean = cleanBookingJson(bookingFirst);
  var sendData = ko.toJSON(clean);
  console.log(sendData);
  sendBookingToServerPost('/admin/booking/create', sendData, function(res){

    if(res === 'success') {
      window.location = http_url+"/admin/booking/cart";
    } else if(res === 'failure') {
      window.location = http_url+"/admin/booking/booking1";
    }
  });
}

function removeCartItem(cartID) {
  //remove items from the shopping cart

  window.location = http_url+"/booking/removeitem/"+cartID;
}

function finishBooking() {
  //finish the booking and save data in database
  var foo;
  sendBookingToServerPost('/admin/booking/placebooking', foo, function(res){
    if(res === 'success') {
      window.location = http_url+"/booking/booking1";
    }
  });
}

function removeBooking(id) {
  // delete a booking from the booking table

  var deleteID = id;
  var sendData = ko.toJSON({"booking_id": deleteID});
  sendRequestToServerPost('/booking/destroy', sendData, function(res){
    if(res === 'success') {

      window.location = http_url+"/admin/booking/booking1";
    }
  });
}

function bookingSearch(id, type) {
  // used to search a booking by user's identification number of by booking id
  
  var searchID = id;
  if(type === 'booking') {
    var sendData = ko.toJSON({"booking_id": searchID});
  } else if(type === 'user') {
    var sendData = ko.toJSON({"uid": searchID});
  }

  sendRequestToServerPost('/booking/search', sendData, function(res){
    if(res) {
      var result = JSON.parse(res);
      searchResult.chosenRoomType(result.room_type_id);
      searchResult.noOfRooms(result.no_of_rooms);
      searchResult.noOfAdults(result.no_of_adults);
      searchResult.noOfKids(result.no_of_kids);
      searchResult.chosenService(result.services);
      searchResult.totalPrice(result.total_charges);
      searchResult.chosenAmount(result.paid_amount);
    }
  });
}