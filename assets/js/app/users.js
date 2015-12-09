var Users = (function() {
	var obj = {};
	var tableUsersCurrentRowPos = -1;
	var tableUsersSelectedRowPos = -1;
	var tableSelectBranchSelectedRowPos = -1;
	var tableSelectBranchCurrentRowPos = -1;
	var initialize = function () {
		obj = {
			$tableUsers: $("#users_table").DataTable({
				"columns": [
					{ "sClass": "none","sWidth": "0%" },
					{ "sClass": "text-left font-bold", "sWidth": "15%" },
					{ "sClass": "text-left font-bold", "sWidth": "50%" },
					{ "sClass": "text-left font-bold", "sWidth": "15%" },
				],
				"columnDefs": [{ "targets": [0], "visible": false, "searchable": false }],
				"bLengthChange": false,
				// responsive: true,
				"bPaginate" : true, 
		        "bAutoWidth": false
			}),
			$tableSelectBranch: $("#select_branch_table").DataTable({
				"columns": [
					{ "sClass": "text-left font-bold", "sWidth": "15%" },
					{ "sClass": "text-left font-bold", "sWidth": "50%" },
				],
				"bFilter":false,
				"bLengthChange": false,
				responsive: true,
				"bPaginate" : false, 
		        "bAutoWidth": false
			}),
			$keyUsers: new $.fn.dataTable.KeyTable($("#users_table").dataTable()),
			$keyBranches: new $.fn.dataTable.KeyTable($("#select_branch_table").dataTable()),
			$keyTableBranchesApi: $("#select_branch_table").dataTable(),
			$keyTableUsersApi: $("#users_table").dataTable(),
			$btnNewUser: $("#btn_new_user"),
			$btnDeleteUser: $("#btn_delete_user"),
			$btnUpdateUser: $("#btn_update_user"),
			$btnViewUser: $("#btn_view_user"),
			$btnRefreshUser: $("#btn_refresh_user"),
			$btnSelectBranch : $("#btn_select_branch"),
			$btnExportUsers: $("#btn_export_users"),
			$frmNewUser: $("#frm_new_user"),
			$frmUpdateUser: $("#frm_update_user"),
			$modalNewUser: $("#new_user_modal"),
			$modalUpdateUser: $("#update_user_modal"),
			$modalViewUser: $("#view_user_modal"),
			$modalSelectBranch: $("#select_branch_modal"),
			$textBoxUpdateLastName: $("#last_name_update"),
			$textBoxUpdateFirstName: $("#first_name_update"),
			$textBoxUpdateMiddleName: $("#middle_name_update"),
			$textBoxUpdateUsername: $("#username_update"),
			$textBoxUpdateUserLevel: $("#level_update"),
			$textBoxNewLastName: $("#last_name_new"),
			$textBoxNewFirstName: $("#first_name_new"),
			$textBoxNewMiddleName: $("#middle_name_new"),
			$textBoxNewPassword: $("#password_new"),
			$textBoxNewUsername: $("#username_new"),
			$textBoxNewUserLevel: $("#level_new"),
			$textBoxViewUsername: $("#username_view"),
			$textBoxViewName: $("#name_view"),
			$textBoxViewUserLevel: $("#user_level_view"),
			$toggleSelectUsers: $("#users_table tbody"),
			// functions
			showConfirm: function (text, type, confirmButtonText, cancelButtonText, callback){
				swal({
					html:true,
					title: "",
				  	text: text,
				  	type: type,
				  	showCancelButton: true,
				  	confirmButtonClass: "btn-primary",
				  	confirmButtonText: confirmButtonText,
				  	cancelButtonText: cancelButtonText,
				  	closeOnConfirm: true,
				  	confirmButtonColor: "#3c8dbc",
				  	closeOnCancel: true,
				}, callback );	
			},
			showAlert: function(title, type, text){
				swal({
					html:true,
					title: title,
				  	text: text,
				  	type: type,
				  	confirmButtonClass: "btn-primary",
				  	confirmButtonColor: "#3c8dbc",
				  	closeOnConfirm:true
				});	
			},
			enableActionButtons: function () {
				this.$btnDeleteUser.removeAttr("disabled");
				this.$btnUpdateUser.removeAttr("disabled");
				this.$btnViewUser.removeAttr("disabled");
			},
			disableActionButtons: function () {
				this.$btnDeleteUser.attr("disabled","disabled");
				this.$btnUpdateUser.attr("disabled","disabled");
				this.$btnViewUser.attr("disabled","disabled");
			},
			checkIfUsernameExists: function (username) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/username_exists",{username: username,},function (data) {});
			},
			getAllUsers: function () {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_all_users",{},function (data) {});
			},
			getUserViaUserId: function(userId) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_user_via_id",{userId: userId},function (data) {});
			},
			getUserViaUsername: function (username) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_user_via_username",{username: username},function (data) {});
			},
			getAllBranches: function (){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_all_branches",{},function (data) {});
			},
			getDefaultPath: function (){
				return $.post(BASE_URL + "settings_controller/get_default_save_path",{},function (data) {});
			},
			ExportAllUsers: function (userIds, branchId, filePath){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/write_user_data_to_file",{
							userIds: userIds,
							branchId: branchId,
							filePath: filePath
						},function (data) {});
			}

		};
	};
	
	var bindEvents = function() {
		obj.disableActionButtons();
		obj.$tableUsers.clear().draw();
		obj.getAllUsers().always(function (getAllUsers){
			var getAllData = JSON.parse(getAllUsers);
			for(var i=0; i < getAllData.length; i++){
				obj.$tableUsers.row.add([
					getAllData[i]['id'],
					getAllData[i]['username'],
					getAllData[i]['last_name'] + ", " + getAllData[i]['first_name'] + " " + getAllData[i]['middle_name'].substring(0, 1) + ".",
					getAllData[i]['user_level_id'] == 1 ? "Administrator" : "Cashier",
				]);
				obj.$tableUsers.draw(false);
			}
		});
		// select branch keytable
		obj.$keyBranches.event.focus(null, null, function (node, x, y){
			tableSelectBranchCurrentRowPos = y;
		});
		obj.$keyBranches.event.blur(null, null, function (node, x, y){
			tableSelectBranchCurrentRowPos = -1;
		});

		// users keytable
		obj.$keyUsers.event.focus(null, null, function (node, x, y) {
			tableUsersCurrentRowPos = y;
			obj.enableActionButtons();
		});

		obj.$keyUsers.event.blur(null, null, function (node, x, y) {
			tableUsersCurrentRowPos = -1;
			obj.disableActionButtons();
		});

		obj.$toggleSelectUsers.on("click", "tr", function () {
        	$(this).toggleClass("success");
    	});

		obj.$btnNewUser.click(function (){
			obj.$frmNewUser[0].reset();
			obj.$modalNewUser.modal("show");
			var validatorNewUser = obj.$frmNewUser.validate({
				errorElement: "div",
				errorPlacement: function (error, element){
				error.appendTo("div#" + element.attr("name") + "_error")
				},
				rules:{
					last_name_new: {
						required: true,
					},
					first_name_new: {
						required: true,
					},
					middle_name_new: {
						required: true,
					},
					username_new: {
						required: true,
						minlength: 8,
					},
					password_new: {
						required: true,
						minlength: 8,
					},
					confirm_password_new: {
						required: true,
						equalTo: "#password_new",
						minlength: 8,
					},
					level_new: {
						required: true,
					}

				},
				messages: {
					last_name_new: {
						required: "Please enter a last name",
					},
					first_name_new: {
						required: "Please enter a first name",
					},
					middle_name_new: {
						required: "Please enter a middle name",
					},
					username_new: {
						required: "Please enter a username",
						minlenght: "username should not be less than 8 characters"
					},
					password_new: {
						required: "Please enter a password",
						minlenght: "password should not be less than 8 characters"
					},
					confirm_password_new: {
						required: "Please enter a password",
						equalTo: "Password did not match",
						minlenght: "password should not be less than 8 characters"
					},
					level_new: {
						required: "Please enter a level",
					}

				},
				submitHandler: function(form){
					var lastName = obj.$textBoxNewLastName.val();
					var firstName = obj.$textBoxNewFirstName.val();
					var middleName = obj.$textBoxNewMiddleName.val();
					var username = obj.$textBoxNewUsername.val();
					var password = obj.$textBoxNewPassword.val();
					var userLevelId = obj.$textBoxNewUserLevel.val();
					obj.checkIfUsernameExists(username).always(function (usernameExists){
						if(usernameExists >= 1){
							obj.showAlert("<b>Already in Used</b>", "info", "<span>Username "+ username +" is already used by another user.<span>");
						}
						else{
							NProgress.start();
							$.post(BASE_URL + CURRENT_CONTROLLER + "/new_user",{
								lastName: lastName,
								firstName: firstName,
								middleName: middleName,
								username: username,
								password: password,
								userLevelId: userLevelId
							},function (data){
								obj.getUserViaUsername(username).always(function (getUserViaUsername){
									var insertedData = JSON.parse(getUserViaUsername);
									var lastName, firstName, middleName, username, userLevel, userId;
									$.each(insertedData, function (){
										userId = (this.id);
										username = (this.username);
										name = ((this.last_name) + ", " + (this.first_name) + " " + (this.middle_name.substring(0, 1)) + ".");
										userLevel = ((this.user_level_id == 1) ? "Administrator": "Cashier");
										obj.$tableUsers.row.add([
											userId,
											username,
											name,
											userLevel,
										]);
										obj.$tableUsers.draw(false);
									});
									obj.$modalNewUser.modal("hide");
									obj.showAlert("<b>Username Added</b>", "success", "<span> Username "+ username + " has been successfully added.<span>");
								});
							}).always(function (){
								NProgress.done();
							});
						}
					});
				}
			});
			validatorNewUser.resetForm();
		});

		obj.$btnUpdateUser.click(function (){
			if(tableUsersCurrentRowPos >= 0){
				tableUsersSelectedRowPos = tableUsersCurrentRowPos;
				obj.$keyUsers.fnBlur();
				var username = obj.$keyTableUsersApi._('tr', {"filter":"applied"})[tableUsersSelectedRowPos][1];
				obj.checkIfUsernameExists(username).always(function (usernameExists){
					if(usernameExists >= 1){
						obj.$modalUpdateUser.modal("show");
						obj.$frmUpdateUser[0].reset();
						obj.getUserViaUsername(username).always(function (getUser){
							NProgress.start();
							var getAllData = JSON.parse(getUser);
							$.each(getAllData, function(){
								obj.$textBoxUpdateLastName.val(this.last_name);
								obj.$textBoxUpdateFirstName.val(this.first_name);
								obj.$textBoxUpdateMiddleName.val(this.middle_name);
								obj.$textBoxUpdateUserLevel.val(this.user_level_id);
							});
							var validatorUpdateUser = obj.$frmUpdateUser.validate({
								errorElement: "div",
								errorPlacement: function (error, element){
								error.appendTo("div#" + element.attr("name") + "_error")
								},
								rules:{
									last_name_update: {
										required: true,
									},
									first_name_update: {
										required: true,
									},
									middle_name_update: {
										required: true,
									},
									username_update: {
										required: true,
										minlength: 8,
									},
									level_update: {
										required: true,
									}

								},
								messages: {
									last_name_update: {
										required: "Please enter a last name",
									},
									first_name_update: {
										required: "Please enter a first name",
									},
									middle_name_update: {
										required: "Please enter a middle name",
									},
									username_update: {
										required: "Please enter a username",
										minlenght: "username should not be less than 8 characters"
									},
									level_update: {
										required: "Please enter a level",
									}

								},
								submitHandler: function(form){
									var userId = obj.$keyTableUsersApi._('tr', {"filter":"applied"})[tableUsersSelectedRowPos][0];
									var lastName = obj.$textBoxUpdateLastName.val();
									var firstName = obj.$textBoxUpdateFirstName.val();
									var middleName = obj.$textBoxUpdateMiddleName.val();
									var userLevelId = obj.$textBoxUpdateUserLevel.val();
									NProgress.start();
									$.post(BASE_URL + CURRENT_CONTROLLER + "/update_user",{
										userId: userId,
										lastName: lastName,
										firstName: firstName,
										middleName: middleName,
										userLevelId: userLevelId
									},function (data){
										obj.getUserViaUserId(userId).always(function (getUser){
											var updatedData = JSON.parse(getUser);
											var userId, username, name, userLevel;
											obj.$keyTableUsersApi.fnDeleteRow(obj.$keyTableUsersApi.$('tr', {"filter":"applied"})[tableUsersSelectedRowPos]);
											$.each(updatedData, function (){
												userId = (this.id);
												username = (this.username);
												name = ((this.last_name) + ", " + (this.first_name) + " " + (this.middle_name.substring(0, 1)) + ".");
												userLevel = ((this.user_level_id == 1) ? "Administrator": "Cashier");
												obj.$tableUsers.row.add([
													userId,
													username,
													name,
													userLevel
												])
												obj.$tableUsers.draw(false);
											});
											obj.$modalUpdateUser.modal("hide");
											obj.showAlert("<b>Item Updated</b>", "success", "<span> Username "+ username + " has been successfully updated.<span>");
										});
									}).always(function (){
										NProgress.done();
									});
								}
							});
							validatorUpdateUser.resetForm();
						}).always(function (){
							NProgress.done();
						});
					}
					else{
						obj.showAlert("<b>Username Does Not Exist</b>", "info", "<span> Username" + username + " has already been deleted in another session.<span>");
						obj.$keyTableUsersApi.fnDeleteRow(obj.$keyTableUsersApi.$('tr', {"filter":"applied"})[tableUsersSelectedRowPos]);
					}
				})
				
			}
		})

		obj.$btnViewUser.click(function (){
			if(tableUsersCurrentRowPos >= 0){
				tableUsersSelectedRowPos = tableUsersCurrentRowPos;
				obj.$keyUsers.fnBlur();
				var userId = obj.$keyTableUsersApi._('tr', {"filter":"applied"})[tableUsersSelectedRowPos][0];
				var username = obj.$keyTableUsersApi._('tr', {"filter":"applied"})[tableUsersSelectedRowPos][1];
				obj.checkIfUsernameExists(username).always(function (usernameExists) {
					if(usernameExists >= 1){
						NProgress.start();
						obj.$modalViewUser.modal("show");
						obj.getUserViaUserId(userId).always(function (getUser){
							var getData = JSON.parse(getUser);
							$.each(getData,function(){
								obj.$textBoxViewUsername.text(this.username);
								obj.$textBoxViewName.text(((this.last_name) + ", " + (this.first_name) + " " + (this.middle_name.substring(0, 1)) + "."));
								obj.$textBoxViewUserLevel.text(((this.user_level_id == 1) ? "Administrator": "Cashier"));
							});
						}).always(function (){
							NProgress.done();
						});
					}
					else{
						obj.showAlert("<b>Username Does Not Exist</b>", "info", "<span> Username" + username + " has already been deleted in another session.<span>");
						obj.$keyTableUsersApi.fnDeleteRow(obj.$keyTableUsersApi.$('tr', {"filter":"applied"})[tableUsersSelectedRowPos]);
					}
				});
			}
		});
		
		obj.$btnExportUsers.click(function (){
			if(tableSelectBranchCurrentRowPos >= 0){
				tableSelectBranchSelectedRowPos = tableSelectBranchCurrentRowPos;
				obj.$keyBranches.fnBlur();
				obj.getDefaultPath().always(function (defaultPath){
					var branchId = obj.$keyTableBranchesApi._('tr', {"filter":"applied"})[tableSelectBranchSelectedRowPos][0],
						userTableInfo = (obj.$tableUsers.rows(".success").data()),
						userIds = $.map(userTableInfo, function (userIds){ return (userIds[0]) }),
						transactionType = "EXPORT_USERS",
						extension = ".json",
						fileName = (transactionType +"_"+ branchId),
						filePath = (defaultPath + fileName + extension);
					if(userTableInfo.length >= 1){
						obj.ExportAllUsers(userIds, branchId, filePath).always(function (returnedData){
							if(returnedData >=1){
								obj.showAlert("<b>File Export Success</b>", "success", "<span> Your file "+ fileName +" has been successfully created.</span>");
								obj.$modalSelectBranch.modal("hide");
							}	
							else{
								obj.showAlert("<b>File Export Failed</b>", "info", "<span>Your file "+ fileName +" has not been created. Please check your path settings.</span>");
							}	
						});
					}
					else{
						obj.showAlert("<b>File Export Failed</b>", "info", "<span> Please select users to assign.</span>");
					}
				});
			}
			else{
				obj.showAlert("<b>File Export Failed</b>", "info", "<span> Please select what branch you want to assign the users.</span>");
			}
		});

		obj.$btnSelectBranch.click(function (){
			obj.$modalSelectBranch.modal("show");
			obj.getAllBranches().always(function (getAllBranches){
				obj.$tableSelectBranch.clear().draw();
				var getAllBranchesData = JSON.parse(getAllBranches)
				for(var i=0; i<getAllBranchesData.length; i++){
					obj.$tableSelectBranch.row.add([
						getAllBranchesData[i]['id'],
						getAllBranchesData[i]['description']
					]);
				}
				obj.$tableSelectBranch.draw(false);
			});
		});
		obj.$btnRefreshUser.click(function (){
			obj.$tableUsers.clear().draw();
			obj.getAllUsers().always(function (getAllUsers){
				var getAllData = JSON.parse(getAllUsers);
				NProgress.start();
				for(var i=0; i < getAllData.length; i++){
					obj.$tableUsers.row.add([
						getAllData[i]['id'],
						getAllData[i]['username'],
						getAllData[i]['last_name'] + ", " + getAllData[i]['first_name'] + " " + getAllData[i]['middle_name'].substring(0, 1) + ".",
						getAllData[i]['user_level_id'] == 1 ? "Administrator" : "Cashier",
					]);
				}
				obj.$tableUsers.draw(false);
			}).always(function (){
				NProgress.done();
			});
		});
	};

	return {
		run: function () {
			initialize();
			bindEvents();
		}
	};
})();
