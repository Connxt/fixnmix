var ItemDistribution = (function () {
	var obj = {};
	var tableDeliveryLogsCurrentRowPos = -1;
	var tableDeliveryLogsSelectedRowPos = -1;
	var tableDeliverItemsCurrentRowPos = -1;
	var tableDeliverItemsSelectedRowPos = -1;
	var initialize = function () {
		obj = {
			$tableDeliveryLogs: $("#delivery_logs_table").DataTable({
				"columns": [
					{ "sClass": "text-left font-bold", "sWidth": "10%" },
					{ "sClass": "text-left font-bold", "sWidth": "35%" },
					{ "sClass": "text-left font-bold", "sWidth": "13%" },
					{ "sClass": "text-left font-bold", "sWidth": "4%" },
				],
				"bLengthChange": false,
				responsive: true,
		        scrollCollapse: false,
		        "bAutoWidth": false
			}),
			$tableDeliverItems: $("#deliver_items_table").DataTable({
				"columns": [
					{ "sClass": "text-left font-bold", "sWidth": "10%" },
					{ "sClass": "text-left font-bold", "sWidth": "50%" },
					{ "sClass": "text-left font-bold quantity editable", "sWidth": "10%" },
				],
				"bLengthChange": false,
				responsive: true,
		        scrollCollapse: false,
		        "bAutoWidth": false,
		        "bFilter":false,
		        "rowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
					obj.makeColumnQuantityEditable();
				}
			}),
			$tableSelecItems: $("#select_items_distribution_table").DataTable({
				"columns": [
					{ "sClass": "text-left font-bold", "sWidth": "20%" },
					{ "sClass": "text-left font-bold", "sWidth": "70%" }
				],
				"bLengthChange": false,
				responsive: true,
		        scrollCollapse: false,
		        "bAutoWidth": false,
		        "bFilter":false
			}),
			$tableDeliveryStatus: $("#delivery_status_table").DataTable({
				"columns": [
					{ "sClass": "text-left font-bold", "sWidth": "70%" },
					{ "sClass": "text-left font-bold", "sWidth": "50%" }
				],
				"bLengthChange": false,
				responsive: true,
		        scrollCollapse: false,
		        "bAutoWidth": false,
		        "bFilter":false,
		        "bInfo": false,
		        "bPaginate": false
			}),
			$tableDeliveryInfoList: $("#delivery_list").DataTable({
				"columns": [
					{ "sClass": "text-left font-bold", "sWidth": "15%" },
					{ "sClass": "text-left font-bold", "sWidth": "45%" },
					{ "sClass": "text-left font-bold", "sWidth": "15%" }
				],
				"bLengthChange": false,
				responsive: true,
		        scrollCollapse: false,
		        "bAutoWidth": false,
		        "bFilter":false
			}),
			$selectBranchElementById: $("#select_branch"),
			$selectBranch: $("#select_branch").chosen({width: '100%;',}),
			$keyTableApiDeliveryLogs: $("#delivery_logs_table").dataTable(),
			$keyTableApiDeliverItems: $("#deliver_items_table").dataTable(),
			$keyDeliveryLogs: new $.fn.dataTable.KeyTable($("#delivery_logs_table").dataTable()),
			$keyDeliveryInfoList: new $.fn.dataTable.KeyTable($("#delivery_list").dataTable()),
			$keyDeliverItems: new $.fn.dataTable.KeyTable($("#deliver_items_table").dataTable()),
			$btnViewDeliveredItemsFromLogs: $("#btn_view_delivered_logs"),
			$btnRefreshDeliveredItemsOnLogs: $("#btn_refresh_delivered_logs"),
			$btnSelectItems: $("#btn_select_items"),
			$btnAddSelectedItems: $("#btn_add_selected_items"),
			$btnDeleteSelectedItem: $("#btn_delete_selected_items"),
			$btnDeliverSelectedItems: $("#btn_deliver_selected_items"),
			$btnGenerateFile: $("#btn_generate_file"),
			$btnPrintDeliveredItems: $("#btn_print_item_delivered"),
			$modalDeliveryInformation: $("#delivery_information_modal"),
			$modalSelectItems: $("#select_items_modal_distribution"),
			$modalDeliveryStatus: $("#delivery_status_modal"),
			$modalPrintDeliveredItems: $("#print_delivered_items_modal"),
			$viewDeliveryId: $("#show_delivery_id"),
			$viewDeliveryDate: $("#show_delivery_date"),
			$viewBranchDelivered: $("#show_branch_delivered"),
			$toggleSelectItems: $("#select_items_distribution_table tbody"),
			$deliveryStatusMessage: $("#delivery_status_message"),
			$frmPrintDeliveries: $("#frm_print_deliveries"),
			spanSuccess: ("<span class='label label-primary'>Success</span>"),
			spanFailed: ("<span class='label label-danger' style='padding:0.2em 1em 0.3em'>Failed</span>"),
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
			getDelivery: function(deliveryId){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_delivery", {deliveryId: deliveryId}, function (data){});
			},
			getAllDeliveries: function(){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_all_deliveries",{},function (data) {});
			},
			checkIfDeliveryIdExists: function(deliveryId){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/delivery_exists", {deliveryId: deliveryId}, function (data){});
			},
			getAllItems: function(){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_all_items", {},function (data){});
			},
			getItem: function(itemId){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_item_info",{itemId:itemId},function (data){});
			},
			getAllBranches: function(){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_all_branches",{},function (data){});
			},
			getAllItemsFromDelivery: function(deliveryId){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_all_items_from_this_delivery",{deliveryId:deliveryId},function (data){});
			},
			checkIfItemQuantityIsEnough: function(numOfBranches, items){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_items_with_insufficient_quantity",{
							numOfBranches:numOfBranches,
							items:items
						},function (data){});
			},
			getItemsThatDoNotExist: function(itemIds){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_items_that_do_not_exist",{itemIds: itemIds},function (data){});
			},
			newDelivery: function (branchId, items){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/new_delivery",{
							branchId:branchId,
			 				items:items
			 			},function (data){});
			},
			getDefaultPath: function (){
				return $.post(BASE_URL + "settings_controller/get_default_save_path",{},function (data){});
			},
			writeDeliveryDataToFile: function(filePath, deliveryData, deliveryId){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/write_delivery_data_to_file",{
							filePath: filePath,
							deliveryData: deliveryData,
							deliveryId: deliveryId
						},function (data){});
			},
			generateDeliveryData: function (deliveryId, filePath){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/generate_delivery_data",{
							deliveryId: deliveryId,
							filePath: filePath
						},function (data){});
			},
			disableButtons: function (){
				obj.$btnDeliverSelectedItems.attr("disabled","disabled");
				obj.$btnDeleteSelectedItem.attr("disabled","disabled");
				obj.$btnGenerateFile.attr("disabled", "disabled");
				obj.$btnViewDeliveredItemsFromLogs.attr("disabled","disabled");
			},
			makeColumnQuantityEditable: function(){
				$("#deliver_items_table tbody td.editable").each(function () {
					obj.$keyDeliverItems.event.remove.action(this);
					obj.$keyDeliverItems.event.action(this, function (nCell) {
						tableDeliverItemsSelectedRowPos = tableDeliverItemsCurrentRowPos;
						obj.$keyDeliverItems.block = true;
						$(nCell).editable(function (sVal) {
							obj.$keyDeliverItems.block = false;
							sVal = numeral(sVal).format("0");
							if($(this).hasClass("quantity")){
		        				var selectedRow = (obj.$keyTableApiDeliverItems.$('tr', {"filter":"applied"})[tableDeliverItemsSelectedRowPos]);
								obj.$keyTableApiDeliverItems.fnUpdate(sVal, selectedRow, 2, false);
							}
							$(nCell).editable("destroy");
							return sVal;
						}, {
							"onblur": "submit",
							cssclass : 'form-class',
							height:($("span#edit").height() + 25) + "px",
							"onreset": function () {
								setTimeout(function () {
									obj.$keyDeliverItems.block = false;
								}, 0);
							}
						});
						setTimeout(function () {
							$(nCell).click();
						}, 0);
					});
				});
			},
			refreshDeliveryLogsTable: function(){
				obj.getAllDeliveries().always(function (getAllDeliveries){
					NProgress.start();
					obj.$tableDeliveryLogs.clear().draw();
					var getAllDeliveries = JSON.parse(getAllDeliveries);
					for(var i=0; i<getAllDeliveries.length; i++){
						obj.$tableDeliveryLogs.row.add([
							getAllDeliveries[i]['id'],
							getAllDeliveries[i]['branchId'],
							moment(getAllDeliveries[i]['created_at']).format("MMM DD, YYYY"),
							(getAllDeliveries[i]['status'] == 1) ? obj.spanSuccess : obj.spanFailed
						]);
					}
					obj.$tableDeliveryLogs.draw(false);
				}).always(function (){
					NProgress.done();
				});
			}
		};
	};
	var bindEvents = function () {
		obj.disableButtons();
		obj.refreshDeliveryLogsTable();
		obj.$selectBranchElementById.change(function (){
			if(obj.$selectBranchElementById.val() === null){
				obj.$btnDeliverSelectedItems.attr("disabled","disabled");
			}
			else{
				obj.$btnDeliverSelectedItems.removeAttr("disabled");
			}
		});
		// keytable events for keytableDeliveryLogs		
		obj.$keyDeliveryLogs.event.focus(null, null, function (node, x, y) {
			tableDeliveryLogsCurrentRowPos = y;
			obj.$btnViewDeliveredItemsFromLogs.removeAttr("disabled");
			obj.$btnGenerateFile.removeAttr("disabled");
			obj.$btnPrintDeliveredItems.removeAttr("disabled");
		});

		obj.$keyDeliveryLogs.event.blur(null, null, function (node, x, y) {
			tableDeliveryLogsCurrentRowPos  = -1;
			obj.$btnPrintDeliveredItems.attr("disabled", "disabled");
			obj.$btnViewDeliveredItemsFromLogs.attr("disabled","disabled");
			obj.$btnGenerateFile.attr("disabled", "disabled");
		});
		// keytable events for keytableDeliverItems
		obj.$keyDeliverItems.event.focus(null, null, function (node, x, y){
			tableDeliverItemsCurrentRowPos = y;
			obj.$btnDeleteSelectedItem.removeAttr("disabled");
		});

		obj.$keyDeliverItems.event.blur(null, null, function (node, x, y){
			tableDeliverItemsCurrentRowPos = -1;
			obj.$btnDeleteSelectedItem.attr("disabled","disabled");
		});

		obj.$toggleSelectItems.on("click", "tr", function () {
        	$(this).toggleClass("success");
    	});

		obj.getAllBranches().always(function (getAllBranches){
			var getAllBranches = JSON.parse(getAllBranches);
			for(var i=0; i<getAllBranches.length; i++){
				obj.$selectBranchElementById.append('<option value='+ getAllBranches[i]['id'] +'>'+ getAllBranches[i]['id'] +'</option>');
				obj.$selectBranchElementById.trigger("chosen:updated");
			}
		});

		// delivery logs bindedevents
		obj.$btnViewDeliveredItemsFromLogs.click(function(){
			if(tableDeliveryLogsCurrentRowPos >= 0 ){
				tableDeliveryLogsSelectedRowPos = tableDeliveryLogsCurrentRowPos;
				obj.$keyDeliveryLogs.fnBlur();
				var deliveryId = obj.$keyTableApiDeliveryLogs._('tr', {"filter":"applied"})[tableDeliveryLogsSelectedRowPos][0];
				obj.checkIfDeliveryIdExists(deliveryId).always(function (deliveryIdExists){
					if(deliveryIdExists >= 1){
						NProgress.start();
						obj.$modalDeliveryInformation.modal("show");
						obj.getDelivery(deliveryId).always(function (getDelivery){
							var getData = JSON.parse(getDelivery);
							$.each(getData, function(){
								obj.$viewDeliveryId.text(this.id);
								obj.$viewDeliveryDate.text((moment(this.created_at)).format("MMM DD, YYYY"));
								obj.$viewBranchDelivered.text(this.branch_id);
							});
						});
						obj.getAllItemsFromDelivery(deliveryId).always(function (getAllItemsFromDelivery){
							var getAllItemsFromDelivery = JSON.parse(getAllItemsFromDelivery);
							obj.$tableDeliveryInfoList.clear().draw();
							for(var i=0; i<getAllItemsFromDelivery.length; i++){
								obj.$tableDeliveryInfoList.row.add([
									getAllItemsFromDelivery[i]['item_id'],
									getAllItemsFromDelivery[i]['description'],
									numeral(getAllItemsFromDelivery[i]['quantity']).format("0,0")
								]);
							}
							obj.$tableDeliveryInfoList.draw(false);
						}).always(function(){
							NProgress.done();
						});
					}
					else{
						obj.showAlert("<b>Delivery Does Not Exist</b>", "info", "<span> Delivery ID " + deliveryId + " has already been deleted in another session.<span>");
						obj.$keyTableApiDeliveryLogs.fnDeleteRow(obj.$keyTableApiDeliveryLogs.$('tr', {"filter":"applied"})[tableDeliveryLogsSelectedRowPos]);
					}
				});
			}
		});
		
		obj.$btnGenerateFile.click(function (){
			if(tableDeliveryLogsCurrentRowPos >= 0 ){
				tableDeliveryLogsSelectedRowPos = tableDeliveryLogsCurrentRowPos;
				obj.$keyDeliveryLogs.fnBlur();
					obj.getDefaultPath().always(function (defaultPath){
						var selectedRow = (obj.$keyTableApiDeliveryLogs.$('tr', {"filter":"applied"})[tableDeliveryLogsSelectedRowPos]),
							deliveryId = obj.$keyTableApiDeliveryLogs._('tr', {"filter":"applied"})[tableDeliveryLogsSelectedRowPos][0],
							branchId = obj.$keyTableApiDeliveryLogs._('tr', {"filter":"applied"})[tableDeliveryLogsSelectedRowPos][1],
							transactionType = ("DELIVER_ITEMS"),
							mainId = ("MAIN001"),
							extension = (".json"),
							fileName = (transactionType +"_"+ deliveryId +"_" + mainId +"_"+ branchId),
							filePath = (defaultPath + fileName + extension);
						obj.generateDeliveryData(deliveryId, filePath).always(function (returnData){
							if(returnData >=1){
								obj.$keyTableApiDeliveryLogs.fnUpdate(obj.spanSuccess, selectedRow, 3, false);
								obj.showAlert("<b>File Export Success</b>", "success", "<span>Your file "+ fileName +" has been successfuly created.<span>");
							}
							else{
								obj.$keyTableApiDeliveryLogs.fnUpdate(obj.spanFailed, selectedRow, 3, false);
								obj.showAlert("<b>File Export Failed</b>", "error", "<span>Your file "+ fileName +"  has not been created. Please check your directory path settings.<span>");
							}
						});
				});
			}
		});

		obj.$btnPrintDeliveredItems.click(function (){
			if(tableDeliveryLogsCurrentRowPos >= 0 ){
				tableDeliveryLogsSelectedRowPos = tableDeliveryLogsCurrentRowPos;
				obj.$keyDeliveryLogs.fnBlur();
				deliveryId = obj.$keyTableApiDeliveryLogs._('tr', {"filter":"applied"})[tableDeliveryLogsSelectedRowPos][0];
				obj.checkIfDeliveryIdExists(deliveryId).always(function (deliveryIdExists){
					if(deliveryIdExists >= 1){
						obj.getAllItemsFromDelivery(deliveryId).always(function (getAllItemsFromDelivery){
							obj.getDelivery(deliveryId).always(function (getDelivery){
								var deliveryInfo = JSON.parse(getDelivery),
									allItemsFromDelivery = JSON.parse(getAllItemsFromDelivery),
									columns = {},
									options = {},
									string,
									dataToPrint,
									totalDeliveredQuantity = 0,
									totalDeliveredAmount = 0,
									textData = "[",
									totalPagesExp = "{total_pages_count_string}",
									doc = new jsPDF("p", "pt"),
									header = function (x, y, width, height, key, value, settings) {
								        doc.setFillColor(26, 188, 156);
								        doc.setTextColor(255, 255, 255);
								        doc.setFontStyle('bold');
								        doc.rect(x, y, width, height, 'F');
								        y += settings.lineHeight / 2 + doc.autoTableTextHeight() / 2;
								        doc.text(value, x + settings.padding, y);
								    },
								    cell = function (x, y, width, height, key, value, row, settings) {
								        var style = 'S';
								        doc.setLineWidth(0.1);
								        doc.setDrawColor(240);
								        doc.rect(x, y, width, height, style);
								        y += settings.lineHeight / 2 + doc.autoTableTextHeight() / 2 - 2.5;
								        doc.text(value, x + settings.padding, y);
								        doc.setTextColor(50);
								    },
								    footer = function (doc, lastCellPos, pageCount, options) {
								        var str = "Page " + pageCount;
								        doc.text(str, options.margins.horizontal, doc.internal.pageSize.height - 30);
								    }
								    
							    options = {
									renderHeaderCell: header, renderFooter: footer, renderCell: cell, fontSize: 13, margins: { horizontal: 20, top:200, bottom: 50},
									startY: false, overflow: 'ellipsize', overflowColumns: false, avoidPageSplit: false, extendWidth: true 
								};
								columns = [
								    {title: "Item ID", key: "itemId"},
								    {title: "Description", key: "description"},
								    {title: "Price", key: "price"},
								    {title: "Quantity", key: "quantity"},
								    {title: "Total", key: "total"},
								];
								for(var i=0; i<allItemsFromDelivery.length; i++){
									totalDeliveredQuantity += parseFloat(allItemsFromDelivery[i]["quantity"]);
									totalDeliveredAmount += parseFloat(allItemsFromDelivery[i]["price"] * allItemsFromDelivery[i]["quantity"]);
									textData += '{';
									textData += '"itemId":' + allItemsFromDelivery[i]["item_id"] + ', ';
									textData += '"description":' + '"' +  allItemsFromDelivery[i]["description"] + '", ';
									textData += '"quantity":' + '"' + numeral(allItemsFromDelivery[i]["quantity"]).format("0,0") + '", ';
									textData += '"price":' + '"' + numeral(allItemsFromDelivery[i]["price"]).format("0,0.00") + '", ';
									textData += '"total":' + '"' + numeral(allItemsFromDelivery[i]["price"] * allItemsFromDelivery[i]["quantity"]).format("0,0.00") + '"';
									textData += '},';
								}
								textData = textData.substring(0, textData.length - 1);
								textData += "]";
								dataToPrint = JSON.parse(textData);
				    			doc.autoTable(columns, dataToPrint, options);
				    			doc.setFontType("bold");
							    doc.alignedText("FIX N MIX BAKERS INCORPORATED",{align: "center"}, 0, 50);

							    doc.setFontType("normal");
							    doc.setFontSize(12);
							    doc.alignedText("AR Zayco Subdivision, Kabankalan City 6111",{align: "center"}, 0, 70);
							    doc.alignedText("Tel. No/s.: 034-4712122/09220778001",{align: "center"}, 0, 90);

							    doc.setFontType("bold");
							    doc.setFontSize(13);
							    doc.alignedText("Delivery Receipt", {align: "center"}, 0, 120);

							    $.each(deliveryInfo, function(){
							    	doc.setFontType("normal");
							    	doc.setFontSize(12);
								    doc.text("Branch: " + this.branch_id , 25, 175);
								    doc.text("Date: " + moment(this.created_at).format("MMM DD, YYYY") , 470, 175);
								});

								doc.setFontType("normal");
								doc.setFontSize(12);
							    doc.text("Total Quantity: " + numeral(totalDeliveredQuantity).format("0,0"), 420, doc.autoTableEndPosY() + 45);
							    doc.text("Total Amount: " + numeral(totalDeliveredAmount).format("0,0.00"), 420, doc.autoTableEndPosY() + 25);

							    string = doc.output("datauristring");
							    obj.$frmPrintDeliveries.attr("src", string);
								obj.$modalPrintDeliveredItems.modal("show");
							});
						});
					}
					else{
						obj.showAlert("<b>Delivery Does Not Exist</b>", "info", "<span> Delivery ID " + deliveryId + " has already been deleted in another session.<span>");
						obj.$keyTableApiDeliveryLogs.fnDeleteRow(obj.$keyTableApiDeliveryLogs.$('tr', {"filter":"applied"})[tableDeliveryLogsSelectedRowPos]);
					}
				});
			}
		});

		obj.$btnRefreshDeliveredItemsOnLogs.click(function (){
			obj.refreshDeliveryLogsTable();
		});

		// Deliver items bindedevents
		obj.$btnAddSelectedItems.click(function (){
			var validItemsSelected = [],
				tableDeliverItemsData = (obj.$tableDeliverItems.rows().data()),
				tableSelectItemsData = (obj.$tableSelecItems.rows('.success').data()),
				itemsSelected = $.map(tableDeliverItemsData, function (renderedItems){ return (renderedItems[0]) }),
				itemsToBeSelected = $.map(tableSelectItemsData, function (selectedItems){ return (selectedItems[0]) });
			for(var i=0; i<itemsToBeSelected.length; i++){
				var isEqual = false;
				for(var j=0; j<itemsSelected.length; j++){
					if(itemsSelected[j] == itemsToBeSelected[i]){
						isEqual = true;
					}
				}
				if(!isEqual){
					validItemsSelected.push(itemsToBeSelected[i])
				}
			}
			if (validItemsSelected.length == 0){
				obj.$modalSelectItems.modal("hide");
			}
			else{
				NProgress.start();	
				for(var i=0; i<validItemsSelected.length; i++){
					obj.getItem(validItemsSelected[i]).always(function (getItem){
						var getItem = JSON.parse(getItem);
						$.each(getItem, function (){
							obj.$tableDeliverItems.row.add([
								this.id,
								this.description,
								0,
							]);
						});
						obj.$tableDeliverItems.draw(false);
						obj.$modalSelectItems.modal("hide");
					});
				}
				NProgress.done();
			}
		});
		
		obj.$btnDeliverSelectedItems.click(function (){
			var selectedBranchesData = (obj.$selectBranchElementById.val()),
				branchesToDeliver =  $.map(selectedBranchesData, function (branchesToDeliver){ return (branchesToDeliver) }),
				itemsToDeliver = (obj.$tableDeliverItems.rows().data().toArray()),
				numOfBranches = selectedBranchesData.length,
				itemsThatHasLessQuantity = [],
				branchUnableToExportToFile = [],
				branchSuccessExportToFile = [],
				items = [],
				itemIds = [];
			if(itemsToDeliver.length >= 1){
				NProgress.start();
				for(var i = 0; i < itemsToDeliver.length; i++){
					itemIds.push(itemsToDeliver[i][0]);
				}
				obj.getItemsThatDoNotExist(itemIds).always(function (checkIfItemIdsDoNotExist){
					var itemIdsThatDoNotExist = JSON.parse(checkIfItemIdsDoNotExist);
					if(itemIdsThatDoNotExist.length <= 0){
						for(var i=0; i<itemsToDeliver.length; i++){
							items.push ({
								itemId: itemsToDeliver[i][0],
								quantity: itemsToDeliver[i][2]
							});
						}
						obj.checkIfItemQuantityIsEnough(numOfBranches, items).always(function (checkIfItemQuantityIsEnough){
							var itemsWithNotEnoughQuantity = JSON.parse(checkIfItemQuantityIsEnough);
							if(itemsWithNotEnoughQuantity.length <= 0){
								obj.showConfirm("Are you sure you want to deliver items?", "warning", "Yes, deliver it!", "No, cancel please!", function (isConfirm){
								  	if (isConfirm) {
								  		obj.$btnDeliverSelectedItems.attr("disabled","disabled");
								  		var asyncCounter = 0;
								  		for(var j=0; j<branchesToDeliver.length; j++){
											var items = [];
											for(var i=0; i<itemsToDeliver.length; i++){
												var branchId = branchesToDeliver[j];
												items.push({
													itemId: itemsToDeliver[i][0],
													quantity: itemsToDeliver[i][2]
												});
											}
											obj.newDelivery(branchId, items).always(function (deliveryData){
												obj.getDefaultPath().always(function (defaultPath){
													var itemDeliveryData = JSON.parse(deliveryData),
														branchId = (itemDeliveryData.branch_id),
														transactionType = (itemDeliveryData.transaction),
														mainBranchId = (itemDeliveryData.main_id),
														deliveryId = (itemDeliveryData.id),
														fileName = (transactionType.toUpperCase() + "_" + deliveryId +"_"+ mainBranchId + "_" +  branchId),
														extension = ".json",
														filePath = (defaultPath + fileName + extension);
													obj.writeDeliveryDataToFile(filePath, deliveryData, deliveryId).always(function (returnData){
														if(returnData >=1){
															branchSuccessExportToFile.push(branchId);
															obj.$deliveryStatusMessage.empty().append("<h5 style='color:#3C8DBC;'>Export success. You can still generate the file again in the delivery logs section.</h5>");
														}
														else{
															branchUnableToExportToFile.push(branchId);
															obj.$deliveryStatusMessage.empty().append("<h5 style='color:red;'>File Export Failed. Please check your directory path settings. You can generate the file again in the delivery logs section.</h5>");
														}
														if(asyncCounter >= (branchesToDeliver.length - 1)) {
															NProgress.done();
															for(var i=0; i<branchSuccessExportToFile.length; i++){
																obj.$tableDeliveryStatus.row.add([
																	branchSuccessExportToFile[i],
																	obj.spanSuccess
																]);
															}
															obj.$tableDeliveryStatus.draw(false);
															for(var i=0; i<branchUnableToExportToFile.length; i++){
																obj.$tableDeliveryStatus.row.add([
																	branchUnableToExportToFile[i],
																	obj.spanFailed
																]);
															}
															obj.$tableDeliveryStatus.draw(false);
															obj.$modalDeliveryStatus.modal("show");
															obj.$selectBranchElementById.val('').trigger("chosen:updated");
															obj.$tableDeliverItems.clear().draw();
															obj.refreshDeliveryLogsTable();
														}
														asyncCounter++;
													});
												});
											});
										}
										obj.$tableDeliveryStatus.clear().draw();
								  	}
								  	else{
								  		NProgress.done();
								  	}
								});		 
							}
							else{
								NProgress.done();
								for(var i=0; i<itemsWithNotEnoughQuantity.length; i++){
									itemsThatHasLessQuantity.push(
										"<li style='text-align:left;'><h4>" 
											+ "Item id: " + "<strong>" + itemsWithNotEnoughQuantity[i]['id'] + ".</strong>" 
											+ "  Requested Qty: " + "<strong>" + itemsWithNotEnoughQuantity[i]['requested_quantity'] + ".</strong>" 
											+ "  Available Qty: " + "<strong>" + itemsWithNotEnoughQuantity[i]['available_quantity'] + "</strong>"
										+"</h4></li>"
									);
								}
								obj.showAlert("<h4><b>The following items cannot be delivered. Requested quantity is greater than the saved quantity in the inventory</b></h4>", 
									"warning", "<ul style='display:table; margin: 0 auto;list-style:none; padding:0;'>"+itemsThatHasLessQuantity.join("")+"</ul>" 
								);
							}
						});
					}
					else{
						NProgress.done();
						obj.showAlert("<b>Item Does Not Exist</b>", "warning", "<span>Items "+ itemIdsThatDoNotExist +" has already been deleted in another session. Please delete the items in the list<span>");
					}
				});
			}
			else{
				NProgress.done();
				obj.showAlert("<b>Item List is Empty</b>", "info", "<span>Please select items to deliver.<span>");
			}
		});
		
		obj.$btnDeleteSelectedItem.click(function (){
			if(tableDeliverItemsCurrentRowPos >= 0){
				tableDeliverItemsSelectedRowPos = tableDeliverItemsCurrentRowPos;
				obj.$keyDeliverItems.fnBlur();
				obj.$keyTableApiDeliverItems.fnDeleteRow(obj.$keyTableApiDeliverItems.$('tr', {"filter":"applied"})[tableDeliverItemsSelectedRowPos]);
			}
		});

		obj.$btnSelectItems.click(function(){
			obj.getAllItems().always(function (getAllItems){
				NProgress.start();
				var getAllItems = JSON.parse(getAllItems);
				obj.$tableSelecItems.clear().draw();
				for(var i=0; i < getAllItems.length; i++){
					obj.$tableSelecItems.row.add([
						getAllItems[i]['id'],
						getAllItems[i]['description']
					]);
				}
				obj.$tableSelecItems.draw(false);
				obj.$modalSelectItems.modal("show");
			}).always(function(){
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
