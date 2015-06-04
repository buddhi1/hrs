/*************** Policy Functions ***************/

var PolicyVariables = function() {
	// Policy variable id and value will be stored

	var self = this;

	self.id = ko.observable();
	self.values = ko.observable();
}

var Policy = function() {
  // Room types class which contains id and name

  var self = this;

  self.des = ko.observable();
  self.variables = ko.observableArray();

  self.addNewVar = function() {
  	self.variables.push(new PolicyVariables());
  }
}