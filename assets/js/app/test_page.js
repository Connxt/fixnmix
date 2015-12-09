var TestPage = (function() {
	var obj = {};

	var initialize = function () {
		
	};

	var bindEvents = function() {
		// $.post(BASE_URL + CURRENT_CONTROLLER + "/test_return", {
		// 	returnData: {
		// 		"transaction": "return",
		// 		"id": 1,
		// 		"branch_id": "KAB001",
		// 		"items": [
		// 			{"item_id": 1, "quantity": 10},
		// 			{"item_id": 2, "quantity": 10},
		// 			{"item_id": 3, "quantity": 10},
		// 			{"item_id": 1, "quantity": 10}
		// 		]
		// 	}
		// }, function (data) {
		// 	console.log(data);
		// });
		
		// $.post(BASE_URL + CURRENT_CONTROLLER + "/test_json", {
		// 	data: {
		// 		"transaction": "deliver_items",
		// 		"id": 1
		// 	}
		// }, function (data) {

		// });
		
		// $.post(BASE_URL + CURRENT_CONTROLLER + "/get_top_selling_items", {}, function (data) {
		// 	data = JSON.parse(data);
		// 	console.log(data);
		// });

		// $.post(BASE_URL + CURRENT_CONTROLLER + "/get_top_selling_items_by_branch", {}, function (data) {
		// 	data = JSON.parse(data);
		// 	console.log("By branch:");
		// 	console.log(data);
		// });
	};

	return {
		run: function () {
			initialize();
			bindEvents();
		}
	};
})();