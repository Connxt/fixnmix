<!DOCTYPE html>
<html>
<head>
	<title>Item Distribution</title>
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
	                    		<h3 class="box-title"><i class="fa fa-share"></i> Deliver Items</h3>
			                	<div class="box-tools pull-right">
			                    	<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			                  	</div>
			                </div>
	                        <div class="box-body">
	                        	<div role="tabpanel">
		                        	<div class="nav-tabs-custom">
								  		<ul class="nav nav-tabs" role="tablist">
										    <li role="presentation"><a href="#delivery_logs" aria-controls="delivery_logs" role="tab" data-toggle="tab">Delivery Logs</a></li>
										    <li role="presentation" class="active"><a href="#deliver_items" aria-controls="deliver_items" role="tab" data-toggle="tab">Deliver Items</a></li>
								  		</ul>
								  		<div class="tab-content">
								    		<div role="tabpanel-delivery-logs" class="tab-pane" id="delivery_logs">
								    			<br>
								    			<table id="delivery_logs_table" class="table" cellspacing="0" width="100%">
						                          	<thead>
						                            	<tr>
							                                <th>Delivery ID</th>
							                                <th>Branch</th>
							                                <th>Date</th>
							                                <th>Status</th>
						                              	</tr>
					                            	</thead>
					                        		<tbody>
						                            </tbody>
						                        </table>
						                        <button type="button" class="btn btn-primary" id="btn_generate_file"><i class="fa fa-file"></i> Generate File</button>
						                        <button type="button" class="btn btn-info" id="btn_view_delivered_logs"><span class="glyphicon glyphicon-eye-open"></span></button>
						                        <button type="button" class="btn btn-primary" id="btn_print_item_delivered"><span class="glyphicon glyphicon-print"></span></button>
			                        			<button type="button" class="btn btn-default" id="btn_refresh_delivered_logs"><span class="glyphicon glyphicon-refresh"></span></button>
								    		</div>
								    		<div role="tabpanel-deliver-items" class="tab-pane active" id="deliver_items">
								    			<br>
								    			<div class="pull-left" style="width:23%;">
											        <select data-placeholder="Select Branch" class="chosen-select" id="select_branch"multiple tabindex="6">
											            <!-- option here loaded using jquery -->
											        </select>
										        </div>
										        &nbsp;
										        <button type="button" class="btn btn-default" id="btn_select_items" ><i class="fa fa-search"></i> Search Items</button>
								    			<table id="deliver_items_table" class="table" cellspacing="0" width="100%">
						                          	<thead>
						                            	<tr>
							                                <th>Item ID</th>
							                                <th>Description</th>
							                                <th>Quantity</th>
						                              	</tr>
					                            	</thead>
					                        		<tbody>
						                            </tbody>
						                        </table>
						                        <button type="button" class="btn btn-primary" id="btn_deliver_selected_items"><span class="glyphicon glyphicon-save"></span> Deliver</button>
						                        <button type="button" class="btn btn-default" id="btn_delete_selected_items"><span class="glyphicon glyphicon-trash"></span></button>
								    		</div>
								  		</div>
									</div>
								</div>
	                        </div><!-- /.box-body -->
	                    </div><!-- /.box -->
	                </div><!-- /.col -->
	            </div><!-- /.row -->
	        </section><!-- /.content -->
	    </div><!-- /.content-wrapper -->
	</div><!-- ./wrapper -->

	<div class="modal fade" id="delivery_information_modal" tabindex="-1" role="dialog" aria-labelledby="view_item_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-md">
	    	<div class="modal-content">
	    		<form id="" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="view_item_modal_label">Delivery Information</h4>
			      	</div>
			      	<div class="modal-body">
			        	<div class="row">
	                        <div class="col-lg-8" >
	                            <label for="show_delivery_id">Delivery ID :</label>
	                            <span id="show_delivery_id"></span> 
	                        </div>
	                        <div class="col-lg-4">
	                             <label for="show_delivery_date">Date : </label>
	                             <span id="show_delivery_date"></span> 
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-lg-12">
	                             <label for="show_branch_delivered">Branch : </label>
	                             <span id="show_branch_delivered"></span> 
	                        </div>
	                    </div>
	                    <br>
				  		<table id="delivery_list" class="table" cellspacing="0" width="100%">
                          	<thead> 
                            	<tr>
	                                <th>Item ID</th>
	                                <th>Description</th>
	                                <th>Quantity</th>
	                           	</tr>
                        	</thead>
                    		<tbody>
                            </tbody>
                        </table>
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      	</div>
			    </form>
	    	</div>
	  	</div>
	</div>
	<div class="modal fade" id="select_items_modal_distribution" tabindex="-1" role="dialog" aria-labelledby="select_items_modal_distribution_label" aria-hidden="true">
	  	<div class="modal-dialog modal-md">
	    	<div class="modal-content">
	    		<form id="frm_select_items_distribution" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="select_items_modal_distribution_label">Select Items</h4>
			      	</div>
			      	<div class="modal-body">
			        	<div class="row">
	                        <div class="col-lg-12" >
	                        	<table id="select_items_distribution_table" class="table display" cellspacing="0" width="100%">
		                          	<thead> 
		                            	<tr>
			                                <th>Item ID</th>
			                                <th>Description</th>
			                           	</tr>
	                            	</thead>
	                        		<tbody>
		                            </tbody>
		                        </table>
	                        </div>
	                    </div>
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        	<button type="button" id="btn_add_selected_items" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add</button>
			      	</div>
			    </form>
	    	</div>
	  	</div>
	</div>

	<div class="modal fade" id="delivery_status_modal" tabindex="-1" role="dialog" aria-labelledby="delivery_status_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-sm">
	    	<div class="modal-content">
	    		<form id="frm_delivery_status" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="delivery_status_modal_label">File Export Status</h4>
			      	</div>
			      	<div class="col-lg-12" >
				      	<div id="delivery_status_message"></div>
				    </div>
			      	<div class="modal-body">
			        	<div class="row">
	                        <div class="col-lg-12">
	                        	<table id="delivery_status_table" class="table display" cellspacing="0" width="100%">
		                          	<thead> 
		                            	<tr>
			                                <th>Branch Id</th>
			                                <th>Status</th>
			                           	</tr>
	                            	</thead>
	                        		<tbody>
		                            </tbody>
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

	<div class="modal fade" id="print_delivered_items_modal" tabindex="-1" role="dialog" aria-labelledby="print_delivered_items_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-md">
	    	<div class="modal-content">
	    		<form id="frm_print_delivered_items" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="print_delivered_items_modal_label">Print Delivered Items</h4>
			      	</div>
			      	<div class="modal-body">
			        	<div class="row">
	                        <div class="col-lg-12">
	                        	 <iframe id="frm_print_deliveries" style="width:100%; height:430px;"></iframe>
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
	<script type="text/javascript">ItemDistribution.run();</script>
</body>
</html>