

$(document).ready(function() { // execute when window open



	function convertToRupiah(angka){

		var rupiah = '';

		var angkarev = angka.toString().split('').reverse().join('');

		for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';

		return rupiah.split('',rupiah.length-1).reverse().join('');

	}



	$('#button_track').click(function() {

		// tracking Order

		var idorder = $('#track_idorder').attr("value");

		if(idorder.length > 1){

			$.ajax({

				type	: "POST",

				url		: "/shopcart-ajax/track_order",

				data	: {"orderid": idorder},

				beforeSend:  function() {



				},

				success: function(html){

					$('#return_track').fadeOut(100).html(html).fadeIn(500);

				}

			});

		}

	});



	$('.check_cheked').click(function(e) {

		//alert(a);

		var total = 0;

		$('.check_cheked').each(function(){

			var a = parseInt($(this).attr('nominal'));

			if($(this).is(":checked")) {

				total = total + a;

			}

		});



		//alert(total);

		$("#total_biaya_tambahan").html("IDR "+convertToRupiah(total));

	});





	/*product_detail*/

	$('#cek_detail_gender').change(function(e) {

		var id_product = $('#id_product').attr('value');

		var gender = $(this).attr('value');

		$.ajax({

			type	: "POST",

			url		: "/shopcart-ajax/cek_detail_gender",

			data	: {"gender": gender,"id_product":id_product},

			beforeSend:  function() {

				//$('.loading').fadeIn().html('<img src="/web/images/loading.gif" />');//Loading image during the Ajax Request

			},

			success: function(html){//html = the server response html code

				$('#filter_size_prod_detail').hide();

				$('.filter_type').html(html);

			}

		});

		e.preventDefault();

	});



	$('#cek_detail_fit').change(function(e) {

		var id_product = $('#id_product').attr('value');

		var gender = $('#cek_detail_gender').val();

		var fit_type = $(this).attr('value');

		var curr_lang = $('#language_current').attr('lang');

		var display_lang_size = $('#display_lang_size').attr('lang');

		

		$.ajax({

			type	: "POST",

			url		: "/shopcart-ajax/cek_detail_fit",

			data	: {"gender": gender,"id_product":id_product,"fit_type": fit_type,"curr_lang": curr_lang,"display_lang_size":display_lang_size},

			beforeSend:  function() {

				//$('.loading2').fadeIn().html('<img src="/web/images/loading.gif" />');//Loading image during the Ajax Request

			},

			success: function(html){//html = the server response html code

				$('.filter_size').html(html);

				//get_selected_id_detail(id_product,gender,fit_type);

				$(".addtocart").prop('enabled', true);

				$('#filter_size_prod_detail').show();

			}

		});

		e.preventDefault();

	});



	function get_selected_id_detail(id_product,gender,fit_type){

		$.ajax({

			type	: "POST",

			url		: "/shopcart-ajax/get_id_product_detail",

			data	: {"id_product": id_product,"gender":gender,"fit_type":fit_type},

			beforeSend:  function() {

				//$('.loading2').fadeIn().html('<img src="/web/images/loading.gif" />');//Loading image during the Ajax Request

			},

			success: function(html){

				// ini id detail product nya

				get_stock_tersedia(html);

				$('#ukuran_size').val(parseInt(html));

			}

		});

	}



	function get_stock_tersedia(id_product_detail){

		var language_current = $('#language_current').attr('lang');



		$.ajax({

			type	: "POST",

			url		: "/shopcart-ajax/get_stock_tersedia",

			data	: {"id_product_detail": id_product_detail},

			beforeSend:  function() {

				//$('.loading2').fadeIn().html('<img src="/web/images/loading.gif" />');//Loading image during the Ajax Request

			},

			success: function(html){

				var stok_tersedia = parseInt(html);



				if(stok_tersedia > 0){

					//$('#max_value_buy').attr('max',parseInt(html));

					$(".addtocart").prop('disabled', false);

					$("#custom_checkbox_bordir").show();

					$("#filter_size_prod_detail").show();

					$("#max_value_buy").show();

					if(language_current == 'id'){

						$(".addtocart").css("border-color", "black").css("color", "black").html("Tambahkan ke Keranjang");

					}else{

						$(".addtocart").css("border-color", "black").css("color", "black").html("Add to cart");

					}

				}else{

					$(".addtocart").prop('disabled', true);

					$("#custom_checkbox_bordir").hide();

					$("#filter_size_prod_detail").hide();

					$("#max_value_buy").hide();

					if(language_current == 'id'){

						$(".addtocart").css("border-color", "red").css("color", "red").html("Stok Habis");

					}else{

						$(".addtocart").css("border-color", "red").css("color", "red").html("Out of Stock");

					}

				}

			}

		});

	}



	$("#add_voucher").click(function(){

		var code = $("#voucher_code").val();

		$.ajax({

			type	: "POST",

			url		: "/shopcart-ajax/use_voucher",

			data	: {"code": code},

			beforeSend:  function() {

				//$('.loading2').fadeIn().html('<img src="/web/images/loading.gif" />');//Loading image during the Ajax Request

			},

			success: function(html){//html = the server response html code

				//total_item(); 

				if(html == 1){

					swal('success','voucher accepted','success');

					setTimeout(function(){

						location.reload();

					},500); 

				}else if(html==2){

					swal('failed','you already have a voucher','warning');

				}else if(html==3){

					swal('failed','you already use this voucher','warning');

				}else{

					swal('failed','enter a valid voucher','error');

				}

			}

		});

	});



	$(".remove_voucher").click(function(){

		var code = $(this).attr('val');

		$.ajax({

			type	: "POST",

			url		: "/shopcart-ajax/remove_voucher",

			data	: {"code": code},

			beforeSend:  function() {

				//$('.loading2').fadeIn().html('<img src="/web/images/loading.gif" />');//Loading image during the Ajax Request

			},

			success: function(html){//html = the server response html code

				//total_item(); 

				if(html == 1){

					swal('success','voucher removed','success');

					setTimeout(function(){

						location.reload();

					},500); 

				}

			}

		});

	});



	$(".get_ongkir").click(function(){

		var val = $(this).attr('value');

		$.ajax({

			type	: "POST",

			url		: "/shopcart-ajax/get_ongkir",

			data	: {"type": val},

			beforeSend:  function() {

				//$('.loading2').fadeIn().html('<img src="/web/images/loading.gif" />');//Loading image during the Ajax Request

			},

			success: function(html){//html = the server response html code

				if(html == 1){

					location.reload();

				}

			}

		});

	});

	

	$('form#form_cart').validate({

		rules: {



		},

		messages: {

			

		},

		errorPlacement: function(error, element){

			//error.insertBefore(element);

			error.insertAfter(element);

		},

		submitHandler:function(form){

			var id_product_detail = $('#ukuran_size').attr('value');

			

			if(id_product_detail == ''){

				swal({

					title: "Error",

					text: "Please Select Size",

					type: "warning",

					confirmButtonColor: '#DD6B55',

					confirmButtonText: "OK",

					closeOnConfirm: true

				},

				function(isConfirm){

				});

			}else{

				$(".imgload").removeAttr("style");

				var formData = new FormData($("form#form_cart")[0]);

				$.ajax({

					url:'/shopcart-ajax/add',

					type:'POST',

					data:formData,

					dataType:'HTML',

					contentType:false,

					processData:false,

					cache:false,

					success:function(html){

						total_item();

						var arr_msg = html.split('#');

						swal(arr_msg[0], arr_msg[1],arr_msg[2]);

					}

				});

			}

		}

	});



	//up and down qty

	/*$( ".quantity_number" ).blur(function() {

		var new_qty = this.value;

		var item_id = $(this).attr('record');

		$.ajax({//Make the Ajax Request

			type	: "POST",

			url		: "/shopcart-ajax/update",

			data	: {"item_id": item_id, "new_qty": new_qty},

			beforeSend:  function() {

				//$('.loading2').fadeIn().html('<img src="/web/images/loading.gif" />');//Loading image during the Ajax Request

			},

			success: function(html){//html = the server response html code

				total_item();

				var arr_msg = html.split('#');

				/*swal(arr_msg[0], arr_msg[1]);

				setTimeout(function(){

					location.reload();

				},500);

				swal({

					title: arr_msg[0],



					text: arr_msg[1],

					type: arr_msg[2],

					confirmButtonText: "OK",

					closeOnConfirm: true,

				},

				function(isConfirm){

					if (isConfirm){

						location.reload();

					}

				});



				$("#quantity_product-"+item_id).val(html);

			}

		});



	});*/



	//up and down qty

	$( ".btn-add" ).click(function() {

		var item_id = $(this).attr('id');

		var new_qty = parseInt($('#quantity_product-'+item_id).val());

		var hasil_jumlah = new_qty+1;

		

		$.ajax({//Make the Ajax Request

			type	: "POST",

			url		: "/shopcart-ajax/btn_add",

			data	: {"item_id": item_id, "new_qty": hasil_jumlah},

			beforeSend:  function() {

				//$('.loading2').fadeIn().html('<img src="/web/images/loading.gif" />');//Loading image during the Ajax Request

			},

			success: function(html){//html = the server response html code

				total_item();

				var arr_msg = html.split('#');

				

				swal({

					title: arr_msg[0],

					text: arr_msg[1],

					type: arr_msg[2],

					confirmButtonText: "OK",

					closeOnConfirm: true,

				},

				function(isConfirm){

					if (isConfirm){

						location.reload();

					}

				});



				//$("#quantity_product-"+item_id).val(html);

			}

		});



	});



	$( ".btn-min" ).click(function() {

		var item_id = $(this).attr('id');

		var new_qty = parseInt($('#quantity_product-'+item_id).val());

		var hasil_jumlah = new_qty-1;

		

		$.ajax({//Make the Ajax Request

			type	: "POST",

			url		: "/shopcart-ajax/btn_min",

			data	: {"item_id": item_id, "new_qty": hasil_jumlah},

			beforeSend:  function() {

				//$('.loading2').fadeIn().html('<img src="/web/images/loading.gif" />');//Loading image during the Ajax Request

			},

			success: function(html){//html = the server response html code

				total_item();

				var arr_msg = html.split('#');

				

				swal({

					title: arr_msg[0],

					text: arr_msg[1],

					type: arr_msg[2],

					confirmButtonText: "OK",

					closeOnConfirm: true,

				},

				function(isConfirm){

					if (isConfirm){

						location.reload();

					}

				});



				//$("#quantity_product-"+item_id).val(html);

			}

		});



	});

	

	$(".remove_form_cart").click(function(e){

		var item_id = $(this).attr('id');

		swal({

			title: "Are You Sure?",

			text: "You will not be able to recover this record!",

			type: "warning",

			showCancelButton: true,

			confirmButtonColor: '#DD6B55',

			confirmButtonText: "delete",

			cancelButtonText: "cancel",

			closeOnConfirm: false,

			closeOnCancel: false

		},

		function(isConfirm){

			if (isConfirm){

				$.post( "/shopcart-ajax/delete", { item_id: item_id}, function( data ) {

					if(data==1){

						swal("Success", "Item Deleted Successfully", "success");

						var notif = data.split('#');

						total_item();

						$("#record_"+item_id).fadeOut();	

						setTimeout(function(){

							location.reload();

						},500); 

					}else if(data==2){

						var notif = data.split('#');

						total_item();

						swal("Success", "Item Deleted Successfully", "success");

						location.reload();

					}else{

						swal("Failed","item Delete Failed", "warning");	

					} 

				});

			} else {

				swal("Failed", "fail to delete record", "error");

			}

		});

		e.preventDefault(); 

	});



	function total_item(){

		$.ajax({//Make the Ajax Request

			type	: "POST",

			url		: "/shopcart-ajax/get_total",

			data	: {"token": 'token'},

			beforeSend:  function() {

				//$('.loading2').fadeIn().html('<img src="/web/images/loading.gif" />');//Loading image during the Ajax Request

			},

			success: function(html){//html = the server response html code

				//alert(html);

				$(".totalitem").html(html);

			}

		});

	}

});

