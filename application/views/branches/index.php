<!DOCTYPE html>
<html>
<head>
	<title>Branches</title>
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
	                    		<h3 class="box-title"><i class="fa fa-th-list"></i> Branches List</h3>
			                	<div class="box-tools pull-right">
			                    	<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

			                  	</div>
			                </div>
	                        <div class="box-body">
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
		                        <button type="button" class="btn btn-success pull-right" id="btn_new_branch"><span class="glyphicon glyphicon-plus"></span> New Branch</button>
		                        <button type="button" class="btn btn-primary" id="btn_update_branch"><span class="fa fa-pencil"></span></button>
		                        <button type="button" class="btn btn-info" id="btn_view_branch"><span class="glyphicon glyphicon-eye-open"></span></button>
		                        <button type="button" class="btn btn-default" id="btn_refresh_branch"><span class="glyphicon glyphicon-refresh"></span></button>
	                        </div><!-- /.box-body -->
	                    </div><!-- /.box -->
	                </div><!-- /.col -->
	            </div><!-- /.row -->
	        </section><!-- /.content -->
	    </div><!-- /.content-wrapper -->
	</div><!-- ./wrapper -->
	<!-- Modal New Item -->
	<div class="modal fade" id="new_branch_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  	<div class="modal-dialog modal-sm">
	    	<div class="modal-content">
	    		<form id = "frm_new_branch" method = "post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="myModalLabel">New Branch</h4>
			      	</div>
			      	<div class="modal-body">
			        	<div class="row">
			        		<div class="col-lg-6">
			        			<div class="form-group">
			        				<label for="new_branch_id">Branch ID*</label>
			        				<input name="new_branch_id" id="new_branch_id" type="text" class="form-control" />
			        				<div id="new_branch_id_error" class="error-alert"></div>
			        			</div>
			        		</div>
			        		<div class="col-lg-6">
			        			<div class="form-group">
			        				<label for="new_branch_description">Description*</label>
			        				<input name="new_branch_description" id="new_branch_description" type="text" class="form-control" />
			        				<div id="new_branch_description_error" class="error-alert"></div>
			        			</div>
			        		</div>
			        	</div>
			      	</div>	
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        	<button type="submit" class="btn btn-primary">Save</button>
			      	</div>
			    </form>
	    	</div>
	  	</div>
	</div>
    
    <div class="modal fade" id="view_branch_modal" tabindex="-1" role="dialog" aria-labelledby="view_item_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-sm">
	    	<div class="modal-content">
	    		<form id="frm_view_branch" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="view_branch_modal_label">View Item</h4>
			      	</div>
			      	<div class="modal-body">
			        	<div class="row">
	                        <div class="col-lg-12">
	                            <table>
	                                <tr>
	                                	<div class="col-lg-12">
		                                    <td style="text-align: right; font-weight: bold; padding-bottom: 1em;">Item ID</td>
		                                    <td id="view_branch_id" style="padding-left: 1em; padding-bottom: 1em;"></td>
		                                </div>
	                                </tr>
	                                <tr>
	                                	<div class="col-lg-12">
		                                    <td style="text-align: right; font-weight: bold; padding-bottom: 1em;">Description</td>
		                                    <td id="view_branch_description" style="padding-left: 1em; padding-bottom: 1em;"></td>
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

	<div class="modal fade" id="update_branch_modal" tabindex="-1" role="dialog" aria-labelledby="update_item_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-xs">
	    	<div class="modal-content">
	    		<form id="frm_update_branch" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="update_branch_modal_label">Update Branch</h4>
			      	</div>
			      	<div class="modal-body">
			        	<div class="row">
	                        <div class="col-lg-0">
	                            <div class="form-group" style="display:none;">
	                                <label for="update_branch_id">Branch ID*</label>
	                                <input name="update_branch_id" id="update_branch_id" type="text" class="form-control" />
	                                <div id="update_branch_id_error" class="error-alert"></div>
	                            </div>
	                        </div>
	                        <div class="col-lg-12">
		                    	<div class="form-group">
	                                <label for="update_branch_description">Description*</label>
	                                <input name="update_branch_description" id="update_branch_description" type="text" class="form-control" />
	                                <div id="update_branch_description_error" class="error-alert"></div>
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

	<?php include("/../_shared/js.php"); ?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/app/<?php echo $current_page; ?>.js"></script>
	<script type="text/javascript">Branches.run();</script>
</body>
</html>