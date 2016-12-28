<?php 
	@session_start();
	if(isset($_SESSION['stat'])):
		$notifpesan = $_SESSION['stat'];
	else:
		$notifpesan = '';
	endif;
	$varWaktu = 10;

	
	if($notifpesan != ''){
		$a = global_select_single("alert_notify","`title_id`,`title_en`,`description_id`,`description_en`,`notification_status`","`for` = '$notifpesan'");?>
		<script>
		$( document ).ready(function() {
			swal({
				title: <?php echo "'<h4>".$a['title_'.$curr_lang]."</h4>'" ?>,
				text: 	<?php echo "'<p>".$a['description_'.$curr_lang]."</p>'" ?>,
				type: "<?php echo $a['notification_status'] ?>",
				//timer: 4000,
				html: true
			});
		});
		</script>
		<?php
	} unset($_SESSION['stat'])?>