var User = Class.create();
User = Class.create({
	initialize: function (name, address, email, mobile, username, password, docsSubmitted) {
		this.name = name;
		this.address = address;
		this.email = email;
		this.mobile = mobile;
		this.username = username;
		this.password = password;
		this.docsSubmitted = docsSubmitted;
	},

	setName:function(name){
		this.name = name;
	},

	getName: function () {
		return this.name;
	},

	setAddress: function (address) {
		this.address = address;
	},

	getAddress: function () {
		return this.address;
	},

	setEmail: function (email) {
		this.email = email;
	},

	getEmail: function () {
		return this.email;
	},

	setMobile: function (mobile) {
		this.mobile = mobile;
	},

	getMobile: function () {
		return this.mobile;
	},

	setUsername: function (username) {
		this.username = username;
	},

	getUsername: function () {
		return this.username;
	},

	setPassword: function (password) {
		this.password = password;
	},

	getpassword: function () {
		return this.password;
	},

	toString:function(){
		return this.name + " " + this.address + " " + this.email + " " + this.mobile + " " + this.username + " " + this.password;
	}
});
