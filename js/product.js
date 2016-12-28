$(".filter").click(function(){ going_somewhere($(this)); });



$(".orderby").change(function (){ going_somewhere($(this)); });



$(".filter-form").submit(function(){

	going_somewhere($('.filter-form'));

	return false;

});



function going_somewhere($this) {



	var curr_lang 				= $("#hidden_curr_lang").val();

	var curr_page 				= $("#hidden_curr_page").val();

	var price_range 			= $("#hidden_price_range").val();

	var gender 					= $("#hidden_gender").val();

	var size 					= $("#hidden_size").val();

	var fit 					= $("#hidden_fit").val();

	var category 				= $("#hidden_category").val();

	var sort 					= $("#hidden_sort").val();

	var keyword 				= $("#hidden_keyword").val();

	var halaman 				= 1;

	var SITE_URL				= "http://klassiqueuniform.com/";



	url = SITE_URL+curr_lang+"/"+curr_page+"?view=filter";

	get_param = "";



	if($this.hasClass('gender')) {

		var gender_baru = "gender="+$this.html();

		get_param = get_param +"&"+ gender_baru;

	}else if(gender != ''){

		get_param = get_param +"&gender="+ gender;

	}





	if($this.hasClass('size')) {

		size_baru = "size="+$this.attr('ukuran');	

		get_param = get_param +"&"+ size_baru;

	}else if(size != ''){

		get_param = get_param +"&size="+ size;

	}



	if($this.hasClass('fit')) {

		fit_baru = "fit="+$this.html();	

		get_param = get_param +"&"+ fit_baru;

	}else if(fit != ''){

		get_param = get_param +"&fit="+ fit;

	}



	if($this.hasClass('category')) {

		category_baru = "category="+$this.attr('id');

		get_param = get_param +"&"+ category_baru;

	}else if(category != ''){

		get_param = get_param +"&category="+ category;

	}





	if($this.hasClass('page-numbers')) {

		halaman_baru = "halaman="+$this.attr('hal');

		get_param = get_param +"&"+ halaman_baru;

	}else if(halaman != ''){

		get_param = get_param +"&halaman="+ halaman;

	}



	if($this.hasClass('sorting')) {

		sort_baru = "sort="+$this.attr('value');

		get_param = get_param +"&"+ sort_baru;

	}else if(sort != ''){

		get_param = get_param +"&sort="+ sort;

	}

	

	if(keyword != ''){

		get_param = get_param +"&keyword="+ keyword;

	}

	if($this.hasClass('filter-form')) {

		price_range_baru = "price="+$("#min_price").val() + "-" + $("#max_price").val();

		get_param = "&"+ price_range_baru;

	}else if(price_range != ''){

		get_param = get_param +"&price="+ price_range;

	}





	url = url + get_param+'#sorting';

	location.href=url;

	//alert(url);

}