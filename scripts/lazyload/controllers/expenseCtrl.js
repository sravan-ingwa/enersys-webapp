;(function(){
	var app= angular.module("app.ctrls")
	app.controller("EnersysExpenseCtrl", ["$scope","$route", "$modal", "$rootScope", "$filter", function($scope, $route, $modal, $rootScope, $filter){
	$scope.modalAnim = "modalRapid";
	$scope.CurrentDate = new Date();
	$scope.showRemarksError = false;
	$scope.setAlias = function(alias) {
		$rootScope.alias = alias;
		exp_singleViews(alias, "services/expense_tracker/user_expences_view", $rootScope);
	};
			setTimeout(function() {
				var url = $(".forms_exp").attr('url');
				var data = $(".forms_exp").serializeArray();
				data.push({
					name: 'emp_alias',
					value: readCookie('emp_alias')
				}, {
					name: 'token',
					value: readCookie('token')
				});
				var data = serializeToJson(data);
				var result = ajaxExpense(data, url, $scope,$rootScope);
			}, 0);
			$scope.expsorting = function(e) {
				var url = $(".forms_exp").attr('url');
				var data = $(".forms_exp").serializeArray();
				data.push({
					name: 'emp_alias',
					value: readCookie('emp_alias')
				}, {
					name: 'token',
					value: readCookie('token')
				});
				var data = serializeToJson(data);
				var result = ajaxExpense(data, url, $scope,$rootScope);
			}
			
		//Advance Request
		$scope.sendRequest = function(ref) {
			var went = $(".forms_request").attr('data-went');
			var url = $(".forms_request").attr('url');
			var data = new FormData($('.forms_request')[0]);
			data.append("emp_alias", readCookie('emp_alias'));
			data.append("token", readCookie('token'));
			data.append("ip_addr", readCookie('ip_addr'));
			data.append("ref",ref);
			var result=ajaxRequest(data,url,went, $scope, $route, $rootScope);
		}
		//Advance Request
		$scope.sendRequestAdvExp = function(ref) {
			var went = $(".forms_request").attr('data-went');
			var url = $(".forms_request").attr('url');
			var data = new FormData($('.forms_request')[0]);
			data.append("emp_alias", readCookie('emp_alias'));
			data.append("token", readCookie('token'));
			data.append("ip_addr", readCookie('ip_addr'));
			data.append("ref",ref);
			var result = ajaxRequest(data,url,went, $scope, $route, $rootScope);
		}
		$scope.sendAdvRequest = function(ref) {
			var went = $(".forms_request").attr('data-went');
			var url = $(".forms_request").attr('url');
			var data = new FormData($('.forms_request')[0]);
			var ref=ref;
			//var result=ajaxRequest(data,url,went, $scope, $route, $rootScope);
			var reqAmt =$('#location').val();
			var rem =$('#rem').val();
			//alert(reqAmt);
			if(reqAmt=="" || rem ==''){
				$scope.showRemarksError = true;
			} else {
				$scope.showRemarksError = false;
				$.ajax({
					url: base_url_2+ "services/expense_tracker/total_advance",
					type: "POST",
					data: 'amntCurnt=' + reqAmt+'&emp_alias='+readCookie('emp_alias')+ "&token=" + readCookie('token')+'&ip_addr=' + readCookie('ip_addr'),
					cache:false,
					success: function(result) {
						var obj1 = JSON.parse(result);
						var resVal = obj1.tl_amt; 
						var res = resVal.split("|");
						if(ref=='adreq' || ref=='draft'){
							$('.tadv').val(res[0].trim());
						}
						if(ref=='adreq' || ref=='draft'){
							if(res[1]==1) {
								if(confirm('Please note: Your Request is not more than INR '+$('.limitt').val())){ 
									data.append("emp_alias", readCookie('emp_alias'));
									data.append("token", readCookie('token'));
									data.append("ip_addr", readCookie('ip_addr'));
									data.append("ref",ref);
									var result=ajaxRequest(data,url,went, $scope, $route, $rootScope);
								} else{
									return false;
								}
							} else {
								data.append("emp_alias", readCookie('emp_alias'));
								data.append("token", readCookie('token'));
								data.append("ip_addr", readCookie('ip_addr'));
								data.append("ref",ref);
								var result=ajaxRequest(data,url,went, $scope, $route, $rootScope);
							}
						} else {
							data.append("emp_alias", readCookie('emp_alias'));
							data.append("token", readCookie('token'));
							data.append("ip_addr", readCookie('ip_addr'));
							data.append("ref",ref);
							var result = ajaxRequest(data,url,went, $scope, $route, $rootScope);
						}
					}
				});
			}
		}
		//End Advance Request
		
		//Advance Request and Submit Expense Popup's
		$scope.advanceRequestOpen = function() {$modal.open({templateUrl: "includes/expense/advancerequest.php",size: "lg",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.settingsDeleteOpen = function(setting, data) {
			deleteSetting(setting, data, $scope, $rootScope, $modal);
		}
		$scope.advanceDeleteOpen = function(data) {
			$rootScope.deleteData = data;
			$modal.open({templateUrl: "includes/expense/advances_delete.html",size: "md",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});
		}
		$scope.advanceMappingOpen = function(data) {
			$rootScope.editData = data;
			$modal.open({templateUrl: "includes/expense/advance_mapping.html",size: "md",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});
		}
		$scope.expensesMappingOpen = function(data) {
			$rootScope.editData = data;
			$modal.open({templateUrl: "includes/expense/expenses_mapping.html",size: "md",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});
		}
		$scope.expensesDeleteOpen = function(data) {
			$rootScope.deleteData = data;
			$modal.open({templateUrl: "includes/expense/expenses_delete.html",size: "md",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});
		}
		$scope.advanceseditOpen = function() {$modal.open({templateUrl: "includes/expense/advances_edit.php",size: "lg",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.advancesAdvEditOpen = function() {
			$modal.open({
				templateUrl: "includes/expense/advances_adv_edit.html",
				size: "lg",
				controller: "ModalDemoCtrl",
				resolve: function() {},
				windowClass: $scope.modalAnim,
				keyboard: false,
				backdrop: 'static'
			});
		}
		$scope.serSubmitExpOpen = function() {
			$rootScope.loading = true;
			$rootScope.backto = false;
			setTimeout(function(){
			var mo=$modal.open({templateUrl: "includes/expense/ser_submit_expense.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
			mo.opened.then(function () {
				if($rootScope.loading == true){									
					$rootScope.loading = false;											
				}
				if($rootScope.backto == false){	
					$rootScope.backto = true;										
				}
								
			});
			}, 30);
			//$rootScope.loading = false;
		}
		$scope.othSubmitExpOpen = function() {
			$rootScope.loading = true;
			$rootScope.backto = false;
			setTimeout(function(){
			var mo=$modal.open({templateUrl: "includes/expense/oth_submit_expense.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
			mo.opened.then(function () {
				if($rootScope.loading == true){									
					$rootScope.loading = false;											
				}
				if($rootScope.backto == false){	
					$rootScope.backto = true;										
				}
			});
			}, 30);
			}
		$scope.serEditExpOpen = function() {$modal.open({templateUrl: "includes/expense/ser_expense_edit.php",size: "lg",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.othEditExpOpen = function() {$modal.open({templateUrl: "includes/expense/oth_expense_edit.php",size: "lg",controller: "ModalDemoCtrl",resolve: function() {alert();},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.advEditExpOpen = function() {$modal.open({templateUrl: "includes/expense/expense_advedit.html",size: "lg",controller: "ModalDemoCtrl",resolve: function() {alert();},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.advancesExport = function() {$modal.open({templateUrl: "includes/expense/advances_exp.php",size: "md",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.expensesExport = function() {$modal.open({templateUrl: "includes/expense/expenses_exp.php",size: "md",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.expensesImport = function() {$modal.open({templateUrl: "includes/expense/expenses_imp.php",size: "md",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.financeExpensesImport = function() {
			$modal.open({
				templateUrl: "includes/expense/expenses_finance_imp.html",
				size: "md",
				controller: "ModalDemoCtrl",
				resolve: function() {},
				windowClass: $scope.modalAnim,
				keyboard: false,
				backdrop: 'static'
			});
		}
		$scope.exp_dashboardView = function() {$modal.open({templateUrl: "includes/expense/exp_dashboardView.php",size: "lg",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.approversOpen = function() {$modal.open({templateUrl: "includes/settings/approvers/approvers_add.php",size: "md",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.approversEditOpen = function() {$modal.open({templateUrl: "includes/settings/approvers/approvers_edit.php",size: "md",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.approversexportOpen = function() {$modal.open({templateUrl: "includes/settings/approvers/approvers_export.php",size: "md",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.limitsOpen = function() {$modal.open({templateUrl: "includes/settings/limits/limits_add.php",size: "md",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.limitsEditOpen = function() {$modal.open({templateUrl: "includes/settings/limits/limits_edit.php",size: "md",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.servicesOpen = function() {$modal.open({templateUrl: "includes/settings/allowances/services_add.php",size: "md",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.servicesEditOpen = function() {$modal.open({templateUrl: "includes/settings/allowances/services_edit.php",size: "md",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.othersOpen = function() {$modal.open({templateUrl: "includes/settings/allowances/others_add.php",size: "md",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.othersEditOpen = function() {$modal.open({templateUrl: "includes/settings/allowances/others_edit.php",size: "md",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.expensesSingleOpen = function() {
			$rootScope.backto = false;
			setTimeout(function(){
			var mo=$modal.open({templateUrl: "includes/expense/expenses_Singview.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
			mo.opened.then(function () {
				if($rootScope.backto == false){	
					$rootScope.backto = true;										
				}
			});
			}, 30);			
			}
		// Date Picker
		$scope.dateCal = function(){
			datedprexp($scope,$rootScope);
		}
		$scope.dprreadViews = function(d1,d2,empalias){
			dpr_ajax1(d1,d2,$rootScope,empalias);
		}
		$scope.dateCheck = function(){
				var mdate=$('.checkin').val().split('-');
				var idate=$('.checkout').val().split('-');
				//var split_mdate = mdate['1']+'-'+mdate['0']+'-'+mdate['2'];
				$scope.pr=mdate['1']+'-'+mdate['0']+'-'+mdate['2'];
		}
		$scope.amnt = function(){
			tot_amt();
		}
		$scope.remAmnt = function(){
			remb_amt();
		}
		$scope.currAmnt = function(){
			curReqq();
		}
		
		// APPROVAL LEVEL DROPDOWN
		$scope.applevels = [{
				"alias":"1", "name": "Approver Level"
			}, {
				"alias":"2","name": "HR Level"
			}, {
				"alias":"3","name": "Finance Level"
			}, {
				"alias":"4","name": "HOD Level"
			}, {
				"alias":"5","name": "MD Level"
			}];
		
		$scope.modeOfTravel = [{
				"name": "ACT"
			}, {
				"name": "AIR"
			}, {
				"name": "TRAIN 2ND AC"
			}, {
				"name": "TRAIN 3 TIER"
			}, {
				"name": "TRAIN SLEEPER"
			},{
				"name": "VOLVO AC BUS"
			},{
				"name": "NON-AC BUS"
			},{
				"name": "OWN VEHICLE"
			}, {
				"name": "CAB"
			}, {
				"name": "AUTO"
			}, {
				"name": "LOCAL TRAIN"
			}, {
				"name": "ANY PUBLIC TRANSPORT"
			}];
		$scope.locOfTravel = [{
				"name": "OWN VEHICLE"
			}, {
				"name": "CAB"
			}, {
				"name": "AUTO"
			}, {
				"name": "LOCAL TRAIN"
			}, {
				"name": "ANY PUBLIC TRANSPORT"
			}];
		$scope.advReq = function(alias){ 
			$.ajax({
					type: 'POST',
					url: 'services/expense_tracker/adv_addview',
					data: 'alias=' + alias+'&emp_alias='+readCookie('emp_alias')+ "&token=" + readCookie('token'),
					cache: false,
					async: false,
					error: function(result) {
						/* alert('error occured'); */
					},
					success: function(result) {
						$rootScope.advAdd = JSON.parse(result);
					}
				});
		}
		/*$scope.getAmnt = function(alias){ getAmnt
		}*/
		$scope.serReq = function(alias){ 
			$.ajax({
					type: 'POST',
					url: base_url_2+ 'services/expense_tracker/ser_expview',
					data: '&emp_alias='+readCookie('emp_alias')+ "&token=" + readCookie('token'),
					cache: false,
					async: false,
					error: function(result) {
						/* alert('error occured'); */
					},
					success: function(result) {
						$rootScope.expAdd = JSON.parse(result);
					}
				});
		}
		$scope.expDash = function(alias) {
			exp_singleViews(alias, "services/expense_tracker/dashboard_empview", $rootScope);
		}
		$scope.expdashsorting = function() {
				var url = $(".forms_exp1").attr('url');
				var data = $(".forms_exp1").serializeArray();
				data.push({
					name: 'emp_alias',
					value: readCookie('emp_alias')
				}, {
					name: 'token',
					value: readCookie('token')
				});
				var data = serializeToJson(data);
				var result = ajaxExpense(data, url, $scope,$rootScope);
		}
		/*$scope.singExp = function(x) {
			$rootScope.alias= x;
			exp_singleViews(x, "services/expense_tracker/user_expences_view", $rootScope);
		}
		$scope.editExp = function(alias) {
			exp_singleViews($rootScope.alias, "services/expense_tracker/user_expences_view", $rootScope);
		}*/
		
		
		$scope.removeDyn = function(key,x,ex,event) {//alert(x);
			var ev = $(event.target);
			var dataRef = $(event.target).attr('data-ref');
			if(dataRef == 'lc'){
				var tab = 'ec_localconveyance';
			}else if(dataRef == 'co'){
				var tab = 'ec_conveyance';
			}else if(dataRef == 'ld'){
				var tab = 'ec_lodging';
			}else if(dataRef == 'bd'){
				var tab = 'ec_boarding';
			}else if(dataRef == 'ot'){
				var tab = 'ec_other_expenses';
			}
			//alert(tab);
			if(confirm('Are you sure you want to delete?')){ 
				exp_del(x,"services/expense_tracker/del_expenses", $rootScope, tab, ex, ev); 
				} 
		}
		$scope.dash_exp_adv = function() {
			exp_singleViews(x, "services/expense_tracker/advances_view", $scope);
		}
		/*$scope.currRequest = function(event) {
			amntCurnt(event);
		}*/
		$scope.onlyIntegers = function(event) {
			curReqAmnt(event);
		}
		$scope.qntyInt = function(event) {
			qntyInteg(event);
		}
		$scope.emailSend = function(alias) {
			$.ajax({
					type: 'POST',
					url: 'services/expense_tracker/sendexp_email',
					data: 'exalias=' + alias+'&emp_alias='+readCookie('emp_alias')+ "&token=" + readCookie('token')+'&ip_addr=' + readCookie('ip_addr'),
					cache: false,
					async: false,
					error: function(result) {/* alert('error occured'); */},
					success: function(result) {
						var emails = jQuery.parseJSON(result);
						if (emails.ErrorDetails.ErrorCode == '0') {
								$rootScope.toasts = [{
									anim: "bouncyflip",
									type: "success",
									msg: emails.ErrorDetails.ErrorMessage
								}];
								setTimeout(function(){
									$rootScope.toasts.splice(0, 1);
									}, 3000);
						} else if(emails.ErrorDetails.ErrorCode > '0') {
							$rootScope.toasts = [{
								anim: "bouncyflip",
								type: "danger",
								msg: emails.ErrorDetails.ErrorMessage
							}];
							setTimeout(function() {
								$rootScope.toasts.splice(0, 1);
								}, 3000);
						}
						
					}
				});
		}
		$scope.delExp = function(alias) {
			if(confirm('Are you sure you want to delete ?')){ 
				$.ajax({
					type: 'POST',
					url: 'services/expense_tracker/del_mainexp',
					data: 'exalias=' + alias+'&emp_alias='+readCookie('emp_alias')+ "&token=" + readCookie('token')+'&ip_addr=' + readCookie('ip_addr'),
					cache: false,
					async: false,
					error: function(result) {/* alert('error occured'); */},
					success: function(result) {
						var deletes = jQuery.parseJSON(result);
						if (deletes.ErrorDetails.ErrorCode == '0') {
								$scope.$close();
								$rootScope.toasts = [{
									anim: "bouncyflip",
									type: "success",
									msg: deletes.ErrorDetails.ErrorMessage
								}];
							$route.reload();
								setTimeout(function(){
									$rootScope.toasts.splice(0, 1);
									}, 3000);
						} else if(deletes.ErrorDetails.ErrorCode > '0') {
							$rootScope.toasts = [{
								anim: "bouncyflip",
								type: "danger",
								msg: emails.ErrorDetails.ErrorMessage
							}];
							setTimeout(function() {
								$rootScope.toasts.splice(0, 1);
								}, 3000);
						}
						
					}
				});
			}
		}
		$scope.delReq = function(alias){ 
				if(confirm('Are you sure you want to delete?')){ 
					$.ajax({
						type: 'POST',
						url: base_url_2+ 'services/expense_tracker/advances_delete',
						data: 'alias='+alias+'&emp_alias='+readCookie('emp_alias')+ "&token=" + readCookie('token')+'&ip_addr=' + readCookie('ip_addr'),
						cache: false,
						async: false,
						error: function(result) {},
						success: function(result) {
							var delViews = jQuery.parseJSON(result);
							if(delViews.ErrorDetails.ErrorCode == '0'){
								$rootScope.toasts = [{
									anim: "bouncyflip",
									type: "success",
									msg: delViews.ErrorDetails.ErrorMessage
								}];
								setTimeout(function() {
									$rootScope.toasts.splice(0, 1);
									}, 3000);
								
								
								$scope.advances_open = false;
								$route.reload();
								
	
							}else{
								$rootScope.toasts = [{
									anim: "bouncyflip",
									type: "danger",
									msg: delViews.ErrorDetails.ErrorMessage
								}];
								setTimeout(function() {
									$rootScope.toasts.splice(0, 1);
									}, 3000);
							}
							
							
						}
					});
				}	
			}		
	}]).controller("fileUploadCtrl", ["$scope", "$rootScope", "$element", function($scope, $rootScope,$element){
		$scope.file_load_exp=function(files,e){file_loading_exp(files,$scope);}
	}])
	.controller("expensesMappingPopUpCntl", ["$scope", "$rootScope", "$route", function($scope, $rootScope, $route) {
		$scope.submitStatusChange = function() {
			var went = $(".forms_add").attr('data-went');
			var url = $(".forms_add").attr('url');
			var data = new FormData($('.forms_add')[0]);
			data.append("emp_alias", readCookie('emp_alias'));
			data.append("token", readCookie('token'));
			data.append("ip_addr", readCookie('ip_addr'));
			ajaxpost(data, url, went, $scope, $route, $rootScope);
		}
	}])
	.controller("advanceMappingPopUpCntl", ["$scope", "$rootScope", "$route", function($scope, $rootScope, $route) {
		$scope.submitStatusChange = function() {
			var went = $(".forms_add").attr('data-went');
			var url = $(".forms_add").attr('url');
			var data = new FormData($('.forms_add')[0]);
			data.append("emp_alias", readCookie('emp_alias'));
			data.append("token", readCookie('token'));
			data.append("ip_addr", readCookie('ip_addr'));
			ajaxpost(data, url, went, $scope, $route, $rootScope);
		}
	}])
	/*-----------------New Expenses------------------*/
	
	// Service Expenses
	.controller("expenseSingCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal","$route", function($scope, $http, $rootScope, $filter, $modal, $route) {
		
		drop_down("services/state_emp_drop?all=1", "", $scope, "third");
		$scope.rmrk = function(x) { 
			if(confirm('Are you sure?')){ 
				ajaxsingleViews1(x+",ec_remarks,remark_alias", "services/del_remark_reqcell", $scope,$rootScope); $('.'+x).hide(); 
			} 
		}
		$scope.singExp = function(x) {
			$rootScope.alias= x;
			exp_singleViews(x, "services/expense_tracker/user_expences_view", $rootScope);
		}
		$scope.dprreadViews = function(d1,d2,empalias){
			dpr_ajax1(d1,d2,$rootScope,empalias);
		}
		$scope.removeDyn1 = function(alias,ex,reff,ecnt) {
			if(ecnt > 1){
				if(confirm('Are you sure you want to delete?')){ 
					exp_dyn_del(alias,"services/expense_tracker/del_dyn_expenses", $rootScope, reff, ex, $route); 
				}
			}else{
				alert("Atleast one expense should be present.");
			}
		}
		$scope.expensesReadeditOpen = function() {$modal.open({templateUrl: "includes/expense/expense_Readonly.php",size: "lg",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.serExpensesReadeditOpen = function() {$modal.open({templateUrl: "includes/expense/ser_expense_Readonly.php",size: "lg",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static'});}
		$scope.editreadExp = function(alias) {
			exp_singleViews($rootScope.alias, "services/expense_tracker/user_expences_view", $rootScope);
		}
		$scope.sendRequest1 = function() {
			var went = $(".forms_request").attr('data-went');
			var url = $(".forms_request").attr('url');
			var data = new FormData($('.forms_request')[0]);
			data.append("emp_alias", readCookie('emp_alias'));
			data.append("token", readCookie('token'));
			data.append("ip_addr", readCookie('ip_addr'));
			var result=ajaxRequest(data, url, went, $scope, $route, $rootScope);
		}
		$scope.emailSend = function(alias) {
			$.ajax({
					type: 'POST',
					url: 'services/expense_tracker/sendexp_email',
					data: 'exalias=' + alias+'&emp_alias='+readCookie('emp_alias')+ "&token=" + readCookie('token')+'&ip_addr=' + readCookie('ip_addr'),
					cache: false,
					async: false,
					error: function(result) {/* alert('error occured'); */},
					success: function(result) {
						var emails = jQuery.parseJSON(result);
						if (emails.ErrorDetails.ErrorCode == '0') {
								$rootScope.toasts = [{
									anim: "bouncyflip",
									type: "success",
									msg: emails.ErrorDetails.ErrorMessage
								}];
								setTimeout(function(){
									$rootScope.toasts.splice(0, 1);
									}, 3000);
						} else if(emails.ErrorDetails.ErrorCode > '0') {
							$rootScope.toasts = [{
								anim: "bouncyflip",
								type: "danger",
								msg: emails.ErrorDetails.ErrorMessage
							}];
							setTimeout(function() {
								$rootScope.toasts.splice(0, 1);
								}, 3000);
						}
						
					}
				});
		}
		$scope.delExp = function(alias) {
			if(confirm('Are you sure you want to delete ?')){ 
				$.ajax({
					type: 'POST',
					url: 'services/expense_tracker/del_mainexp',
					data: 'exalias=' + alias+'&emp_alias='+readCookie('emp_alias')+ "&token=" + readCookie('token')+'&ip_addr=' + readCookie('ip_addr'),
					cache: false,
					async: false,
					error: function(result) {/* alert('error occured'); */},
					success: function(result) {
						var deletes = jQuery.parseJSON(result);
						if (deletes.ErrorDetails.ErrorCode == '0') {
								$scope.$close();
								$rootScope.toasts = [{
									anim: "bouncyflip",
									type: "success",
									msg: deletes.ErrorDetails.ErrorMessage
								}];
							$route.reload();
								setTimeout(function(){
									$rootScope.toasts.splice(0, 1);
									}, 3000);
						} else if(deletes.ErrorDetails.ErrorCode > '0') {
							$rootScope.toasts = [{
								anim: "bouncyflip",
								type: "danger",
								msg: emails.ErrorDetails.ErrorMessage
							}];
							setTimeout(function() {
								$rootScope.toasts.splice(0, 1);
								}, 3000);
						}
						
					}
				});
			}
		}
	}])
	.controller("mainexpCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal", function($scope, $http, $rootScope, $filter, $modal){
		$scope.mainExpOpen = function(alias) {
			$rootScope.backto=false;
			edit_singleViews(alias, "services/expense_tracker/user_main_expences_view", $rootScope);
			setTimeout(function(){
			var mo=$modal.open({templateUrl: "includes/expense/expense_edit/serOth_Exp.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
			mo.opened.then(function () {
				if($rootScope.backto == false){	
					$rootScope.backto = true;										
				}
			});
			}, 30);
		}
		$scope.mainExpAdvOpen = function(alias) {
			$rootScope.backto=false;
			console.log("Called.......")
			edit_singleViews(alias, "services/expense_tracker/user_main_expences_view", $rootScope);
			setTimeout(function(){
			var mo=$modal.open({
				templateUrl: "includes/expense/expense_edit/serOthExpAdvEdit.html",
				size: "lg",
				controller: "ModalDemoCtrl",
				resolve: function() {},
				windowClass: $scope.modalAnim,
				keyboard: false,
				backdrop: 'static'});
				mo.opened.then(function () {
					if($rootScope.backto == false){	
						$rootScope.backto = true;										
					}
				});
			}, 30);
		}
		$scope.dprreadViews1 = function(d1,d2,empalias){
			dpr_ajax1(d1,d2,$rootScope,empalias);
		}
			$scope.dateCal = function(){
				datedprexp($scope,$rootScope);
			}
			$scope.dateNights = function(){
				numNights($scope);		
			}

		}])
	.controller("locConvy_S_EditCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal","$route", function($scope, $http, $rootScope, $filter, $modal, $route){
		$scope.editExp = function(alias) {
			edit_singleViews(alias, "services/expense_tracker/loc_single_view", $rootScope);
			$modal.open({templateUrl: "includes/expense/expense_edit/local_conveyance_s_edit.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
		}
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.qntyInt = function(event) {qntyInteg(event);}
		$scope.addLocOpen = function(alias){
			$rootScope.backto = false;
			setTimeout(function(){
			var mo=$modal.open({templateUrl: "includes/expense/expense_add/local_conveyance_s_add.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
			mo.opened.then(function () {
				if($rootScope.backto == false){	
					$rootScope.backto = true;										
				}
			});
			}, 30);
		}
		$scope.deleteExp = function(alias) {
			edit_singleViews(alias, "services/expense_tracker/loc_single_view", $rootScope);
		}
	}])
	.controller("locConvy_S_AddCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal","$route", function($scope, $http, $rootScope, $filter, $modal, $route){
		$scope.expAlias = $rootScope.alias;
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.qntyInt = function(event) {qntyInteg(event);}
		$scope.addRequest = function() {
			var url = $(".forms_update").attr('url');
			var data = new FormData($('.forms_update')[0]);
			data.append("emp_alias", readCookie('emp_alias'));
			data.append("token", readCookie('token'));
			data.append("ip_addr", readCookie('ip_addr'));
			var result=updateAjax(data,url,$scope, $route, $rootScope);
		}
	}])
	.controller("convy_S_EditCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal", function($scope, $http, $rootScope, $filter, $modal){
		$scope.editCon = function(alias) {
			edit_singleViews(alias, "services/expense_tracker/con_single_view", $rootScope);
			$modal.open({templateUrl: "includes/expense/expense_edit/conveyance_s_edit.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
		}
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.qntyInt = function(event) {qntyInteg(event);}
		$scope.addConOpen = function(alias){
			$rootScope.backto = false;
			setTimeout(function(){
			var mo=$modal.open({templateUrl: "includes/expense/expense_add/conveyance_s_add.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
			mo.opened.then(function () {
				if($rootScope.backto == false){	
					$rootScope.backto = true;										
				}
			});
			}, 30);
		}
	}])
	.controller("convy_S_AddCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal","$route", function($scope, $http, $rootScope, $filter, $modal, $route){
		$scope.expAlias = $rootScope.alias;
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.qntyInt = function(event) {qntyInteg(event);}
		$scope.addRequest = function() {
			var url = $(".forms_update").attr('url');
			var data = new FormData($('.forms_update')[0]);
			data.append("emp_alias", readCookie('emp_alias'));
			data.append("token", readCookie('token'));
			data.append("ip_addr", readCookie('ip_addr'));
			var result=updateAjax(data,url,$scope, $route, $rootScope);
		}
		$scope.amnt = function(){tot_amt();}
		$scope.remAmnt = function(){remb_amt();}
	}])
	.controller("lod_S_EditCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal", function($scope, $http, $rootScope, $filter, $modal){
		$scope.editLod = function(alias) {
			edit_singleViews(alias, "services/expense_tracker/lod_single_view", $rootScope);
			$modal.open({templateUrl: "includes/expense/expense_edit/lodging_s_edit.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
		}
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.qntyInt = function(event) {qntyInteg(event);}
		$scope.lodExpOpen = function(alias){
			$rootScope.backto = false;
			setTimeout(function(){
			var mo=$modal.open({templateUrl: "includes/expense/expense_add/lodging_s_add.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
			mo.opened.then(function () {
				if($rootScope.backto == false){	
					$rootScope.backto = true;										
				}
			});
			}, 30);
		}
	}])
	.controller("lod_S_AddCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal","$route", function($scope, $http, $rootScope, $filter, $modal, $route){
		$scope.expAlias = $rootScope.alias;
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.qntyInt = function(event) {qntyInteg(event);}
		$scope.addRequest = function() {
			var url = $(".forms_update").attr('url');
			var data = new FormData($('.forms_update')[0]);
			data.append("emp_alias", readCookie('emp_alias'));
			data.append("token", readCookie('token'));
			data.append("ip_addr", readCookie('ip_addr'));
			var result=updateAjax(data,url,$scope, $route, $rootScope);
		}
		$scope.amnt = function(){tot_amt();}
		$scope.remAmnt = function(){remb_amt();}
	}])
	.controller("bod_S_EditCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal", function($scope, $http, $rootScope, $filter, $modal){
		$scope.editBod = function(alias) {
			edit_singleViews(alias, "services/expense_tracker/bod_single_view", $rootScope);
			$modal.open({templateUrl: "includes/expense/expense_edit/boarding_s_edit.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
		}
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.qntyInt = function(event) {qntyInteg(event);}
		$scope.bodExpOpen = function(alias){
			$rootScope.backto = false;
			setTimeout(function(){
			var mo=$modal.open({templateUrl: "includes/expense/expense_add/boarding_s_add.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
			mo.opened.then(function () {
				if($rootScope.backto == false){	
					$rootScope.backto = true;										
				}
			});
			}, 30);
		}
	}])
	.controller("bod_S_AddCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal","$route", function($scope, $http, $rootScope, $filter, $modal, $route){
		$scope.expAlias = $rootScope.alias;
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.qntyInt = function(event) {qntyInteg(event);}
		$scope.addRequest = function() {
			var url = $(".forms_update").attr('url');
			var data = new FormData($('.forms_update')[0]);
			data.append("emp_alias", readCookie('emp_alias'));
			data.append("token", readCookie('token'));
			data.append("ip_addr", readCookie('ip_addr'));
			var result=updateAjax(data,url,$scope, $route, $rootScope);
		}
	}])
	.controller("oth_S_EditCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal", function($scope, $http, $rootScope, $filter, $modal){
		$scope.editOth = function(alias) {
			edit_singleViews(alias, "services/expense_tracker/oth_single_view", $rootScope);
			$modal.open({templateUrl: "includes/expense/expense_edit/others_s_edit.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
		}
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.qntyInt = function(event) {qntyInteg(event);}
		$scope.othExpOpen = function(alias){
			$rootScope.backto = false;
			setTimeout(function(){
			var mo=$modal.open({templateUrl: "includes/expense/expense_add/others_s_add.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
			mo.opened.then(function () {
				if($rootScope.backto == false){	
					$rootScope.backto = true;										
				}
			});
			}, 30);
		}
	}])
	.controller("oth_S_AddCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal","$route", function($scope, $http, $rootScope, $filter, $modal, $route){
		$scope.expAlias = $rootScope.alias;
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.qntyInt = function(event) {qntyInteg(event);}
		$scope.addRequest = function() {
			var url = $(".forms_update").attr('url');
			var data = new FormData($('.forms_update')[0]);
			data.append("emp_alias", readCookie('emp_alias'));
			data.append("token", readCookie('token'));
			data.append("ip_addr", readCookie('ip_addr'));
			var result=updateAjax(data,url,$scope, $route, $rootScope);
		}
		$scope.amnt = function(){tot_amt();}
		$scope.remAmnt = function(){remb_amt();}
	}])
	// Other Expenses
	.controller("locConvy_O_AddCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal","$route", function($scope, $http, $rootScope, $filter, $modal, $route){
		$scope.expAlias = $rootScope.alias;
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.addRequest = function() {
			var url = $(".forms_update").attr('url');
			var data = new FormData($('.forms_update')[0]);
			data.append("emp_alias", readCookie('emp_alias'));
			data.append("token", readCookie('token'));
			data.append("ip_addr", readCookie('ip_addr'));
			var result=updateAjax(data,url,$scope, $route, $rootScope);
		}
		$scope.amnt = function(){tot_amt();}
	}])
	.controller("locConvy_O_EditCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal","$route", function($scope, $http, $rootScope, $filter, $modal, $route){
		$scope.editOExp = function(alias) {
			edit_singleViews(alias, "services/expense_tracker/loc_single_view", $rootScope);
			$modal.open({templateUrl: "includes/expense/expense_edit/local_conveyance_o_edit.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
		}
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.qntyInt = function(event) {qntyInteg(event);}
		$scope.addOLocOpen = function(alias){
			$rootScope.backto = false;
			setTimeout(function(){
			var mo=$modal.open({templateUrl: "includes/expense/expense_add/local_conveyance_o_add.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
			mo.opened.then(function () {
				if($rootScope.backto == false){	
					$rootScope.backto = true;										
				}
			});
			}, 30);
		}
	}])
	.controller("convy_O_AddCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal","$route", function($scope, $http, $rootScope, $filter, $modal, $route){
		$scope.expAlias = $rootScope.alias;
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.addRequest = function() {
			var url = $(".forms_update").attr('url');
			var data = new FormData($('.forms_update')[0]);
			data.append("emp_alias", readCookie('emp_alias'));
			data.append("token", readCookie('token'));
			data.append("ip_addr", readCookie('ip_addr'));
			var result=updateAjax(data,url,$scope, $route, $rootScope);
		}
		$scope.amnt = function(){tot_amt();}
	}])
	.controller("convy_O_EditCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal","$route", function($scope, $http, $rootScope, $filter, $modal, $route){
		$scope.editOConExp = function(alias) {
			edit_singleViews(alias, "services/expense_tracker/con_single_view", $rootScope);
			$modal.open({templateUrl: "includes/expense/expense_edit/conveyance_o_edit.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
		}
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.qntyInt = function(event) {qntyInteg(event);}
		$scope.addOConOpen = function(alias){
			$rootScope.backto = false;
			setTimeout(function(){
			var mo=$modal.open({templateUrl: "includes/expense/expense_add/conveyance_o_add.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
			mo.opened.then(function () {
				if($rootScope.backto == false){	
					$rootScope.backto = true;										
				}
			});
			}, 30);
		}
	}])
	.controller("lod_O_EditCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal", function($scope, $http, $rootScope, $filter, $modal){
		$scope.editOLod = function(alias) {
			edit_singleViews(alias, "services/expense_tracker/lod_single_view", $rootScope);
			$modal.open({templateUrl: "includes/expense/expense_edit/lodging_o_edit.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
		}
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.qntyInt = function(event) {qntyInteg(event);}
		$scope.addOLodOpen = function(alias){
			$rootScope.backto = false;
			setTimeout(function(){
			var mo=$modal.open({templateUrl: "includes/expense/expense_add/lodging_o_add.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
			mo.opened.then(function () {
				if($rootScope.backto == false){	
					$rootScope.backto = true;										
				}
			});
			}, 30);
		}
	}])
	.controller("lod_O_AddCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal","$route", function($scope, $http, $rootScope, $filter, $modal, $route){
		$scope.expAlias = $rootScope.alias;
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.qntyInt = function(event) {qntyInteg(event);}
		$scope.addRequest = function() {
			var url = $(".forms_update").attr('url');
			var data = new FormData($('.forms_update')[0]);
			data.append("emp_alias", readCookie('emp_alias'));
			data.append("token", readCookie('token'));
			data.append("ip_addr", readCookie('ip_addr'));
			var result=updateAjax(data,url,$scope, $route, $rootScope);
		}
		$scope.amnt = function(){tot_amt();}
		$scope.remAmnt = function(){remb_amt();}
	}])
	.controller("bod_O_EditCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal", function($scope, $http, $rootScope, $filter, $modal){
		$scope.editOBod = function(alias) {
			edit_singleViews(alias, "services/expense_tracker/bod_single_view", $rootScope);
			$modal.open({templateUrl: "includes/expense/expense_edit/boarding_o_edit.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
		}
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.qntyInt = function(event) {qntyInteg(event);}
		$scope.addOBodOpen = function(alias){
			$rootScope.backto = false;
			setTimeout(function(){
			var mo=$modal.open({templateUrl: "includes/expense/expense_add/boarding_o_add.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
			mo.opened.then(function () {
				if($rootScope.backto == false){	
					$rootScope.backto = true;										
				}
			});
			}, 30);
		}
	}])
	.controller("bod_O_AddCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal","$route", function($scope, $http, $rootScope, $filter, $modal, $route){
		$scope.expAlias = $rootScope.alias;
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.qntyInt = function(event) {qntyInteg(event);}
		$scope.addRequest = function() {
			var url = $(".forms_update").attr('url');
			var data = new FormData($('.forms_update')[0]);
			data.append("emp_alias", readCookie('emp_alias'));
			data.append("token", readCookie('token'));
			data.append("ip_addr", readCookie('ip_addr'));
			var result=updateAjax(data,url,$scope, $route, $rootScope);
		}
		$scope.amnt = function(){tot_amt();}
	}])
	.controller("oth_O_EditCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal", function($scope, $http, $rootScope, $filter, $modal){
		$scope.editOOth = function(alias) {
			edit_singleViews(alias, "services/expense_tracker/oth_single_view", $rootScope);
			$modal.open({templateUrl: "includes/expense/expense_edit/others_o_edit.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
		}
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.qntyInt = function(event) {qntyInteg(event);}
		$scope.addOOthOpen = function(alias){
			$rootScope.backto = false;
			setTimeout(function(){
			var mo=$modal.open({templateUrl: "includes/expense/expense_add/others_o_add.php",
			size: "lg",
			controller: "ModalDemoCtrl",
			resolve: function() {},
			windowClass: $scope.modalAnim,
			keyboard: false,
			backdrop: 'static'});
			mo.opened.then(function () {
				if($rootScope.backto == false){	
					$rootScope.backto = true;										
				}
			});
			}, 30);
		}
	}])
	.controller("oth_O_AddCtrl", ["$scope", "$http", "$rootScope", "$filter", "$modal","$route", function($scope, $http, $rootScope, $filter, $modal, $route){
		$scope.expAlias = $rootScope.alias;
		$scope.onlyIntegers = function(event) {curReqAmnt(event);}
		$scope.qntyInt = function(event) {qntyInteg(event);}
		$scope.addRequest = function() {
			var url = $(".forms_update").attr('url');
			var data = new FormData($('.forms_update')[0]);
			data.append("emp_alias", readCookie('emp_alias'));
			data.append("token", readCookie('token'));
			data.append("ip_addr", readCookie('ip_addr'));
			var result=updateAjax(data,url,$scope, $route, $rootScope);
		}
		$scope.amnt = function(){tot_amt();}
		$scope.remAmnt = function(){remb_amt();}
	}])
	.controller("mainExpCtrl1", ["$scope", "$http", "$rootScope", "$filter", "$modal","$route", function($scope, $http, $rootScope, $filter, $modal, $route){
		
	}])
	/*-----------------End New Expenses------------------*/
	
	.controller("AdvancesAdvEditCtrl", ["$scope", "$http", "$rootScope", "$filter", function($scope, $http, $rootScope, $filter) {
		var lastUsed = null;
		$scope.advances = function(x) {
			$rootScope.alias = x;
			exp_singleViews(x, "services/expense_tracker/advances_view", $scope);
			//$scope.siteMaster_open = true;
			var prevClicked = lastUsed;
			if (prevClicked == x) {
				$scope.advances_open = $scope.advances_open ? false : true;
				event.stopPropagation();
			} else {
				$scope.advances_open = false;
				setTimeout(function() {
					$scope.advances_open = true;
				}, 300);
			}
			lastUsed = x;
		};
		$scope.removeAdvances = function() {
			$scope.advances_open = false;
		};
		document.onclick = function(event) {
			if (!$(event.target).parents('#ticketviesw').html() && $scope.advances_open){
				 $scope.advances_open = false;
			}
		};
		$scope.setAlias = function(alias) {
			$rootScope.alias = alias;
		};
		exp_singleViews($rootScope.alias, "services/expense_tracker/advances_view", $scope);
		$scope.myModelCopy = angular.copy( $scope.expenseViews );
	}])	
	.controller("AdvEnersysExpenseCtrl", ["$scope", "$http", "$rootScope", "$filter", function($scope, $http, $rootScope, $filter){
		$scope.expensesRemarksDelete = function(remarkAlias) {
			if(confirm('Are you sure?')){ 
				console.log("remarkAlias :: ", remarkAlias)
				ajaxsingleViews1(remarkAlias+",ec_remarks,remark_alias", "services/del_remark_reqcell", $scope, $rootScope); 
				$('.' + remarkAlias).hide(); 
			}	
		} 
	}])
	.controller("AdvancesCtrl", ["$scope", "$http", "$rootScope", "$filter", function($scope, $http, $rootScope, $filter){
			//singleviews Request
			var lastUsed = null;
			$scope.advances = function(x) {
				$rootScope.alias = x;
				exp_singleViews(x, "services/expense_tracker/advances_view", $scope);
				//$scope.siteMaster_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.advances_open = $scope.advances_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.advances_open = false;
					setTimeout(function() {
						$scope.advances_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeAdvances = function() {
				$scope.advances_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.advances_open){
					 $scope.advances_open = false;
				}
			};
			$scope.setAlias = function(alias) {
				$rootScope.alias = alias;
			};
		//End singleviews Request
		
		//Edit Request
			exp_singleViews($rootScope.alias, "services/expense_tracker/advances_view", $scope);
			
			$scope.myModelCopy = angular.copy( $scope.expenseViews );
		//End Edit Request
	}]).controller("ApproversCtrl", ["$scope", "$http", "$rootScope", "$filter", function($scope, $http, $rootScope, $filter){
		//singleviews Request
			var lastUsed = null;
			$scope.approvers = function(x) {
				$rootScope.alias = x;
				exp_singleViews(x, "services/expense_tracker/approvers_view", $scope);
				//$scope.siteMaster_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.approvers_open = $scope.approvers_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.approvers_open = false;
					setTimeout(function() {
						$scope.approvers_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeApprovers = function() {
				$scope.approvers_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.approvers_open){
					 $scope.approvers_open = false;
				}
			};
		//End singleviews Request
		
		//Edit Request
			exp_singleViews($rootScope.alias, "services/expense_tracker/approvers_view", $scope);
			$scope.myModelCopy = angular.copy( $scope.expenseViews );
			$scope.approvexport=function(){
			exp_singleViews('', "services/expense_tracker/approvers_export", $scope);
			}
		//End Edit Request
	}]).controller("LimitsCtrl", ["$scope", "$http", "$rootScope", "$filter", function($scope, $http, $rootScope, $filter){
		//singleviews Request
			var lastUsed = null;
			$scope.limits = function(x) {
				$rootScope.alias = x;
				exp_singleViews(x, "services/expense_tracker/limit_view", $scope);
				//$scope.siteMaster_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.limits_open = $scope.limits_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.limits_open = false;
					setTimeout(function() {
						$scope.limits_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeLimits = function() {
				$scope.limits_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.limits_open){
					 $scope.limits_open = false;
				}
			};
		//End singleviews Request
		
		//Edit Request
			exp_singleViews($rootScope.alias, "services/expense_tracker/limit_view", $scope);
			$scope.myModelCopy = angular.copy( $scope.expenseViews );
			
			$scope.limitexport=function(){
			exp_singleViews('', "services/expense_tracker/limit_export", $scope);
			}
		//End Edit Request
	}]).controller("ServicesCtrl", ["$scope", "$http", "$rootScope", "$filter", function($scope, $http, $rootScope, $filter){
		//singleviews Request
			var lastUsed = null;
			$scope.services = function(x) {
				$rootScope.alias = x;
				exp_singleViews(x, "services/expense_tracker/serallowances_view", $scope);
				//$scope.siteMaster_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.services_open = $scope.services_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.services_open = false;
					setTimeout(function() {
						$scope.services_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeServices = function() {
				$scope.services_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.services_open){
					 $scope.services_open = false;
				}
			};
		//End singleviews Request
		
		//Edit Request
			exp_singleViews($rootScope.alias, "services/expense_tracker/serallowances_view", $scope);
			$scope.myModelCopy = angular.copy( $scope.expenseViews );
		//End Edit Request
		$scope.serexport=function(){
			exp_singleViews('', "services/expense_tracker/ser_export", $scope);
		}
	}])			
	
.controller("OthersCtrl", ["$scope", "$http", "$rootScope", "$filter", function($scope, $http, $rootScope, $filter){
		//singleviews Request
			var lastUsed = null;
			$scope.others = function(x) {
				$rootScope.alias = x;
				exp_singleViews(x, "services/expense_tracker/othallowances_view", $scope);
				//$scope.siteMaster_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.others_open = $scope.others_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.others_open = false;
					setTimeout(function() {
						$scope.others_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeOthers = function() {
				$scope.others_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.others_open){
					 $scope.others_open = false;
				}
			};
		//End singleviews Request
		
		//Edit Request
			exp_singleViews($rootScope.alias, "services/expense_tracker/othallowances_view", $scope);
			$scope.myModelCopy = angular.copy( $scope.expenseViews );
			
		$scope.othexport=function(){
			exp_singleViews('', "services/expense_tracker/oth_export", $scope);
		}
		

		//End Edit Request
	}]).controller("lczoneStateMulCntrl", ["$scope", function($scope){
			exp_dep_drop("services/exp_azone_drop","services/exp_astate_drop","services/exp_adistrict_drop","services/district_area_drop",$scope);
			$scope.zone_lc = function() {//$($event.target)
				var zonealias=$('select[name="zone[]"]').val();
				exp_drop_down("services/exp_astate_drop", zonealias, $scope, 'second');
				$('select[name="state[]"]')[0].sumo.unload();
			}	
			$scope.state_lc = function() {
				var statealias=$('select[name="state[]"]').val();
				exp_drop_down("services/exp_adistrict_drop", statealias, $scope, 'third');
				$('select[name="district[]"]')[0].sumo.unload();
			}
			$scope.district_lc = function() {
				var districtalias=$('select[name="district[]"]').val();
				exp_drop_down("services/district_area_drop", districtalias, $scope, 'fourth');
				$('input[name="area"]');
			}
		}])
		.controller("alczoneStateMulCntrl", ["$scope", function($scope){
			exp_dep_drop("services/exp_zone_drop","services/exp_state_drop","services/exp_district_drop","services/district_area_drop",$scope);
			$scope.zone_alc = function() {//$($event.target)
				var zonealias=$('select[name="zone"]').val();
				exp_drop_down("services/exp_state_drop", zonealias, $scope, 'second');
				$('select[name="state"]')[0].sumo.unload();
			}	
			$scope.state_alc = function() {
				var statealias=$('select[name="state"]').val();
				exp_drop_down("services/exp_district_drop", statealias, $scope, 'third');
				$('select[name="district"]')[0].sumo.unload();
			}
			$scope.district_alc = function() {
				var districtalias=$('select[name="district"]').val();
				exp_drop_down("services/district_area_drop", districtalias, $scope, 'fourth');
				$('input[name="area"]');
			}
		}])
		.controller("loczoneStateMulCntrl", ["$scope", "$element", function($scope,$element){
			exp_dep_drop("services/exp_zone_drop","services/exp_state_drop","services/exp_district_drop","services/district_area_drop",$scope);
			$scope.zone_loc = function(zones,e) {
				var zonealias=zones; 
				exp_drop_down("services/exp_state_drop", zonealias, $scope, 'second');
				$element.find('.stateChange')[0].sumo.unload();
				ajaxAmount($element);
			}	
			$scope.state_loc = function(states,e) {
				var statealias=states;
				exp_drop_down("services/exp_district_drop", statealias, $scope, 'third');
				$element.find('.districtChange')[0].sumo.unload();
				ajaxAmount($element);
			}
			$scope.district_loc = function(districts,e) {
				var districtalias=districts;
				exp_drop_down("services/district_area_drop", districtalias, $scope, 'fourth');
				$('input[name="area[]"]');
				ajaxAmount($element);
			}
			$scope.qnty= function(){ 
				ajaxAmount($element);
			}
			$scope.numKilo= function(){
				ajaxAmount($element);
			}
			$scope.localConvy= function(x,e){
				var lcRes = x;// alert(x);
				if(lcRes == 1){$scope.abc='hidden';}
				else{$scope.abc='';}
				ajaxAmount($element);
			}
			$scope.capChange= function(abc,productcode,e){
				capacity_ajax($scope,abc,$element);
			}
			$scope.loddateChange= function(e){
				//$parentone=$(event.target).parents('.locCon'); //alert($parentone.find('.clc').val()+1);
				var mdate=$element.find('.clc').val().split('-'); 
				var idate=$element.find('.slc').val().split('-');
				var c=mdate['2']+'-'+mdate['1']+'-'+mdate['0'];
				
				var date1 = new Date(mdate['2'], mdate['1'] - 1, mdate['0']);
				var date2 = new Date(idate['2'], idate['1'] - 1, idate['0']);
				// We use the getTime() method and get the unixtime (in milliseconds, but we want seconds, therefore we divide it through 1000)
				var date1_unixtime = parseInt(date1.getTime() / 1000);
				var date2_unixtime = parseInt(date2.getTime() / 1000);
				if(mdate['0']==31){
						if(date1_unixtime>date2_unixtime){$element.find('.slc').val('');}
						else{
							var d = new Date(c); 
							d.setDate(d.getDate() + 1);
							$scope.pr=d; 
							ajaxAmount($element);
						}
					}
					else { 
						if(date1_unixtime>=date2_unixtime){$element.find('.slc').val('');}
						else{
							var d = new Date(c); 
							d.setDate(d.getDate() + 1);
							$scope.pr=d; 
							ajaxAmount($element);
						}
					}
				
			}

			$scope.boddateChange= function(e){//alert();
				//$parentone=$(event.target).parents('.locCon');
				var mdate=$element.find('.clc').val().split('-');
				var idate=$element.find('.slc').val().split('-');
				var c=mdate['2']+'-'+mdate['1']+'-'+mdate['0'];
				var date1 = new Date(mdate['2'], mdate['1'] - 1, mdate['0']);
				var date2 = new Date(idate['2'], idate['1'] - 1, idate['0']);
				// We use the getTime() method and get the unixtime (in milliseconds, but we want seconds, therefore we divide it through 1000)
				var date1_unixtime = parseInt(date1.getTime() / 1000);
				var date2_unixtime = parseInt(date2.getTime() / 1000);
				if(date1_unixtime>date2_unixtime){
					$element.find('.slc').val('');
				}else{
					var d = new Date(c);
					d.setDate(d.getDate() + 0);
					$scope.pr=d
					ajaxAmount($element);
				}
			}

		}]).controller("othersExpenseeditCtrl", ["$scope", "$element", function($scope, $element){
			$scope.lodging_self = function(x,e) {
				var ldRes = x; 
				if(ldRes == 'Self'){$scope.htName='hidden';$scope.stName='';}
				else{$scope.htName=''; $scope.stName='hidden'; $('.stAmnt').removeAttr('readonly');}
				var htypee=$element.find('.stay').val();
				if(htypee!="Self"){ 
					var coutdate1=$element.find('.amtt');
					coutdate1.val("");
					coutdate1.removeAttr("readonly");
				}
			}
			
			$scope.loadvalto = function(e) {
			var mdate=$element.find('.checkin').val().split('-');
			var idate=$element.find('.checkout').val().split('-');
			var c=mdate['2']+'-'+mdate['1']+'-'+mdate['0'];				
			var	date1 = new Date(mdate['2'], mdate['1'] - 1, mdate['0']);
			var	date2 = new Date(idate['2'], idate['1'] - 1, idate['0']);
			var date1_unixtime = parseInt(date1.getTime() / 1000);
			var date2_unixtime = parseInt(date2.getTime() / 1000);
			if(date1_unixtime>date2_unixtime){
				$element.find('.checkout').val('');
			}else{
				var d = new Date(c);
				d.setDate(d.getDate() + 1);
				$scope.pr=d
			}			
			var htype=$element.find('.lodvalto');
			var cindate=$element.find('.checkin');
			var coutdate=$element.find('.checkout');
			var staytypee=$element.find('.stay').val();
			//alert('locding='+htype.val()+'&cindate='+cindate.val()+'&coutdate='+coutdate.val()+'&emp_alias='+readCookie('emp_alias')+ "&token=" + readCookie('token'));
			if(cindate.val()!="" && coutdate.val()!="" && staytypee=="Self"){
				$.ajax({
					url: base_url_2+"services/expense_tracker/lod_bod_amt",
					type: "POST",
					data: 'locding='+htype.val()+'&cindate='+cindate.val()+'&coutdate='+coutdate.val()+'&emp_alias='+readCookie('emp_alias')+ "&token=" + readCookie('token'),
					success: function(result) {
						var obj1 = JSON.parse(result);
						var tr = obj1.lb_amt;
						var coutdate1=$element.find('.amtt');
						coutdate1.val(tr);
						tot_amt();
						coutdate1.attr("readonly","readonly");
						//coutdate1.focus();
					},
					error : function(result){
						alert("error occured");
					}
				});
			}
		}
		
		$scope.boardvalto = function(e) {
			var mdate=$element.find('.checkin').val().split('-');
			var idate=$element.find('.checkout').val().split('-');
			var c=mdate['2']+'-'+mdate['1']+'-'+mdate['0'];
			var	date1 = new Date(mdate['2'], mdate['1'] - 1, mdate['0']);
			var	date2 = new Date(idate['2'], idate['1'] - 1, idate['0']);
			var date1_unixtime = parseInt(date1.getTime() / 1000);
			var date2_unixtime = parseInt(date2.getTime() / 1000);
			if(date1_unixtime>date2_unixtime){
				$element.find('.checkout').val('');
			}else{
				var d = new Date(c);
				d.setDate(d.getDate() + 0);
				$scope.pr=d			
			}					
			var htype=$element.find('.bodvalto');
			var cindate=$element.find('.checkin');
			var coutdate=$element.find('.checkout');
			//alert('locding='+htype.val()+'&cindate='+cindate.val()+'&coutdate='+coutdate.val()+'&emp_alias='+readCookie('emp_alias')+ "&token=" + readCookie('token'));
			if(cindate.val()!="" && coutdate.val()!=""){
				$.ajax({
					url: base_url_2+"services/expense_tracker/lod_bod_amt",
					type: "POST",
					data: 'bodding='+htype.val()+'&cindate='+cindate.val()+'&coutdate='+coutdate.val()+'&emp_alias='+readCookie('emp_alias')+ "&token=" + readCookie('token'),
					success: function(result) {
						var obj1 = JSON.parse(result);
						var tr = obj1.lb_amt;
						var coutdate1=$element.find('.amtt');
						coutdate1.val(tr);
						tot_amt();
						coutdate1.attr("readonly","readonly");
					},
					error : function(result){
						alert("error occured");
					}
				});
			}
		}
			
			
		}])
		.controller("ticketDropCtrl", ["$scope", function($scope){
			exp_dep_drop("services/getTicket","","","",$scope);
		}])
		.controller("gradeCntrl", ["$scope", function($scope){
			exp_dep_drop("services/grade_drop","","","",$scope);
			$scope.grade = function(gradealias) {
				$scope.temp=ajax_alias("services/gradedesg",gradealias,$scope);
			}		
		}]).controller("appDropCntrl", ["$scope", function($scope) {
			exp_dep_drop("services/exlevels_drop", "", "", "", $scope);
		}]).controller("desDropCntrl", ["$scope", function($scope) {
			exp_dep_drop("services/designation_drop", "", "", "", $scope);
		}]).controller("depDropCntrl", ["$scope", function($scope) {
			exp_dep_drop("services/department_drop", "", "", "", $scope);
		}]).controller("depEmpDropCtrl", ["$scope", function($scope) {
			exp_dep_drop("services/department_drop", "services/dep_emp_drop", "", "", $scope);
			$scope.dep_emp_mul = function() {
				var depalias=$('select[name="appdepartment_alias"]').val(); 
				drop_down("services/dep_emp_drop", depalias, $scope, 'second');
				$('select[name="employ_alias"]')[0].sumo.unload();
			}
		}]).controller("empnameDropCtrl", ["$scope", function($scope) {
			exp_dep_drop("services/employeename_drop", "", "", "", $scope);
		}]).controller("empnameexpDropCtrl", ["$scope", function($scope) {
			exp_dep_drop("services/exlevels_drop", "services/exp_emp_drop", "", "", $scope);
		}])
		.controller("capdropCntrl", ["$scope", "$element","$rootScope", function($scope,$element,$rootScope){
			exp_dep_drop("services/product_desc_drop","","","",$scope);
			
		}]).controller("addFieldsExpCtrl", ["$scope", function($scope) {
			$scope.forms = [
				{
					name: "field1",
					itemtype:[
						{ ac: '', auth: '', autname: ''}
					]
				}
			];
			$scope.addFields = function (field,event) {
				event.preventDefault();
				field.itemtype.push({ ac: '', auth: '', autname: '' });
			}
			$scope.removeExp = function(key,field){
				var len = field.itemtype.length;
				if(len!=1){
					var rm = parseInt(key)-parseInt(len);
					event.preventDefault();
					field.itemtype.splice(rm, 1);
					setTimeout(function(){tot_amt();}, 500);
					//field.itemtype.splice(field, 1);
				}
			}; 
		}]).controller("admnappDropCntrl", ["$scope", function($scope) {
			exp_dep_drop("services/admnexlevels_drop", "", "", "", $scope);
		}]).controller('appLevlCntrl', ["$scope", function($scope) {
			$scope.applevels = [{
				"alias":"1", "name": "Approver Level"
			}, {
				"alias":"2","name": "HR Level"
			}, {
				"alias":"3","name": "Finance Level"
			}, {
				"alias":"4","name": "HOD Level"
			}, {
				"alias":"5","name": "MD Level"
			}];
		}]).controller('modeOfTravelCntrl', ["$scope", function($scope) {
			$scope.modeOfTravel = [{
				"name": "ACT"
			}, {
				"name": "AIR"
			}, {
				"name": "TRAIN 2ND AC"
			}, {
				"name": "TRAIN 3 TIER"
			}, {
				"name": "TRAIN SLEEPER"
			},{
				"name": "VOLVO AC BUS"
			},{
				"name": "NON-AC BUS"
			},{
				"name": "OWN VEHICLE"
			}, {
				"name": "CAB"
			}, {
				"name": "AUTO"
			}, {
				"name": "LOCAL TRAIN"
			}, {
				"name": "ANY PUBLIC TRANSPORT"
			}];
		}])
		.controller('locOfTravelCntrl', ["$scope","$rootScope", function($scope,$rootScope) {
			$scope.locOfTravel = [{
				"name": "OWN VEHICLE"
			}, {
				"name": "CAB"
			}, {
				"name": "AUTO"
			}, {
				"name": "LOCAL TRAIN"
			}, {
				"name": "ANY PUBLIC TRANSPORT"
			}];
		}])
		.controller('updatingCntrl', ["$scope","$rootScope","$route", function($scope,$rootScope,$route) {
			$rootScope.upadteRequest = function() {
				var url = $(".forms_update").attr('url');
				var data = new FormData($('.forms_update')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));				
				var result=updateAjax(data,url,$scope, $route, $rootScope);
			}
		}])
function ajax_alias(url, alias, $scope) {
	if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0') {
		$.ajax({
			url: base_url_2 + url,
			type: "POST",
			data: "alias="+alias,
			error: function(result) {/*alert("error occured");*/},
			success: function(result) {
				$scope.expenseViews = JSON.parse(result);
			}
		});
	} else {window.location = base_url + '#/signin';}
}
	
function ajaxExpense(data, url, $scope,$rootScope) { $rootScope.loading=true;
	if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0') {
		$.ajax({
			url: base_url_2 + url,
			type: "POST",
			data: data,
			error: function(result) {/*alert("error occured");*/},
			success: function(result) { 
				$rootScope.enerlod = false;  
				$rootScope.loading=false;
				if(url=='services/expense_tracker/dashboard_empview'){
					$scope.expenseViews = JSON.parse(result);
				}else{
					$scope.expenses = JSON.parse(result);
				}
			}
		});
	} else {window.location = base_url + '#/signin';}
}
function updateAjax(data, url, $scope, $route, $rootScope) {
	$rootScope.loading = true;
	$.ajax({
		url: base_url_2 + url,
		type: "POST",
		data: data,
		processData: false,
		contentType: false,
		error: function(result) { /*alert("error occured");*/ },
		success: function(result) {$rootScope.loading = false;
			$('.aran').css("display","none");
			var json = jQuery.parseJSON(result);
			exp_singleViews($rootScope.alias, "services/expense_tracker/user_expences_view", $rootScope);
			dpr_ajax1($rootScope.st_date,$rootScope.en_date,$rootScope,readCookie('emp_alias'));
			$('.aran').css("display","block");
			if (json.ErrorDetails.ErrorCode == '0') {
				$scope.$close();
				if(json.ErrorDetails.ErrorCode == '0'){
					$rootScope.toasts = [{
						anim: "bouncyflip",
						type: "success",
						msg: json.ErrorDetails.ErrorMessage
					}];
					setTimeout(function(){$rootScope.toasts.splice(0, 1);}, 3000);
					$route.reload();
				}
			} else if (json.ErrorDetails.ErrorCode > '0') {
				$rootScope.toasts = [{
					anim: "bouncyflip",
					type: "danger",
					msg: json.ErrorDetails.ErrorMessage
				}];
				setTimeout(function() {$rootScope.toasts.splice(0, 1);}, 3000);
			}
		}
	});
}					
function ajaxRequest(data, url, went, $scope, $route, $rootScope) {
	//var base_url_2='http://enersyscare.co.in/';
	$rootScope.loading = true;
	$.ajax({
		url: base_url_2 + url,
		type: "POST",
		data: data,
		processData: false,
		contentType: false,
		error: function(result) { /*alert("error occured");*/ },
		success: function(result) {$rootScope.loading = false;
		$rootScope.backto=false;
			var json = jQuery.parseJSON(result);
			if (json.ErrorDetails.ErrorCode == '0') {
				$scope.$close();
				$rootScope.backto = false;	
				if(json.ErrorDetails.ErrorMessage=='export'){
					window.location='exports/'+json.file_name+'.xlsx';
					$rootScope.toasts = [{
						anim: "bouncyflip",
						type: "success",
						msg:  "Exported Sucessfully"
					}];
					setTimeout(function(){
						$rootScope.toasts.splice(0, 1);
					}, 3000);
				}else{ $('.back-to-top').css('display','none');
					$rootScope.toasts = [{
						anim: "bouncyflip",
						type: "success",
						msg: json.ErrorDetails.ErrorMessage
					}];
					$route.reload();
					setTimeout(function(){
						$rootScope.toasts.splice(0, 1);
						}, 3000);
				}
			} else if (json.ErrorDetails.ErrorCode > '0') {
				$rootScope.backto = true;
				$rootScope.toasts = [{
					anim: "bouncyflip",
					type: "danger",
					msg: json.ErrorDetails.ErrorMessage
				}];
				setTimeout(function() {
					$rootScope.toasts.splice(0, 1);
					}, 3000);
				$('button[type="submit"], input[type="submit"]').removeAttr('disabled','disabled');
			}
		}
	});
}

function exp_singleViews(alias, url, $scope) { 
	if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0') {
		$.ajax({
			type: 'POST',
			url: base_url_2 + url,
			data: "emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token') + "&alias=" + alias,
			cache: false,
			async: false,
			error: function(result) {
				/* alert('error occured'); */
			},
			success: function(result) {
					$scope.expenseViews = JSON.parse(result);
			}
		});
	}
}
function edit_singleViews(alias, url, $scope) { 
	if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0') {
		$.ajax({
			type: 'POST',
			url: base_url_2 + url,
			data: "emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token') + "&alias=" + alias,
			cache: false,
			async: false,
			error: function(result) {
				/* alert('error occured'); */
			},
			success: function(result) {
				$scope.editViews = JSON.parse(result);
			}
		});
	}
}
function exp_dep_drop(first_path, second_path, third_path, fourth_path, $scope) {
	exp_drop_down(first_path, '', $scope, 'first');
	$scope.dep_drop_asset_emp = function(alias) {
		exp_drop_down(first_path, alias, $scope, 'first');
	}
	$scope.dep_drop = function(alias) {//alert(alias);
		exp_drop_down(second_path, alias, $scope, 'second');
	}
	$scope.dep_drop2 = function(alias) {
		exp_drop_down(third_path, alias, $scope, 'third');
	}
	$scope.dep_drop3 = function(alias) {
		exp_drop_down(fourth_path, alias, $scope, 'fourth');
	}
}

function exp_drop_down(url, alias, $scope, help) {
	$.ajax({
		type: 'POST',
		url: base_url_2 + url,
		data: 'alias=' + alias+'&emp_alias='+readCookie('emp_alias')+ "&token=" + readCookie('token'),
		cache: false,
		async: false,
		error: function(result) {
			/* alert('error occured'); */
		},
		success: function(result) {//alert(result);
			setTimeout(function(){$('.testSelAll2').SumoSelect({selectAll:true});
				$('.textSearch').keyup(function(){
				var cc = $(this).siblings('.options').find('li');
				var aa =$(this).siblings('.options > li');
				var valThis = $(this).val().toLowerCase();
					if(valThis == ""){
						cc.removeClass('hidden');           
					}else{
						cc.each(function(){
							var text = $(this).text().toLowerCase();
							(text.indexOf(valThis) >= 0) ? $(this).removeClass('hidden') : $(this).addClass('hidden');
						});
				   };
				   if(cc.length==$(this).siblings('.options').find('.hidden').length){
						$(this).siblings('.options').append('<li class="no_rec"><label>No Records</label></li>');
						$(this).siblings('.select-all').addClass('hidden');}
				   else{
					    $(this).siblings('.options').find('.no_rec').remove(); 
						$(this).siblings('.select-all').removeClass('hidden');
				   };
				$('.forms_add').find('.SumoSelect').addClass('singleSelect');});
				
			},0);

			switch (help) {
				case 'first':
					$scope.firstDrop = JSON.parse(result);
					break
				case 'second':
					$scope.secondDrop = JSON.parse(result);
					break
				case 'third':
					$scope.thirdDrop = JSON.parse(result);
					break
				case 'fourth':
					$scope.fourthDrop = JSON.parse(result);
					break
			}
		}
	});
}

function tot_amt(){ 
	var tamt=tcmt=tlamt=blamt=tlomt=ttcm=0;
	$(".tamfor").each(function(){tamt+=Number($(this).val());});
	$(".tcm").each(function(){tcmt+=Number($(this).val());});
	$(".ttcm").each(function(){ttcm+=Number($(this).val());});
	$(".tlam").each(function(){tlamt+=Number($(this).val());});
	$(".blam").each(function(){blamt+=Number($(this).val());});
	$(".tlom").each(function(){tlomt+=Number($(this).val());}); 
	
	//start--for float checking
	var n1=ttcm; 
	if(isFloat(n1)==true){var v1=n1.toFixed(2);}else{var v1=n1;}
	$('.ttcmt').val(v1);
	
	var n2=tcmt;
	if(isFloat(n2)==true){var v2=n2.toFixed(2);}else{var v2=n2;}
	$('.tcmt').val(v2);
	
	var n3=tlamt;
	if(isFloat(n3)==true){var v3=n3.toFixed(2);}else{var v3=n3;}
	$('.tlamt').val(v3);
	
	var n4=blamt;
	if(isFloat(n4)==true){var v4=n4.toFixed(2);}else{var v4=n4;}
	$('.blamt').val(v4);
	
	var n5=tlomt;
	if(isFloat(n5)==true){var v5=n5.toFixed(2);}else{var v5=n5;}
	$('.tlomt').val(v5);
	//end--for float checking
	
	var n6=Number($('.nsamt').val());
	if(isNaN(n6)==true){var v6=0;}else{var v6=Number($('.nsamt').val());}
	
	$('.texp').val(Math.round(tamt));$('.finchamt').val(Math.round(tamt)-v6);
}

function remb_amt(){ 
	var remb=$(".qntyy").val();
	var finchamt=$(".finchamt_hid").val();
	var diff=Number(finchamt)-Number(remb);
	$('.finchamt').val(Math.round(diff));
}
	function ajaxAmount(tr) {
		var ref =  tr.find(".zoneChange").attr('data-ref');
		var tmp = tr.find(".localConvy").val();
		var bucket = (tmp==null ? 5 : tmp);
		var zoneval = tr.find(".zoneChange").val();
		var stateval = tr.find(".stateChange").val();
		var districtval = tr.find(".districtChange").val();
		var capChange = tr.find(".capChange").val();
		var weight = tr.find(".weightChange").val();
		var qnty = tr.find(".qnty").val();
		var km = tr.find(".numKilo").val();
		var appli = tr.find(".appliChange").val();
		var frd=tr.find('.clc').val();
		var erd=tr.find('.slc').val();
		//alert('bucket=' + bucket + '&zonesel=' + zoneval + '&statesel=' + stateval + '&dissel=' + districtval + '&weight=' + weight + '&qnty=' + qnty + '&km=' + km + '&appli=' + appli+'&ref='+ref+'&fda='+frd+'&eda='+erd);
		if(bucket != ""){
				$.ajax({
					url: base_url_2+ "services/expense_tracker/ajaxAmount",
					type: "POST",
                    data: 'bucket=' + bucket + '&zonesel=' + zoneval + '&statesel=' + stateval + '&dissel=' + districtval  + '&capChange=' + capChange + '&weight=' + weight + '&qnty=' + qnty + '&km=' + km + '&appli=' + appli+'&ref='+ref+'&fda='+frd+'&eda='+erd+'&emp_alias='+readCookie('emp_alias')+ "&token=" + readCookie('token'),
					success: function(result) {
						var obj1 = JSON.parse(result);
						var resVal = obj1.ajaxAmt;
						tr.find("."+ref).val($.trim(resVal));
						tot_amt();
					},
					error : function(result){
						//alert("error occured");
					}
				});
		}
	}
	function dpr_ajax(d1,d2,$scope){
		$.ajax({
				url: base_url_2+ "services/expense_tracker/dpr_details",
				type: "POST",
				data: '&emp_alias='+readCookie('emp_alias')+ "&d1=" + d1+ "&d2=" + d2,
				success: function(result) {//alert(result);
					$scope.dprViews = JSON.parse(result);
				},
				error : function(result){
					//alert("error occured");
				}
			});
	}
	function dpr_ajax1(d1,d2,$rootScope,empalias){
		$.ajax({
				url: base_url_2+ "services/expense_tracker/dpr_details",
				type: "POST",
				data: '&emp_alias='+empalias+ "&d1=" + d1+ "&d2=" + d2,
				success: function(result) {//alert(result);
					$rootScope.dprViews = JSON.parse(result);
				},
				error : function(result){
					//alert("error occured");
				}
			});
	}
	function capacity_ajax($scope,abc,$element){
			//$parentone=$(event.target).parents('.locCon');
			var capacity = abc;//$parentone.find('.capChange').val();
			$.ajax({
				type: 'POST',
				url:  base_url_2+"services/expense_tracker/cap_weight",
				data: "capalias=" + capacity,
				success: function(result) {//alert(result);console.log(result);
						$scope.capChng = JSON.parse(result);
				}
			});
				ajaxAmount($element);

		
	}

	function isFloat(n){
   	 return Number(n) === n && n % 1 !== 0;
	}


function exp_del(alias, url, $rootScope, reff, ex, ev) { 
	if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0') {
		$.ajax({
			type: 'POST',
			url: base_url_2 + url,
			data: "emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token') + "&alias=" + alias + "&reff=" + reff + "&ealias=" + ex+ "&ip_addr=" + readCookie('ip_addr'),
			cache: false,
			async: false,
			error: function(result) {
				/* alert('error occured'); */
			},
			success: function(result) {
				var delViews = jQuery.parseJSON(result);
				if(delViews.ErrorDetails.ErrorMessage=='Successfully Deleted'){ 
					$rootScope.toasts = [{
						anim: "bouncyflip",
						type: "success",
						msg: delViews.ErrorDetails.ErrorMessage
					}];
					setTimeout(function() {
						$rootScope.toasts.splice(0, 1);
						}, 3000);
					ev.parents('.expHide').remove();
					setTimeout(function(){tot_amt();}, 500);
				}else{
					$rootScope.toasts = [{
						anim: "bouncyflip",
						type: "danger",
						msg: delViews.ErrorDetails.ErrorMessage
					}];
					setTimeout(function() {
						$rootScope.toasts.splice(0, 1);
						}, 3000);
				}
			}
		});
	}
}
function exp_dyn_del(alias, url, $rootScope, reff, ex, $route) { 
	if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0') {
		$.ajax({
			type: 'POST',
			url: base_url_2 + url,
			data: "emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token') + "&alias=" + alias + "&reff=" + reff + "&ealias=" + ex+ "&ip_addr=" + readCookie('ip_addr'),
			cache: false,
			async: false,
			error: function(result) {
				/* alert('error occured'); */
			},
			success: function(result) {
				//$('.aran').css("display","none");
				var delViews = jQuery.parseJSON(result);
				//$('.aran').css("display","block");
				if(delViews.ErrorDetails.ErrorMessage=='Successfully Deleted'){ 
					$rootScope.toasts = [{
						anim: "bouncyflip",
						type: "success",
						msg: delViews.ErrorDetails.ErrorMessage
					}];
					setTimeout(function() {
						$rootScope.toasts.splice(0, 1);
						}, 3000);
					setTimeout(function() {exp_singleViews($rootScope.alias, "services/expense_tracker/user_expences_view", $rootScope);}, 0);
					$route.reload();
					//alert('f');
				}else{
					$rootScope.toasts = [{
						anim: "bouncyflip",
						type: "danger",
						msg: delViews.ErrorDetails.ErrorMessage
					}];
					setTimeout(function() {
						$rootScope.toasts.splice(0, 1);
						}, 3000);
				}
			}
		});
	}
}
/*function amntCurnt(event) {
		var amntCurnt = $(event.target).val();
		if(amntCurnt!=""){
			$.ajax({
				url: base_url_2+ "services/expense_tracker/total_advance",
				type: "POST",
				data: 'amntCurnt=' + amntCurnt+'&emp_alias='+readCookie('emp_alias')+ "&token=" + readCookie('token'),
				cache:false,
				success: function(result){
					var obj1 = JSON.parse(result);
						var resVal = obj1.tl_amt; 
						var res = resVal.split("|");
						$('.tadv').val(res[0].trim());
						if(res[1]==1) alert('Please note: Your Request is not more than INR '+$('.limitt').val());
						return false;
						
					}
				});
		}
	
	}*/
	
	function curReqAmnt(event) {
				$(document).on("keypress keyup focus",".numKilo, .amntDig",function (event) {    
			 var charCode = (event.which) ? event.which : event.keyCode;
			  if ((charCode != 46  || $(this).val().indexOf('.') != -1)&& (charCode < 48 || charCode > 57))
			   return false;
			 return true;
		});	
	}
	function qntyInteg(event) {
		$(document).on("keypress keyup focus",".qnty",function (event) {   
		var charCode = (event.which) ? event.which : event.keyCode;
			  if (charCode > 31 && (charCode < 48 || charCode > 57))
			   return false;
			 return true;
		});
	}

function datedprexp($scope,$rootScope) {

	var stdate = $('input[name="visitFromDate"]').val();
	var endate = $('input[name="visitToDate"]').val();
	var mdate=stdate.split('-');
	var idate=endate.split('-');
	var cy = mdate[2];
	var cd = mdate[0];
	var cm = mdate[1] - 1;
	var ey = idate[2];
	var ed = idate[0];
	var em = idate[1] - 1;
	var c = cy + '-' + cm + '-' + cd;
	var e = ey + '-' + em + '-' + ed;
	var d = new Date(c);
	d.setDate(d.getDate() + 0);
	$scope.pr=d
	date1 = new Date(cy, cm, cd);
	date2 = new Date(ey, em, ed);
	date1_unixtime = parseInt(date1.getTime() / 1000);
	date2_unixtime = parseInt(date2.getTime() / 1000);
	if(stdate!='' && endate!='') {
		if(date1_unixtime>date2_unixtime) {
			$('input[name="visitToDate"]').val('');
			$('#num_nights').val('');
		} else {
			$rootScope.st_date = c;
			$rootScope.en_date = e;
			var t2 = date2.getTime();
			var t1 = date1.getTime();
			var nodays = parseInt((t2-t1)/(24*3600*1000))+parseInt(1);
			if(!isNaN(nodays))$('#num_nights').val(nodays);
			if($('input[name="visitToDate"]').val() != ''){
				$('.dprDetails').removeClass('hidden');
			}
			dpr_ajax($('input[name="visitFromDate"]').val(),$('input[name="visitToDate"]').val(),$scope);
		}
	} else {
		$('#num_nights').val('');
	}
}

function datedpr($scope,$rootScope){
		var stdate = $('input[name="visitFromDate"]').val();
		var endate = $('input[name="visitToDate"]').val();
		var mdate=stdate.split('-');
		var idate=endate.split('-');
		//var split_mdate = mdate['1']+'-'+mdate['0']+'-'+mdate['2'];
		var c=mdate['2']+'-'+mdate['1']+'-'+mdate['0'];
		var e=idate['2']+'-'+idate['1']+'-'+idate['0']; 
		var d = new Date(c);
		d.setDate(d.getDate() + 0);
		$scope.pr=d
		date1 = new Date(mdate['2'], mdate['1'], mdate['0']);
		date2 = new Date(idate['2'], idate['1'], idate['0']);
		// We use the getTime() method and get the unixtime (in milliseconds, but we want seconds, therefore we divide it through 1000)
		date1_unixtime = parseInt(date1.getTime() / 1000);
		date2_unixtime = parseInt(date2.getTime() / 1000);
		if(stdate!='' && endate!=''){
			if(date1_unixtime>date2_unixtime){
				$('input[name="visitToDate"]').val('');
				$('#num_nights').val('');
			}else{
				$rootScope.st_date=c;
				$rootScope.en_date=e;
				// This is the calculated difference in seconds
				//var timeDifference = date2_unixtime - date1_unixtime;
				// in Hours
				//var timeDifferenceInHours = timeDifference / 60 / 60;
				// and finaly, in days :)
				//var timeDifferenceInDays = timeDifferenceInHours  / 24;
				//var nodays = parseInt(timeDifferenceInDays)+parseInt(1);
				var t2 =  new Date(e).getTime();
				var t1 = new Date(c).getTime();
				var nodays = parseInt((t2-t1)/(24*3600*1000))+parseInt(1);
				if(!isNaN(nodays))$('#num_nights').val(nodays);
				if($('input[name="visitToDate"]').val() != ''){
					$('.dprDetails').removeClass('hidden');
				}
				dpr_ajax($('input[name="visitFromDate"]').val(),$('input[name="visitToDate"]').val(),$scope);
			}
		}else{
			$('#num_nights').val('');
		}
	}
	function numNights($scope){
		var stdate = $('input[name="visitFromDate"]').val();
		var endate = $('input[name="visitToDate"]').val();
		var mdate=stdate.split('-');
		var idate=endate.split('-');
		//var split_mdate = mdate['1']+'-'+mdate['0']+'-'+mdate['2'];
		var c=mdate['2']+'-'+mdate['1']+'-'+mdate['0'];
		var e=idate['2']+'-'+idate['1']+'-'+idate['0']; 
		var d = new Date(c);
		d.setDate(d.getDate() + 0);
		$scope.pr=d
		date1 = new Date(mdate['2'], mdate['1']-1, mdate['0']);
		date2 = new Date(idate['2'], idate['1']-1, idate['0']);
		// We use the getTime() method and get the unixtime (in milliseconds, but we want seconds, therefore we divide it through 1000)
		date1_unixtime = parseInt(date1.getTime() / 1000);
		date2_unixtime = parseInt(date2.getTime() / 1000);	
		if(stdate!='' && endate!=''){
			if(date1_unixtime>date2_unixtime){
				$('input[name="visitToDate"]').val('');
				$('#num_nights').val('');
			}else{
				// This is the calculated difference in seconds
				//var timeDifference = date2_unixtime - date1_unixtime;
				// in Hours
				//var timeDifferenceInHours = timeDifference / 60 / 60;
				// and finaly, in days :)
				//var timeDifferenceInDays = timeDifferenceInHours  / 24;
				//var nodays = parseInt(timeDifferenceInDays)+parseInt(1);
				var t2 =  new Date(e).getTime();
				var t1 = new Date(c).getTime();
				var nodays = parseInt((t2-t1)/(24*3600*1000))+parseInt(1);
				if(!isNaN(nodays))$('#num_nights').val(nodays);
			}
		}
	}
function curReqq(){ 
var tamt=nval=0;
	$(".tamfor").each(function(){
		if($(this).val()!='No pending Advances'){nval=$(this).val();}
			tamt+=Number(nval);
		}
	);
	$('.tamt').val(tamt);
}
function file_loading_exp(files,$scope){
	$scope.prg_shw_hde=true;
	$scope.determinateValue = $scope.determinateValue2 = 0;
	var dv=0,size = Math.floor((files[0].size)/10000),
	set_int=setInterval(function(){
		$scope.determinateValue += 1;
		$scope.determinateValue2 += 1.5;
		dv=$scope.determinateValue;
		$scope.file_name=dv+"%";
		if(dv>100){clearInterval(set_int);$scope.file_name=files[0].name;$scope.prg_shw_hde=false;}
	}, size);
}

var settingsDetails = {
	'limits' : {
		'redirectTo': '#/limits',
		'verifyUrl': 'services/expense_tracker/limit_check_delete_status',
		'formUrl': 'services/expense_tracker/limit_delete',
		'alias': 'limit_alias'
	},
	'approvers' : {
		'redirectTo': '#/approvers',
		'verifyUrl': 'services/expense_tracker/approvers_check_delete_status',
		'formUrl': 'services/expense_tracker/approvers_delete',
		'alias': 'approval_alias'
	},
	'serallowances' : {
		'redirectTo': '#/Service-allowances',
		'verifyUrl': 'services/expense_tracker/serallowances_check_delete_status',
		'formUrl': 'services/expense_tracker/serallowances_delete',
		'alias': 'service_allowance_alias'
	},
	'othallowances' : {
		'redirectTo': '#/Others-allowances',
		'verifyUrl': 'services/expense_tracker/othallowances_check_delete_status',
		'formUrl': 'services/expense_tracker/othallowances_delete',
		'alias': 'allowance_alias'
	}
};

function deleteSetting(setting, data, $scope, $rootScope, $modal) {
	var postData = new FormData();
	postData.append("emp_alias", readCookie('emp_alias'));
	postData.append("token", readCookie('token'));
	postData.append("ip_addr", readCookie('ip_addr'));
	var settingDetails = settingsDetails[setting];
	if(typeof settingDetails == 'undefined') {
		toast_msg($rootScope, 'danger', 'Invalid Request. Please contact admin', 3000);
		return;
	}
	postData.append("alias", data[settingDetails.alias]);
	$.ajax({
		url: base_url_2 + settingDetails['verifyUrl'],
		type: "POST",
		data: postData,
		processData: false,
		contentType: false,
		error: function(result) {
			$rootScope.loading = false;
			toast_msg($rootScope, 'danger', 'Request failed, Contact Admin', 10000);
		}, beforeSend:function(result){
			$rootScope.loading = true;
		}, success: function(result) {
			$rootScope.loading=false;
			var json = jQuery.parseJSON(result);
			if (json.ErrorDetails.ErrorCode == '0') {
				data.verifyUrl = settingDetails.verifyUrl;
				data.formUrl = settingDetails.formUrl;
				data.redirectTo = settingDetails.redirectTo;
				data.alias = data[settingDetails.alias];
				$rootScope.deleteData = data;
				modelpopup("includes/settings/delete.html", "md", $modal, $scope);
			} else if(json.ErrorDetails.ErrorCode > '0') {
				$(".sendMail").show();
				toast_msg($rootScope,'danger',json.ErrorDetails.ErrorMessage,3000);
				$('button[type="submit"], input[type="submit"]').removeAttr('disabled','disabled');
			}
		}
	});
}
//=== #end
})()
