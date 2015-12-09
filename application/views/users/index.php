<!DOCTYPE html>
<html>
<head>
	<title>User Accounts</title>
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
	                    		<h3 class="box-title"><i class="fa fa-user"></i> Users</h3>
			                	<div class="box-tools pull-right">
			                    	<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			                  	</div>
			                </div>
	                        <div class="box-body">
		                        <table id="users_table" class="table" cellspacing="0" width="100%">
		                          	<thead>
		                            	<tr>
		                            		<th>User ID</th>
			                                <th>Username</th>
			                                <th>Name</th>
			                                <th>Level</th>
		                              	</tr>
	                            	</thead>
	                        		<tbody>
		                              	
		                            </tbody>
		                        </table>
		                        <button type="button" class="btn btn-success pull-right" id="btn_new_user"><span class="glyphicon glyphicon-plus"></span> New User</button>
		                        <button type="button" class="btn btn-primary" id="btn_update_user"><span class="fa fa-pencil"></span></button>
		                        <button type="button" class="btn btn-info" id="btn_view_user"><span class="glyphicon glyphicon-eye-open"></span></button>
		                        <button type="button" class="btn btn-default" id="btn_refresh_user"><span class="glyphicon glyphicon-refresh"></span></button>
		                        <button type="button" class="btn btn-warning" id="btn_select_branch"><i class="fa fa-file"></i> Export</button>
	                        </div><!-- /.box-body -->
	                    </div><!-- /.box -->
	                </div><!-- /.col -->
	            </div><!-- /.row -->
	        </section><!-- /.content -->
	    </div><!-- /.content-wrapper -->
	</div><!-- ./wrapper -->
	<div class="modal fade" id="new_user_modal" tabindex="-1" role="dialog" aria-labelledby="new_user_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-md">
	    	<div class="modal-content">
	    		<form id="frm_new_user" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="new_user_modal_label">Add User</h4>
			      	</div>
			      	<div class="modal-body">
			        	<div class="row">
	                        <div class="col-lg-4">
	                            <div class="form-group">
	                                <label for="last_name_new">Last Name*</label>
	                                <input name="last_name_new" id="last_name_new" type="text" class="form-control" />
	                                <div id="last_name_new_error" class="error-alert"></div>
	                            </div>
	                        </div>
	                        <div class="col-lg-4">
	                            <div class="form-group">
	                                <label for="first_name_new">First Name*</label>
	                                <input name="first_name_new" id="first_name_new" type="text" class="form-control" />
	                                <div id="first_name_new_error" class="error-alert"></div>
	                            </div>
	                        </div>
	                        <div class="col-lg-4">
	                            <div class="form-group">
	                                <label for="middle_name_new">Middle Name*</label>
	                                <input name="middle_name_new" id="middle_name_new" type="text" class="form-control" />
	                                <div id="middle_name_new_error" class="error-alert"></div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row">
	                    	<div class="col-lg-4">
		                    	<div class="form-group">
	                                <label for="username_new">Username*</label>
	                                <input name="username_new" id="username_new" type="text" class="form-control" />
	                                <div id="username_new_error" class="error-alert"></div>
	                            </div>
	                        </div>
	                        <div class="col-lg-4">
		                    	<div class="form-group">
	                                <label for="password_new">Password*</label>
	                                <input name="password_new" id="password_new" type="password" class="form-control" />
	                                <div id="password_new_error" class="error-alert"></div>
	                            </div>
	                        </div>
	                        <div class="col-lg-4">
		                    	<div class="form-group">
	                                <label for="confirm_password_new">Confirm Password*</label>
	                                <input name="confirm_password_new" id="confirm_password_new" type="password" class="form-control" />
	                                <div id="confirm_password_new_error" class="error-alert"></div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row">
	                    	<div class="col-lg-6">
		                    	<div class="form-group">
	                                <label for="level_new">Level*</label>
	                                <select aria-invalid="false" name="level_new" id="level_new" class="form-control valid">
	                                    <option value="2">Cashier</option>
	                                    <option value="1">Administrator</option>
	                                </select>
	                                <div id="level_new_error" class="error-alert"></div>
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
	<div class="modal fade" id="update_user_modal" tabindex="-1" role="dialog" aria-labelledby="update_user_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-sm">
	    	<div class="modal-content">
	    		<form id="frm_update_user" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="update_user_modal_label">Update User</h4>
			      	</div>
			      	<div class="modal-body">
			        	<div class="row">
	                        <div class="col-lg-6">
	                            <div class="form-group">
	                                <label for="last_name_update">Last Name*</label>
	                                <input name="last_name_update" id="last_name_update" type="text" class="form-control" />
	                                <div id="last_name_update_error" class="error-alert"></div>
	                            </div>
	                        </div>
	                        <div class="col-lg-6">
	                            <div class="form-group">
	                                <label for="first_name_update">First Name*</label>
	                                <input name="first_name_update" id="first_name_update" type="text" class="form-control" />
	                                <div id="first_name_update_error" class="error-alert"></div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row">
	                    	<div class="col-lg-6">
	                            <div class="form-group">
	                                <label for="middle_name_update">Middle Name*</label>
	                                <input name="middle_name_update" id="middle_name_update" type="text" class="form-control" />
	                                <div id="middle_name_update_error" class="error-alert"></div>
	                            </div>
	                        </div>
	                        <div class="col-lg-6">
		                    	<div class="form-group">
	                                <label for="level_update">Level*</label>
	                                <select name="level_update" id="level_update" class="form-control">
	                                    <option value="2">Cashier</option>
	                                    <option value="1">Administrator</option>
	                                </select>
	                                <div id="level_update_error" class="error-alert"></div>
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
	<div class="modal fade" id="view_user_modal" tabindex="-1" role="dialog" aria-labelledby="view_user_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-sm">
	    	<div class="modal-content">
	    		<form id="frm_view_user" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="view_user_modal_label">View User</h4>
			      	</div>
			      	<div class="modal-body">
			        	<div class="row">
	                        <div class="col-lg-12">
	                            <table>
	                                <tr>
	                                	<div class="col-lg-12">
		                                    <td style="text-align: right; font-weight: bold; padding-bottom: 1em;">Username</td>
		                                    <td id="username_view" style="padding-left: 1em; padding-bottom: 1em;"></td>
		                                </div>
	                                </tr>
	                                <tr>
	                                	<div class="col-lg-12">
		                                    <td style="text-align: right; font-weight: bold; padding-bottom: 1em;">Name</td>
		                                    <td id="name_view" style="padding-left: 1em; padding-bottom: 1em;"></td>
		                                </div>
	                                </tr>
	                                <tr>
	                                	<div class="col-lg-12">
		                                    <td style="text-align: right; font-weight: bold; padding-bottom: 1em;">Level</td>
		                                    <td id="user_level_view" style="padding-left: 1em; padding-bottom: 1em;"></td>
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
	<div class="modal fade" id="select_branch_modal" tabindex="-1" role="dialog" aria-labelledby="select_branch_modal_label" aria-hidden="true">
	  	<div class="modal-dialog modal-sm">
	    	<div class="modal-content">
	    		<form id="frm_select_branch_modal" method="post">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="select_branch_modal_label">Select Branch To Export</h4>
			      	</div>
			      	<div class="modal-body">
			        	<table id="select_branch_table" class="table" cellspacing="0" width="100%">
                          	<thead>
                            	<tr>
                            		<th>Branch Id</th>
	                                <th>Description</th>
                              	</tr>
                        	</thead>
                    		<tbody>
                              	
                            </tbody>
                        </table>
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        	<button type="button" class="btn btn-warning pull-right" id="btn_export_users">Export</button>
			      	</div>
			    </form>
	    	</div>
	  	</div>
	</div>
	<?php include("/../_shared/js.php"); ?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/app/<?php echo $current_page; ?>.js"></script>
	<script type="text/javascript">Users.run();</script>
</body>
</html>