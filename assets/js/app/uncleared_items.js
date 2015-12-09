var UnclearedItems = (function() {
	var obj = {};
	var tableBranchCurrentRowPos = -1;
	var tableBranchSelectedRowPos = -1;

	var initialize = function () {
		obj = {
			$tableBranch: $("#branch_table").DataTable({
				"columns": [	
					{ "sClass": "text-left font-bold", "sWidth": "13%" },
					{ "sClass": "text-left font-bold", "sWidth": "43%" },
				],
				"bLengthChange": false,
				responsive: true,
				"bPaginate" : true, 
		        "bAutoWidth": false
			}),

			$tableBranchUnclearedItems: $("#branch_uncleared_items_table").DataTable({
				"columns": [	
					{ "sClass": "text-left font-bold", "sWidth": "13%" },
					{ "sClass": "text-left font-bold", "sWidth": "43%" },
					{ "sClass": "text-left font-bold", "sWidth": "13%" },
				],
				"bLengthChange": false,
				responsive: true,
				"bPaginate" : true, 
		        "bAutoWidth": false,
		        "bFilter":false
			}),
			
			$keyBranch: new $.fn.dataTable.KeyTable($("#branch_table").dataTable()),
			$keyBranchTableApi: $("#branch_table").dataTable(),
			$btnViewBranchUnclearedItems: $("#btn_view_branch_uncleared_item"),
			$btnRefreshBranchList: $("#btn_refresh_branch_list"),
			$txtBranchId: $("#branch_id"),
			$modalBranchUnclearedItems: $("#branch_uncleared_items_modal"),

			enableActionButtons: function(){
				this.$btnViewBranchUnclearedItems.removeAttr("disabled");
			},

			disableActionButtons: function(){
				this.$btnViewBranchUnclearedItems.attr("disabled","disabled");
			},

			getAllBranches: function (){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_all_branches",{},function (data) {});
			},

			isBranchExist: function (branchId) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/branch_exists",{branchId: branchId,},function (data) {});
			},
			getAllUnclearedItemsFromThisBranch: function(branchId) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_all_uncleared_items_from_this_branch",{branchId: branchId,},function (data) {});
			},
		};
	};

	var bindEvents = function() {
		obj.getAllBranches().always( function (getAllBranches) {
			NProgress.start();
			obj.$tableBranch.clear().draw();
		  	var getAllBranches = JSON.parse(getAllBranches);
			 for(var i=0; i<getAllBranches.length; i++){
				obj.$tableBranch.row.add([
					getAllBranches[i]['id'],
					getAllBranches[i]['description'],
				]).draw(false);
			}
		}).always(function (){
			NProgress.done();
		});

		obj.$keyBranch.event.focus(null, null, function (node, x, y) {
			tableBranchCurrentRowPos = y;
			obj.enableActionButtons();
		});

		obj.$keyBranch.event.blur(null, null, function (node, x, y) {
			tableBranchCurrentRowPos = -1;
			obj.disableActionButtons();
		});

		obj.$btnViewBranchUnclearedItems.click( function () {
			if(tableBranchCurrentRowPos >= 0 ){
				tableBranchSelectedRowPos = tableBranchCurrentRowPos;
				obj.$keyBranch.fnBlur();
				var branchId = obj.$keyBranchTableApi._('tr', {"filter":"applied"})[tableBranchSelectedRowPos][0];
				
				obj.isBranchExist(branchId).always( function (isBranchExist) {
					NProgress.start();

					obj.getAllUnclearedItemsFromThisBranch(branchId).always( function (getAllUnclearedItemsFromThisBranch) {
						var unclearedItems = JSON.parse(getAllUnclearedItemsFromThisBranch);
						obj.$txtBranchId.text(branchId);
						obj.$tableBranchUnclearedItems.clear().draw();
						for(i=0;i<unclearedItems.length; i++){
							obj.$tableBranchUnclearedItems.row.add([
								unclearedItems[i]['item_id'],
								unclearedItems[i]['description'],
								unclearedItems[i]['quantity']
							]);
							obj.$tableBranchUnclearedItems.draw(false);
						}

					    obj.$modalBranchUnclearedItems.modal("show");
					}).always( function () {
							NProgress.done();
					});
					
				}).always( function () {
					NProgress.done();
				});
			} else {
				obj.showAlert("<b>Branch Does Not Exist</b>", "info", "<span> Sales " + branchId + " has already been deleted in another session.<span>");
				obj.$keyTableApi.fnDeleteRow(obj.$keyTableApi.$('tr', {"filter":"applied"})[tableBranchCurrentRowPos]);
			}	
		});

		obj.$btnRefreshBranchList.click( function () {
			
		});
		
	};

	return {
		run: function () {
			initialize();
			bindEvents();
		}
	};
})();
