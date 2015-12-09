var Branches = (function () {
	var obj = {};
	var tableBranchesCurrentRowPos = -1;
	var tableBranchesSelectedRowPos = -1;
	var initialize = function () {
		obj = {
			$tableBranches: $("#branches_table").DataTable({
				"columns": [
					{ "sClass": "text-left font-bold", "sWidth": "34%" },
					{ "sClass": "text-left font-bold", "sWidth": "50%" },
				],
				"bLengthChange": false,
				responsive: true,
				"bPaginate" : true, 
		        "bAutoWidth": false
			}),
			$keyTableApi: $("#branches_table").dataTable(),
			$keyBranches: new $.fn.dataTable.KeyTable($("#branches_table").dataTable()),
			$btnNewBranch: $("#btn_new_branch"),
			$btnDeleteBranch: $("#btn_delete_branch"),
			$btnUpdateBranch: $("#btn_update_branch"),
			$btnViewBranch: $("#btn_view_branch"),
			$btnRefreshBranch: $("#btn_refresh_branch"),
			$modalNewBranch: $("#new_branch_modal"),
			$modalViewBranch: $("#view_branch_modal"),
			$modalUpdateBranch: $("#update_branch_modal"),
			$frmNewBranch: $("#frm_new_branch"),
			$frmUpdateBranch: $("#frm_update_branch"),
			//functions
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
			disableActionButtons: function(){
				this.$btnDeleteBranch.attr("disabled","disabled");
				this.$btnUpdateBranch.attr("disabled","disabled");
				this.$btnViewBranch.attr("disabled","disabled");
			},
			enableActionButtons: function(){
				this.$btnDeleteBranch.removeAttr("disabled");
				this.$btnUpdateBranch.removeAttr("disabled");
				this.$btnViewBranch.removeAttr("disabled");
			},
			checkIfBranchIdExists: function (branch_id){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/branch_exists",{branchId: branch_id,}, function (data) {});
			},
			getAllBranches: function(){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_all_branches",{},function (data) {});
			},
			getBranch: function(branch_id){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_branch",{branchId: branch_id,},function (data) {});
			},
		};
	};
	var bindEvents = function () {
		obj.disableActionButtons();
		obj.getAllBranches().always(function (getAllBranches){
		NProgress.start();
		obj.$tableBranches.clear().draw();
		var getAllData = JSON.parse(getAllBranches);
			for(var i=0; i < getAllData.length; i++){
				obj.$tableBranches.row.add([
					getAllData[i]['id'],
					getAllData[i]['description'],
				]);
				obj.$tableBranches.draw();
			}
	        }).always(function (){
	        	NProgress.done();
    	});

		obj.$keyBranches.event.focus(null, null, function (node, x, y){
			tableBranchesCurrentRowPos = y;
			obj.enableActionButtons();
		});

		obj.$keyBranches.event.blur(null, null, function (node, x, y){
			tableBranchesCurrentRowPos = -1;
			obj.disableActionButtons();
		});

		obj.$btnNewBranch.click(function(){
			var branchCount = (obj.$tableBranches.rows().data().toArray());
			if(branchCount.length >= 20){
				obj.showAlert("<b>You Can No Longer Add a Branch</b>", "info", "<span> You have reached the maximum amount of branches to add.<span>");
			}
			else{
				obj.$frmNewBranch[0].reset();
				obj.$modalNewBranch.modal("show");
				var validatorNewBranch = obj.$frmNewBranch.validate({
					errorElement: "div",
					errorPlacement: function (error, element){
				  	error.appendTo("div#" + element.attr("name") + "_error")
					},
					rules:{
						new_branch_id: {
							required: true,
						},
						new_branch_description: {
							required: true,
						}
					},
					messages: {
						new_branch_id: {
							required: "Please enter branch ID"
						},
						new_branch_description: {
							required: "Please enter branch description"
						}
					},
					submitHandler: function(form){
						var branch_id = $("#new_branch_id").val();
						var description = $("#new_branch_description").val();
						obj.checkIfBranchIdExists(branch_id).always(function (branchIdExists){
							if(branchIdExists >= 1 ){
								obj.showAlert("<b>Already in Used</b>", "info", "<span> Branch ID " + branch_id + " is already used by another branch.<span>");
							}
							else{
								NProgress.start();
								$.post(BASE_URL + CURRENT_CONTROLLER + "/new_branch",{
									branchId: branch_id,
									description: description
								}, function (data){
									obj.getBranch(branch_id).always(function (getBranch){
										var insertedData = JSON.parse(getBranch);
										var branchId, description;
										$.each(insertedData, function(){
											branchId = (this.id);
											description =(this.description);
											obj.$tableBranches.row.add([
												branchId,
												description
											]);
										});
										obj.$tableBranches.draw(false);
										obj.showAlert("<b>Branch Added</b>", "success", "<span> Branch ID " + branchId + " has been successfully added.<span>");
										obj.$modalNewBranch.modal("hide");
									});
								}).always(function (){
									NProgress.done();
								});
							}
						});
					}
				});
				validatorNewBranch.resetForm();
			}
	    });
  		
  		obj.$btnViewBranch.click(function(){
  			if(tableBranchesCurrentRowPos >= 0){
  				tableBranchesSelectedRowPos = tableBranchesCurrentRowPos;
  				obj.$keyBranches.fnBlur();
				var branch_id = obj.$keyTableApi._('tr', {"filter":"applied"})[tableBranchesSelectedRowPos][0];
  				obj.checkIfBranchIdExists(branch_id).always(function (branchIdExists){
  					if(branchIdExists >= 1){
  						NProgress.start();
  						obj.$modalViewBranch.modal("show");
  						obj.getBranch(branch_id).always(function (getBranch){
  							var getData = JSON.parse(getBranch);
  							var branchId, description;
  							$.each(getData, function(){
  								branchId = (this.id);
  								description = (this.description);
  							});
  							$("#view_branch_id").text(branchId);
  							$("#view_branch_description").text(description);

  						}).always(function(){
  							NProgress.done();
  						});
  					}
  					else{
  						obj.showAlert("<b>Branch Does Not Exist</b>", "info", "<span> Branch ID " + branch_id + " has already been deleted in another session.<span>");
  						obj.$keyTableApi.fnDeleteRow(obj.$keyTableApi.$('tr',{"filter":"applied"})[tableBranchesSelectedRowPos]);
  					}
  				});
  			}
  		});
		
		obj.$btnUpdateBranch.click(function(){
			if(tableBranchesCurrentRowPos >= 0){
				tableBranchesSelectedRowPos = tableBranchesCurrentRowPos;
				obj.$keyBranches.fnBlur();
				var branch_id = obj.$keyTableApi._('tr', {"filter":"applied"})[tableBranchesSelectedRowPos][0];
				obj.checkIfBranchIdExists(branch_id).always(function (branchIdExists){
					if(branchIdExists >= 1){
						obj.$modalUpdateBranch.modal("show");
						obj.$frmUpdateBranch[0].reset();
						obj.getBranch(branch_id).always(function (getBranch){
							NProgress.start();
							var getData = JSON.parse(getBranch);
							$.each(getData, function(){
								brancId = (this.id);
								description = (this.description);
								$("#update_branch_id").val(brancId);
								$("#update_branch_description").val(description);
							});
							var validatorUpdateBranch = obj.$frmUpdateBranch.validate({
								errorElement: "div",
								errorPlacement: function (error, element){
							 	error.appendTo("div#" + element.attr("name") + "_error") 
								},
								rules:{
									update_branch_id: {
										required: true,
									},
									update_branch_description : {
										required: true
									}
								},
								messages: {
									update_branch_description: {
										required: "Please enter branch description",
									}
								},
								submitHandler: function(form){
									var branch_id = $("#update_branch_id").val();
									var description = $("#update_branch_description").val();
									obj.checkIfBranchIdExists(branch_id).always(function (branchIdExists){
										if(branchIdExists < 1){
											obj.showAlert("<b>Branch Does Not Exist</b>", "info", "<span> Branch ID " + branch_id + " has already been deleted in another session.<span>");
											obj.$keyTableApi.fnDeleteRow(obj.$keyTableApi.$('tr', {"filter":"applied"})[tableBranchesSelectedRowPos]);
											validatorUpdateBranch.resetForm();
											obj.$modalUpdateBranch.modal("hide");
											obj.$frmUpdateBranch[0].reset();
										}
										else{
											NProgress.start();
											$.post(BASE_URL + CURRENT_CONTROLLER + "/update_branch",{
												branchId: branch_id,
												description: description
											}, function (data){
												obj.getBranch(branch_id).always(function (getBranch){
													var updatedData = JSON.parse(getBranch);
													obj.$keyTableApi.fnDeleteRow(obj.$keyTableApi.$('tr', {"filter":"applied"})[tableBranchesSelectedRowPos]);
													$.each(updatedData,function(){
														branch_id = (this.id);
														description = (this.description);
														obj.$tableBranches.row.add([
															branch_id,
															description
														]);
														obj.$tableBranches.draw(false);
														obj.$modalUpdateBranch.modal("hide");
														obj.showAlert("<b>Branch Updated</b>", "success", "<span> Branch ID " + branch_id + " has been successfully updated.<span>");
													});
												});
											}).always( function(){
												NProgress.done();
											});
										}
									});
								}
							});
							validatorUpdateBranch.resetForm();
						}).always(function (){
							NProgress.done();
						});
					}
					else{
						obj.showAlert("<b>Branch Does Not Exist</b>", "info", "<span> Branch ID " + branch_id + " has already been deleted in another session.<span>");
					    obj.$keyTableApi.fnDeleteRow(obj.$keyTableApi.$('tr', {"filter":"applied"})[tableBranchesSelectedRowPos]);
				   
					}
				});
			}
		});
		
		obj.$btnRefreshBranch.click(function(){
			obj.$tableBranches.clear().draw();
			NProgress.start();
			obj.getAllBranches().always(function (getAllBranches){
				var getAllData = JSON.parse(getAllBranches);
				for(var i=0; i<getAllData.length; i++){
					obj.$tableBranches.row.add([
						getAllData[i]['id'],
						getAllData[i]['description'],
						
					]);
					obj.$tableBranches.draw(false);
				}
			}).always(function(){
				NProgress.done();
			});
		});
	}; // end of bind events 
	return {
		run: function () {
			initialize();
			bindEvents();
		}
	};
})();