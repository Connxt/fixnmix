<!DOCTYPE html>
<html>
<head>
	<title>Uncleared Items</title>
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
	                    		<h3 class="box-title"><i class="fa fa-question-circle"></i> Uncleared Items</h3>
			                	<div class="box-tools pull-right">
			                    	<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			                  	</div>
			                </div>
	                        <div class="box-body">
		                        <table id="branch_table" class="display table" cellspacing="0" width="100%">
		                          	<thead>
		                            	<tr>
		                            		<th>Branch ID</th>
											<th>Description</th>
			                               <!--  <th>Quantity</th> -->
			                            </tr>
	                            	</thead>
	                        		<tbody>
		                              
		                            </tbody>
		                        </table>
		                        <button type="button" class="btn btn-info" id="btn_view_branch_uncleared_item"><span class="glyphicon glyphicon-eye-open"></span></button>
	                       		<button type="button" class="btn btn-default" id="btn_refresh_branch_list"><span class="glyphicon glyphicon-refresh"></span></button>
	                        </div><!-- /.box-body -->
	                    </div><!-- /.box -->
	                </div><!-- /.col -->
	            </div><!-- /.row -->
	        </section><!-- /.content -->
	    </div><!-- /.content-wrapper -->
	</div><!-- ./wrapper -->

	<div class="modal fade" id="branch_uncleared_items_modal" tabindex="-1" role="dialog" aria-labelledby="view_item_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-md">
	    	<div class="modal-content">
	    		<form id="frm_branch_uncleared_items" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="view_branch_uncleared_items">Branch Uncleared Items</h4>
			      	</div>
			      	<div class="modal-body">
			      		<div class="row">
			      			<div class="col-lg-6">
			      				<label for="branch_id"> Branch ID : </label>
			      				<span id="branch_id"></span>
			      			</div>
			      			<div class="col-lg-6">
			      				<label></label>
			      			</div>
			      		</div>
			        	<div class="row">
	                        <div class="col-lg-12">
	                            <table id="branch_uncleared_items_table" class="table" cellspacing="0" width="100%">
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

	<?php include("/../_shared/js.php"); ?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/app/<?php echo $current_page; ?>.js"></script>
	<script type="text/javascript">UnclearedItems.run();</script>
</body>
</html>