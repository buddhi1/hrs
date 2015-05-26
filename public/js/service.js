// ------------------------- Data binding for service view -------------------------

var Service = function(){
	var self = this;

	this.name = ko.observable();

	this.addService = function(){
		var service = new Service();
		service.name(this.name());
		newServices.services.push(service);
		// self.name('');

		var res = saveService();
		//console.log(res);	
		if(res ==1 ){
			alert('The service added successfully');
			return 1;
		}else if(res == 0){
			alert('The service already exists');
		}else{
			alert('Something went wrong');
		}
		
	} 
		
}
var ServiceArray = function(){
	var self = this;

	this.services = ko.observableArray();

	this.removeService = function(){
	
		self.services.remove(this);
	}

}

var newService = new Service();
var newServices = new ServiceArray();

ko.applyBindings(newService, document.getElementById('add-service'));
ko.applyBindings(newServices, document.getElementById('saved-services'));


// ------------------------- service controller functions -------------------------

var saveService = function(){
	var test;
	var url = '/admin/service/create';
	var variables = ko.toJSON(newService);

	var callback = function(res){
		test = res;
		return res;
	}

	sendRequestToServerPost(url,variables,callback);
	console.log(test);
	return test;
}