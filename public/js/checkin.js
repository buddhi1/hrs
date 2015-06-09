/*************** Checkin Functions ***************/

var Checkin = function() {
	//Checkin class

	var self = this;

	self.id = ko.observable();
	self.bookingID = ko.observable();
	self.authorizer = ko.observable();
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

	self.saveCheckout = function() {
		//send checking details to controller
		
		var sendData = ko.toJSON(checkinView);

		sendRequestToServerPost('/admin/checkin/update', sendData, function(res) {
			if(res === 'success') {
				window.location = http_url+"/admin/checkin/index";
			}
		});
	}

	self.addPayment = function() {
		//send checkin id to controller

		var sendData = ko.toJSON({"id": self.id()});

		sendRequestToServerPost('/admin/checkin/newpayment', sendData, function(res) {
			if(res === 'success') {
				window.location = http_url+"/admin/checkin/addpayment";
			}
		});
	}

	self.savePayment = function() {
		//send checkin id to controller

		var sendData = ko.toJSON(checkinView);
		console.log(sendData);

		sendRequestToServerPost('/admin/checkin/recordpayment', sendData, function(res) {
			if(res === 'success') {
				window.location = http_url+"/admin/checkin/index";
			}
		});
	}
}

var CheckinIndex = function() {
	//Checkin Index calass to hold multiple checkins

	var self = this;

	self.id = ko.observable();
	self.checkins = ko.observableArray();
}