<header class="header-type-classic header-absolute header-transparent">
				<div class="topbar">
					<div class="container topbar-wap">
						<div class="row">
							<div class="col-sm-6">
								<div class="left-topbar">
									<div class="topbar-social">
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
							<div class="col-sm-6">
								<div class="right-topbar">
									<div class="user-login">
										<ul class="nav top-nav">
											
												<?php 
												if(isset($_SESSION['token_login'])){
													echo'<li class="menu-item" style="width:120px; float:right"><a href="/'.$curr_lang.'/logout"><i class="fa fa-user"></i> Log out</a></li>';
													echo'<li class="menu-item" style="width:120px; float:right"><a href="/'.$curr_lang.'/edit-profile"><i class="fa fa-user"></i> My Profile</a></li>';
												}else{
													echo'<li class="menu-item"><a data-rel="loginModal" href="#"><i class="fa fa-user"></i> Login</a></li>';
												}
												?>
										</ul>
									</div>
									<div class="language-switcher">
										<div class="wpml-languages disabled">
											<a class="active dropdown-hover" href="#" data-toggle="dropdown">
												<img src="<?php echo $workdir ?>images/<?php echo $curr_lang ?>.png" alt="English"/> <?php echo strtoupper($curr_lang) ?>
											</a>
											<ul class="dropdown-menu f-g6">
												<li><a href="/en/<?php echo $curr_page ?>" <?php if($curr_lang == 'en'){ echo 'class="lang-active"'; }?>>English</a></li>
												<li><a href="/id/<?php echo $curr_page ?>" <?php if($curr_lang == 'id'){ echo 'class="lang-active"'; }?>>Bahasa Indonesia</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="navbar-container">
					<div class="navbar navbar-default  navbar-scroll-fixed">
						<div class="navbar-default-wrap">
							<div class="container">
								<div class="row">
									<div class="col-md-12 navbar-default-col">
										<div class="navbar-wrap">
											<div class="navbar-header">
												<button type="button" class="navbar-toggle">
													<span class="sr-only">Toggle navigation</span>
													<span class="icon-bar bar-top"></span>
													<span class="icon-bar bar-middle"></span>
													<span class="icon-bar bar-bottom"></span>
												</button>
												<a class="navbar-search-button search-icon-mobile" href="#">
													<i class="fa fa-search"></i>
												</a>
												<a class="cart-icon-mobile" href="#">
													<?php 
													if(isset($_SESSION['token_shopcart'])){
														$jumlah_item = total_item($_SESSION['token_shopcart']);
													}else{
														$jumlah_item = 0;
													}
													?>
													<i class="elegant_icon_bag" class="totalitem"></i><span><?php echo $jumlah_item ?></span>
												</a>
												<a class="navbar-brand" href="./">
													<img class="logo" alt="Klassique" src="<?php echo $workdir ?>images/klassique/klassique-logo.png">
													<img class="logo-fixed" alt="Klassique" src="<?php echo $workdir ?>images/klassique/klassique-logo.png">
													<img class="logo-mobile" alt="Klassique" src="<?php echo $workdir ?>images/klassique/klassique-logo-s.png">
												</a>
											</div>
											<nav class="collapse navbar-collapse primary-navbar-collapse">
												<ul class="nav navbar-nav primary-nav f-g8">
													<li><a href="/<?php echo $curr_lang ?>/index"><span class="underline"><?php echo $language_config[16]['lang_'.$curr_lang] ?></span></a></li>
													<li><a href="/<?php echo $curr_lang ?>/about"><span class="underline"><?php echo $language_config[4]['lang_'.$curr_lang] ?></span></a></li>
													<li class="menu-item-has-children dropdown">
														<a href="#" class="dropdown-hover"><span class="underline"><?php echo $language_config[5]['lang_'.$curr_lang] ?></span> <span class="caret"></span></a>
														<ul class="dropdown-menu f-g6">
															<?php 
															/*categories*/
															$product_category_for_head = global_select("product_category","*","publish = 1"); 
															if($product_category_for_head){ foreach ($product_category_for_head as $key_category_head => $value_category_head) {
																echo'<li><a href="/'.$curr_lang.'/product-list?view=filter&category='.$value_category_head['urlpage'].'&halaman=1#sorting">'.$value_category_head['title'].'</a></li>';
															}}?>
														</ul>
													</li>
													<li><a href="/<?php echo $curr_lang ?>/news"><span class="underline"><?php echo $language_config[6]['lang_'.$curr_lang] ?></span></a></li>
													<li class="menu-item-has-children dropdown">
														<a href="#" class="dropdown-hover"><span class="underline"><?php echo $language_config[17]['lang_'.$curr_lang] ?></span> <span class="caret"></span></a>
														<ul class="dropdown-menu f-g6">
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
													<li class="navbar-search">
														<a class="navbar-search-button" href="#">
															<i class="fa fa-search"></i>
														</a>
													</li>
													<?php 
													if(isset($_SESSION['token_shopcart'])){
														$jumlah_item = total_item($_SESSION['token_shopcart']);
													}else{
														$jumlah_item = 0;
													}
													?>
													<li class="navbar-minicart navbar-minicart-nav">
														<a class="minicart-link" href="/<?php echo $curr_lang ?>/cart">
															<span class="minicart-icon">
																<i class="minicart-icon-svg elegant_icon_bag"></i>
																<span class="totalitem"><?php echo $jumlah_item; ?></span>
															</span>
														</a>
														<?php 
															if($jumlah_item==0){
																echo'
																<div class="minicart">
																	<div class="minicart-header no-items show">
																		'.$language_config[20]['lang_'.$curr_lang].'
																	</div>
																	<div class="minicart-footer">
																		<div class="minicart-actions clearfix">
																			<a class="button" href="#">
																				<span class="text">'.$language_config[21]['lang_'.$curr_lang].'</span>
																			</a>
																		</div>
																	</div>
																</div>';
															}?>
													</li>
												</ul>
											</nav>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="header-search-overlay hide">
							<div class="container">
								<div class="header-search-overlay-wrap">
									<form action="/<?php echo $curr_lang ?>/product-list" method="POST" class="searchform">
										<input type="search" class="searchinput" name="keyword" value="" placeholder="Search..."/>
										<input type="submit" class="searchsubmit hidden" name="submit" value="Search"/>
									</form>
									<button type="button" class="close">
										<span aria-hidden="true" class="fa fa-times"></span>
										<span class="sr-only">Close</span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>