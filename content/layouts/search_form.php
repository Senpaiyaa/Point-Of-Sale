
	<div class="row" id="manage_buttons" style="max-width: 1300px; margin: 0 auto;">	
			<form class="search_form" autocomplete="off" method="get" accept-charset="utf-8">
				<div class="pull-left">
					<div id="custom-search-input">
						<ul class="list-inline">
							<li>
								<!-- <div class="row"> -->
									<div class="input-group">
										<input type="text" class="form-control input-md" placeholder="Search for..." name="item">
									</div>	
								<!-- </div> -->
							</li>
							<li>
								<!-- Search options -->
								<div class="input-group">
									<label for="fields">More options:</label>
									<select id="fields" class="form-control" name="fields">
										<option selected>All</option>
										<!-- <option>Item ID</option> -->
										<!-- <option>Receiver</option> -->
										<!-- <option>Item</option> -->
										<?php
											// require_once 'class/Item.php';
											// require_once 'class/Functions.php';
											// $item_db = new Item();
											// $item = $item_db->find_all_fields();

											// foreach ($item as $column) {
											// 	$option = $column;
											// }
											// echo $option;

										?>
									</select>					
								</div>


								<!-- <div class="row"> -->
									<!-- <div class="form-group col-lg-12"> -->
									<!-- </div>  -->
								<!-- </div>			 -->
							</li>
							<li>
								<div class="input-group">
									<label for="cat">Category:</label>
									<select id="category" class="form-control" name="category">
										<option selected>All</option>
										<?php
											require_once 'class/Stocks.php';
											$stocks_db = new Stocks();
											$stocks = $stocks_db->option_category();
											$option = "";
											foreach ($stocks as $category) {
												$stocks_category = $category["category_name"];
												$option .= '<option>' . $stocks_category . '</option>';
											}
											echo $option;
										?>
									</select>										
								</div>
							</li>
							<li>
								<div class="input-group">
									<button class="btn btn-primary btn-md" type="submit" name="search" value="Search">Search</button>
								</div>
							</li>
							<li>
							</li>
						</ul>
					</div>		
				</div>
			</form>
		<div class="pull-right" style="margin-top: 25px;">
			<div class="dropdown">
				<button class="btn btn-primary btn-md" data-toggle="modal" data-target="#new-item" title="New Item">New Item</button>
				<button type="button" class="btn btn-more dropdown-toggle btn-sm" data-toggle="dropdown">
					<i class="glyphicon glyphicon-option-horizontal"></i>
				</button>				
				<ul class="dropdown-menu" role="menu">						
					<li>
						<a href="#" class="" title="Manage categories"><span class="">Manage categories</span></a>
					</li>
													
					<li>
						<a href="#" class="" title="Manage tags"><span class="">Manage tags</span></a>
					</li>
																	
					<li>
						<a href="#" class="" title="Manage Manufacturers"><span class="">Manage Manufacturers</span></a>
					</li>
															
					<li>
						<a href="#" class="" title="Count inventory"><span class="">Count inventory</span></a>
					</li>			

					<li>
						<a href="#" id="cleanup" class="" title="Cleanup Old Items"><span class="">Cleanup Old Items</span></a>
					</li>	
				</ul>
			</div>
		</div>
		<?php require_once 'new_item.php'; ?>
	</div>
