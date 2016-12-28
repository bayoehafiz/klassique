<script type='text/javascript' src='<?php echo $workdir ?>js/jquery-migrate.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/jquery.themepunch.tools.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/jquery.themepunch.revolution.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/easing.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/imagesloaded.pkgd.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/bootstrap.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/superfish-1.7.4.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/jquery.appear.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/swatches-and-photos.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/jquery.prettyPhoto.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/jquery.prettyPhoto.init.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/jquery.selectBox.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/jquery.parallax.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/jquery.touchSwipe.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/jquery.transit.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/jquery.carouFredSel.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/isotope.pkgd.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/core.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/widget.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/mouse.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/slider.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/jquery-ui-touch-punch.min.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/price-slider.js'></script>
<!-- RATY -->
<script type='text/javascript' src="<?php echo $workdir ?>js/raty/jquery.raty.js"></script>
<!-- ELEVATE ZOOM -->
<script type='text/javascript' src="<?php echo $workdir ?>js/jquery.elevateZoom-3.0.8.min.js"></script>

<!-- Jquery Validate -->
<script type='text/javascript' src="<?php echo $workdir ?>js/jval/jquery.validate.js" type="text/javascript"></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/jval/jval_<?php echo $curr_lang ?>.js'></script>
<link rel='stylesheet' href='<?php echo $workdir; ?>js/jval/jval.css' type='text/css' media='all'/>

<script type='text/javascript' src='<?php echo $workdir ?>js/custom.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>js/script.js'></script>
<script type='text/javascript' src='<?php echo $workdir ?>shop/shopcart.js'></script>
<script type="text/javascript">
$( document ).ready(function() {

	$("#country").change(function(){
	 	 var country = $(this).val();	
		 $.post("/web/ajax/get_propinsi.php", {"country": country},
		 function(data){
			$("#propinsi").html(data); 
		 });	 
    });    

	$("#propinsi").change(function(){
	 	 var propinsi = $(this).val();			
		 $.post("/web/ajax/get_kabupaten.php", {"propinsi": propinsi},
		 function(data){
			$("#kabupaten").html(data); 
		 });
  	}); 
	   
	$("#kabupaten").change(function(){
	 	 var kabupaten = $(this).val();			
		 $.post("/web/ajax/get_kotalist.php", {"kabupaten": kabupaten},
		 function(data){
			$("#namakota").html(data); 
		 });
    });
});
</script>