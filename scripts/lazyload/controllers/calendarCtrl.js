;(function() {
	var app = angular.module("app.ctrls");
		app.controller("CalendarDemoCtrl", ["$scope", "$http", "$modal", "uiCalendarConfig", "$compile", "$rootScope", function($scope, $http, $modal, uiCalendarConfig, $compile,$rootScope){
		$scope.modalAnim = "modalRapid";
		var cc = uiCalendarConfig.calendars,date = new Date(),d = date.getDate(),m = date.getMonth(),y = date.getFullYear();
		var eventColors = {success: "#4CAF50",warning: "#FDD835",danger: "#f44336",primary: "#3F51B5"};
		$scope.currentDate = moment().format("MMMM DD, YYYY");//alert(moment().format("MMMM DD, YYYY"));
		//onload calender service call Starts format("MMMM YYYY"); format("MMMM DD, YYYY")
		var url = $(".form_cal").attr('url');
		var data = new FormData($('.form_cal')[0]);
		data.append("emp_alias", readCookie('emp_alias'));
		data.append("token", readCookie('token'));
		data.append("heldate", $scope.currentDate);
		ajaxCalendar(data,url,$scope,$rootScope);
		function ajaxCalendar(data,url,$scope,$rootScope){
			//$('.loadingg').show();
			$rootScope.loading = true;
			//setTimeout(function(){
				$.ajax({
					type: 'POST',
					url: url,
					data: data,
					cache: false,
					async: false,
					processData: false,
					contentType: false,
					error: function(result) {},
					success: function(result){
						$rootScope.loading = false;
						$rootScope.enerlod = false;
						//$('.loadingg').hide();
						$scope.calenderEvents = JSON.parse(result);
						$scope.eventSources = [$scope.calenderEvents.events];		
					}
				});
			//},10);
		}	
		//onload calender service call Ends
		$scope.calSorting = function(e) {
			$rootScope.loading = true;
			//$('.loadingg').show();
			setTimeout(function(){
				var url = $(".form_cal").attr('url');
				var data = new FormData($('.form_cal')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("heldate", $scope.currentDate);
				$.ajax({
					type: 'POST',
					url: url,
					data: data,
					cache: false,
					async: false,
					processData: false,
					contentType: false,
					error: function(result) {},
					success: function(result){
						$rootScope.loading = false;
						//$('.loadingg').hide();
						$scope.calenderEvents = JSON.parse(result);
						$scope.eventSources = [$scope.calenderEvents.events];}
				});
				cc['mycalendar'].fullCalendar('removeEvents');
				cc['mycalendar'].fullCalendar('addEventSource', $scope.calenderEvents);         
				cc['mycalendar'].fullCalendar('rerenderEvents' );
			},10);
		}
		$scope.eventRender = function(event, elem, view){elem.attr({'tooltip': event.event_type, 'tooltip-append-to-body': true});$compile(elem)($scope);};
		$scope.uiConfig = {//agendaDay OR month
			calendar:{height: 450,editable: false,defaultView: "agendaDay",eventLimit: 2,header: false,eventRender: $scope.eventRender,
				dayClick: function(date) {
					$scope.currentDate = date.format();
					var url = $(".form_cal").attr('url');
					var data = new FormData($('.form_cal')[0]);
					data.append("emp_alias", readCookie('emp_alias'));
					data.append("token", readCookie('token'));
					data.append("heldate", date.format());
					ajaxCalendar(data,"services/calender/calender", $scope,$rootScope);
				}
			}
		}
		$scope.addEvent=function(){$modal.open({templateUrl: "includes/calender/addEvent.php",size: "md",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim ,keyboard: false,backdrop: 'static' });};
		$scope.emailSend = function(){$modal.open({templateUrl:"includes/calender/emailCalendar.php",size: "md",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static' });};	
		$scope.viewDetailsopen = function(){$modal.open({templateUrl: "includes/calender/viewDetails.php",size: "lg",controller: "ModalDemoCtrl",resolve: function() {},windowClass: $scope.modalAnim,keyboard: false,backdrop: 'static' });};
		$scope.editDetailsopen = function(){
			$modal.open({
				templateUrl: "includes/calender/edit_event.html",
				size: "md",
				controller: "ModalDemoCtrl",
				resolve: function() {},
				windowClass: $scope.modalAnim,
				keyboard: false,
				backdrop: 'static' 
			});
		};
		$rootScope.details = function(alias,types){
			$.ajax({
				type: 'POST',url: 'services/calender/event_popup',
				data: "emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token')+"&alias="+alias+"&types="+types,
				cache: false,async: false,
				success: function(result){$rootScope.detailEvents = JSON.parse(result);}
			});
		}
		$scope.changeView = function(view,calendar){
			//$('.loadingg').show();
			$rootScope.loading = true; 
			setTimeout(function(){
				cc[calendar].fullCalendar('changeView',view);
				$scope.currentDate = cc[calendar].fullCalendar("getView").title;
					var url = $(".form_cal").attr('url');
					var data = new FormData($('.form_cal')[0]);
					data.append("emp_alias", readCookie('emp_alias'));
					data.append("token", readCookie('token'));
					data.append("heldate", $scope.currentDate);
					$.ajax({
						type: 'POST',
						url: url,
						data: data,
						cache: false,
						async: false,
						processData: false,
						contentType: false,
						error: function(result) {},
						success: function(result) {
							$rootScope.loading = false;
							//$('.loadingg').hide();
							$scope.calenderEvents = JSON.parse(result);
							$scope.eventSources = [$scope.calenderEvents.events];		
						}
					});
					cc['mycalendar'].fullCalendar('removeEvents');
					cc['mycalendar'].fullCalendar('addEventSource', $scope.calenderEvents);         
					cc['mycalendar'].fullCalendar('rerenderEvents' );
				},10);
		};
		$scope.prev = function(calendar) {
			//$('.loadingg').show();
			$rootScope.loading = true;
			setTimeout(function(){
				cc[calendar].fullCalendar("prev");
				$scope.currentDate = cc[calendar].fullCalendar("getView").title;		
				var url = $(".form_cal").attr('url');
				var data = new FormData($('.form_cal')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("heldate", $scope.currentDate);
				$.ajax({
					type: 'POST',
					url: url,
					data: data,
					cache: false,
					async: false,
					processData: false,
					contentType: false,
					error: function(result) {},
					success: function(result) { 
						$rootScope.loading = false;
						//$('.loadingg').hide();
						$scope.calenderEvents = JSON.parse(result);
						$scope.eventSources = [$scope.calenderEvents.events];		
					}
				});
				cc['mycalendar'].fullCalendar('removeEvents');
				cc['mycalendar'].fullCalendar('addEventSource', $scope.calenderEvents);         
				cc['mycalendar'].fullCalendar('rerenderEvents' );
			},10);
		};
		$scope.next = function(calendar) { 
			//$('.loadingg').show();
			$rootScope.loading = true;
			setTimeout(function(){
				cc[calendar].fullCalendar("next");
				$scope.currentDate = cc[calendar].fullCalendar("getView").title;
				var url = $(".form_cal").attr('url');
				var data = new FormData($('.form_cal')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("heldate", $scope.currentDate);
				$.ajax({
					type: 'POST',
					url: url,
					data: data,
					cache: false,
					async: false,
					processData: false,
					contentType: false,
					error: function(result) {},
					success: function(result) { 
						$rootScope.loading = false;
						//$('.loadingg').hide();
						$scope.calenderEvents = JSON.parse(result);
						$scope.eventSources = [$scope.calenderEvents.events];		
					}

				});
				cc['mycalendar'].fullCalendar('removeEvents');
				cc['mycalendar'].fullCalendar('addEventSource', $scope.calenderEvents);         
				cc['mycalendar'].fullCalendar('rerenderEvents' );
			},10);
		};
		$scope.today = function(calendar) { 
			//$('.loadingg').show();
			$rootScope.loading = true;
			setTimeout(function(){
				cc[calendar].fullCalendar("today");
				$scope.currentDate = cc[calendar].fullCalendar("getView").title;
				var url = $(".form_cal").attr('url');
				var data = new FormData($('.form_cal')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("heldate", $scope.currentDate);
				$.ajax({
					type: 'POST',
					url: url,
					data: data,
					cache: false,
					async: false,
					processData: false,
					contentType: false,
					error: function(result) {},
					success: function(result){ 
						$rootScope.loading = false;
						//$('.loadingg').hide();
						$scope.calenderEvents = JSON.parse(result);
						$scope.eventSources = [$scope.calenderEvents.events];		
					}

				});
				cc['mycalendar'].fullCalendar('removeEvents');
				cc['mycalendar'].fullCalendar('addEventSource', $scope.calenderEvents);         
				cc['mycalendar'].fullCalendar('rerenderEvents' );
			},10);
		};
	}])
	.controller("emailCalendarCtrl", ["$scope","$http","$route","$rootScope", function($scope,$http,$route,$rootScope) {
		$scope.sendEmail = function() {
			$('.loadingg').show();
			var went = $(".forms_add").attr('data-went');
			var url = $(".forms_add").attr('url');
			var data = new FormData($('.forms_add')[0]);
			data.append("emp_alias", readCookie('emp_alias'));
			data.append("token", readCookie('token'));
			var result = emailCalendar(data,url,$scope,$route,$rootScope);
		}
		function emailCalendar(data,url,$scope,$route,$rootScope) {
			setTimeout(function(){
				$.ajax({
					type: 'POST',
					url: base_url_2 + url,
					data: data,
					cache: false,
					async: false,
					processData: false,
					contentType: false,
					success: function(result) {					
						var json = jQuery.parseJSON(result);
						if (json.ErrorDetails.ErrorCode=='0') {
								$scope.$close();
								$rootScope.toasts = [{anim: "bouncyflip",type: "success",msg: json.ErrorDetails.ErrorMessage}];
								setTimeout(function(){$rootScope.toasts.splice(0,1);}, 3000);
						}else if (json.ErrorDetails.ErrorCode>'0') {
							$scope.toasts = [{anim: "bouncyflip",type: "danger",msg: json.ErrorDetails.ErrorMessage}];
							setTimeout(function(){$scope.toasts.splice(0,1);},3000);
						}
						$('.loadingg').hide();
					}
				});
			},10);
		}	
	}])
	
//=== #end
})()

