jQuery.validator.addMethod("alphanumeric", function(value, element) {
	//    return this.optional(element) || /^\w[\w\d\s]*$/.test(value);
	return this.optional(element) || /^[0-9a-z-.,\s]+$/i.test(value);
		}, "Letters, numbers, spaces or underscores only"); 
	jQuery.validator.addMethod("alphanumeric2", function(value, element) {
	//    return this.optional(element) || /^\w[\w\d\s]*$/.test(value);
	return this.optional(element) || /^[0-9a-z_]+$/i.test(value);
		}, "Letters, numbers or underscores only");  
	jQuery.validator.addMethod("alphanumeric3", function(value, element) {
	//    return this.optional(element) || /^\w[\w\d\s]*$/.test(value);
	return this.optional(element) || /^[0-9.]+$/i.test(value);
		}, "Number Only");  
	jQuery.validator.addMethod("alphanumeric5", function(value, element) {
	//    return this.optional(element) || /^\w[\w\d\s]*$/.test(value);
	return this.optional(element) || /^[0-9.]+$/i.test(value);
		}, "Please Provide valid phone.");  

	$("#email_subscribe").validate({
		rules: {
			email:{
				required: true
			}
		},
			
		messages: {
			email: { 
				  required : "* Please enter Email"
			}
		}
	});	
	
	$("#member_restore_password").validate({
		rules: {
			password1:{
				required: true,
				minlength: 8
			},
			password2:{
				required: true,
				equalTo: "#password1"
			}
		},
			
		messages: {
			password1: {
				required : "* Please Enter password",
				minlength:"* Password must 8 charakter or more"
			},
			password2: { 
				required : "* Pleae Enter password",
				equalTo: "* Password confirmation must same"
			}
		}
	});

	$("#member_change_password").validate({
		rules: {
			password1:{
				required: true
			},
			password2:{
				required: true,
				minlength: 8
			},
			password3:{
				required: true,
				equalTo: "#password2"
			}
		},
			
		messages: {
			password1: {
				required : "* Please enter password"
			},
			password2: { 
				required : "* Please enter new password",
				minlength:"* password length more than 8 character"
			},
			password3: { 
				required : "* Please enter confirmation password",
				equalTo: "* Confirmation Password must equal to password"
			}
		}
	});

	$("#member_profile").validate({
		rules: {
			fullname:{
				required: true
			},
			email:{ 
				required: true,
				email: true
			},
			phone:{
				required: true
			},
			handphone:{
				required: true
			},
			gender:{
				required: true
			},
			birth_date:{
				required: true
			},
			country:{
				required: true
			},
			propinsi:{
				required: true
			},
			kabupaten:{
				required: true
			},
			namakota:{
				required: true
			},
		},

			
		messages: {
			fullname: {
				required : "* Please Enter name"
			},
			email:{ 
				required: "* Please Enter Valid Email Address.",
				email:"* not contain special char: *($#&"
			},
			phone: {
				required : "* Please Enter phone"
			},
			handphone: {
				required : "* Please Enter mobile phone"
			},
			gender: {
				required : "* Please Enter gender"
			},
			birth_date: {
				required : "* Please Enter birth date"
			},
			country: {
				required : "* Please Enter country"
			},
			propinsi: {
				required : "* Please Enter province"
			},
			kabupaten: {
				required : "* Please Enter kabupaten"
			},
			namakota: {
				required : "* Please Enter city"
			},
		}
	});

	$("#contact_us").validate({
		rules: {
			name:{
				required: true
			},
			email:{ 
				required: true,
				email: true
			},
			message:{
				required: true
			},
			captcha:{
				required: true
			},
		},
			
		messages: {
			name: { 
				required : "* Please enter Email"
			},
			email:{ 
				required: "* Please enter Valid Email Address.",
				addressval:"* Your email must not have special characters like: *($#&"
			},
			message: { 
				required : "* Please enter Your Message"
			},
			captcha: { 
				required : "* Please enter Captcha Code"
			},
		}
	});	