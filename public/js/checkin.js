/*************** Checkin Functions ***************/

var Checkin = function() {
	//Checkin class

	var self = this;

	self.id = ko.observable();
	self.bookingID = ko.observable();
	self.checkin = ko.observable();
	self.checkout = ko.observable();
	self.advancedPay = ko.observable();
	self.paid = ko.observable();
	self.payment = ko.observable();

	self.saveCheckin = function() {
		//send checking details to controller
		
		var sendData = ko.toJSON(checkinView);
		sendRequestToServerPost('/admin/checkin/create', sendData, function(res) {
			console.log(res);
		});
	}
}