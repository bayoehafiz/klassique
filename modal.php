
<div class="modal fade user-login-modal" id="userloginModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="userloginModalForm" method="POST" action="/<?php echo $curr_lang ?>/member-login">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only"><?php echo $language_config[35]['lang_'.$curr_lang] ?></span>
					</button>
					<h4 class="modal-title"><?php echo $language_config[34]['lang_'.$curr_lang] ?></h4>
				</div>
				<div class="modal-body">
					<div class="user-login-facebook">
						<button class="btn-login-facebook" type="button" onclick="window.location.href='<?php echo htmlspecialchars($loginUrl) ?>'">
							<i class="fa fa-facebook"></i><?php echo $language_config[36]['lang_'.$curr_lang] ?>
						</button>
					</div>
					<div class="user-login-or"><span><?php echo $language_config[37]['lang_'.$curr_lang] ?></span></div>
					<div class="form-group">
						<label for="login-email">Email</label>
						<input type="text" id="login-email" name="email" required class="form-control" value="" placeholder="Email">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" id="password" required value="" name="password" class="form-control" placeholder="Password">
					</div>
					<div class="checkbox clearfix">
						<!-- <div class="form-flat-checkbox pull-left">
							<input type="checkbox" name="rememberme" id="rememberme" value="forever"><i></i>&nbsp;<?php echo $language_config[25]['lang_'.$curr_lang] ?>
						</div> -->
						<span class="lostpassword-modal-link pull-right">
							<a href="#lostpasswordModal" data-rel="lostpasswordModal"><?php echo $language_config[26]['lang_'.$curr_lang] ?></a>
						</span>
					</div>
				</div>
				<div class="modal-footer">
					<span class="user-login-modal-register pull-left">
						<a data-rel="registerModal" href="#"><?php echo $language_config[24]['lang_'.$curr_lang] ?></a>
					</span>
					<button type="submit" name="submit" value="submit" class="btn btn-default btn-outline"><?php echo $language_config[27]['lang_'.$curr_lang] ?></button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade user-login-modal" id="userloginModal_checkout" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="userloginModalForm" method="POST" action="/<?php echo $curr_lang ?>/member-login">
				<input type="hidden" name="from" value="checkout">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only"><?php echo $language_config[35]['lang_'.$curr_lang] ?></span>
					</button>
					<h4 class="modal-title"><?php echo $language_config[34]['lang_'.$curr_lang] ?></h4>
				</div>
				<div class="modal-body">
					<div class="user-login-facebook">
						<!-- <button class="btn-login-facebook" type="button" onclick="window.location.href='<?php echo htmlspecialchars($loginUrl) ?>'">
							<i class="fa fa-facebook"></i><?php echo $language_config[36]['lang_'.$curr_lang] ?>
						</button> -->
					</div>
					<!-- <div class="user-login-or"><span><?php echo $language_config[37]['lang_'.$curr_lang] ?></span></div> -->
					<div class="form-group">
						<label for="login-email">Email</label>
						<input type="text" id="login-email" name="email" required class="form-control" value="" placeholder="Email">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" id="password" required value="" name="password" class="form-control" placeholder="Password">
					</div>
					<div class="checkbox clearfix">
						<!-- <div class="form-flat-checkbox pull-left">
							<input type="checkbox" name="rememberme" id="rememberme" value="forever"><i></i>&nbsp;<?php echo $language_config[25]['lang_'.$curr_lang] ?>
						</div> -->
						<span class="lostpassword-modal-link pull-right">
							<a href="#lostpasswordModal" data-rel="lostpasswordModal"><?php echo $language_config[26]['lang_'.$curr_lang] ?></a>
						</span>
					</div>
				</div>
				<div class="modal-footer">
					<span class="user-login-modal-register pull-left">
						<a data-rel="registerModal" href="#"><?php echo $language_config[24]['lang_'.$curr_lang] ?></a>
					</span>
					<button type="submit" name="submit" value="submit" class="btn btn-default btn-outline"><?php echo $language_config[27]['lang_'.$curr_lang] ?></button>
				</div>
			</form>
		</div>
	</div>
</div>


<div class="modal fade user-register-modal" id="userregisterModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="userregisterModalForm" action="/<?php echo $curr_lang ?>/member-register" method="POST">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title"><?php echo $language_config[28]['lang_'.$curr_lang] ?></h4>
				</div>
				<div class="modal-body">
					<div class="user-login-facebook">
						<button class="btn-login-facebook" type="button" onclick="window.location.href='<?php echo htmlspecialchars($loginUrl) ?>'">
							<i class="fa fa-facebook"></i><?php echo $language_config[36]['lang_'.$curr_lang] ?>
						</button>
					</div>
					<div class="user-login-or"><span><?php echo $language_config[37]['lang_'.$curr_lang] ?></span></div>
					<div class="form-group">
						<label><?php echo $language_config[53]['lang_'.$curr_lang] ?></label>
						<input type="text" name="fullname" required class="form-control" value="" placeholder="Your fullname">
					</div>
					<div class="form-group">
						<label for="user_email">Email</label>
						<input type="email" id="user_email" name="email" required class="form-control" value="" placeholder="Email">
					</div>
					<div class="form-group">
						<label for="user_password"><?php echo $language_config[68]['lang_'.$curr_lang] ?></label>
						<input type="password" id="user_password" required value="" name="password1" class="form-control" placeholder="Password">
					</div>
					<div class="form-group">
						<label for="user_password"><?php echo $language_config[69]['lang_'.$curr_lang] ?></label>
						<input type="password" id="cuser_password" required value="" name="password2" class="form-control" placeholder="Retype password">
					</div>
				</div>
				<div class="modal-footer">
					<span class="user-login-modal-link pull-left">
						<a data-rel="loginModal" href="#loginModal"><?php echo $language_config[38]['lang_'.$curr_lang] ?></a>
					</span>
					<button type="submit" name="submit" value="submit" class="btn btn-default btn-outline"><?php echo $language_config[29]['lang_'.$curr_lang] ?></button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade user-lostpassword-modal" id="userlostpasswordModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="userlostpasswordModalForm" method="POST" action="/<?php echo $curr_lang ?>/member-lost-password">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title"><?php echo $pages_config[1]['title_'.$curr_lang] ?></h4>
					<p style="margin-top:20px;"><?php echo $pages_config[1]['description_'.$curr_lang] ?></p>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>E-mail:</label>
						<input type="text" name="email" required class="form-control" value="" placeholder="E-mail">
					</div>
				</div>
				<div class="modal-footer">
					<span class="user-login-modal-link pull-left">
						<a data-rel="loginModal" href="#loginModal">Already have an account?</a>
					</span>
					<button type="submit" class="btn btn-default btn-outline">Reset</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- MODAL FOR ADDRESS BOOK -->
<div class="modal fade addAddress-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="addAddressForm" method="POST" action="/<?php echo $curr_lang ?>/member-add_addressbook">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title"><?php echo $language_config[70]['lang_'.$curr_lang] ?></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label><?php echo $language_config[71]['lang_'.$curr_lang] ?>:</label>
						<input type="text" name="receiver_name" required class="form-control" value="">
					</div>
					<div class="form-group">
						<label><?php echo $language_config[55]['lang_'.$curr_lang] ?>:</label>
						<input type="text" name="phone_number" required class="form-control" value="">
					</div>
					<div class="form-group">
						<label><?php echo $language_config[59]['lang_'.$curr_lang] ?>:</label>
						<div class="form-flat-select">
							<select style="width:100%" id="country" name="country">
								<option>- Pilih Country -</option>
								<?php countrylist($data_member['country']); ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label><?php echo $language_config[60]['lang_'.$curr_lang] ?>:</label>
						<div class="form-flat-select">
							<select style="width:100%" name="propinsi" id="propinsi">
								<option>- Pilih Provinsi -</option>
								
							</select>
						</div>
					</div>
					<div class="form-group">
						<label><?php echo $language_config[61]['lang_'.$curr_lang] ?>:</label>
						<div class="form-flat-select">
							<select style="width:100%" name="kabupaten" id="kabupaten">
								<option>- Pilih Kabupaten -</option>
								
							</select>
						</div>
					</div>
					<div class="form-group">
						<label><?php echo $language_config[62]['lang_'.$curr_lang] ?>:</label>
						<div class="form-flat-select">
							<select style="width:100%" id="namakota" name="idkota">
								<option>- Pilih Kota -</option>
								
							</select>
						</div>
					</div>
					<div class="form-group">
						<label><?php echo $language_config[63]['lang_'.$curr_lang] ?>:</label>
						<input type="text" name="kodepos" required class="form-control" value="">
					</div>
					<div class="form-group">
						<label><?php echo $language_config[72]['lang_'.$curr_lang] ?>:</label>
						<textarea name="address" cols="40" rows="6" class="form-control textarea"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" name="submit" value="submit" class="btn btn-default btn-outline f-g8"><?php echo $language_config[73]['lang_'.$curr_lang] ?></button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade measurement-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editAddressForm">
                <div class="modal-body shop">
                	<?php
					$measurement_pages = global_select_single("pages","*","id = 3");
					echo $measurement_pages['description_'.$curr_lang];
					?>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade custombordir-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editAddressForm">
                <div class="modal-body shop">
                	<?php
					$custombordir_pages = global_select_single("pages","*","id = 4");
					echo $custombordir_pages['description_'.$curr_lang];
					?>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- TRACK ORDER & CONFIRM PAYMENT -->
<div class="modal fade trackOrder-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<script type="text/javascript">
		function isNumber(evt) {
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode > 31 && (charCode < 48 || charCode > 57)) {
				return false;
			}
			return true;
		}
	</script>
	<div class="modal-dialog">
		<div class="modal-content">
			
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title">Track Your Order</h4>
				</div>
				<div class="modal-body">
					<p style="text-align:center;">Type your Order ID below to view your order status.</p>
					<div class="form-group">
						<label for="track-order-id">Order ID</label>
						<input id="track_idorder" type="text" id="track-order-id" name="trackID" required class="form-control" value="" placeholder="Your Order ID" onkeypress="return isNumber(event)">
					</div>
				<div id="return_track"></div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="button_track" class="btn btn-default btn-outline f-g8">Submit</button>
				</div>
		</div>
	</div>
</div>
<div class="modal fade confirmPayment-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/<?php echo $curr_lang ?>/member-confirmpayment" method="POST" enctype="multipart/form-data">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title"><?php echo $language_config[11]['lang_'.$curr_lang] ?></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="confirm-bank-name"><?php echo $language_config[94]['lang_'.$curr_lang] ?></label>
						<input type="text" id="confirm-bank-name" name="nama_bank" required class="form-control">
					</div>
					<div class="form-group">
						<label for="confirm-bank-name">Rec no</label>
						<input type="text" id="confirm-bank-name" name="norek" required class="form-control">
					</div>
					<div class="form-group">
						<label for="confirm-amount"><?php echo $language_config[95]['lang_'.$curr_lang] ?></label>
						<input type="text" id="confirm-amount" name="nominal" required class="form-control">
					</div>
					<div class="form-group">
						<label for="confirm-bank-name"><?php echo $language_config[96]['lang_'.$curr_lang] ?></label>
						<input type="text" id="confirm-bank-name" name="transferke" required class="form-control">
					</div>
					<div class="form-group">
						<label for="confirm-proof"><?php echo $language_config[97]['lang_'.$curr_lang] ?></label>
						<input type="file" id="confirm-proof" name="confirmPayment" />
						<small><?php echo $language_config[98]['lang_'.$curr_lang] ?></small>
					</div>
					<div class="form-group">
						<label for="confirm-holder"><?php echo $language_config[99]['lang_'.$curr_lang] ?></label>
						<input type="text" id="confirm-holder" name="atas_nama" required class="form-control">
					</div>
					<div class="form-group">
						<label for="confirm-date"><?php echo $language_config[100]['lang_'.$curr_lang] ?></label>
						<input type="text" id="confirm-date" name="tanggal" required class="form-control" placeholder="DD/MM/YY">
					</div>
					<div class="form-group">
						<label for="confirm-orderid">Order ID</label>
						<input type="text" id="confirm-orderid" name="idorder" required class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" name="submit" value="submit" class="btn btn-default btn-outline f-g8">Confirm</button>
				</div>
			</form>
		</div>
	</div>
</div>