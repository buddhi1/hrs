// ------------------------- Data binding for service view -------------------------

var Service = function(){
	var self = this;

	this.name = ko.observable();

	this.addService = function(){
		var service = new Service();

		service.name(this.name());
		newServices.services.push(service);		
		var res = saveService();
		self.name('');			
	} 
		
}
var ServiceArray = function(){
	var self = this;

	this.services = ko.observableArray();

	this.removeService = function(){
	
		self.services.remove(this);
		deleteService(this);
	}

}

var newService = new Service();
var newServices = new ServiceArray();

ko.applyBindings(newService, document.getElementById('add-service'));
ko.applyBindings(newServices, document.getElementById('saved-services'));


// ------------------------- service controller functions -------------------------

window.onload = function(){
	loadServices();
}


var saveService = function(){
	var result=-1;
	var url = '/admin/service/create';
	var variables = ko.toJSON(newService);

	var callback = function(res){
		return res;	
	}

	sendRequestToServerPost(url,variables,function(res){		
		if(res ==1 ){
			alert('The service added successfully');
			return 1;
		}else if(res == 0){
			newServices.services.pop();
			alert('The service already exists');
		}else{
			newServices.services.pop();
			alert('Something went wrong');
		}
	});
	
}

var deleteService = function(obj){
	var result=-1;
	var url = '/admin/service/destroy';
	var variables = ko.toJSON(obj);

	var callback = function(res){
		return res;	
	}

	sendRequestToServerPost(url,variables,function(res){		
		if(res ==1 ){
			alert('Service is successfully deleted');
			return 1;
		}else{
			alert('Something went wrong');
		}
	});
	
}

var loadServices = function(){
	obj = JSON.parse(services);

	for(i=0; i < obj.length; i++){
		var service = new Service();

		service.name(obj[i].name);
		newServices.services.push(service);		
	}
}