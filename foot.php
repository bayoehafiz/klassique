<div class="footer-widget">
	<div class="container">
		<div class="footer-widget-wrap">
			<div class="row">
				<div class="footer-widget-col col-md-2 col-sm-4">
					<div class="widget widget_nav_menu">
						<h3 class="widget-title f-g8"><span><?php echo $language_config[1]['lang_'.$curr_lang] ?></span></h3>
						<ul class="menu">
							<li><a href="/<?php echo $curr_lang ?>/about"><?php echo $language_config[4]['lang_'.$curr_lang] ?></a></li>
							<li><a href="/<?php echo $curr_lang ?>/product-list"><?php echo $language_config[5]['lang_'.$curr_lang] ?></a></li>
							<li><a href="/<?php echo $curr_lang ?>/news"><?php echo $language_config[6]['lang_'.$curr_lang] ?></a></li>
							<li><a href="/<?php echo $curr_lang ?>/testimonial">Testimonial</a></li>
							<li><a href="/<?php echo $curr_lang ?>/privacy-policy"><?php echo $language_config[7]['lang_'.$curr_lang] ?></a></li>
							<!-- <li><a href="/<?php echo $curr_lang ?>/return-policy"><?php echo $language_config[13]['lang_'.$curr_lang] ?></a></li> -->
							<li><a href="/<?php echo $curr_lang ?>/terms-and-conditions"><?php echo $language_config[8]['lang_'.$curr_lang] ?></a></li>
						</ul>
					</div>
				</div>
				<div class="footer-widget-col col-md-2 col-sm-4">
					<div class="widget widget_nav_menu">
						<h3 class="widget-title f-g8"><span><?php echo $language_config[2]['lang_'.$curr_lang] ?></span></h3>
						<ul class="menu">
							<li><a href="/<?php echo $curr_lang ?>/contact"><?php echo $language_config[9]['lang_'.$curr_lang] ?></a></li>
							<li><a href="/<?php echo $curr_lang ?>/faq"><?php echo $language_config[10]['lang_'.$curr_lang] ?></a></li>
							<li><a href="#" data-rel="confirmPaymentModal"><?php echo $language_config[11]['lang_'.$curr_lang] ?></a></li>
							<li><a href="#" data-rel="trackOrderModal"><?php echo $language_config[12]['lang_'.$curr_lang] ?></a></li>
							<!-- <li><a href="/<?php echo $curr_lang ?>/return-policy"><?php echo $language_config[13]['lang_'.$curr_lang] ?></a></li> -->
							
						</ul>
					</div>
				</div>
				<div class="footer-widget-col col-md-4 col-sm-4 col-xs-8">
					<div class="widget widget_nav_menu">
						<h3 class="widget-title f-g8"><span><?php echo $language_config[3]['lang_'.$curr_lang] ?></span></h3>
						<form class="newsletter-form" method="POST" action="/<?php echo $curr_lang ?>/email_subscribe" id="email_subscribe">
							<div>
								<label class="f-g6"><?php echo $language_config[33]['lang_'.$curr_lang] ?></label>
								<p class="form-control-wrap" style="margin-bottom:10px;">
									<input type="email" name="email" class="form-control text validates-as-required" size="40" value="" name="your-email">
								</p>
							</div>
							<input type="submit" name="submit" value="submit" class="form-control submit f-g8" value="<?php echo $language_config[15]['lang_'.$curr_lang] ?>">
						</form>
					</div>
				</div>
				<div class="footer-widget-col col-md-4 col-sm-12 col-xs-12">
					<div class="widget widget_text">
						<h3 class="widget-title f-g8"><span><?php echo $language_config[14]['lang_'.$curr_lang] ?></span></h3>
						<div class="textwidget">
							<p><i class="fa fa-map-marker"></i> 1 Pasar Baru Selatan, Jakarta Pusat 10710, Indonesia</p>
							<p><i class="fa fa-phone"></i> +6221 345 7403</p>
							<p><i class="fa fa-fax"></i> +6221 385 8250</p>
							<p>
								<i class="fa fa-envelope"></i> <a href="mailto:info@klassiqueuniform.com">info@klassiqueuniform.com</a>
							</p>
							<p class="payment"><img src="<?php echo $workdir ?>images/footer-payment-color.png" alt=""></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<footer id="footer" class="footer">
	<div class="footer-info">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="footer-info-logo">
						<a href="#"><img alt="Klassique" src="<?php echo $workdir ?>images/klassique/klassique-logo-s.png" style="width:170px;"></a>
					</div>
					<div class="copyright text-center">Copyright right &copy; 2016 Klassique Uniform. All Rights Reserved.</div>
					<div class="footer-social">
						<a href="<?php echo $facebook_config ?>" title="Facebook" target="_blank">
							<i class="fa fa-facebook facebook-bg-hover"></i>
						</a>
						<a href="<?php echo $twitter_config ?>" title="Twitter" target="_blank">
							<i class="fa fa-twitter twitter-bg-hover"></i>
						</a>
						<a href="<?php echo $linkedin_config ?>" title="Linkedin" target="_blank">
							<i class="fa fa-linkedin linkedin-bg-hover"></i>
						</a>
						<a href="<?php echo $instagram_config ?>" title="Instagram" target="_blank">
							<i class="fa fa-instagram instagram-bg-hover"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>