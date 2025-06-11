// --- treeview controller
;(function() {

	var app = angular.module("app.ctrls");
	// Tree View Demo Ctrl
	app.controller("TreeViewDemoCtrl", ["$scope", "$timeout", "$ocLazyLoad", "$rootScope", function($scope, $timeout, $ocLazyLoad, $rootScope) {

		var apple_selected, tree, treedata_avm, treedata_geography;
		$scope.my_tree_handler = function(branch) {
		var _ref;
		$scope.output = "You selected: " + branch.label;
		if ((_ref = branch.data) != null ? _ref.description : void 0) {
			return $scope.output += '(' + branch.data.description + ')';
		}
		};
		apple_selected = function(branch) {
			return $scope.output = "APPLE! : " + branch.label;
		};
		ajaxsingleViews('1', "services/settings/tree_view", $scope,$rootScope);
		//ajaxsingleViews1('2', "services/settings/tree_view", $scope,$rootScope);
		treedata_avm=$scope.singleViews;
		treedata_geography={};//$scope.singleViews1;
			$scope.my_data = treedata_avm;
			$scope.try_changing_the_tree_data = function() {
				if ($scope.my_data === treedata_avm) {
					return $scope.my_data = treedata_geography;
				} else {
					return $scope.my_data = treedata_avm;
				}
			};
			$scope.my_tree = tree = {};
			$scope.try_async_load = function() {
				$scope.my_data = [];
				$scope.doing_async = true;
				return $timeout(function() {
					if (Math.random() < 0.5) {
						$scope.my_data = treedata_avm;
					} else {
						$scope.my_data = treedata_geography;
					}
					$scope.doing_async = false;
					return tree.expand_all();
				}, 1000);
			};
			return $scope.try_adding_a_branch = function() {
				var b;
				b = tree.get_selected_branch();
				if(b.level==1){
					return tree.add_branch(b, {
						id:b.ref_id,
						flag:"0_",
						label: 'New Branch',
						data: {
							something: 42,
							"else": 43
						}
					});
				}else{alert("Add branch is enabled only for main branch");}
			};
			/*return $scope.try_remove_a_branch = function(_id) { 
				var b;
				b = tree.get_selected_branch();
				if(b.level==1){ 
					return tree.remove_branch(b, {
						id:_id,
						flag:0,
						label: 'New Branch',
						data: {
							something: 42,
							"else": 43
						}
					});
				}else{alert("Remove branch is enabled only for main branch");}
			};*/
	}])

//=== #end
})()