<?php
$data_status = select_custom("SELECT * FROM `status_detailorder` GROUP BY `idorder`");
if($data_status){ foreach ($data_status['row'] as $key => $value) {?>
		<div class="modal fade statusDetail-modal-<?php echo $value['idorder'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<form id="editAddressForm">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">
								<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
							</button>
							<h4 class="modal-title">Order #<?php echo $orderid ?></h4>
						</div>
						<div class="modal-body shop">
							<table class="table shop_table cart">
								<thead>
									<tr>
										<th class="product-name" style="padding-left:15px;">Last Status</th>
									</tr>
								</thead>
								<tbody>

									<?php 
									$list_status = global_select("status_detailorder","*","idorder = $value[idorder]");
									foreach ($list_status as $key => $value) {
									echo'
									<tr>
										<td class="f-g6" style="padding-left:15px;">
											<strong class="f-g8">'.$value['date'].'</strong><br>
											'.$value['description'].'
										</td>
									</tr>';
									}
									?>
								</tbody>
							</table>
						</div>
						<div class="modal-footer">
							<a href="" data-rel="orderDetailModal" id="<?php echo $value['idorder'] ?>" class="btn btn-default btn-outline">View Order Detail</a>
						</div> 
					</form>
				</div>
			</div>
		</div>
<?php }}?>