// ------------------------- Data binding for calendar CRUD -------------------------
var Tax = function(){
	var self = this;

	this.id = ko.observable();
	this.name = ko.observable();
	this.rate = ko.observable();

	this.addTax = function(){

		if(document.getElementById('name').value !== "" && document.getElementById('rate').value !== ""){
			newTax.name(this.name());
			newTax.rate(this.rate());

			saveTax();
		}else{
			alert('Please fill all fields');
		}
		
	}
}

var TaxArray = function(){
	var self = this;

	this.taxArray = ko.observableArray();

	this.loadEditSavedTax = function(){
		
		var url = '/admin/tax/edit';
		var variables = ko.toJSON(this);

		var callback = function(res){
			return res;	
		}
		
		sendRequestToServerPost(url,variables,function(res){

			if(res == 1){
				window.location = http_url+"/admin/tax/edit"
			}
		});
	}

	this.deleteSavedTax = function(){
		var url = '/admin/tax/destroy';
		var variables = ko.toJSON(this);

		var callback = function(res){
			return res;	
		}
		
		sendRequestToServerPost(url,variables,function(res){

			if(res == 1){
				window.location = http_url+"/admin/tax"
			}else{
				alert('Something went wrong. Please try again.')
			}
		});
	}
}



// ------------------------- promotion controller functions -------------------------

var loadTaxes = function(){
	for(i=0; i<taxes.length; i++){
		var tax = new Tax();
		tax.name(taxes[i].name);
		tax.id(taxes[i].id);
		tax.rate(taxes[i].rate);

		allTax.taxArray.push(tax);
	}
}

var loadTax = function(){
	currTax.id(id);
	currTax.name(name);
	currTax.rate(rate);
}

var saveTax = function(){
	var result=-1;
	var url = '/admin/tax/create';
	
	var variables = ko.toJSON(newTax);

	var callback = function(res){
		return res;	
	}

	sendRequestToServerPost(url,variables,function(res){	
		if(res ==1 ){
			alert('The Tax added successfully');
			window.location = http_url+"/admin/tax";
			return 1;
		}else{
			alert('Something went wrong');
		}
	});
}

var saveEditedTax = function(){
	var result=-1;
	var url = '/admin/tax/update';
	var variables = ko.toJSON(this);

	var callback = function(res){
		return res;	
	}

	sendRequestToServerPost(url,variables,function(res){		
		if(res ==1 ){
			alert('The Tax edited successfully');
			window.location = http_url+"/admin/tax";
			return 1;
		}else{			
			alert('Something went wrong');
		}
	});
}
