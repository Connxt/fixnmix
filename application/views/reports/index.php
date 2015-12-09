<!DOCTYPE html>
<html>
<head>
	<title>Reports</title>
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
	                    		<h3 class="box-title"><i class="fa fa-bar-chart"></i> Reports</h3>
			                	<div class="box-tools pull-right">
			                    	<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			                    </div>
			                </div>
	                        <div class="box-body">
		                        <div role="tabpanel">
							  		<ul class="nav nav-tabs" role="tablist">
									    <li role="presentation" class="active"><a href="#sales_report" aria-controls="sales_report" role="tab" data-toggle="tab">Sales</a></li>
									    <li role="presentation"><a href="#top_selling_branch_report" aria-controls="top_selling_branch_report" role="tab" data-toggle="tab">Top Selling Branch</a></li>
									    <li role="presentation"><a href="#item_returns_report" aria-controls="item_returns_report" role="tab" data-toggle="tab">Item Returns</a></li>
									</ul>
							  		<div class="tab-content">
							    		<div role="tabpanel-sales-report" class="tab-pane active" id="sales_report">
							    			<br>
							    			<table id="branches_table" class="table" cellspacing="0" width="100%">
							    				<thead>
					                            	<tr>
					                            		<th>Branch ID</th>
						                                <th>Description</th>
						                            </tr>
					                            </thead>
				                        		<tbody>
					                            </tbody>
							    			</table>
							    		</div>
							    		<div role="tabpanel-top-selling-branch-report" class="tab-pane" id="top_selling_branch_report">
							    			<br>
							    			<table id="per_branch_sales_report_table" class="table" cellspacing="0" width="100%">
							    				<thead>
					                            	<tr>
						                                <th>ID</th>
						                                <th>Branch ID</th>
						                                <th>Total Amount</th>
						                                <th>Sales</th>
						                              	<th>Date</th>
					                              	</tr>
					                            </thead>
				                        		<tbody>
					                            </tbody>
							    			</table>
							    		</div>
							    		<div role="tabpanel-item-returns-report" class="tab-pane" id="item_returns_report">
							    			<br>
							    			<table id="" class="table" cellspacing="0" width="100%">
							    				<thead>
					                            	<tr>
						                                <th>ID</th>
						                                <th>Branch ID</th>
						                                <th>Total Amount</th>
						                                <th>Sales</th>
						                              	<th>Date</th>
					                              	</tr>
					                            </thead>
				                        		<tbody>
					                            </tbody>
							    			</table>
							    		</div>
							    		<button type="button" class="btn btn-primary" id="btn_import_reports"><i class="fa fa-reply-all"></i> Import Report</button>
							    		<button type="button" class="btn btn-info" id="btn_view_branch_sales"><span class="glyphicon glyphicon-eye-open"></span></button>
							    	</div>
								</div>
	                        </div><!-- /.box-body -->
	                    </div><!-- /.box -->
	                </div><!-- /.col -->
	            </div><!-- /.row -->
	            <div class="row">
	            	<div class="col-xs-12">
	            		<input type="file" id="input_import_report_file_dialog" name="files" title="Load File"  accept = ".json" style="display:none;" />
	            	</div>
	            </div>
	        </section><!-- /.content -->
	    </div><!-- /.content-wrapper -->
	</div><!-- ./wrapper -->

	<div class="modal fade" id="view_sales_modal" tabindex="-1" role="dialog" aria-labelledby="new_item_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-lg">
	    	<div class="modal-content">
	    		<form id="frm_view_sales" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="new_item_modal_label">Branch Sales Report</h4>
			      	</div>
			      	<div class="modal-body">
			        	<div class="row">
	                        <div class="col-lg-9">
	                            <div class="form-group">
	                                <label for="branch_id">Branch ID:</label>
	                                <span id="branch_id" ></span>
	                           	</div>
	                        </div>
	                        <div class="col-lg-3">
	                            <div class="form-group">
	                                <label for="report_date">Date</label>
	                                <span id="report_date"></span>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row">
	                    	<div class="col-lg-12">
		                    	<table id="branch_sales_report_table" class="table" cellspacing="0" width="100%">
				    				<thead>
		                            	<tr>
		                            		<th>ID</th>
			                                <th>Sales ID</th>
			                            	<th>Total Amount</th>
			                            	<th>Date</th>
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
						<button type="button" class="btn btn-info pull-left" id="btn_view_sales"><span class="glyphicon glyphicon-eye-open"></span></button>
			      	</div>
			    </form>
	    	</div>
	  	</div>
	</div>

	<div class="modal fade" id="view_receipts_modal" tabindex="-1" role="dialog" aria-labelledby="new_item_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-md">
	    	<div class="modal-content">
	    		<form id="frm_view_receipts" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="new_item_modal_label">Receipts</h4>
			      	</div>
			      	<div class="modal-body">
			        	<div class="row">
	                        <div class="col-lg-9">
	                            <div class="form-group">
	                                <label for="sales_report_id">Sales ID:</label>
	                                <span id="sales_report_id"></span>
	                           	</div>
	                        </div>
	                        <div class="col-lg-3">
	                            <div class="form-group">
	                                <label for="sales_report_date">Date: </label>
	                                <span id="sales_report_date"></span>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row">
	                    	<div class="col-lg-12">
	                            <div class="form-group">
	                                <label for="sales_report_total_amount">Total Amount: </label>
	                            	<span id="sales_report_total_amount"></span>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row">
	                    	<div class="col-lg-12">
		                    	<table id="receipts_table" class="table" cellspacing="0" width="100%">
				    				<thead>
		                            	<tr>
			                                <th>ID</th>
			                                <th>Receipt ID</th>
			                           		<th>Total Amount</th>
			                            	<th>Date</th>
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
						<button type="button" class="btn btn-info pull-left" id="btn_view_receipts_item"><span class="glyphicon glyphicon-eye-open"></span></button>
			      	</div>
			    </form>
	    	</div>
	  	</div>
	</div>

	<div class="modal fade" id="view_receipts_item_modal" tabindex="-1" role="dialog" aria-labelledby="new_item_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-md">
	    	<div class="modal-content">
	    		<form id="frm_view_receipts" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="new_item_modal_label">Receipt Items</h4>
			      	</div>
			      	<div class="modal-body">
			        	<div class="row">
	                        <div class="col-lg-9">
	                            <div class="form-group">
	                                <label for="receipt_id">Receipt ID:</label>
	                                <span id = "receipt_id"></span>
	                           	</div>
	                        </div>
	                        <div class="col-lg-3">
	                            <div class="form-group">
	                                <label for="receipt_date">Date: </label>
	                                <span id = "receipt_date"></span>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row">
	                    	<div class="col-lg-12">
	                            <div class="form-group">
	                                <label for="receipt_amount">Total Amount: </label>
	                                <span id ="receipt_amount"></span>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row">
	                    	<div class="col-lg-12">
		                    	<table id="receipts_item_table" class="table" cellspacing="0" width="100%">
				    				<thead>
		                            	<tr>
			                                <th>Item ID</th>
			                                <th>Description</th>
			                           		<th>Price</th>
			                            	<th>Quantity</th>
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



	<?php include("/../_shared/js.php"); ?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/app/<?php echo $current_page; ?>.js"></script>
	<script type="text/javascript">Reports.run();</script>
</body>
</html>