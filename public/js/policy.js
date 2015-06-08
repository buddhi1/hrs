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

  self.id = ko.observable();
  self.des = ko.observable();
  self.variables = ko.observableArray([new PolicyVariables()]);

  self.addNewVar = function() {
    //add property

  	self.variables.push(new PolicyVariables());
  }

  self.removeProperty = function() {
    //remove property

    if(self.variables().length>1) {
      self.variables.remove(this);
    }
  }

  self.savePolicy = function() {
    //save all the policy details

    var sendData = ko.toJSON(self);
    console.log(sendData);
    if(self.des() !== undefined) {
      if((self.variables()[0].id() !== undefined && self.variables()[0].id() !== '') && (self.variables()[0].values() !== undefined && self.variables()[0].values() !== '')) {
        sendPolicyToServerPost('/admin/policy/create', sendData, function(res){
          if(res === 'success') {
            window.location = http_url+"/admin/policy";
          } else {
            window.location = http_url+"/admin/policy";
          }
        });
      } else {
        alert('Required Fields cannot be Empty');
      }
    } else {
      alert('Required Fields cannot be Empty');
    }
  }
}

var SavedPolicyView = function() {
  //array of saved policies

  var self = this;

  self.policy = ko.observableArray();
}

var SavedPolicy = function() {
  //contain the description and variables

  var self = this;

  self.id = ko.observable();
  self.des = ko.observable();
  self.variables = ko.observable();

  self.editPolicy = function() {
    var editID = self.id;
    var sendData = ko.toJSON({"id": editID});
    sendRequestToServerPost('/admin/policy/edit', sendData, function(res){
      if(res) {
        policy_obj = JSON.parse(res);

        policy.id(policy_obj.id);
        policy.des(policy_obj.description);
        policy.variables([]);
        var variables_arr = JSON.parse(policy_obj.variables);
        

        for(var col in variables_arr) {

          var editPolicy = new PolicyVariables();

          editPolicy.id(col);
          editPolicy.values(variables_arr[col]);
          policy.variables.push(editPolicy);
        }
      }
    });
  }

  self.deletePolicy = function() {
    var deleteID = self.id;
    var sendData = ko.toJSON({"id": deleteID});
    sendRequestToServerPost('/admin/policy/destroy', sendData, function(res){
      if(res === 'success') {

        window.location = http_url+"/admin/policy/index";
      }
    });
  }
}

function sendPolicyToServerPost(url,variables,callback){
  // send only policy details

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