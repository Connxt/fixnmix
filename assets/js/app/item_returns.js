var ItemReturns = (function() {
	var obj = {};
	var tableItemsReturnCurrentRowPos = -1;
	var tableItemsReturnSelectedRowPos = -1;
	var initialize = function () {
		obj = {
			$tableItemsReturns: $("#item_returns_table").DataTable({
				"columns": [
					{ "sClass": "text-left font-bold", "sWidth": "10%" },
					{ "sClass": "text-left font-bold", "sWidth": "35%" },
					{ "sClass": "text-left font-bold", "sWidth": "13%" },
				],
				"bLengthChange": false,
				responsive: true,
				deferRender: true,
		        scrollCollapse: false,
		       	 "bAutoWidth": false
			}),

			$tableReceiveItems: $("#receive_returned_items_table").DataTable({
				"columns": [
					{ "sClass": "text-left font-bold", "sWidth": "10%" },
					{ "sClass": "text-left font-bold", "sWidth": "35%" },
					{ "sClass": "text-left font-bold", "sWidth": "10%" },
				],
				"bLengthChange": false,
				responsive: true,
				deferRender: true,
		        scrollCollapse: false,
		       	 "bAutoWidth": false,
		       	  "bFilter": false
			}),

			$tableViewReturnedeItems: $("#view_returned_items_table").DataTable({
				"columns": [
					{ "sClass": "text-left font-bold", "sWidth": "10%" },
					{ "sClass": "text-left font-bold", "sWidth": "35%" },
					{ "sClass": "text-left font-bold", "sWidth": "10%" },
				],
				"bLengthChange": false,
				responsive: true,
				deferRender: true,
		        scrollCollapse: false,
		       	 "bAutoWidth": false,
		       	 "bFilter": false
			}),

			$keyTableApi: $("#item_returns_table").dataTable(),
			$keyItemReturns: new $.fn.dataTable.KeyTable($("#item_returns_table").dataTable()),
			$btnRefreshItemReturn: $("#btn_refresh_item_returns"),
			$btnViewItemReturn: $("#btn_view_item_returns"),
			$btnReceiveReturnItems: $("#btn_receive_return_items"),
			$btnOpenFileDialogReturn: $("#btn_open_return_file_dialog"),
			$btnConfirmReturns: $("#btn_confirm_returns"),
			$inputFileDialogLoader: $("#input_open_return_file_dialog"),
			$txtfileDisplayArea: $("#fileDisplayArea"),
			$txtReturnId: $("#return_id"),
			$txtReturnedBranchId: $("#returned_branch_id"),
			$txtReturnedDate: $("#return_date"),
			$modalViewItemReturn: $("#view_item_return_modal"),
			$modalReceiveReturnItems: $("#recieve_return_item_modal"),
			$showReturnId: $("#show_return_id"),
			$showReturnDate: $("#show_return_date"),
			$showReturnBranch: $("#show_return_branch"),
			$tempJsonVarFile: "",
			// function
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
				this.$btnViewItemReturn.removeAttr("disabled");
			}, 
			disableActionButtons: function () {
				this.$btnViewItemReturn.attr("disabled","disabled");
			},
			checkifItemReturnIdExists: function (returnId) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/return_exists",{returnId: returnId, },function (data) {});
			},
			getReturn: function (returnId) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_return",{returnId: returnId,},function (data) {});
			},
			getAllReturns: function () {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_all_returns",{},function (data) {});
			},
			getAllItemsFromThisReturn: function (returnId) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_all_items_from_this_return",{returnId: returnId,},function (data) {});
			},
			checkifreturnIdFromBranchExist: function (returnIdFromBranch) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/return_exists_via_return_id_from_branch",{returnIdFromBranch: returnIdFromBranch,},function (data) {});
			},
			confirmNewReturn: function (returnData) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/new_return",{returnData: returnData,},function (data) {});
			},
			isTransactionReturnValid: function (mainId, branchId, returnIdFromBranch, transaction) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/is_transaction_valid",{mainId, branchId, returnIdFromBranch, transaction: mainId, branchId, returnIdFromBranch, transaction,},function (data) {});
			},
			getItemInfo: function (itemId) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_item_info",{itemId: itemId,},function (data) {});
			},
			decryptReturnData: function (returnData) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/decrypt_return_data",{returnData: returnData,},function (data) {});
			},	

			deleteReturnDataFile: function (filePath) {
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/delete_return_data_file",{filePath: filePath,},function (data) {});
			},
			
			refreshItemReturns: function () {
				obj.$tableItemsReturns.clear().draw();
				NProgress.start();
				obj.getAllReturns().always(function (getAllReturns) {
					var getAllData = JSON.parse(getAllReturns);
					for(var i=0; i<getAllData.length; i++) {
						obj.$tableItemsReturns.row.add([
							getAllData[i]['id'],
							getAllData[i]['branchId'],
							moment(getAllData[i]['created_at']).format("MMM DD, YYYY")

						]).draw(false);
					}
				}).always(function () {
					NProgress.done();
				});
			},

			receiveReturns: function (e) {
				var data = e.target.result;
				if(data != "") {	
						obj.decryptReturnData(data).always(function (decryptReturnData) {
							try{
								var returnData = JSON.parse(decryptReturnData);
								var transaction = returnData.transaction;
								var returnIdFromBranch = returnData.id;
								var mainId = returnData.main_id;
								var branchId = returnData.branch_id;

								obj.$tableReceiveItems.clear().draw();
								obj.isTransactionReturnValid (mainId, branchId, returnIdFromBranch, transaction).always(function (isTransactionReturn) {
									try{
										switch(isTransactionReturn) {
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
												obj.$txtReturnId.text(returnData.id);
											    obj.$txtReturnedBranchId.text(returnData.branch_id);
											    obj.$txtReturnedDate.text(moment().format("MMM/DD/YYYY"))
											    var asyncCounter = 0;
												for(var i=0; i<returnData.items.length; i++) {
													var itemId = returnData.items[i]['item_id'];
													var itemQuantity = returnData.items[i]['quantity'];	
													
													obj.getItemInfo(itemId).always(function (getItemInfo) {
														var t = JSON.parse(getItemInfo);
														var description = t[0].description;
														obj.$tableReceiveItems.row.add([
											 				returnData.items[asyncCounter]['item_id'],
															description,
											 				returnData.items[asyncCounter]['quantity']
											 			]).draw();
														asyncCounter++;
													});
										 		}
												obj.$modalReceiveReturnItems.modal("show");
												break;
											default:
													obj.showAlert("Stop", "warning", "Transaction is invalid.");
												break;
											}
									}catch (err) {
										obj.showAlert("Stop", "warning", "File content is invalid.");
									}
								});

							}catch(err) {
								obj.showAlert("Stop", "warning", "File content is invalid.");
							}
						}); 
				}else{
					obj.showAlert("Stop", "warning", "File is empty.");
				}
			}
		};
	};
	var bindEvents = function () {
		obj.disableActionButtons();
		obj.getAllReturns().always(function (getAllReturns) {
			NProgress.start();
			obj.$tableItemsReturns.clear().draw();
			var getAllData = JSON.parse(getAllReturns);
			for(i = 0; i < getAllData.length; i++) {
				obj.$tableItemsReturns.row.add([
					getAllData[i]['id'],
					getAllData[i]['branchId'],
				    moment(getAllData[i]['created_at']).format("MMM DD, YYYY")
				]).draw();
			}
		}).always(function () {
			NProgress.done();
		});

		obj.$keyItemReturns.event.focus(null, null, function (node, x, y) {
			tableItemsReturnCurrentRowPos = y;
			obj.enableActionButtons();
		});

		obj.$keyItemReturns.event.blur(null, null, function (node, x, y) {
			tableItemsReturnCurrentRowPos = -1;
			obj.disableActionButtons();
		});

		obj.$btnReceiveReturnItems.click(function () {
			obj.$inputFileDialogLoader.click();
		});
 		
  		obj.$btnViewItemReturn.click(function () {
			if(tableItemsReturnCurrentRowPos >= 0) {
				tableItemsReturnSelectedRowPos = tableItemsReturnCurrentRowPos;
				obj.$keyItemReturns.fnBlur();
				var returnId = obj.$keyTableApi._('tr', {"filter":"applied"})[tableItemsReturnSelectedRowPos][0];
				obj.checkifItemReturnIdExists(returnId).always(function (itemReturnIdExists) {

					if(itemReturnIdExists >= 1) {
						NProgress.start();
						obj.$modalViewItemReturn.modal("show");
						obj.getReturn(returnId).always(function (getReturn) {
							var getData = JSON.parse(getReturn);
							$.each(getData, function() {
								obj.$showReturnId.text(this.id);
								obj.$showReturnBranch.text(this.branch_id);
								obj.$showReturnDate.text(moment(this.created_at).format("MMM DD, YYYY"));
								});

							obj.getAllItemsFromThisReturn(returnId).always(function (getAllItemsFromThisReturn) {
								var getAllItemsFromThisReturn = JSON.parse(getAllItemsFromThisReturn);
								for(var i=0; i<getAllItemsFromThisReturn.length; i++) {
									var returnItem = getAllItemsFromThisReturn[i];
									obj.$tableViewReturnedeItems.row.add([
										returnItem['item_id'],
										returnItem['description'],
										returnItem['quantity']
									]);
								}
								obj.$tableViewReturnedeItems.draw(false);
							});
						}).always(function () {
							NProgress.done();
						});
					}
					else{
						obj.showAlert("Stop", "warning", "Please inform your administrator.");
						obj.$keyTableApi.fnDeleteRow(obj.$keyTableApi.$('tr', {"filter":"applied"})[tableItemsReturnSelectedRowPos]);
					}
				});
			}
		});
		
		obj.$btnConfirmReturns.click(function () {
			var filename = obj.$tempJsonVarFile;
			var fr = new FileReader();
            fr.onload = function (e) {
            	var  data = e.target.result;
            	obj.decryptReturnData(data).always( function (decryptReturnData) {
            		var returnData = JSON.parse(decryptReturnData);	

            		obj.confirmNewReturn(returnData).always( function (newReturn) {
						try{
							switch(newReturn) {
								case '-2':
									obj.showAlert("Stop", "warning", "Main store is invalid.");
									obj.$modalReceiveReturnItems.modal("hide");
									break;
								case '-1':
									obj.showAlert("Stop", "warning", "Branch store is invalid.");
									obj.$modalReceiveReturnItems.modal("hide");
									break;
								case '0':
									obj.showAlert("Stop", "warning", "Transaction is already finished.");
									obj.$modalReceiveReturnItems.modal("hide");
									break;
								case '1':
									obj.showAlert("Stop", "warning", "Transaction type is invalid.");
									obj.$modalReceiveReturnItems.modal("hide");
									break;
								case '2':
									obj.showAlert("Items successfully returned", "success", "");
									obj.$modalReceiveReturnItems.modal("hide");
									obj.refreshItemReturns();
								break;
								default:
									obj.showAlert("Stop", "warning", "Please inform your administrator.");
									obj.$modalReceiveReturnItems.modal("hide");
									break;
							}
						}catch(err) {
							obj.showAlert("Stop", "warning", "Please inform your administrator.");
						}
					});
            	});
			}
			fr.readAsText(filename);
		});

		obj.$inputFileDialogLoader.change(function (e) {
			var filename = this.files[0];
			var fr = new FileReader();
			obj.$tempJsonVarFile = filename;
  	 		fr.onload = obj.receiveReturns;
  	 		fr.readAsText(filename);
			this.value = null;
		});
 		
 		obj.$btnRefreshItemReturn.click(function () {
 			obj.refreshItemReturns();
		});
	};
	return {
		run: function () {
			initialize();
			bindEvents();
		}
	};
})();
;