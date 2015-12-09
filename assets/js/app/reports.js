var Reports = (function() {
	var obj = {};
	var tableBranchesCurrentRowPos = -1;
	var tableBranchesSelectedRowPos = -1;
	var tableBranchSalesReportCurrentRowPos = -1;
	var tableBranchSalesReportSelectedRowPos = -1;
	var tableReceiptsCurrentRowPos = -1;
	var tableReceiptsSelectedRowPos = -1;
	var initialize = function () {
		obj = {
			$tableBranches: $("#branches_table").DataTable({
				"columns": [
					{ "sClass": "text-left font-bold", "sWidth": "15%"},
					{ "sClass": "text-left font-bold", "sWidth": "30%"},
				],
				"bLengthChange": false,
				responsive: true,
				scrollCollapse: false,
				"bPaginate" : true, 
		        "bAutoWidth": false,
			}),
			$tableBranchSalesReport: $("#branch_sales_report_table").DataTable({
				"columns": [
					{ "sClass": "none", "sWidth": "0%"},
					{ "sClass": "text-left font-bold", "sWidth": "30%"},
					{ "sClass": "text-left font-bold", "sWidth": "30%"},
					{ "sClass": "text-left font-bold", "sWidth": "20%"},
				],
				"bLengthChange": false,
				// responsive: true,
				scrollCollapse: false,
				"bPaginate" : true, 
		        "bAutoWidth": false,
		        "bFilter": false,
		        "columnDefs": [{ "targets": [0], "visible": false, "searchable": false }]
			}),

			$tableReceipts: $("#receipts_table").DataTable({
				"columns": [
					{ "sClass": "text-left font-bold", "sWidth": "20%"},
					{ "sClass": "text-left font-bold", "sWidth": "20%"},
					{ "sClass": "text-left font-bold", "sWidth": "30%"},
					{ "sClass": "text-left font-bold", "sWidth": "30%"},
				],
				"bLengthChange": false,
				responsive: true,
				scrollCollapse: false,
				"bPaginate" : true, 
		        "bAutoWidth": false,
		        "bFilter": false
			}),

			$tableReceiptsItems: $("#receipts_item_table").DataTable({
				"columns": [
					{ "sClass": "text-left font-bold", "sWidth": "20%"},
					{ "sClass": "text-left font-bold", "sWidth": "30%"},
					{ "sClass": "text-left font-bold", "sWidth": "20%"},
					{ "sClass": "text-left font-bold", "sWidth": "30%"},

				],
				"bLengthChange": false,
				responsive: true,
				scrollCollapse: false,
				"bPaginate" : true, 
		        "bAutoWidth": false,
		        "bFilter": false
			}),

			$keyTableApi: $("#branches_table").dataTable(),
			$keyBranch: new $.fn.dataTable.KeyTable($("#branches_table").dataTable()),
			$keyBranchSalesTableApi: $("#branch_sales_report_table").dataTable(),
			$keyBranchSalesReport: new $.fn.dataTable.KeyTable( $("#branch_sales_report_table").dataTable()),
			$keyReceiptTableApi: $("#receipts_table").dataTable(),
			$keyReceipts: new $.fn.dataTable.KeyTable($("#receipts_table").dataTable()),

			$btnViewBranchSales: $("#btn_view_branch_sales"),
			$btnViewSales: $("#btn_view_sales"),
			$btnImportReports: $("#btn_import_reports"),
			$btnViewReceiptsItem: $("#btn_view_receipts_item"),
			$txtBranchId: $("#branch_id"),
			$txtReportDate: $("#report_date"),
			$txtSalesReportId: $("#sales_report_id"),
			$txtSalesReportDate: $("#sales_report_date"),
			$txtSalesReportTotalAmount: $("#sales_report_total_amount"),

			$txtReceiptId: $("#receipt_id"),
			$txtReceiptDate: $("#receipt_date"),
			$txtReceiptAmount: $("#receipt_amount"),
			$inputImportReportFileDialog: $("#input_import_report_file_dialog"),
			$modalViewSales: $("#view_sales_modal"),
			$modalViewReceipts: $("#view_receipts_modal"),
			$modalViewReceiptsItem: $("#view_receipts_item_modal"),
			$importSalesReportFile: null,
			// function
			enableActionButtons: function(){
				this.$btnViewBranchSales.removeAttr("disabled");
			},
			disableActionButtons: function(){
				this.$btnViewBranchSales.attr("disabled","disabled");
			},
			decryptSalesReport: function (salesReportData) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/decrypt_sales_report_data",{salesReportData: salesReportData,},function (data) {});
			},
			getAllBranches: function () {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_all_branches",{},function (data) {});
			},
			isBranchExist: function (branchId) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/branch_exists",{branchId: branchId,},function (data) {});
			},
			getAllSalesReporsFromThisBranch: function (branchId) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_all_sales_reports_from_this_branch",{branchId: branchId,},function (data) {});
			},
			newSalesReport: function (salesReportData) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/new_sales_report",{salesReportData: salesReportData,},function (data) {});
			},
			getSalesReport: function () {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_all_sales_reports",{},function (data) {});
			},
			getAllReceiptsViaSalesReportId: function (salesReportId) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_all_receipts_via_sales_report_id",{salesReportId: salesReportId,},function (data) {});
			},
			getAllItemsFromThisReceipt: function (receiptId) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_all_items_from_this_receipt",{receiptId: receiptId,},function (data) {});
			},
			isSalesReportExist: function (salesReportId) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/sales_report_exists",{salesReportId: salesReportId,},function (data) {});
			},
			refreshBranchesTable: function () {
				obj.getAllBranches().always( function (getSAllBranch) {
					NProgress.start();
					obj.$tableBranches.clear().draw();
					var getSAllBranch = JSON.parse(getSAllBranch);
						try{
							for(i=0; i<getSAllBranch.length; i++){
								obj.$tableBranches.row.add([
									getSAllBranch[i]['id'],
									getSAllBranch[i]['description'],
								]);
								obj.$tableBranches.draw(false);
							}
						} catch (err){
							obj.showAlert("Stop", "warning", "Please inform your administrator.");
						}
					}).always( function () {
					NProgress.done();
				});
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
			importReports: function (e) {
				var salesreportData = e.target.result;
				if(salesreportData != "") {
					try{
						obj.decryptSalesReport(salesreportData).always( function (salesReport) {
							var reportData = JSON.parse(salesReport);
							obj.newSalesReport(reportData).always( function (newSalesReport) {
								try{
									NProgress.start();
									switch(newSalesReport){
										case '-2':
											obj.showAlert("Stop", "warning", "Main store is invalid.");
											break;
										case '-1':
											obj.showAlert("Stop", "warning", "Branch store is invalid.");
											break;
										case '0':
											obj.showAlert("Stop", "warning", "Transaction is already finished.");
											break;
										case '1':
											obj.showAlert("Stop", "warning", "Transaction type is invalid.");
											break;
										case '2':
											obj.showAlert("Reports has been successfully added.", "success", "");
											obj.refreshBranchesTable();
											break;
										default:
											obj.showAlert("Stop", "warning", "File content is invalid.");
											break;
									}
								} catch (err) {
									obj.showAlert("Stop", "warning", "File content is invalid.");
								}
							}).always( function () {
								NProgress.done();
							});
						});
					} catch (err) {
						obj.showAlert("Stop", "warning", "Please inform your administrator");
					}
				} else {
					obj.showAlert("Stop", "warning", "File is empty.");
				}
			},
		};
	};

	var bindEvents = function () {
		obj.disableActionButtons();
		obj.refreshBranchesTable();
		obj.$keyBranch.event.focus(null, null, function (node, x, y) {
			tableBranchesCurrentRowPos = y;
			obj.enableActionButtons();
		});

		obj.$keyBranch.event.blur(null, null, function (node, x, y) {
			tableBranchesCurrentRowPos = -1;
			obj.disableActionButtons();
		});

		obj.$keyBranchSalesReport.event.focus(null, null, function (node, x, y) {
			tableBranchSalesReportCurrentRowPos = y;
			obj.$btnViewSales.removeAttr("disabled");
		});

		obj.$keyBranchSalesReport.event.blur(null, null, function (node, x, y) {
			tableBranchSalesReportCurrentRowPos = -1;
			obj.$btnViewSales.attr("disabled","disabled");
		});

		obj.$keyReceipts.event.focus(null, null, function (node, x, y) {
			tableReceiptsCurrentRowPos = y;
			obj.$btnViewReceiptsItem.removeAttr("disabled");
		});

		obj.$keyReceipts.event.blur(null, null, function (node, x, y) {
			tableReceiptsCurrentRowPos = -1;
			obj.$btnViewReceiptsItem.attr("disabled","disabled");
		});

		obj.$btnImportReports.click( function () {
			obj.$inputImportReportFileDialog.click();
		});

		

		obj.$btnViewBranchSales.click( function () {
			if(tableBranchesCurrentRowPos >= 0){	
				tableBranchesSelectedRowPos = tableBranchesCurrentRowPos;
				obj.$keyBranch.fnBlur();
				var branchId = obj.$keyTableApi._('tr', {"filter":"applied"})[tableBranchesSelectedRowPos][0];
				obj.isBranchExist(branchId).always( function (isBranchExist){
					if(isBranchExist == 1){
						NProgress.start();
						obj.getAllSalesReporsFromThisBranch(branchId).always( function (getAllSalesReporsFromThisBranch) {
							NProgress.start();
							var branchSalesReport = JSON.parse(getAllSalesReporsFromThisBranch);
							obj.$modalViewSales.modal("show");
							obj.$txtBranchId.text(branchId);
							obj.$txtReportDate.text(moment().format("MMM DD, YYYY"));
							obj.$tableBranchSalesReport.clear().draw();
							for(i=0; i<branchSalesReport.length; i++){
								var id = branchSalesReport[i]['id'];
								obj.$tableBranchSalesReport.row.add([
									branchSalesReport[i]['sales_report_id_from_branch'],
									id,
									numeral(branchSalesReport[i]['total_amount']).format("0.00"),
									moment(branchSalesReport[i]['created_at']).format("MMM DD, YYYY"),
								]);
								obj.$tableBranchSalesReport.draw(false);
							}
						}).always( function () {
							NProgress.done();
						});
					} else {
						obj.showAlert("<b>Sales Does Not Exist</b>", "info", "<span> Sales " + branchId + " has already been deleted in another session.<span>");
						obj.$keyTableApi.fnDeleteRow(obj.$keyTableApi.$('tr', {"filter":"applied"})[tableBranchesSelectedRowPos]);
					}
				}).always( function () {
					NProgress.done();
				});
			} 
		});
		
		
		obj.$btnViewSales.click( function () {
			if(tableBranchSalesReportCurrentRowPos >= 0){
				tableBranchSalesReportSelectedRowPos = tableBranchSalesReportCurrentRowPos;
				obj.$keyBranchSalesReport.fnBlur();
				var salesId = obj.$keyBranchSalesTableApi._('tr', {"filter":"applied"})[tableBranchSalesReportSelectedRowPos][1];
				var salesTotalAmount = obj.$keyBranchSalesTableApi._('tr', {"filter":"applied"})[tableBranchSalesReportSelectedRowPos][2];
				var salesDate = obj.$keyBranchSalesTableApi._('tr', {"filter":"applied"})[tableBranchSalesReportSelectedRowPos][3];
				obj.isSalesReportExist(salesId).always( function (isSalesReportExist) {
					NProgress.start();
					if(isSalesReportExist == 1){
						obj.getAllReceiptsViaSalesReportId(salesId).always( function (getAllReceiptsViaSalesReportId) {
							NProgress.start();
							var receipts = JSON.parse(getAllReceiptsViaSalesReportId);
							obj.$modalViewReceipts.modal("show");
							obj.$txtSalesReportId.text(salesId);
							obj.$txtSalesReportTotalAmount.text(salesTotalAmount);
							obj.$txtSalesReportDate.text(salesDate);
							obj.$tableReceipts.clear().draw();
							for(i=0; i<receipts.length; i++){
								obj.$tableReceipts.row.add([
									receipts[i]['id'],
									receipts[i]['receipt_id_from_branch'],
									numeral(receipts[i]['total_amount']).format("0.00"),
									moment(receipts[i]['created_at']).format("MMM DD, YYYY"),
								]);
								obj.$tableReceipts.draw(false);
							}
						}).always( function () {
							NProgress.done();
						});
					} else {
						obj.showAlert("<b>Sales Does Not Exist</b>", "info", "<span> Sales " + branchId + " has already been deleted in another session.<span>");
						obj.$keyTableApi.fnDeleteRow(obj.$keyTableApi.$('tr', {"filter":"applied"})[tableBranchSalesReportSelectedRowPos]);
					}
				}).always( function () {
					NProgress.done();
				});
			}
		});

		obj.$btnViewReceiptsItem.click( function () {
			if(tableReceiptsCurrentRowPos >= 0){
				tableReceiptsSelectedRowPos = tableReceiptsCurrentRowPos;
				obj.$keyReceipts.fnBlur();
				var id = obj.$keyReceiptTableApi._('tr', {"filter":"applied"})[tableReceiptsSelectedRowPos][0];
				var receiptId = obj.$keyReceiptTableApi._('tr', {"filter":"applied"})[tableReceiptsSelectedRowPos][1];
				var totalAmount =  obj.$keyReceiptTableApi._('tr', {"filter":"applied"})[tableReceiptsSelectedRowPos][2];
				var date =  obj.$keyReceiptTableApi._('tr', {"filter":"applied"})[tableReceiptsSelectedRowPos][3];
				
				obj.getAllItemsFromThisReceipt(id).always( function (getAllItemsFromThisReceipt) {
					NProgress.start();
					var items = JSON.parse(getAllItemsFromThisReceipt);
					obj.$tableReceiptsItems.clear().draw();
					obj.$txtReceiptId.text(receiptId);
					obj.$txtReceiptAmount.text(totalAmount);
					obj.$txtReceiptDate.text(moment(date).format("MMM DD, YYYY"));
					for(i=0; i<items.length; i++){
						obj.$tableReceiptsItems.row.add([
							items[i]['item_id'],
							items[i]['description'],
							numeral(items[i]['price']).format("0.00"),
							items[i]['quantity']
						]);
						obj.$tableReceiptsItems.draw(false);
					}

					obj.$modalViewReceiptsItem.modal("show");
				}).always( function () {
					NProgress.done();
				});
				
				
			}
			
		});

		obj.$inputImportReportFileDialog.change( function (e) {
			var reportFile = this.files[0];
			var fileReader = new FileReader();
			obj.$importSalesReportFile;
			fileReader.onload = obj.importReports;
			fileReader.readAsText(reportFile);
			this.value = null;
		});
	};

	return {
		run: function () {
			initialize();
			bindEvents();
		}
	};
})();