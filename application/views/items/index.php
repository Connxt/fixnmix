<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<?php include("/../_shared/css.php"); ?>
</head>
<body class="skin-green fixed">
	<div class="wrapper">
		<header class="main-header">
            <?php include("/../_shared/header.php"); ?>
        </header>
        <aside class="main-sidebar">
        	<?php include("/../_shared/sidebar.php"); ?>
        </aside>
		<div class="content-wrapper">
	        <section class="content">
	            <div class="row">
	                <div class="col-xs-12">
	                    <div class="box">
	                    	<div class="box-header with-border">
	                    		<h3 class="box-title"><i class="fa fa-th-list"></i>  Items List</h3>
			                	<div class="box-tools pull-right">
			                    	<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			                  	</div>
			                </div>
	                        <div class="box-body">
		                        <table id="items_table" class="table" cellspacing="0" width="100%">
		                          	<thead>
		                            	<tr>
			                                <th>Item ID</th>
			                                <th>Description</th>
			                                <th>Quantity</th>
			                                <th>Price</th>
		                              	</tr>
	                            	</thead>
	                        		<tbody>
	                        			
		                            </tbody>
		                        </table>
		                        <button type="button" class="btn btn-success pull-right" id="btn_new_item"><span class="glyphicon glyphicon-plus"></span> New Item</button>
		                        <button type="button" class="btn btn-danger" id="btn_delete_item"><span class="fa fa-trash-o"></span></button>
		                        <button type="button" class="btn btn-primary" id="btn_update_item"><span class="fa fa-pencil"></span></button>
		                        <button type="button" class="btn btn-info" id="btn_view_item"><span class="glyphicon glyphicon-eye-open"></span></button>
	                        	<div class="btn-group dropup">
									<button type="button" class="btn btn-warning dropdown-toggle" id="btn_choose_quantity_action" data-toggle="dropdown" aria-expanded="false">Quantity <span class="caret"></span></button>
							  		<ul class="dropdown-menu" role="menu">
							    		<li><a id="add_quantity">Add</a></li>
							    		<li><a id="deduct_quantity">Deduct</a></li>
							  		</ul>
								</div>
								<button type="button" class="btn btn-default" id="btn_refresh_item"><span class="glyphicon glyphicon-refresh"></span></button>
	                        </div><!-- /.box-body -->
	                    </div><!-- /.box -->
	                </div><!-- /.col -->
	            </div><!-- /.row -->
	        </section><!-- /.content -->
	    </div><!-- /.content-wrapper -->
	</div><!-- ./wrapper -->
	<!-- Modal New Item -->
	<div class="modal fade" id="new_item_modal" tabindex="-1" role="dialog" aria-labelledby="new_item_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-sm">
	    	<div class="modal-content">
	    		<form id="frm_new_item" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="new_item_modal_label">Add Item</h4>
			      	</div>
			      	<div class="col-lg-12" >
				      	<div id="message"><h5 style='color:#3C8DBC;'>Note: You can't change the item ID later.</h5></div>
				    </div>
			      	<div class="modal-body">
			        	<div class="row">
	                        <div class="col-lg-6">
	                            <div class="form-group">
	                                <label for="item_id_new">Item ID*</label>
	                                <input name="item_id_new" id="item_id_new" type="text" class="form-control" />
	                                <div id="item_id_new_error" class="error-alert"></div>
	                            </div>
	                        </div>
	                        <div class="col-lg-6">
	                            <div class="form-group">
	                                <label for="price_new">Price*</label>
	                                <input name="price_new" id="price_new" type="number" class="form-control" />
	                                <div id="price_new_error" class="error-alert"></div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row">
	                    	<div class="col-lg-12">
		                    	<div class="form-group">
	                                <label for="description_new">Description*</label>
	                                <input name="description_new" id="description_new" type="text" class="form-control" />
	                                <div id="description_new_error" class="error-alert"></div>
	                            </div>
	                        </div>
	                    </div>
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        	<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Save</button>
			      	</div>
			    </form>
	    	</div>
	  	</div>
	</div>
	<div class="modal fade" id="update_item_modal" tabindex="-1" role="dialog" aria-labelledby="update_item_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-sm">
	    	<div class="modal-content">
	    		<form id="frm_update_item" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="update_item_modal_label">Update Item</h4>
			      	</div>
			      	<div class="modal-body">
			        	<div class="row">
	                        <div class="col-lg-0">
	                            <div class="form-group" style="display:none;">
	                                <label for="item_id_update">Item ID*</label>
	                                <input name="item_id_update" id="item_id_update" type="text" class="form-control" />
	                                <div id="item_id_update_error" class="error-alert"></div>
	                            </div>
	                        </div>
	                        <div class="col-lg-6">
	                            <div class="form-group">
	                                <label for="price_update">Price*</label>
	                                <input name="price_update" id="price_update" type="text" class="form-control" />
	                                <div id="price_update_error" class="error-alert"></div>
	                            </div>
	                        </div>
	                        <div class="col-lg-6">
		                    	<div class="form-group">
	                                <label for="description_update">Description*</label>
	                                <input name="description_update" id="description_update" type="text" class="form-control" />
	                                <div id="description_update_error" class="error-alert"></div>
	                            </div>
	                        </div>
	                    </div>
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        	<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Update</button>
			      	</div>
			    </form>
	    	</div>
	  	</div>
	</div>
	<div class="modal fade" id="add_quantity_modal" tabindex="-1" role="dialog" aria-labelledby="add_quantity_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-xs">
	    	<div class="modal-content">
	    		<form id="frm_add_quantity" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="add_quantity_modal_label">Add Quantity</h4>
			      	</div>
			      	</br>
			      	<div class="col-lg-12">
			      		<div>Item ID: <strong><span id="item_id_add_quantity">1239</span></strong></div>
			      	</div>
			      	<br>
			      	<div class="modal-body">
			        	<div class="row">
	                        <div class="col-lg-12">
	                            <div class="form-group">
	                                <!-- <label for="quantity_add">Quantity*</label> -->
	                                <input name="quantity_add" id="quantity_add" type="number" class="form-control" />
	                                <div id="quantity_add_error" class="error-alert"></div>
	                            </div>
	                        </div>
	                    </div>
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        	<button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-plus"></span> Add</button>
			      	</div>
			    </form>
	    	</div>
	  	</div>
	</div>
	<div class="modal fade" id="deduct_quantity_modal" tabindex="-1" role="dialog" aria-labelledby="deduct_quantity_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-xs">
	    	<div class="modal-content">
	    		<form id="frm_deduct_quantity" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="deduct_quantity_modal_label">Deduct Quantity</h4>
			      	</div>
			      	<br>
			      	<div class="col-lg-12">
			      		<div>Item ID: <strong><span id="item_id_deduct_quantity">1239</span></strong></div>
			      	</div>
			      	<br>
			      	<div class="modal-body">
			        	<div class="row">
	                        <div class="col-lg-12">
	                            <div class="form-group">
	                                <input name="quantity_deduct" id="quantity_deduct" type="number" class="form-control" />
	                                <div id="quantity_deduct_error" class="error-alert"></div>
	                            </div>
	                        </div>
	                    </div>
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        	<button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-minus"></span> Deduct</button>
			      	</div>
			    </form>
	    	</div>
	  	</div>
	</div>
	<div class="modal fade" id="view_item_modal" tabindex="-1" role="dialog" aria-labelledby="view_item_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-sm">
	    	<div class="modal-content">
	    		<form id="frm_view_item" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="view_item_modal_label">View Item</h4>
			      	</div>
			      	<div class="modal-body">
			        	<div class="row">
	                        <div class="col-lg-12">
	                            <table>
	                                <tr>
	                                	<div class="col-lg-12">
		                                    <td style="text-align: right; font-weight: bold; padding-bottom: 1em;">Item ID</td>
		                                    <td id="item_id_view" style="padding-left: 1em; padding-bottom: 1em;"></td>
		                                </div>
	                                </tr>
	                                <tr>
	                                	<div class="col-lg-12">
		                                    <td style="text-align: right; font-weight: bold; padding-bottom: 1em;">Description</td>
		                                    <td id="description_view" style="padding-left: 1em; padding-bottom: 1em;"></td>
		                                </div>
	                                </tr>
	                                <tr>
	                                	<div class="col-lg-12">
		                                    <td style="text-align: right; font-weight: bold; padding-bottom: 1em;">Quantity</td>
		                                    <td id="quantity_view" style="padding-left: 1em; padding-bottom: 1em;"></td>
		                                </div>
	                                </tr>
	                                <tr>
	                                	<div class="col-lg-12">
		                                    <td style="text-align: right; font-weight: bold; padding-bottom: 1em;">Price</td>
		                                    <td id="price_view" style="padding-left: 1em; padding-bottom: 1em;"></td>
		                                </div>
	                                </tr>
	                            </table>
	                        </div>
	                    </div>
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      	</div>
			    </form>
	    	</div>
	  	</div>
	</div>
	<?php include("/../_shared/js.php"); ?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/app/<?php echo $current_page; ?>.js"></script>
	<script type="text/javascript">Items.run();</script>
</body>
</html>