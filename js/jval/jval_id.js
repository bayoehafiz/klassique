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
				  required : "* Harap masukan Email"
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
				required : "* Harap masukan password",
				minlength:"* Password harus lebih dari 8 karakter"
			},
			password2: { 
				required : "* Harap masukan password",
				equalTo: "* Password konfirmasi harus sama"
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
				required : "* Harap masukan password"
			},
			password2: { 
				required : "* Harap masukan password Baru",
				minlength:"* Password harus lebih dari 8 karakter"
			},
			password3: { 
				required : "* Harap masukan password Konfirmasi",
				equalTo: "* Password konfirmasi harus sama"
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
				required : "* Harap masukan Nama"
			},
			email:{ 
				required: "* Masukan Alamat Email dengan benar.",
				email:"* Email anda tidak boleh menggunakan karakter spesial seperti: *($#&"
			},
			phone: {
				required : "* Harap masukan telepon"
			},
			handphone: {
				required : "* Harap masukan handphone"
			},
			gender: {
				required : "* Harap masukan jenis kelamin"
			},
			birth_date: {
				required : "* Harap masukan Tanggal Lahir"
			},
			country: {
				required : "* Harap masukan negara"
			},
			propinsi: {
				required : "* Harap masukan propinsi"
			},
			kabupaten: {
				required : "* Harap masukan kabupaten"
			},
			namakota: {
				required : "* Harap masukan namakota"
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
				required : "* Harap masukan Email"
			},
			email:{ 
				required: "* Masukan Alamat Email dengan benar.",
				email:"* Email anda tidak boleh menggunakan karakter spesial seperti: *($#&"
			},
			message: { 
				required : "* Harap masukan Pesan"
			},
			captcha: { 
				required : "* Harap masukan Kode Verifikasi"
			},
		}
	});	