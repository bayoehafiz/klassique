<div class="offcanvas open">
			<div class="offcanvas-wrap">
				<div class="offcanvas-user clearfix" style="margin-bottom:0;">
					<a class="offcanvas-user-account-link f-g8" href="" data-rel="loginModal">
						<i class="fa fa-user"></i> Login
					</a>
				</div>
                <div class="mobile-lang">
                	<a href="/en/<?php echo $curr_page ?>" class="active f-g8"><img src="<?php echo $SITE_URL?>images/en.png" alt="English" />&nbsp;&nbsp;EN</a>
                    <a href="/id/<?php echo $curr_page ?>" style="border-left:1px solid #ccc;"><img src="<?php echo $SITE_URL?>images/id.png" alt="Bahasa Indonesia" />&nbsp;&nbsp;ID</a>
                </div><!-- .mobile-lang -->
				<nav class="offcanvas-navbar">
					<ul class="offcanvas-nav">
						<li><a href="/<?php echo $curr_lang ?>/index">Home</a></li>
                        <li><a href="/<?php echo $curr_lang ?>/about">About Us</a></li>
						<li class="menu-item-has-children dropdown">
							<a href="product-list.php" class="dropdown-hover">Shop <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<?php 
								/*categories*/
								$product_category_for_head = global_select("product_category","*","publish = 1"); 
								if($product_category_for_head){ foreach ($product_category_for_head as $key_category_head => $value_category_head) {
									echo'<li><a href="/'.$curr_lang.'/product-list">'.$value_category_head['title'].'</a></li>';
								}}?>
							</ul>
						</li>
						<li><a href="/<?php echo $curr_lang ?>/news">News</a></li>
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-hover">Help <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="/<?php echo $curr_lang ?>/contact"><?php echo $language_config[9]['lang_'.$curr_lang] ?></a></li>
								<li><a href="/<?php echo $curr_lang ?>/faq"><?php echo $language_config[10]['lang_'.$curr_lang] ?></a></li>
								<li><a href="/<?php echo $curr_lang ?>/testimonial">Testimonial</a></li>
								<li><a href="/<?php echo $curr_lang ?>/how-to-buy"><?php echo $language_config[39]['lang_'.$curr_lang] ?></a></li>
								<li><a href="/<?php echo $curr_lang ?>/custom-order"><?php echo $language_config[18]['lang_'.$curr_lang] ?></a></li>
								<li><a href="/<?php echo $curr_lang ?>/measurement-guide"><?php echo $language_config[67]['lang_'.$curr_lang] ?></a></li>
								<li><a href="/<?php echo $curr_lang ?>/return-policy"><?php echo $language_config[13]['lang_'.$curr_lang] ?></a></li>
								<li><a href="/<?php echo $curr_lang ?>/privacy-policy"><?php echo $language_config[7]['lang_'.$curr_lang] ?></a></li>
								<li><a href="/<?php echo $curr_lang ?>/terms-and-conditions"><?php echo $language_config[8]['lang_'.$curr_lang] ?></a></li>
							</ul>
						</li>
					</ul>
				</nav>
				<div class="offcanvas-widget">
					<div class="widget social-widget">
						<div class="social-widget-wrap social-widget-none">
							<a href="<?php echo $facebook_config ?>" title="Facebook" target="_blank">
								<i class="fa fa-facebook"></i>
							</a>
							<a href="<?php echo $twitter_config ?>" title="Twitter" target="_blank">
								<i class="fa fa-twitter"></i>
							</a>
							<a href="<?php echo $linkedin_config ?>" title="Linkedin" target="_blank">
								<i class="fa fa-linkedin"></i>
							</a>
							<a href="<?php echo $instagram_config ?>" title="Instagram" target="_blank">
								<i class="fa fa-instagram"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>