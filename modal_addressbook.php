		<?php
if($address_book){ 
	foreach ($address_book as $key => $value) { ?>
	<div class="modal fade editAddress-modal-<?php echo $value['id'];?>" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<?php 
					$data_address_edit = global_select_single("member_addressbook","*","id = ".$value['id']); 
				?>
				<form id="editAddressForm" method="POST" action="/<?php echo $curr_lang ?>/member-edit_addressbook">
					<input type="hidden" name="id_addressbook" value="<?php echo $value['id'] ?>">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
						</button>
						<h4 class="modal-title"><?php echo $language_config[74]['lang_'.$curr_lang] ?></h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label><?php echo $language_config[71]['lang_'.$curr_lang] ?>:</label>
							<input type="text" name="receiver_name" required class="form-control" value="<?php echo $value['receiver_name'] ?>">
						</div>
						<div class="form-group">
							<label><?php echo $language_config[55]['lang_'.$curr_lang] ?>:</label>
							<input type="text" name="phone_number" required class="form-control" value="<?php echo $value['phone_number'] ?>">
						</div>
						<div class="form-group">
							<label><?php echo $language_config[59]['lang_'.$curr_lang] ?>:</label>
							<div class="form-flat-select">
								<select style="width:100%" id="country_<?php echo $value['id'] ?>" name="country">
									<?php countrylist($value['country']); ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label><?php echo $language_config[60]['lang_'.$curr_lang] ?>:</label>
							<div class="form-flat-select">
								<select style="width:100%" name="propinsi" id="propinsi_<?php echo $value['id'] ?>">
									<?php propinsilistedit($value['country'],$value['propinsi']); ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label><?php echo $language_config[61]['lang_'.$curr_lang] ?>:</label>
							<div class="form-flat-select">
								<select style="width:100%" name="kabupaten" id="kabupaten_<?php echo $value['id'] ?>">
									<?php kabupatenlistedit($value['propinsi'],$value['kabupaten']); ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label><?php echo $language_config[62]['lang_'.$curr_lang] ?>:</label>
							<div class="form-flat-select">
								<select style="width:100%" id="namakota_<?php echo $value['id'] ?>" name="idkota">
									<?php kotalistedit($value['kabupaten'],$value['idkota']); ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label><?php echo $language_config[63]['lang_'.$curr_lang] ?>:</label>
							<input type="text" name="kodepos" required class="form-control" value="15810">
						</div>
						<div class="form-group">
							<label><?php echo $language_config[72]['lang_'.$curr_lang] ?>:</label>
							<textarea name="address" cols="40" rows="6" class="form-control textarea"><?php echo $value['address'] ?></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" name="submit" value="submit" class="btn btn-default btn-outline f-g8">SAVE ADDRESS</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	$( document ).ready(function() {

		$("#country_"+<?php echo $value['id'] ?>).change(function(){
		 	 var country = $(this).val();	
			 $.post("/web/ajax/get_propinsi.php", {"country": country},
			 function(data){
				$("#propinsi_"+<?php echo $value['id'] ?>).html(data); 
			 });	 
	    });    

		$("#propinsi_"+<?php echo $value['id'] ?>).change(function(){
		 	 var propinsi = $(this).val();			
			 $.post("/web/ajax/get_kabupaten.php", {"propinsi": propinsi},
			 function(data){
				$("#kabupaten_"+<?php echo $value['id'] ?>).html(data); 
			 });
	  	}); 
		   
		$("#kabupaten_"+<?php echo $value['id'] ?>).change(function(){
		 	 var kabupaten = $(this).val();			
			 $.post("/web/ajax/get_kotalist.php", {"kabupaten": kabupaten},
			 function(data){
				$("#namakota_"+<?php echo $value['id'] ?>).html(data); 
			 });
	    });
	});
	</script>
<?php }}?>