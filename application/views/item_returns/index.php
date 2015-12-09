<!DOCTYPE html>
<html>
<head>
	<title>Item Returns</title>
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
	                    		<h3 class="box-title"><i class="fa fa-reply"></i> Item Returns</h3>
			                	<div class="box-tools pull-right">
			                    	<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			                  	</div>
			                </div>
	                        <div class="box-body">	
				    			<table id="item_returns_table" class="table" cellspacing="0" width="100%">
		                          	<thead>
		                            	<tr>
			                                <th>Return ID</th>
			                                <th>Branch</th>
			                                <th>Date</th>
		                              	</tr>
	                            	</thead>
	                        		<tbody>
	                        			
		                            </tbody>
		                        </table>
		                        <button type="button" class="btn btn-primary" id="btn_receive_return_items"><i class="fa fa-reply-all"></i> Receive Items</button>
		                        <button type="button" class="btn btn-info" id="btn_view_item_returns"><span class="glyphicon glyphicon-eye-open"></span></button>
                    			<button type="button" class="btn btn-default" id="btn_refresh_item_returns"><span class="glyphicon glyphicon-refresh"></span></button>
                    		</div><!-- /.box-body -->
	                    </div><!-- /.box -->
	                </div><!-- /.col -->
	            </div><!-- /.row -->
	        </section><!-- /.content -->
	    </div><!-- /.content-wrapper -->
	</div><!-- ./wrapper -->
	<div class="modal fade" id="view_item_return_modal" tabindex="-1" role="dialog" aria-labelledby="view_item_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-md">
	    	<div class="modal-content">
	    		<form id="frm_view_item_return" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="view_item_modal_label">Item Returns Information</h4>
			      	</div>
			      	<div class="modal-body">
			        	<div class="row">
	                        <div class="col-lg-8">
	                            <label for="show_return_id">Return ID : </label>
	                            <span id="show_return_id"></span>
	                        </div>
	                        <div class="col-lg-4">
	                            <label for="show_return_date">Date : </label>
								<span id="show_return_date"></span>	
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-lg-12">
	                            <label for="show_branch_returned">Branch : </label>
	                            <span id="show_return_branch"></span>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-lg-12">
            					<table id="view_returned_items_table" class="table" cellspacing="0" width="100%">
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
	                    </div>
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      	</div>
			    </form>
	    	</div>
	  	</div>
	</div>

	<div class="modal fade" id="recieve_return_item_modal" tabindex="-1" role="dialog" aria-labelledby="view_item_modal_label" aria-hidden="true" data-backdrop = "static">
	  	<div class="modal-dialog modal-md">
	    	<div class="modal-content">
	    		<form id="frm_recieve_return_item" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="view_item_modal_label">Receive Return Items</h4>
			      	</div>
			      	<div class="modal-body">
			      		<div class="row">
		                        <div class="col-lg-8">
		                             <label for="description_new">Return ID : </label>
		                             <span id="return_id"></span>
		                        </div>
		                        <div class="col-lg-4">
		                             <label for="description_new">Date : </label>
		                             <span id="return_date"></span>
		                        </div>
		                </div>
		                <div class="row">
		                        <div class="col-lg-12">
		                             <label for="description_new">Branch : </label>
		                             <span id="returned_branch_id"></span>
		                        </div>
		                </div>
		                <div class="row">
	                    	<div class="col-lg-12">
            					<table id="receive_returned_items_table" class="table" cellspacing="0" width="100%">
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
	                    </div>
	                    
	                    <div class="row">
	                    	<div class="col-lg-12" >
	                    		<input type="file" id="input_open_return_file_dialog" name="files" title="Load File"  accept = ".json" style="display:none;" />
	                   		</div>
	                    </div>
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			       		<button type="button" class="btn btn-success" id="btn_confirm_returns"><span class="glyphicon glyphicon-plus"></span> Confirm</button>
			      	</div>
			    </form>
	    	</div>
	  	</div>
	</div>

	<?php include("/../_shared/js.php"); ?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/app/<?php echo $current_page; ?>.js"></script>
	<script type="text/javascript">ItemReturns.run();</script>
</body>
</html>