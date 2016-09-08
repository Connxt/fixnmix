var Items = (function() {
	var obj = {};
	var tableItemsCurrentRowPos = -1;
	var tableItemsSelectedRowPos = -1;
	var initialize = function () {
		obj = {
			$tableItems: $("#items_table").DataTable({
				"columns": [
					{ "sClass": "text-left font-bold", "sWidth": "10%" },
					{ "sClass": "text-left font-bold", "sWidth": "40%" },
					{ "sClass": "text-left font-bold", "sWidth": "10%" },
					{ "sClass": "text-left font-bold", "sWidth": "10%" },
				],
				"bLengthChange": false,
				responsive: true,
				"bPaginate" : true, 
		        "bAutoWidth": false
			}),
			$keyTableApi: $("#items_table").dataTable(),
			$keyItems: new $.fn.dataTable.KeyTable($("#items_table").dataTable()),
			$btnNewItem: $("#btn_new_item"),
			$btnUpdateItem: $("#btn_update_item"),
			$btnAddQuantity: $("#add_quantity"),
			$btnDeductQuantity: $("#deduct_quantity"),
			$btnViewItem: $("#btn_view_item"),
			$btnRefreshItem: $("#btn_refresh_item"),
			$btnDeleteItem: $("#btn_delete_item"),
			$btnChooseQuantityAction: $("#btn_choose_quantity_action"),
			$modalNewItem: $("#new_item_modal"),
			$modalUpdateItem: $("#update_item_modal"),
			$modalAddQuantity: $("#add_quantity_modal"),
			$modalDeductQuantity: $("#deduct_quantity_modal"),
			$modalViewItem: $("#view_item_modal"),
			$frmNewItem: $("#frm_new_item"),
			$frmUpdateItem: $("#frm_update_item"),
			$frmAddQuantity: $("#frm_add_quantity"),
			$frmDeductQuantity: $("#frm_deduct_quantity"),
			$textBoxNewItemId: $("#item_id_new"),
			$textBoxNewPrice: $("#price_new"),
			$textBoxNewDescription: $("#description_new"),
			$textBoxUpdateItemId: $("#item_id_update"),
			$textBoxUpdatePrice: $("#price_update"),
			$textBoxUpdateDescription: $("#description_update"),
			$textBoxAddQuantity: $("#quantity_add"),
			$textBoxDeductQuantity: $("#quantity_deduct"),
			$textBoxViewItemId: $("#item_id_view"),
			$textBoxViewPrice: $("#price_view"),
			$textBoxViewQuantity: $("#quantity_view"),
			$textBoxViewDescription: $("#description_view"),
			$textItemIdDeduct: $("#item_id_deduct_quantity"),
			$textItemIdAdd: $("#item_id_add_quantity"),
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
				  	closeOnConfirm: false,
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
			enableActionButtons: function(){
				this.$btnUpdateItem.removeAttr("disabled");
				this.$btnChooseQuantityAction.removeAttr("disabled");
				this.$btnViewItem.removeAttr("disabled");
				this.$btnDeleteItem.removeAttr("disabled");
			},
			disableActionButtons: function(){
				this.$btnUpdateItem.attr("disabled","disabled");
				this.$btnChooseQuantityAction.attr("disabled","disabled");
				this.$btnViewItem.attr("disabled","disabled");
				this.$btnDeleteItem.attr("disabled","disabled");
			},
			checkIfItemIdExists: function (itemId){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/item_exists",{itemId: itemId,},function (data) {});
			},
			getAllItems: function (){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_all_items",{},function (data) {});
			},
			getItem: function (itemId){
				return $.post(BASE_URL + CURRENT_CONTROLLER + "/get_item",{itemId: itemId,},function (data) {});
			}
		};
	};

	var bindEvents = function() {
		obj.disableActionButtons();
		obj.getAllItems().always(function (getAllItems){
			NProgress.start();
			obj.$tableItems.clear().draw();
			var getAllData = JSON.parse(getAllItems);
			for(var i=0; i<getAllData.length; i++){
				obj.$tableItems.row.add([
					getAllData[i]['id'],
					getAllData[i]['description'],
					numeral(getAllData[i]['quantity']).format("0,0"),
					numeral(getAllData[i]['price']).format("0,0.00"),
				]);
				obj.$tableItems.draw(false);
			}
		}).always(function (){
			NProgress.done();
		});

		obj.$keyItems.event.focus(null, null, function (node, x, y) {
			tableItemsCurrentRowPos = y;
			obj.enableActionButtons();
		});

		obj.$keyItems.event.blur(null, null, function (node, x, y) {
			tableItemsCurrentRowPos = -1;
			obj.disableActionButtons();
		});

		obj.$btnNewItem.click(function(){
			obj.$frmNewItem[0].reset();
			obj.$modalNewItem.modal("show");
			obj.$textBoxNewItemId.numeric(false, function() {});
			var validatorNewItem = obj.$frmNewItem.validate({
				errorElement: "div",
				errorPlacement: function (error, element){
				error.appendTo("div#" + element.attr("name") + "_error")
				},
				rules:{
					item_id_new: {
						required: true,
						maxlength: 9
					},
					price_new: {
						required: true,
						number: true,
						min: true
					},
					description_new: {
						required: true,
					}
				},
				messages: {
					item_id_new: {
						required: "Please enter item's ID",
						maxlength: "Item's id should not be greater than 9 characters"
					},
					price_new: {
						required: "Please enter item's price",
						number: "Please enter a valid price",
						min: "Please enter a valid price"
					},
					description_new: {
						required: "Please enter item's description",
					}
				},
				submitHandler: function(form){
					var itemId = obj.$textBoxNewItemId.val();
					var price = obj.$textBoxNewPrice.val();
					var description = obj.$textBoxNewDescription.val();
					obj.checkIfItemIdExists(itemId).always(function (itemIdExists) {
						if(itemIdExists >= 1){
							obj.showAlert("<b>Already in Use</b>", "info", "<span>Item ID "+ itemId +" is already used by another item.<span>");
						}
						else{
							NProgress.start();
							$.post(BASE_URL + CURRENT_CONTROLLER + "/new_item",{
								itemId: itemId,
								price: price,
								description: description
							},function (data){
								obj.getItem(itemId).always(function (getItem){
									var insertedData = JSON.parse(getItem);
									var itemId, price, quantity, description;
									$.each(insertedData, function() {
										itemId = (this.id);
										price = (this.price);
										quantity = (this.quantity);
										description = (this.description);
										obj.$tableItems.row.add([
											itemId,
											description,
											numeral(quantity).format("0,0"),
											numeral(price).format("0,0.00")
										]);
										obj.$tableItems.draw(false);
									});
									obj.showAlert("<b>Item Added</b>", "success", "<span>Item ID "+ itemId + " has been successfully added.<span>");
									obj.$modalNewItem.modal("hide");
								});
							}).always(function (){
								NProgress.done();
							});
						}
					});
				}
			});
			validatorNewItem.resetForm();
		});

		obj.$btnAddQuantity.click(function(){
			if(tableItemsCurrentRowPos >= 0) {
				tableItemsSelectedRowPos = tableItemsCurrentRowPos;
				obj.$keyItems.fnBlur();
				var itemId = obj.$keyTableApi._('tr', {"filter":"applied"})[tableItemsSelectedRowPos][0];
				obj.$textItemIdAdd.text(itemId);
				obj.checkIfItemIdExists(itemId).always(function (itemIdExists){
					if(itemIdExists >= 1){
						NProgress.start();
						obj.$frmAddQuantity[0].reset();
						obj.$modalAddQuantity.modal("show");
						var validatorAddQuantity = obj.$frmAddQuantity.validate({
							errorElement: "div",
							errorPlacement: function (error, element){
							error.appendTo("div#" + element.attr("name") + "_error")
							},
							rules:{
								quantity_add: {
									required: true,
									min: 1,
									number: true
								}
							},
							messages: {
								quantity_add: {
									required: "Please enter quantity",
									min: "Quantity should not be less than 1.00",
									number: "Please enter a valid quantity"
								}
							},
							submitHandler: function(form){
								var addedQuantity = obj.$textBoxAddQuantity.val();
								var itemId = obj.$keyTableApi._('tr', {"filter":"applied"})[tableItemsSelectedRowPos][0];
								NProgress.start();
								$.post(BASE_URL + CURRENT_CONTROLLER + "/update_item_quantity",{
									quantity: addedQuantity,
									itemId: itemId
								},function (data){
									obj.getItem(itemId).always(function (getItem){
										var insertedData = JSON.parse(getItem);
										obj.$keyTableApi.fnDeleteRow(obj.$keyTableApi.$('tr', {"filter":"applied"})[tableItemsSelectedRowPos]);
										var itemId, price, quantity, description;
										$.each(insertedData,function(){
											itemId = (this.id);
											price = (this.price);
											quantity = (this.quantity);
											description = (this.description);
											obj.$tableItems.row.add([
												itemId,
												description,
												numeral(quantity).format("0,0"),
												numeral(price).format("0,0.00")
											]);
											obj.$tableItems.draw(false);
											obj.$modalAddQuantity.modal("hide");
											obj.showAlert("<b>Quantity Updated</b>", "success", "<span> " + addedQuantity + " Quantity has been successfully added to item ID " + itemId + ".<span>");
										});
									});
								}).always(function (){
									NProgress.done();
								});
							}
						});
						validatorAddQuantity.resetForm();
					}
					else{
						obj.showAlert("<b>Item ID Does Not Exist</b>", "info", "<span> Item ID " + itemId + " has already been deleted in another session.<span>");
						obj.$keyTableApi.fnDeleteRow(obj.$keyTableApi.$('tr', {"filter":"applied"})[tableItemsSelectedRowPos]);
					}
				}).always(function (){
					NProgress.done();
				});
			}
		});

		obj.$btnDeductQuantity.click(function(){
			if(tableItemsCurrentRowPos >= 0) {
				tableItemsSelectedRowPos = tableItemsCurrentRowPos;
				obj.$keyItems.fnBlur();
				var itemId = obj.$keyTableApi._('tr', {"filter":"applied"})[tableItemsSelectedRowPos][0];
				var quantity = obj.$keyTableApi._('tr', {"filter":"applied"})[tableItemsSelectedRowPos][2];
				obj.$textItemIdDeduct.text(itemId);
				if(quantity < 1 ){
					obj.showAlert("<b>Unable To Deduct</b>", "info", "<span>Quantity has a zero value.<span>");
				}
				else{
					obj.checkIfItemIdExists(itemId).always(function (itemIdExists){
						if(itemIdExists >= 1){
							NProgress.start();
							obj.$frmDeductQuantity[0].reset();
							obj.$modalDeductQuantity.modal("show");
							var validatorDeductQuantity = obj.$frmDeductQuantity.validate({
								errorElement: "div",
								errorPlacement: function (error, element){
								error.appendTo("div#" + element.attr("name") + "_error")
								},
								rules:{
									quantity_deduct: {
										required: true,
										min: 1,
										number: true
									}
								},
								messages: {
									quantity_deduct: {
										required: "Please enter quantity",
										min: "Quantity should not be less than 1.00",
										number: "Please enter a valid quantity"
									}
								},
								submitHandler: function(form){
									var deductedQuantity = (obj.$textBoxDeductQuantity.val() * -1);
									NProgress.start();
									var itemId = obj.$keyTableApi._('tr', {"filter":"applied"})[tableItemsSelectedRowPos][0];
									$.post(BASE_URL + CURRENT_CONTROLLER + "/update_item_quantity",{
										quantity: deductedQuantity,
										itemId: itemId
									},function (data){
										obj.getItem(itemId).always(function (getItem){
											var insertedData = JSON.parse(getItem);
											obj.$keyTableApi.fnDeleteRow(obj.$keyTableApi.$('tr', {"filter":"applied"})[tableItemsSelectedRowPos]);
											var itemId, price, quantity, description;
											$.each(insertedData,function(){
												itemId = (this.id);
												price = (this.price);
												quantity = (this.quantity);
												description = (this.description);
												obj.$tableItems.row.add([
													itemId,
													description,
													numeral(quantity).format("0,0"),
													numeral(price).format("0,0.00")
												]);
												obj.$tableItems.draw(false);
												obj.$modalDeductQuantity.modal("hide");
												obj.showAlert("<b>Quantity Updated</b>", "success", "<span>" + Math.abs(deductedQuantity) + " Quantity has been successfully deducted to item ID " + itemId +".<span>");
											});
										});
									}).always(function (){
										NProgress.done();
									});
								}
							});
							validatorDeductQuantity.resetForm();
						}
						else{
							obj.showAlert("<b>Item ID Does Not Exist</b>", "info",  "<span> Item ID " + itemId + " has already been deleted in another session.<span>");
							obj.$keyTableApi.fnDeleteRow(obj.$keyTableApi.$('tr', {"filter":"applied"})[tableItemsSelectedRowPos]);
						}
					}).always(function (){
						NProgress.done();
					});
				}
				
			}
		});

		obj.$btnUpdateItem.click(function(){
			if(tableItemsCurrentRowPos >= 0) {
				tableItemsSelectedRowPos = tableItemsCurrentRowPos;
				// obj.$keyItems.fnBlur();
				var itemId = obj.$keyTableApi._('tr', {"filter":"applied"})[tableItemsSelectedRowPos][0];
				obj.checkIfItemIdExists(itemId).always(function (itemIdExists){
					if(itemIdExists >=1 ){
						obj.$modalUpdateItem.modal("show");
						obj.$frmUpdateItem[0].reset();
						obj.getItem(itemId).always(function (getItem){
							NProgress.start();
							var getData = JSON.parse(getItem);
							$.each(getData, function(){
								obj.$textBoxUpdateItemId.val(this.id);
								obj.$textBoxUpdatePrice.val(this.price);
								obj.$textBoxUpdateDescription.val(this.description);
							});
							var validatorUpdateItem = obj.$frmUpdateItem.validate({
								errorElement: "div",
								errorPlacement: function (error, element){
								error.appendTo("div#" + element.attr("name") + "_error")
								},
								rules:{
									item_id_update: {
										required: true,
									},
									price_update: {
										required: true,
										number: true
									},
									description_update: {
										required: true,
									}
								},
								messages: {
									item_id_update: {
										required: "Please enter item's ID",
									},
									price_update: {
										required: "Please enter item's price",
										number: "Please enter a valid price"
									},
									description_update: {
										required: "Please enter item's descrition",
									}
								},
								submitHandler: function(form){
									var itemId = obj.$textBoxUpdateItemId.val();
									var price = obj.$textBoxUpdatePrice.val();
									var description = obj.$textBoxUpdateDescription.val();
									obj.checkIfItemIdExists(itemId).always(function (itemIdExists){
										if(itemIdExists < 1){
											obj.showAlert("<b>Item ID Does Not Exist</b>", "info", "<span> Item ID " + itemId + " has already been deleted in another session.<span>");
											obj.$keyTableApi.fnDeleteRow(obj.$keyTableApi.$('tr', {"filter":"applied"})[tableItemsSelectedRowPos]);
											validatorUpdateItem.resetForm();
											obj.$modalUpdateItem.modal("hide");
											obj.$frmUpdateItem[0].reset();
										}
										else{
											NProgress.start();
											$.post(BASE_URL + CURRENT_CONTROLLER + "/update_item",{
												itemId: itemId,
												price: price,
												description: description
											},function (data){
												obj.getItem(itemId).always(function (getItem){
													var updatedData = JSON.parse(getItem);
													obj.$keyTableApi.fnDeleteRow(obj.$keyTableApi.$('tr', {"filter":"applied"})[tableItemsSelectedRowPos]);
													$.each(updatedData,function(){
														itemId = (this.id);
														price = (this.price);
														quantity = (this.quantity);
														description = (this.description);
														obj.$tableItems.row.add([
															itemId,
															description,
															numeral(quantity).format("0,0"),
															numeral(price).format("0,0.00")
														]);
														obj.$tableItems.draw(false);
														obj.$modalUpdateItem.modal("hide");
														obj.showAlert("<b>Item Updated</b>", "success", "<span> Item ID "+itemId + " has been successfully updated.<span>");
													});
												});
											}).always(function (){
												NProgress.done();
											});
										}
									});
								}
							});
							validatorUpdateItem.resetForm();
						}).always(function (){
							NProgress.done();
						});
					}
					else{
						obj.showAlert("<b>Item ID Does Not Exist</b>", "info", "<span> Item ID " + itemId + " has already been deleted in another session.<span>");
						obj.$keyTableApi.fnDeleteRow(obj.$keyTableApi.$('tr', {"filter":"applied"})[tableItemsSelectedRowPos]);
					}
				});
			}
		});
		obj.$btnDeleteItem.click(function (){
			if(tableItemsCurrentRowPos >= 0){
				tableItemsSelectedRowPos = tableItemsCurrentRowPos;
				obj.$keyItems.fnBlur();
				var itemId = obj.$keyTableApi._('tr', {"filter":"applied"})[tableItemsSelectedRowPos][0];
				obj.checkIfItemIdExists(itemId).always(function (itemIdExists){
					if(itemIdExists >=1){
						obj.showConfirm("Are you sure you want to delete item ID " + itemId + "?", "warning", "Yes, delete it!", "No, cancel please!", function (isConfirm){
						  	if (isConfirm) {
						  		NProgress.start();
						    	$.post(BASE_URL + CURRENT_CONTROLLER + "/delete_item",{itemId: itemId},function (data){
						    		if(data <= 0){
						    			obj.showAlert("<b>Unable to Delete</b>", "info", "<span> Item ID "+ itemId +" has not been deleted. Item was already included in the delivery.<span>");
						    		}
						    		else{
						    			obj.$keyTableApi.fnDeleteRow(obj.$keyTableApi.$('tr', {"filter":"applied"})[tableItemsSelectedRowPos]);
						    			obj.showAlert("<b>Item Deleted</b>", "success", "<span> Item ID " + itemId + " has been successfully deleted.<span>");
						    		}
						    		
						    	}).always(function (){
						    		NProgress.done();
						    	});
						  	}
						});
					}
					else{
						obj.showAlert("<b>Item ID Does Not Exist</b>", "info", "<span> Item ID " + itemId + " has already been deleted in another session.<span>");
						obj.$keyTableApi.fnDeleteRow(obj.$keyTableApi.$('tr', {"filter":"applied"})[tableItemsSelectedRowPos]);
					}
				});
			}
		});
		obj.$btnViewItem.click(function(){
			if(tableItemsCurrentRowPos >= 0) {
				tableItemsSelectedRowPos = tableItemsCurrentRowPos;
				obj.$keyItems.fnBlur();
				var itemId = obj.$keyTableApi._('tr', {"filter":"applied"})[tableItemsSelectedRowPos][0];
				obj.checkIfItemIdExists(itemId).always(function (itemIdExists){
					if(itemIdExists >= 1){
						NProgress.start();
						obj.$modalViewItem.modal("show");
						obj.getItem(itemId).always(function (getItem){
							var getData = JSON.parse(getItem);
							$.each(getData, function(){
								obj.$textBoxViewItemId.text(this.id);
								obj.$textBoxViewDescription.text(this.description);
								obj.$textBoxViewPrice.text(numeral(this.price).format("0,0.00"));
								obj.$textBoxViewQuantity.text(numeral(this.quantity).format("0,0"));
							});
						}).always(function (){
							NProgress.done();
						});
					}
					else{
						obj.showAlert("<b>Item ID Does Not Exist</b>", "info", "<span> Item ID " + itemId + " has already been deleted in another session.<span>");
						obj.$keyTableApi.fnDeleteRow(obj.$keyTableApi.$('tr', {"filter":"applied"})[tableItemsSelectedRowPos]);
					}
				});
			}
		});
		obj.$btnRefreshItem.click(function(){
			obj.$tableItems.clear().draw();
			NProgress.start();
			obj.getAllItems().always(function (getAllItems){
				var getAllData = JSON.parse(getAllItems);
				for(var i=0; i<getAllData.length; i++){
					obj.$tableItems.row.add([
						getAllData[i]['id'],
						getAllData[i]['description'],
						numeral(getAllData[i]['quantity']).format("0,0"),
						numeral(getAllData[i]['price']).format("0,0.00"),
					]);
					obj.$tableItems.draw(false);
				}
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
