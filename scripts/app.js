//var base_url = "https://enersyscare.co.in/";
//var base_url_2 = "https://enersyscare.co.in/";
!(function() {
	"use strict";
	angular.module("app", ["ngPatternRestrict", "ngRoute", "ngAnimate", "ngSanitize", "ngAria", "ngMaterial","textAngular", "oc.lazyLoad", "ui.bootstrap", "angular-loading-bar", "FBAngular", "app.ctrls", "app.directives", "app.ui.ctrls", "app.ui.directives", "app.form.ctrls", "app.table.ctrls","ngAutocomplete.module","ngMask","ui.tab.scroll"])
		//disable spinner in loading-bar
		.config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
			cfpLoadingBarProvider.includeSpinner = false;
			cfpLoadingBarProvider.latencyThreshold = 500;
		}])
		//lazy loading scripts refernces of angular modules only
		.config(["$ocLazyLoadProvider", function($oc){
			$oc.config({
				debug: true,
				event: false,
				modules: [{
					name: "angularBootstrapNavTree",
					files: ["scripts/lazyload/abn_tree_directive.js", "styles/lazyload/abn_tree.css"]
				}, {
					name: "ui.calendar",
					serie: true, // load files in series
					files: ["scripts/lazyload/moment.min.js", "scripts/lazyload/fullcalendar.min.js", "styles/lazyload/fullcalendar.css", "scripts/lazyload/calendar.js"]
				}, {
					name: "ui.select",
					files: ["scripts/lazyload/select.min.js", "styles/lazyload/select.css"]
				}, {
					name: "ngTagsInput",
					files: ["scripts/lazyload/ng-tags-input.min.js", "styles/lazyload/ng-tags-input.css"]
				}, {
					name: "colorpicker.module",
					files: ["scripts/lazyload/bootstrap-colorpicker-module.min.js", "styles/lazyload/colorpicker.css"]
				}, {
					name: "ui.slider",
					serie: true,
					files: ["scripts/lazyload/bootstrap-slider.min.js", "scripts/lazyload/directives/bootstrap-slider.directive.js", "styles/lazyload/bootstrap-slider.css"]
				}, {
					name: "textAngular",
					serie: true,
					files: ["scripts/lazyload/textAngular-rangy.min.js", "scripts/lazyload/textAngular.min.js", "scripts/lazyload/textAngularSetup.js", "styles/lazyload/textAngular.css"]
				}, {
					name: "flow",
					files: ["scripts/lazyload/ng-flow-standalone.min.js"]
				}, {
					name: "ngImgCrop",
					files: ["scripts/lazyload/ng-img-crop.js", "styles/lazyload/ng-img-crop.css"]
				}, {
					name: "ngMask",
					files: ["scripts/lazyload/ngMask.min.js"]
				}, {
					name: "angular-c3",
					files: ["scripts/lazyload/directives/c3.directive.js"]
				}, {
					name: "easypiechart",
					files: ["scripts/lazyload/angular.easypiechart.min.js"]
				}, {
					name: "ngMap",
					files: ["scripts/lazyload/ng-map.min.js"]
				}, {
					name: "ui.tab.scroll",
					files: ["scripts/angular-ui-tab-scroll.js","styles/angular-ui-tab-scroll.css","scripts/ui-bootstrap-tpls.min.js"]
				}]
			})
		}])
		// jquery/javascript and css for plugins via lazy load
		.constant("JQ_LOAD", {
			fullcalendar: [],
			moment: ["scripts/lazyload/moment.min.js"],
			sparkline: ["scripts/lazyload/jquery.sparkline.min.js"],
			c3: ["scripts/lazyload/d3.min.js", "scripts/lazyload/c3.min.js", "styles/lazyload/c3.css"],
			gmaps: ["https://maps.google.com/maps/api/js"]
		})
		// route provider
		.config(["$routeProvider", "$locationProvider", "JQ_LOAD", function($routeProvider, $locationProvider, jqload) {
			var routes = [
				"signin", "enersyscare",
				"404","401","forgetPassword",
				"changePassword", "passwordManagement",
				"dynamic_remark", "inventory/items/items_view", 
				"settings/sitestatus/sitestatus_view", "contractprice/contractprice_view"
			];
			var settingsMenu = [
				{ setting: 'zone', route : "/settings/zone/zone_view" }, 
				{ setting: 'state', route : "/settings/state/state_view" }, 
				{ setting: 'district', route : "/settings/district/district_view" }, 
				{ setting: 'designation', route : "/settings/designation/designation_view" }, 
				{ setting: 'department', route : "/settings/department/department_view" }, 
				{ setting: 'email_sms', route : "/settings/email_sms_recipient/view" }, 
				{ setting: 'emprole', route : "/settings/emprole/employeerole_view" }, 
				{ setting: 'privilages', route : "/settings/privilages/privilages_view" }, 
				{ setting: 'stockcode', route : "/settings/stockcode/stockcode_view" }, 
				{ setting: 'segment', route : "/settings/segment/segment_view" }, 
				{ setting: 'customer', route : "/settings/customer/customer_view" }, 
				{ setting: 'product', route : "/settings/product/product_view" }, 
				{ setting: 'complaint', route : "/settings/complaint/complaint_view" }, 
				{ setting: 'faultycode', route : "/settings/faultycode/faultcode_view" }, 
				{ setting: 'activity', route : "/settings/activity/activity_view" }, 
				{ setting: 'levels', route : "/settings/levels/levels_view" },
				{ setting: 'warehouse', route : "/settings/warehouse/warehouse_view" },
				{ setting: 'assets', route : "/settings/assets/assets_view" },
				{ setting: 'sitetype', route : "/settings/sitetype/sitetype_view" }, 
				{ setting: 'accessories', route : "/settings/accessories/accessories_view" },
				{ setting: 'milestone', route : "/settings/milestone/milestone_view" },  
				{ setting: 'esca', route : "/settings/esca/esca_view" },
				{ setting: 'dpr', route : "/settings/dpr/dpr_view" }, 
				{ setting: 'shift', route : "/settings/shift/shift_view" },
				{ setting: 'moc', route : "/settings/moc/moc_view" }, 
				{ setting: 'dynamiclevel', route : "/settings/dynamiclevel/dynamic_level_view" },
				{ setting: 'buckets', route : "/settings/buckets/bucket_view" }, 
				{ setting: 'manuals', route : "/settings/mobile_app/manuals_view" }, 
				{ setting: 'workguide', route : "/settings/mobile_app/workguide_view" }, 
				{ setting: 'changelog', route : "/settings/mobile_app/changelog_view" }, 
			]
			function setRoutes(route){
				var url = '/' + route,config={templateUrl: "includes/" + route + ".php"};
				$routeProvider.when(url,config);
				return $routeProvider;
			}
			routes.forEach(function(route) {
				setRoutes(route);
			});
			settingsMenu.forEach(function(route) {
				$routeProvider.when(route.route, {
					templateUrl: "includes/" + route.route + ".php",
					resolve: {
						authCheck: function(Privilage) {
							Privilage.PrivilageCheck(route.setting);
						}
					}
				})	
			});
			$routeProvider.when("/settings/mobile_app/tree_view", {
				templateUrl: "includes/settings/mobile_app/tree_view.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load("angularBootstrapNavTree")
						.then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/treeviewCtrl.js"]
							})
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('settings/mobile_app/tree_view');
					}
				}
			}).when("/",{redirectTo: "signin"}).when("/404",{templateUrl: "404.html"}).when("/401",{templateUrl: "401.html"}).otherwise({redirectTo: "/404"});
			$routeProvider.when("/dashboard", {
				templateUrl: "includes/dashboard/dashboard.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load([jqload.c3, jqload.sparkline]).then(function() {
							return a.load({
								name: "app.directives",
								files: ["scripts/lazyload/directives/sparkline.directive.js"]
							})
						}).then(function() {
							return a.load("angular-c3");
						}).then(function() {
							return a.load("easypiechart");
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('dashboard');
					}
				}
			})
			/*.when("/settings", {
				templateUrl: "includes/settings/settings.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load([jqload.c3, jqload.sparkline]).then(function() {
							return a.load({
								name: "app.directives",
								files: ["scripts/lazyload/directives/sparkline.directive.js"]
							})
						}).then(function() {
							return a.load("angular-c3");
						}).then(function() {
							return a.load("easypiechart");
						})
					}]
				}
			});*/
			
			.when("/settings", {
				templateUrl: "includes/settings/settings.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load("angularBootstrapNavTree")
						.then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/treeviewCtrl.js"]
							})
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('settings');
					}
				}
			})	
			.when("/signin-redirect/:value", {
				templateUrl: "includes/signin-redirect.html",
			})	
			.when("/signin/:loginStatus/:value", {
				templateUrl: "includes/signin.php",
			})	
			
			// Sitemaster view
			.when("/Sitemaster", {
				templateUrl: "includes/sitemaster/sitemaster.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load({
							name: "app.table.ctrls",
							files: ["scripts/app.js"]
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('Sitemaster');
					}
				}
			})
			// Employeemaster view
			.when("/Employeemaster", {
				templateUrl: "includes/employeemaster/view.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load({
							name: "app.table.ctrls",
							files: ["scripts/app.js"]
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('Employeemaster');
					}
				}
			})
			//Expense Tracker
			// Advances view
			.when("/Advances", {
				templateUrl: "includes/expense/advances.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load({
							name: "app.table.ctrls",
							files: ["scripts/app.js"]
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('Advances');
					}
				}
			})
			// Expenses view
			.when("/Expenses", {
				templateUrl: "includes/expense/expenses.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load({
							name: "app.table.ctrls",
							files: ["scripts/app.js"]
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('Expenses');
					}
				}
			})
			// Expense-dashboard view
			.when("/Expensedashboard", {
				templateUrl: "includes/expense/expense_dashboard.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load({
							name: "app.table.ctrls",
							files: ["scripts/app.js"]
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('Expensedashboard');
					}
				}
			})
			// Reports view
			.when("/Reports", {
				templateUrl: "includes/exports/reports.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load({
							name: "app.table.ctrls",
							files: ["scripts/app.js"]
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('expense');
					}
				}
			})
			// Reports view
			.when("/Profile", {
				templateUrl: "includes/profile.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load({
							name: "app.table.ctrls",
							files: ["scripts/app.js"]
						})
					}]
				}
			})
			.when("/spottickets", {
				templateUrl: "includes/tickets/spottickets.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('spottickets');
					}
				}
			})
			// load ui-select in form-elements
			.when("/tickets", {
				templateUrl: "includes/tickets/tickets.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider","ui.tab.scroll"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js", "scripts/angular-ui-tab-scroll.js","styles/angular-ui-tab-scroll.css","scripts/ui-bootstrap-tpls.min.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('tickets');
					}
				}
			})
			// load ui-select in form-elements
			.when("/efsr-edit", {
				templateUrl: "includes/tickets/tickets_efsr_edit.html",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider","ui.tab.scroll"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js", "scripts/angular-ui-tab-scroll.js","styles/angular-ui-tab-scroll.css","scripts/ui-bootstrap-tpls.min.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('tickets');
					}
				}
			})
			// Reports view
			.when("/imeicontrol", {
				templateUrl: "includes/imeicontrol/imeicontrol.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load({
							name: "app.table.ctrls",
							files: ["scripts/app.js"]
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('imeicontrol');
					}
				}
			})
			// Reports view
			.when("/usertracking", {
				templateUrl: "includes/usertracking/usertracking.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load({
							name: "app.table.ctrls",
							files: ["scripts/app.js"]
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('usertracking');
					}
				}
			})
			// Reports view
			.when("/notifications", {
				templateUrl: "includes/notifications/notifications_view.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load({
							name: "app.table.ctrls",
							files: ["scripts/app.js"]
						})
					}]
				}
			})
			// Tickets By Customer Ends	
			.when("/bycustomer", {
				templateUrl: "includes/bycustomer.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('tickets');
					}
				}
			})
			.when("/onlinetickets", {
				templateUrl: "includes/onlinetickets.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}]
				}
			})
			// Tickets By Customer Ends	
			//By Jagan
			//Inventory Module For Table Views Starts
			// Materialbalance view
			.when("/Materialbalance", {
				templateUrl: "includes/inventory/material_balance/materialbalance.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load({
							name: "app.table.ctrls",
							files: ["scripts/app.js"]
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('Materialbalance');
					}
				}
			})
			// Inwardbalance view
			.when("/Inwardbalance", {
				templateUrl: "includes/inventory/material_balance/inwardbalance.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load({
							name: "app.table.ctrls",
							files: ["scripts/app.js"]
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('Materialbalance');
					}
				}
			})
			// Outwardbalance view
			.when("/Outwardbalance", {
				templateUrl: "includes/inventory/material_balance/outwardbalance.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load({
							name: "app.table.ctrls",
							files: ["scripts/app.js"]
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('Materialbalance');
					}
				}
			})

			// Materialinward view
			.when("/Materialinward", {
				templateUrl: "includes/inventory/material_inward/materialinward.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('Materialinward');
					}
				}
			})
			// Materialoutward view
			.when("/Materialoutward", {
				templateUrl: "includes/inventory/material_outward/materialoutward.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('Materialoutward');
					}
				}
			})
			// Materialrequest View
			.when("/Materialrequest", {
				templateUrl: "includes/inventory/material_request/Materialrequest.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('Materialrequest');
					}
				}
			})
			// Revival view
			.when("/Revival", {
				templateUrl: "includes/inventory/material_revival/revival.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load({
							name: "app.table.ctrls",
							files: ["scripts/app.js"]
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('Revival');
					}
				}
			})
			// Refreshing view
			.when("/Refreshing", {
				templateUrl: "includes/inventory/material_refreshing/refreshing.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load({
							name: "app.table.ctrls",
							files: ["scripts/app.js"]
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('Refreshing');
					}
				}
			})
			// SJO Search view
			.when("/sjo_search", {
				templateUrl: "includes/inventory/sjo_search/sjo_search.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('sjo_search');
					}
				}
			})
			// Stocks(Item Code) view
			.when("/items_view", {
				templateUrl: "includes/inventory/stocks/items_view.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('items_view');
					}
				}
			})
			//Inventory Module For Table Views Ends
			//By Jagan
		//eca
		.when("/dashboard-esca", {
				templateUrl: "includes/esca/dashboard.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load([jqload.c3, jqload.sparkline]).then(function() {
							return a.load({
								name: "app.directives",
								files: ["scripts/lazyload/directives/sparkline.directive.js"]
							})
						}).then(function() {
							return a.load("angular-c3");
						}).then(function() {
							return a.load("easypiechart");
						})
					}]
				}
			})
			.when("/tickets-esca", {
				templateUrl: "includes/esca/tickets.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider","ui.tab.scroll"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js", "scripts/angular-ui-tab-scroll.js","styles/angular-ui-tab-scroll.css","scripts/ui-bootstrap-tpls.min.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}]
				}
			})
			.when("/employeemaster-esca", {
				templateUrl: "includes/esca/view.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}]
				}
			})
			//end esca
			//customer
			.when("/dashboard-customer", {
				templateUrl: "includes/customer/dashboard.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load([jqload.c3, jqload.sparkline]).then(function() {
							return a.load({
								name: "app.directives",
								files: ["scripts/lazyload/directives/sparkline.directive.js"]
							})
						}).then(function() {
							return a.load("angular-c3");
						}).then(function() {
							return a.load("easypiechart");
						})
					}]
				}
			})
			.when("/tickets-customer", {
				templateUrl: "includes/customer/tickets.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider","ui.tab.scroll"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js", "scripts/angular-ui-tab-scroll.js","styles/angular-ui-tab-scroll.css","scripts/ui-bootstrap-tpls.min.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}]
				}
			})
			.when("/sitemaster-customer", {
				templateUrl: "includes/customer/sitemaster.php",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}]
				}
			})
			// calendar plugin
			// "scripts/lazyload/apps/calendarDemo.js"
			.when("/calendar", {
				templateUrl: "includes/calender/calendar.php",
				controller: "CalendarDemoCtrl",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load("ui.calendar")
						.then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/calendarCtrl.js"]
							})
						});
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('calendar');
					}
				}
			})
		/*-------------Expense Tracker---------------*/
			.when("/expense_dashboard", {
				templateUrl: "includes/expense/expense_dashboard.php",
				controller: "EnersysExpenseCtrl",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/expenseCtrl.js","scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('expense_dashboard');
					}
				}
			})
			.when("/advances", {
				templateUrl: "includes/expense/advances.php",
				controller: "EnersysExpenseCtrl",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/expenseCtrl.js","scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('advances');
					}
				}
			})
			.when("/expense", {
				templateUrl: "includes/expense/expenses.php",
				controller: "EnersysExpenseCtrl",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider", "flow"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/expenseCtrl.js","scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js","scripts/lazyload/ng-flow-standalone.min.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('expense');
					}
				}
			})
			.when("/approvers", {
				templateUrl: "includes/settings/approvers/approvers_view.php",
				controller: "EnersysExpenseCtrl",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/expenseCtrl.js","scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('approvers');
					}
				}
			})
			.when("/limits", {
				templateUrl: "includes/settings/limits/limits_view.php",
				controller: "EnersysExpenseCtrl",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/expenseCtrl.js","scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('limits');
					}
				}
			})
			.when("/Service-allowances", {
				templateUrl: "includes/settings/allowances/services_view.php",
				controller: "EnersysExpenseCtrl",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/expenseCtrl.js","scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('allowances');
					}
				}
			})
			.when("/Others-allowances", {
				templateUrl: "includes/settings/allowances/others_view.php",
				controller: "EnersysExpenseCtrl",
				resolve: {
					deps: ["$ocLazyLoad", function(a) {
						return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider"]).then(function() {
							return a.load({
								name: "app.ctrls",
								files: ["scripts/lazyload/controllers/expenseCtrl.js","scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js"]
							})
						}).then(function() {
							return a.load("textAngular");
						})
					}],
					authCheck: function(Privilage) {
						Privilage.PrivilageCheck('allowances');
					}
				}
			});
		}])

}());
! function() {
	"use strict";
	angular.module("app.form.ctrls", []).controller("FormWizardCtrl", ["$scope", function($scope) {
		$scope.steps = [!0, !1, !1], $scope.stepNext = function(index) {
			for (var i = 0; i < $scope.steps.length; i++) $scope.steps[i] = !1;
			$scope.steps[index] = !0
		}, $scope.stepReset = function() {
			$scope.steps = [!0, !1, !1]
		}
	}])
}();
! function() {
	"use strict";
	angular.module("ngAutocomplete.module", ['ngAutocomplete']).controller("autocomplete", ["$scope", function($scope) {
			$scope.result1 = '';
			$scope.options1 = null;
			$scope.details1 = '';
		}])
}();

!(function() {
	"use strict";
	angular.module("app.ctrls", [])
		//String Filter
		.filter('strLimit', ['$filter', function($filter) {
		   return function(input, limit) {
			  if (! input) return;
			  if (input.length <= limit) {
				  return input;
			  }
			  return $filter('limitTo')(input, limit) + '...';
		   };
		}])
		.filter('htmlToPlaintext', function() {
			return function(text) {
				return text ? String(text).replace(/<[^>]+>/gm, '') : '';
			};
		})
		.service('all_apiRoute', function ($http) {
			var urlGet = '';  
			this.getAll = function (apiRoute) {  
				urlGet = apiRoute;  
				return $http.post(urlGet);  
			}  
		})
		.service('Privilage', function ($http,$location) {
			var Priv = {};
			Priv.PrivilageCheck = function (module,callback) {
				if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('ip_addr') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0' && readCookie('ip_addr') != '0') {
					$http.post(base_url + 'services/url_menu?menu_name='+module+'&emp_alias='+readCookie('emp_alias')+'&token='+readCookie('token')).success(function(response) {
						if(module!==response.res) $location.path(response.res);
					});
				} else {
					console.log("Redirected to signin")
					$location.path('signin');
				}
			};
			return Priv;
		})
		/*.filter('trusted', ['$sce', function($sce) {
				var div = document.createElement('div');
				return function(text) {
					div.innerHTML = text;
					return $sce.trustAsHtml(div.textContent);
				};
			}]).filter('escapeHtml', function () {
			var entityMap = {
				"&": "&amp;",
				"<": "&lt;",
				">": "&gt;",
				'"': '&quot;',
				"'": '&#39;',
				"/": '&#x2F;'
			};
			return function(str) {
				return String(str).replace(/[&<>"'\/]/g, function (s) {
					return entityMap[s];
				});
			}
		})*/
		// Root Controller
		.controller("AppCtrl", ["$rootScope", "$scope", "$timeout", "$location", "Privilage", function($rs, $scope, $timeout, $location, Privilage) { 
			$scope.date = new Date();
			var path = function() {
				return $location.path()
			};
			var a = ["/404", "/401", "/signin", "/forgetPassword", "/lockScreen", "/bycustomer", "/onlinetickets", "/enersyscare"];
			if (!(path() in a) && path().indexOf("signin") < 0  && path().indexOf("signin-redirect") < 0) {
				if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('ip_addr') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0' && readCookie('ip_addr') != '0') {
					 checkLogin(readCookie('emp_alias'), readCookie('token'), readCookie('ip_addr'),$scope);
				} else {
					Privilage.PrivilageCheck(path());
				}
			}
			var mm = window.matchMedia("(max-width: 767px)");
			$rs.isMobile = mm.matches ? true : false;
			$rs.safeApply = function(fn) {
				var phase = this.$root.$$phase;
				if (phase == '$apply' || phase == '$digest') {
					if (fn && (typeof(fn) === 'function')) {
						fn();
					}
				} else {
					this.$apply(fn);
				}
			};
			mm.addListener(function(m) {
				$rs.safeApply(function() {
					$rs.isMobile = (m.matches) ? true : false;
				});
			});
			$scope.navFull = true;
			$scope.toggleNav = function() {
				$scope.navFull = $scope.navFull ? false : true;
				$rs.navOffCanvas = $rs.navOffCanvas ? false : true;
				$timeout(function() {
					$rs.$broadcast("c3.resize");
				}, 260); // adjust this time according to nav transition
			};
			// ======= Site Settings
			$scope.toggleSettingsBox = function() {
				$scope.isSettingsOpen = $scope.isSettingsOpen ? false : true;
			};
			$scope.themeActive = "theme-zero"; // first theme
			$scope.fixedHeader = true;
			$scope.navHorizontal = false; // this will access by other directive, so in rootScope.
			// ======= Material Inward View
			var lastUsed = null;
			$scope.materialinwardview = function(x) { //alert(prevClicked);
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.materialinwardView = $scope.materialinwardView ? false : true;
				} else {
					$scope.materialinwardView = false;
					$timeout(function() {
						$scope.materialinwardView = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removematerialinwardView = function() {
				$scope.materialinwardView = false;
			};
			// === saving states
			var SETTINGS_STATES = "_setting-states";
			var statesQuery = {
				get: function() {
					return JSON.parse(localStorage.getItem(SETTINGS_STATES));
				},
				put: function(states) {
					localStorage.setItem(SETTINGS_STATES, JSON.stringify(states));
				}
			};
			// initialize the states
			var sQuery = statesQuery.get() || {
				navHorizontal: $scope.navHorizontal,
				fixedHeader: $scope.fixedHeader,
				navFull: $scope.navFull,
				themeActive: $scope.themeActive
			};
			// console.log(savedStates);
			if (sQuery) {
				$scope.navHorizontal = sQuery.navHorizontal;
				$scope.fixedHeader = sQuery.fixedHeader;
				$scope.navFull = sQuery.navFull;

				$scope.themeActive = sQuery.themeActive;
			}
			// putting the states
			$scope.onNavHorizontal = function() {
				sQuery.navHorizontal = $scope.navHorizontal;
				statesQuery.put(sQuery);
			};
			$scope.onNavFull = function() {
				sQuery.navFull = $scope.navFull;
				statesQuery.put(sQuery);
				$timeout(function() {
					$rs.$broadcast("c3.resize");
				}, 260);
			};
			$scope.onFixedHeader = function() {
				sQuery.fixedHeader = $scope.fixedHeader;
				statesQuery.put(sQuery);
			};
			$scope.onThemeActive = function() {
				sQuery.themeActive = $scope.themeActive;
				statesQuery.put(sQuery);
			};
			$scope.onThemeChange = function(theme) {
				$scope.themeActive = theme;
				$scope.onThemeActive();
			}
			/*var idleTime = 0;
			$(document).ready(function ($scope,$rootScope) {
				//Increment the idle time counter every minute.
				var idleInterval = setInterval(timerIncrement, 1000); // 1 minute
			
				//Zero the idle timer on mouse movement.
				$('body').mousemove(function (e) {
					idleTime = 0;
				});
				$('body').keypress(function (e) {
					idleTime = 0;
				});
				$('body').click(function(e) {
					idleTime = 0;
				});
			});*/
		}]).controller("HeadCtrl", ["$scope", "Fullscreen", function($scope, Fullscreen) {
			$scope.toggleFloatingSidebar = function() {
				$scope.floatingSidebar = $scope.floatingSidebar ? false : true;
				console.log("floating-sidebar: " + $scope.floatingSidebar);
			};
			$scope.goFullScreen = function() {
				if (Fullscreen.isEnabled()) Fullscreen.cancel();
				else Fullscreen.all()
			};
		}])
		.controller("logoCtrl", ["$scope", "$rootScope", "Privilage", "$location", function($scope, $rootScope, Privilage, $location) {
			$rootScope.menu = function(){Privilage.PrivilageCheck($location.path());}
		}])
		.controller("fileUploadPrgCtrl", ["$scope", "$rootScope", "$element", function($scope, $rootScope,$element){
			$scope.file_load=function(files,type){file_loading(files,$scope,$rootScope,type);}
			$scope.clear = function() {angular.element("input[type='file']").val(null);}		
			$scope.closeloadings = function(e){ $rootScope.loading= false;}
			$scope.disablebut = function(e){ $('button[type="submit"], input[type="submit"]').attr('disabled','disabled');}
			$scope.enablebut = function(e){$('button[type="submit"], input[type="submit"]').removeAttr('disabled','disabled');}
		}])
		/// ==== Dashboard Controller
		.controller("DashboardCtrl", ["$scope","$rootScope", "$window", function($scope,$rootScope, $window) {
			//ajaxsingleViews(readCookie('emp_alias'), "services/profile_view", $scope,$rootScope);
				ajaxsingleViews1('', 'services/left_menu', $scope,$rootScope);
			$.ajax({
				type: 'POST',
				url: base_url_2+'services/dashboard/yogzkmi',
				data: 'alias=' + readCookie('emp_alias')+"&token=" + readCookie('token')+"&ip_addr=" + readCookie('ip_addr'),
				cache: false,
				async: false,
				success: function(result){ re_drop();
					$scope.firstDrop = JSON.parse(result);
				}
			});
			$scope.closeloadings = function(e){ $rootScope.loading=false;}
			$scope.redirectTo = function(redirect, location) {
				if(redirect) {
					$window.location.href = location;
				} else {
					toast_msg($rootScope, "danger", "You don't have access to view",3000);
				}
			}
		}])
		// #end
		//esca dashboard
		.controller("DashboardEscaCtrl", ["$scope","$rootScope", function($scope,$rootScope) {
			//ajaxsingleViews1(readCookie('emp_alias'), "services/profile_view", $scope,$rootScope);
			//ajaxsingleViews1('', 'services/left_menu', $scope,$rootScope);
			$.ajax({
				type: 'POST',
				url: base_url_2+'services/esca/yogzkmi_fun',
				data: 'alias=' + readCookie('emp_alias')+"&token=" + readCookie('token')+"&ip_addr=" + readCookie('ip_addr'),
				cache: false,
				async: false,
				success: function(result){ re_drop();
					$scope.firstDrop = JSON.parse(result);
				}
			});
		}])
		//end esca
		//customer
		.controller("DashboardCustCtrl", ["$scope","$rootScope", function($scope,$rootScope) {
			ajaxsingleViews1(readCookie('emp_alias'), "services/profile_view", $scope,$rootScope);
			//ajaxsingleViews1('', 'services/left_menu', $scope,$rootScope);
			$.ajax({
				type: 'POST',
				url: base_url_2+'services/customer/yogzkmi_fun',
				data: 'alias=' + readCookie('emp_alias')+"&token=" + readCookie('token')+"&ip_addr=" + readCookie('ip_addr'),
				cache: false,
				async: false,
				success: function(result){ re_drop();
					$scope.firstDrop = JSON.parse(result);
				}
			});
			/*ajaxsingleViews(readCookie('emp_alias'), "services/profile_view", $scope,$rootScope);*/
			
		}])
		//end customer
})();
!(function() {
	"use strict";
	angular.module("app.directives", [])
	/*.directive('backto',["$interval", function ($interval) {
			  return {
				restrict: 'E',
				replace:true,
				template: '<div class="back-to-top"><i class="ion ion-chevron-up"></i></div>',
				link: function (scope, element, attr) {
					scope.$watch('backto', function (val) { $(element).hide();
						var stop = $interval(function() {
							var win = ($('.modal').length ? $('.modal') : $(window));
							var modc = $('#content');
							var view_content = modc.html();
							if(view_content!==undefined && view_content!==null && view_content!==""){
								angular.element(win).bind("scroll", function() {
									 if (win.scrollTop() > 200) $(element).fadeIn(200); 
									 else $(element).fadeOut(200);
								});
								//scope.stopInter();
							}
						}, 2500);
						$(element).off('click').on('click', function(event){
							event.preventDefault();
							$('body, html, .modal').animate({ scrollTop:0}, 1000);
							return false;
						});
						scope.stopInter = function() {
							$interval.cancel(stop); 
						};
					});
				}
			 }
		}])*/
		.directive('clickOnce', ["$timeout", function($timeout) {
			return {
				restrict: 'A',
				link: function(scope, element, attrs) {
					var replacementText = attrs.clickOnce;
		
					element.bind('click', function() {
						$timeout(function() {
							if (replacementText) {
								element.html(replacementText);
							}
							element.attr('disabled', true);
						}, 0);
					});
				}
			};
		}]).directive('validInput', function($compile) {
		  return {
			restrict: 'A',
			//replace: true,
			//priority: 1000,
			//terminal: true,
			link: function(scope, element, attrs) {
				var limit = attrs.validInput!=undefined ? parseInt(attrs.validInput) : true;
				if(limit=='4'){ //Cell quantity No.
					attrs.$set('ng-pattern-restrict','^$|^[1-9][0-9]*$');
					attrs.$set('ng-minlength','1');
					attrs.$set('maxlength','4');
				}else if(limit=='10'){ //Mobile No.
					attrs.$set('ng-pattern-restrict','^$|^[6-9][0-9]*$');
					attrs.$set('ng-minlength','10');
					attrs.$set('maxlength','10');
				}else if(limit=='15'){ //IMEI No.
					attrs.$set('ng-pattern-restrict','^$|^[1-9][0-9]*$');
					attrs.$set('ng-minlength','14');
					attrs.$set('maxlength','15');
				}else{ //Cell Serial No.
					attrs.$set('ng-pattern-restrict','^[a-zA-Z0-9_]*$');
					attrs.$set('ng-minlength','7');
					attrs.$set('maxlength','20');
				}attrs.$set('validInput', null);
			  $compile(element)(scope);
		   }
		  };
		})
		/*.directive('enerlod', function () {
			  return {
				restrict: 'E',
				replace:true,
				template: '<div class="enersysLod">'+
					'<div layout="row" layout-sm="column" layout-align="space-around" class="mb20 gfa">'+
						'<md-progress-circular md-mode="indeterminate" aria-valuemin="0" aria-valuemax="100" role="progressbar" class="md-default-theme" style="transform: scale(1);">'+
							'<p><div class="md-spinner-wrapper">'+
								'<div class="md-inner">'+
									'<div class="md-gap"></div>'+
									'<div class="md-left"><div class="md-half-circle"></div></div>'+
									'<div class="md-right"><div class="md-half-circle"></div></div>'+
								'</div>'+
							'</div></p>'+
						'</md-progress-circular>'+
					'</div>'+
					'<div layout="row" layout-sm="column" layout-align="space-around" class="mb20 textLod">'+
						'<h3 style="color:rgb(63,81,181);">Please wait while we process your request...</h3>'+
					'</div>'+
				'</div>',
				link: function (scope, element, attr) {
					  scope.$watch('enerlod', function (val) {
						  if (val)
							  $(element).show();
						  else
							  $(element).hide();
					  });
				}
			  }
		})*/
		.directive('enerlod', function () {
			  return {
				restrict: 'E',
				replace:true,
				template: '<div class="enerload">\
							<div class="lod">\
								<div class="sk-wave">\
									<div class="please">Please wait while we process your request...</div>\
									<div class="sk-rect sk-rect1"></div>\
									<div class="sk-rect sk-rect2"></div>\
									<div class="sk-rect sk-rect3"></div>\
									<div class="sk-rect sk-rect4"></div>\
									<div class="sk-rect sk-rect5"></div>\
								</div>\
							</div>\
						</div>',
				//template: 'localhost\Fugue\Lead\views\loading.html',
				link: function (scope, element, attr) {
					  scope.$watch('enerlod', function (val) {
						  if (val) $(element).show(); else $(element).hide();
					  });
				}
			  }
		 })
		.directive('loading', function () {
			  return {
				restrict: 'E',
				replace:true,
				template: '<div class="loadingg">'+
							'<div layout="row" layout-sm="column" layout-align="space-around" class="mb20 gfff">'+
								'<md-progress-circular md-mode="indeterminate" aria-valuemin="0" aria-valuemax="100" role="progressbar" class="md-default-theme" style="transform: scale(1);">'+
									'<div class="md-spinner-wrapper">'+
										'<div class="md-inner">'+
											'<div class="md-gap"></div>'+
											'<div class="md-left"><div class="md-half-circle"></div></div>'+
											'<div class="md-right"><div class="md-half-circle"></div></div>'+
										'</div>'+
									'</div>'+
								'</md-progress-circular>'+
							'</div>'+
						'</div>',
				link: function (scope, element, attr) {
					  scope.$watch('loading', function (val) {
						  if (val)
							  $(element).show();
						  else
							  $(element).hide();
					  });
				}
			  }
		 })
		.directive( 'resetDirective', [ '$parse', function ( $parse ) {
			return function( scope, element, attr ) {
				var fn = $parse( attr.resetDirective );
				var masterModel = angular.copy( fn( scope ) );
				// Error check to see if expression returned a model
				if ( !fn.assign ) {
					throw Error( 'Expression is required to be a model: ' + attr.resetDirective );
				}
				element.bind( 'reset', function ( event ) {
					scope.$apply( function () {
						fn.assign( scope, angular.copy( masterModel ) );
						scope.form.$setPristine();
					});
					$scope.resetDropDown = function() {
						if(angular.isDefined($scope.first)){
							delete $scope.first;
							$scope.form.$setPristine();
						}
					}
					// TODO: memoize prevention method
					if ( event.preventDefault ) {
						return event.preventDefault();
					}
					else {
						return false;
					}
				});
			};
		}])
	
	.directive("collapseNavAccordion", ["$rootScope", function($rs) {
			return {
				restrict: "A",
				link: function(scope, el, attrs) {
					var lists = el.find("ul").parent("li"), // target li which has sub ul
						a = lists.children("a"),
						aul = lists.find("ul a"),
						listsRest = el.children("li").not(lists),
						aRest = listsRest.children("a"),
						stopClick = 0;
					a.on("click", function(e) {
						if (!scope.navHorizontal) {
							if (e.timeStamp - stopClick > 300) {
								var self = $(this),
									parent = self.parent("li");
								// remove `open` class from all
								lists.not(parent).removeClass("open");
								parent.toggleClass("open");
								stopClick = e.timeStamp;
							}
							e.preventDefault();
						}
						e.stopPropagation();
						e.stopImmediatePropagation();
					});
					aul.on("touchend", function(e) {
						if (scope.isMobile) {
							$rs.navOffCanvas = $rs.navOffCanvas ? false : true;
						}
						e.stopPropagation();
						e.stopImmediatePropagation();
					})
					aRest.on("touchend", function(e) {
							if (scope.isMobile) {
								$rs.navOffCanvas = $rs.navOffCanvas ? false : true;
							}
							e.stopPropagation();
							e.stopImmediatePropagation();
						})
						// slide up nested nav when clicked on aRest
					aRest.on("click", function(e) {
						if (!scope.navHorizontal) {
							var parent = aRest.parent("li");
							lists.not(parent).removeClass("open");
						}
						e.stopPropagation();
						e.stopImmediatePropagation();
					});
				}
			}
		}])
		// highlight active nav
		.directive("highlightActive", ["$location", function($location) {
			return {
				restrict: "A",
				link: function(scope, el, attrs) {
					var links = el.find("a"),
						path = function() {
							return $location.path()
						},
						highlightActive = function(links, path) {
							var path = "#" + path;
							angular.forEach(links, function(link) {
								var link = angular.element(link),
									li = link.parent("li"),
									href = link.attr("href");
								if (li.hasClass("active")) li.removeClass("active");
								if (path.indexOf(href) == 0) li.addClass("active");
							})
						};
					highlightActive(links, $location.path());
					scope.$watch(path, function(newVal, oldVal) {
						if (newVal == oldVal) return;
						highlightActive(links, $location.path());
					})
				}
			}
		}])
		// perfect-scrollbar simple directive
		.directive("customScrollbar", ["$interval", function($interval) {
			return {
				restrict: "A",
				link: function(scope, el, attrs) {
					// if(!scope.$isMobile) // not initialize for mobile
					// {
					el.perfectScrollbar({
						suppressScrollX: true
					});
					$interval(function() {
						if (el[0].scrollHeight >= el[0].clientHeight) el.perfectScrollbar("update");
					}, 400); // late update means more performance.
					// }	
				}
			}
		}]).directive("customPage", ["$location", function($location) {
			return {
				restrict: "A",
				link: function(scope, element, attrs) {
					var path = function() {
						return $location.path()
					};
					var addBg = function(path) {
						scope.bodyFull = false;
						switch (path) {
							case "":
							case "/404":
							case "/401":
							case "/signin":
							case "/forgetPassword":
							case "/lockScreen":
							case "/bycustomer":
							case "/onlinetickets":
							case "/enersyscare":
							scope.bodyFull = true;
						}
						if (path.indexOf("signin") >= 0) {
							scope.bodyFull = true;
						}
						if(path.indexOf("signin-redirect") >= 0) {
							scope.bodyFull = true;
						}
					};
					addBg(path());
					scope.$watch(path, function(newVal, oldVal) {
						if (angular.equals(newVal, oldVal)) return;
						addBg(path());
					});
				}
			}
		}])
		.directive('physicalObservation', function () {
			return {
				restrict: 'E',
				replace: true,
				templateUrl: "includes/tickets/efsr_forms/physical_observation.html",
				link: function (scope, element, attr) {
					
				}
		  	}
		})
		.directive('generatorObservation', function () {
				return {
				  restrict: 'E',
				  replace: true,
				  templateUrl: "includes/tickets/efsr_forms/generator_observation.html",
				  link: function (scope, element, attr) {
					  
				  }
				}
		   })
		.directive('historyOfCoach', function () {
			return {
				restrict: 'E',
				replace: true,
				templateUrl: "includes/tickets/efsr_forms/history_of_coach.html",
				link: function (scope, element, attr) {
					
				}
			}
		})
		.directive('equipmentDetails', function () {
			return {
				restrict: 'E',
				replace: true,
				templateUrl: "includes/tickets/efsr_forms/equipment_details.html",
				link: function (scope, element, attr) {
					
				}
			}
		})
		.directive('checkPoints', function () {
			return {
				restrict: 'E',
				replace: true,
				templateUrl: "includes/tickets/efsr_forms/check_points.html",
				link: function (scope, element, attr) {
					
				}
			}
		})
		.directive('chargerDetails', function () {
			return {
				restrict: 'E',
				replace: true,
				templateUrl: "includes/tickets/efsr_forms/charger_details.html",
				link: function (scope, element, attr) {
					
				}
			}
		})
		.directive('forkliftDetails', function () {
			return {
				restrict: 'E',
				replace: true,
				templateUrl: "includes/tickets/efsr_forms/forklift_details.html",
				link: function (scope, element, attr) {
					
				}
			}
		})
		.directive('batteryDetails', function () {
			return {
				restrict: 'E',
				replace: true,
				templateUrl: "includes/tickets/efsr_forms/battery_details.html",
				link: function (scope, element, attr) {
					
				}
			}
		})
		.directive('smpsObservation', function () {
			return {
				restrict: 'E',
				replace: true,
				templateUrl: "includes/tickets/efsr_forms/smps_observation.html",
				link: function (scope, element, attr) {
					
				}
			}
		})
		.directive('batteryObservation', function () {
			return {
				restrict: 'E',
				replace: true,
				templateUrl: "includes/tickets/efsr_forms/battery_observation.html",
				link: function (scope, element, attr) {
					
				}
			}
		})
		.directive('motiveBatteryObservation', function () {
			return {
				restrict: 'E',
				replace: true,
				templateUrl: "includes/tickets/efsr_forms/motive_battery_observation.html",
				link: function (scope, element, attr) {
					
				}
			}
		})
		.directive('serviceEngineerObservation', function () {
			return {
				restrict: 'E',
				replace: true,
				templateUrl: "includes/tickets/efsr_forms/service_engineer_observation.html",
				link: function (scope, element, attr) {
					
				}
			}
		})
		.directive('customerComments', function () {
			return {
				restrict: 'E',
				replace: true,
				templateUrl: "includes/tickets/efsr_forms/customer_comments.html",
				link: function (scope, element, attr) {

				}
			}
		})
}());
!(function() {
	"use strict";
	angular.module("app.table.ctrls", [])
		// Data Table
		.controller("imeiCtrl", ["$scope","$rootScope","$route","$mdDialog","all_apiRoute", function($scope,$rootScope,$route,$mdDialog,all_apiRoute) {
			$scope.actClick = function(x,name) {
				var confirm = $mdDialog.confirm()
				.title('Device Activation !!')
				.content("Would you like to activate "+name+"'S Device?")
				.ariaLabel('Lucky day')
				.ok('Activate!')
				.cancel('Cancel');
				$mdDialog.show(confirm).then(function() {
					var remarks="";
					all_apiRoute.getAll(base_url_2+'services/devicecontrol/device_activate?device_emp_alias='+x+'&emp_alias='+readCookie('emp_alias')+'&token='+readCookie('token')+'&remarks='+remarks)
					.then(function (response) {
						var ErrorDetails = response.data.ErrorDetails;
						var ErrorCode = ErrorDetails.ErrorCode;
						var ErrorMessage = ErrorDetails.ErrorMessage;
						if(ErrorCode=='0'){
							toast_msg($rootScope,"success","Successfully "+name+" Device Activated!",3000);
							window.location = '#/imeicontrol';$route.reload();
							$scope.alert = 'OK';
						}else toast_msg($rootScope,"danger",ErrorMessage,3000);
					}, function(error){toast_msg($rootScope,"danger","Something went wrong, Try again!",3000); });
				}, function() {
					$scope.alert = 'Not OK';
				});
			}
			$scope.deactClick = function(x,name) {
				var confirm = $mdDialog.confirm()
				.title('Device Deactivation !!')
				.content("Would you like to deactivate "+name+"'S Device?")
				.ariaLabel('Lucky day')
				.ok('Deactivate!')
				.cancel('Cancel');
				$mdDialog.show(confirm).then(function() {
					var remarks="";
					all_apiRoute.getAll(base_url_2+'services/devicecontrol/device_deactivate?device_emp_alias='+x+'&emp_alias='+readCookie('emp_alias')+'&token='+readCookie('token')+'&remarks='+remarks)
					.then(function (response) {
						var ErrorDetails = response.data.ErrorDetails;
						var ErrorCode = ErrorDetails.ErrorCode;
						var ErrorMessage = ErrorDetails.ErrorMessage;
						if(ErrorCode=='0'){
							toast_msg($rootScope,"success","Successfully "+name+" Device Deactivated!",3000);
							window.location = '#/imeicontrol';$route.reload();
							$scope.alert = 'OK';
						}else toast_msg($rootScope,"danger",ErrorMessage,3000);
					}, function(error){toast_msg($rootScope,"danger","Something went wrong, Try again!",3000); });
				}, function() {
					$scope.alert = 'Not OK';
				});
			}
		}]).controller("imeiEditCtrl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/imeicontrol/imei_view", $scope,$rootScope);
			reset_click($scope);
		}]).controller("spotticketEditCntl", ["$scope","all_apiRoute","$rootScope", function($scope,all_apiRoute,$rootScope) {
			ajaxsingleViews1($rootScope.alias, "services/tickets/spotticket_view", $scope,$rootScope);
			$scope.tt_sitename_drop = function(tt_alias){
				all_apiRoute.getAll(base_url_2+'services/tickets/tt_sitename_drop?alias='+tt_alias).then(function (response) {
					$scope.dynamic_site_name = response.data.site_name;
				}, function(error){console.log("Error: " + error); });
			}
			$scope.myModelCopy = angular.copy( $scope.singleViews);
		}])
		.controller("ticketCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.createing = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/tickets/ticket_view", $scope,$rootScope);
				//$scope.ticket_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.ticket_open = $scope.ticket_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.ticket_open = false;
					$timeout(function() {
						$scope.ticket_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeTickets = function() {
				$scope.ticket_open = false;
			};
			$scope.advEdit = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/tickets/ticket_view", $scope, $rootScope, $scope.ticketsEditPopup);
			};
			$scope.delTicket = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/tickets/ticket_view", $scope, $rootScope, $scope.ticketsDelEfsrPopup);
			};
			$scope.efsrEdit = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/tickets/ticket_view", $scope, $rootScope, $scope.ticketsEditEfsrPopup);
				ajaxsingleViews(x, "services/tickets/emp_efsr_tickets", $scope, $rootScope,
				$scope.setEfsrTickets);
				
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.ticket_open){
					 $scope.ticket_open = false;
				}
			};
			$scope.tabtickets = function(t_id,t_ali,l_code,l_color,lvl,deposition,ts_download) {
				$rootScope.alias=t_ali;
				$scope.main_ticket_id=t_id;
				$scope.ticket_alias=$rootScope.sub_alias=t_ali;
				$scope.level_code=l_code;
				$scope.levelcolor=l_color;
				$scope.level=lvl;
				$scope.deposition_edit=deposition;
				$scope.ts_download=ts_download;
			};
			var ctrlAs = this;
			ctrlAs.scrlTabsApi = {};
			ctrlAs.scrollIntoView = function(arg) {if(ctrlAs.scrlTabsApi.scrollTabIntoView)ctrlAs.scrlTabsApi.scrollTabIntoView(arg);};
		}])
		.controller("ticketMappingPopUpCntl", ["$scope", "$rootScope", "$route", function($scope, $rootScope, $route) {
			$scope.efsrTicketId = '';
			$rootScope.sub_alias = '';
			$scope.noOfEsfr = 0;
			$scope.noOfTickets = 0;
			$scope.myModelCopy = angular.copy( $scope.singleViews );
			$scope.checkedEfsrMapping = [];
			$scope.existingEfsr = [];
			$scope.mappedEfsr = [];
			$scope.checkEfsrMapping = function(tktAlias, key) {
				var idx = $scope.checkedEfsrMapping.indexOf(tktAlias);
				console.log("IDX :: ", idx);
				if( idx == -1) {
					$scope.checkedEfsrMapping[key] = tktAlias;
				} else {
					$scope.checkedEfsrMapping[key] = null;
				}
			}
			$scope.mapEfsr = function() {
				var went = "#/tickets";
				var url = "services/tickets/map_efsr_tickets";
				var data = new FormData();
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				for(var i in $scope.mappedEfsr) {
					if($scope.mappedEfsr[i]['checked']) {
						data.append("changeEfsr["+ i +"][existing_efsr]", $scope.mappedEfsr[i]['actual_ticket_alias']);
						data.append("changeEfsr["+ i +"][mapped_efsr]", $scope.mappedEfsr[i]['mapped_ticket_alias']);
					}
				}
				var result = ajaxpost(data, url, went, $scope, $route, $rootScope);
			}
		}])
		.controller("ticketEditPopUpCntl", ["$scope", "$rootScope", "$route", function($scope, $rootScope, $route) {
			$scope.efsrTicketId = '';
			$rootScope.sub_alias = '';
			$scope.noOfEsfr = 0;
			$scope.noOfTickets = 0;
			$scope.myModelCopy = angular.copy( $scope.singleViews );
			$scope.checkedEfsrMapping = [];
			$scope.existingEfsr = [];
			$scope.mappedEfsr = [];
			$scope.ths_notified_emp = function() {
				drop_down("services/ths_notified_emp", 1, $scope, 'first');
			}
			$scope.assem_jar = function(ref){
				var as_jar=$('input[name="'+ref+'"]').val().split('-'); 
				$scope.pr=(as_jar!='' ? as_jar['1']+'-'+as_jar['0']+'-'+as_jar['2'] : Date.now());
			}
			$scope.ticketChecked = function(ticket_id, alias) {
				$scope.efsrTicketId = ticket_id;
				$rootScope.sub_alias = alias;
			}
			$scope.mainChanged = function() {
				$scope.efsrTicketId = "";
				$rootScope.sub_alias = "";
			}
			$scope.openEditEFSRPopUp = function() {
				$scope.ticketsEfsrEditOpen();
			}
			$scope.openEditTicketPopUp = function() {
				$scope.ticketsAdveditOpen();
			}
			$scope.checkEfsrMapping = function(tktAlias, key) {
				var idx = $scope.checkedEfsrMapping.indexOf(tktAlias);
				console.log("IDX :: ", idx);
				if( idx == -1) {
					$scope.checkedEfsrMapping[key] = tktAlias;
				} else {
					$scope.checkedEfsrMapping[key] = null;
				}
			}
			$scope.mapEfsr = function() {

				var went = "#/tickets";
				var url = "services/tickets/map_efsr_tickets";
				var data = new FormData();
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				data.append("existing_efsr", $scope.checkedEfsrMapping);
				data.append("mapped_efsr", $scope.mappedEfsr);
				var result = ajaxpost(data, url, went, $scope, $route, $rootScope);
			}
		}]).controller("ticketEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/tickets/ticket_edit_view", $scope,$rootScope);
			//ajaxsingleViews1($rootScope.alias, "services/requested_cells_drop", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
			$scope.ths_notified_emp = function() {
				drop_down("services/ths_notified_emp", 1, $scope, 'first');
			}
			$scope.assem_jar = function(ref){
				var as_jar=$('input[name="'+ref+'"]').val().split('-'); 
				$scope.pr=(as_jar!='' ? as_jar['1']+'-'+as_jar['0']+'-'+as_jar['2'] : Date.now());
			}
			
		}]).controller("ticketEditEfsrCntl", ["$scope", "$rootScope", "$timeout", "$filter", "all_apiRoute", "$modal", function($scope, $rootScope, $timeout, $filter, all_apiRoute, $modal) {
			$timeout(function(){
				$scope.forms = [
					{ name: 'Physical Observation', key: 'Physical_Observation', display : false },
					{ name: 'Generator Observation', key: 'Generator_Observation', display : false },
					{ name: 'History of Coach', key: 'History_of_Coach', display : false },
					{ name: 'Equipment Details', key: 'Equipment_Details', display : false },
					{ name: 'Check Points', key: 'Check_Points', display : false },
					{ name: 'Charger Details', key: 'Charger_Details', display : false },
					{ name: 'Forklift Details', key: 'Forklift_Details', display : false },
					{ name: 'Battery Details', key: 'Battery_Details', display : false },
					{ name: 'SMPS Observation', key: 'SMPS_Observation', display : false },
					//{ name: 'FCBC Observation', key: 'SMPS_Observation', display : false },
					//{ name: 'UPS Observation', key: 'SMPS_Observation', display : false },
					//{ name: 'Solar Panel Observation', key: 'SMPS_Observation', display : false },
					{ name: 'Battery Observation', key: 'Battery_Observation', display : false },
					{ name: 'Battery Observation', key: 'Motive_Battery_Observation', display : false },
					{ name: 'Service Engineer Observation', key: 'Service_Engineer_Observation', display : false },
					{ name: 'Customer Comments', key: 'Customer_Comments', display : false }
				];
				$scope.isArray = angular.isArray;
				ajaxsingleViews('1', "services/settings/tree_view", $scope,$rootScope);
				$rootScope.loading=true;
				all_apiRoute.getAll(base_url+'mobile_app_efsr_edit/' + $rootScope.sub_alias + '/efsr_edit').then(function (response) {
					$scope.efsrData = response.data;
					$scope.seobsLength = []; var seobsLength;
					$rootScope.ticket_id = $scope.efsrData.ticket_id;
					if($scope.efsrData.module !== undefined ){
						if($scope.efsrData.module['SEOBS'] !== undefined )seobsLength = (5 - $scope.efsrData.module['SEOBS'].length);
						else seobsLength = 5;
					}else seobsLength = 5;
					for(var i=0; i<seobsLength; i++)$scope.seobsLength.push(i);
					//if($scope.efsrData.install_date != "NA")$scope.efsrData.install_date = $filter("date")($scope.efsrData.install_date, 'YYYY-MM-DD');
					var segment_ref = $scope.efsrData.segment_ref;
					var forms_arr;
					if(segment_ref == "TL")forms_arr = ["Physical_Observation","Generator_Observation","SMPS_Observation","Battery_Observation","Service_Engineer_Observation","Customer_Comments"];
					else if(segment_ref == "TS")forms_arr = ["Physical_Observation","Generator_Observation","SMPS_Observation","Battery_Observation","Service_Engineer_Observation","Customer_Comments"];
					else if(segment_ref == "MP")forms_arr = ["Physical_Observation","Charger_Details","Forklift_Details","Battery_Details","Motive_Battery_Observation","Service_Engineer_Observation","Customer_Comments"];
					else if(segment_ref == "RL")forms_arr = ["History_of_Coach","Equipment_Details","Check_Points","Battery_Observation","Service_Engineer_Observation","Customer_Comments"];
					else if(segment_ref == "PC")forms_arr = ["Physical_Observation","Generator_Observation","SMPS_Observation","Battery_Observation","Service_Engineer_Observation","Customer_Comments"];
					else if(segment_ref == "SA")forms_arr = ["Physical_Observation","Generator_Observation","SMPS_Observation","Battery_Observation","Service_Engineer_Observation","Customer_Comments"];
					else if(segment_ref == "UP")forms_arr = ["Physical_Observation","Generator_Observation","SMPS_Observation","Battery_Observation","Service_Engineer_Observation","Customer_Comments"];
					else forms_arr = ["Battery_Observation","Service_Engineer_Observation","Customer_Comments"];
					angular.forEach($scope.forms, function(v, k){
					  if(forms_arr.indexOf(v.key) !== -1) v.display = true;
					});
					$scope.activeTab = forms_arr[0];
					$rootScope.loading=false;
				}, function(error){ $scope.efsrData = {}; console.log("Error: " + error); });
				$scope.bbRowColumnDelete = function(rowColData, bb_row_col_id, ref) {
					$rootScope.deleteData = {"ref" : "", "id" : bb_row_col_id, "ticket_id" : $rootScope.ticket_id, "rowColData" : rowColData };
					if(ref == "") toast_msg($rootScope,'danger','Somthing went wrong',3000);
					else{
						$rootScope.deleteData.ref = ref;
						modelpopup("includes/tickets/efsr_forms/efsr_delete.html","md",$modal,$scope);
					}
				}
			},0);
			$scope.activeTab = 'Physical_Observation';
			$scope.tabSelected = function(key) {
				$scope.activeTab = key;
			}
		}]).controller("efsrEditFormCntl", ["$scope", "$route", "$rootScope", "$modal", "all_apiRoute", function($scope, $route, $rootScope, $modal, all_apiRoute) {
				$scope.getTotalVoltage = function(className) {
					var total = 0, thisVal;
					$("."+className).each(function(){
						thisVal = $(this).val()
						if(thisVal == "")thisVal == 0;
						total += parseFloat(thisVal);
					});
					$("#"+className).val(total.toFixed(2));
				};
			
			$scope.sendPost = function(formCls) {
				modelpopup("includes/tickets/efsr_forms/efsr_update.html","md",$modal,$scope);
				$rootScope.updateData = {"remarks" : "", "ticket_id" : $rootScope.ticket_id, "formClass" : formCls };
			}
			$scope.updatePost = function(ticket_id,remarks,formCls) {
				$rootScope.loading=true;
				all_apiRoute.getAll(base_url_2+'services/tickets/efsr_services.php/update_remarks?ticket_id=' + ticket_id + '&remarks=' + remarks + '&ref=' + formCls + '&emp_alias='+readCookie('emp_alias')+'&token='+readCookie('token') + '&ip_addr' + readCookie('ip_addr')).then(function (response) {
					$rootScope.loading=false;
					var res = response.data;
					if(res.ErrorDetails.ErrorCode == '0'){
						var formClass = $("." + formCls);
						var went = formClass.attr('data-went');
						var url = formClass.attr('url');
						var data = new FormData(formClass[0]);
						data.append("emp_alias", readCookie('emp_alias'));
						data.append("token", readCookie('token'));
						data.append("ip_addr", readCookie('ip_addr'));
						var result = ajaxpost(data,url,went, $scope, $route, $rootScope);
					}else {$rootScope.loading=false; toast_msg($rootScope,'danger',res.ErrorDetails.ErrorMessage,3000);}
				}, function(error){ $rootScope.loading=false; console.log("Error: " + error); });
			}
		}]).controller("efsrDeleteFormCntl", ["$scope", "$rootScope", "$route", "$modal", function($scope, $rootScope, $route, $modal) {
			$scope.deleteData = angular.copy( $rootScope.deleteData );
			$scope.deleteDataSubmit = function() {
				var went = $(".forms_delete").attr('data-went');
				var url = $(".forms_delete").attr('url');
				var data = new FormData($('.forms_delete')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result = ajaxDelete(data, url, went, $scope, $route, $rootScope);
			}
		}]).controller("ticketDelPopUpCntl", ["$scope", "$rootScope", "$route", "$modal", function($scope, $rootScope, $route, $modal) {
			$scope.efsrTicketId = '';
			$scope.efsr_no = "";
			$rootScope.sub_alias = '';
			$scope.noOfEsfr = 0;
			$scope.noOfTickets = 0;
			$scope.myModelCopy = angular.copy( $scope.singleViews );
			$scope.checkedEfsrMapping = [];
			$scope.existingEfsr = [];
			$scope.mappedEfsr = [];
			$scope.ths_notified_emp = function() {
				drop_down("services/ths_notified_emp", 1, $scope, 'first');
			}
			$scope.assem_jar = function(ref){
				var as_jar=$('input[name="'+ref+'"]').val().split('-'); 
				$scope.pr=(as_jar!='' ? as_jar['1']+'-'+as_jar['0']+'-'+as_jar['2'] : Date.now());
			}
			$scope.ticketChecked = function(ticket_id, alias, efsr_no) {
				$scope.efsrTicketId = ticket_id;
				$rootScope.sub_alias = alias;
				$scope.efsr_no = efsr_no;
			}
			$scope.mainChanged = function() {
				$scope.efsrTicketId = "";
				$rootScope.sub_alias = "";
			}
			$scope.openDelEFSRPopUp = function() {
				deleteTicketEfsr($scope.efsrTicketId, $rootScope.sub_alias, $scope, $rootScope, $modal);
			}
			$scope.openDelTicketPopUp = function() {
				deleteTicket($scope.efsrTicketId, $rootScope.sub_alias, $scope.efsr_no, $scope, $rootScope, $modal);
			}
			$scope.checkEfsrMapping = function(tktAlias, key) {
				var idx = $scope.checkedEfsrMapping.indexOf(tktAlias);
				console.log("IDX :: ", idx);
				if( idx == -1) {
					$scope.checkedEfsrMapping[key] = tktAlias;
				} else {
					$scope.checkedEfsrMapping[key] = null;
				}
			}
			$scope.mapEfsr = function() {

				var went = "#/tickets";
				var url = "services/tickets/map_efsr_tickets";
				var data = new FormData();
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				data.append("existing_efsr", $scope.checkedEfsrMapping);
				data.append("mapped_efsr", $scope.mappedEfsr);
				var result = ajaxpost(data, url, went, $scope, $route, $rootScope);
			}
		}])
		.controller("replacedcellsCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews1($rootScope.alias, "services/requested_cells_drop", $scope,$rootScope);
		}]).controller("ticketAdvEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.sub_alias, "services/tickets/ticket_edit_view", $scope,$rootScope);
			depend_drop("services/general_emprole_drop_downs", "services/general_emprole_emplist_drop_downs", "", $scope);
			drop_down("services/state_emp_drop", "", $scope, "third");
			$scope.rmrk = function(x) { if(confirm('Are you sure?')){ ajaxsingleViews1(x+",ec_remarks,remark_alias", "services/del_remark_reqcell", $scope,$rootScope); $('.'+x).hide(); } }
			$scope.act_tkn = function(x) { if(confirm('Are you sure?')){ ajaxsingleViews1(x+",ec_ticket_action,item_alias", "services/del_remark_reqcell", $scope,$rootScope); $('.'+x).hide(); } }
			$scope.req_cel = function(x) { if(confirm('Are you sure?')){ ajaxsingleViews1(x+",ec_cell_required,item_alias", "services/del_remark_reqcell", $scope,$rootScope); $('.'+x).hide(); } }
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}]).controller("reqCellAccdropCntrl", ["$scope", "$rootScope", function($scope, $rootScope) {
			drop_down("services/req_cells_drop", $rootScope.alias, $scope, "second");
			drop_down("services/req_acc_drop", $rootScope.alias, $scope, "third");
		}])
		// Site Master Table
		.controller("SiteMasterCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.sitemaster = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/sitemaster/sitemaster_view", $scope,$rootScope);
				//$scope.siteMaster_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.siteMaster_open = $scope.siteMaster_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.siteMaster_open = false;
					$timeout(function() {
						$scope.siteMaster_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeSitemaster = function() {
				$scope.siteMaster_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.siteMaster_open){
					 $scope.siteMaster_open = false;
				}
			};
		}]).controller("siteMasterEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews1($rootScope.alias, "services/sitemaster/sitemaster_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// Employee Master Table
		.controller("EmployeeMasterCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.employeemaster = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/employeemaster/employeemaster_single_view", $scope,$rootScope);
				//$scope.employeeMaster_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.employeeMaster_open = $scope.employeeMaster_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.employeeMaster_open = false;
					$timeout(function() {
						$scope.employeeMaster_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeemployeeMaster = function() {
				$scope.employeeMaster_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.employeeMaster_open){
					 $scope.employeeMaster_open = false;
				}
			};
		}]).controller("employeeMasterEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/employeemaster/employeemaster_single_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
			$scope.workingstatus = function(){
				if( $('input[name="relieving_date"]').val() != ""){$scope.choose_resigned = true;}
			};
		}]).controller("deleteFormCntl", ["$scope", "$rootScope", "$route", function($scope, $rootScope, $route) {
			$scope.deleteData = angular.copy( $rootScope.deleteData );
			$scope.deleteDataSubmit = function() {
				var went = $(".forms_add").attr('data-went');
				var url = $(".forms_add").attr('url');
				var data = new FormData($('.forms_add')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result = ajaxDelete(data, url, went, $scope, $route, $rootScope);
			}
			$scope.restoreDataSubmit = function() {
				var went = $(".forms_add").attr('data-went');
				var url = $(".forms_add").attr('url');
				var data = new FormData($('.forms_add')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result = ajaxDelete(data, url, went, $scope, $route, $rootScope);
			}
		}])// Tree View
		.controller("treeController", ["$scope", "$rootScope", function($scope, $rootScope) {
			$(document).on("click",".editbutton", function(){
				$(this).siblings(".put").removeAttr("readonly");
				$(this).siblings(".put").addClass("activeput");
			});
			document.onclick = function(e) {
				if (!$(e.target).parents('ul.abn-tree').html()  || ($(e.target).parents('ul.abn-tree').html() && !$(e.target).parents("li").hasClass("active"))){
					var li_tar=$("ul.abn-tree li");
					var tex=li_tar.find('.put');
					tex.attr("readonly","readonly");
					 tex.removeClass("activeput");
				}
			};
			//var mob_update = new Array();
			$(document).on("click", ".editbtn", function(){
				var bkp = $(this).siblings(".bkp").val();
				if(bkp.indexOf("_")!==-1){var id = bkp.split("_");bkp=id[0];}
				$(this).siblings(".change").val(bkp);
				//if(mob_update.indexOf(bkp)!==-1)alert('Yes');else mob_update.push(bkp);
			});
			$(document).on("click", ".resetbut", function(){
				var tex=$(this).siblings(".put");
				tex.attr("readonly","readonly");
				tex.val($(this).siblings(".bkp").attr('data'));
				tex.removeClass("activeput");
			});
			$(document).on("click", ".disbut", function(e){
				var tex=$(this).siblings(".put");
				var but=$(this).siblings("button");
				var flagg=$(this).siblings(".bkp").val();
				var arr = flagg.split("_");
				if(!$(this).hasClass('enbl')){
					arr[1]=1;
					tex.attr("readonly","readonly");
					tex.removeClass("activeput");
					$(this).siblings(".put, button").css("opacity","0.5");
					but.attr("disabled","disabled");
					$(this).addClass('enbl');
				}else {
					arr[1]=0;
					but.removeAttr("disabled");
					$(this).siblings(".put, button").css("opacity","1");
					$(this).removeClass('enbl');
				}$(this).siblings(".bkp").val(arr[0]+"_"+arr[1]+(arr.length>2 ? "_" : ""));
			});
			$scope.treeexport=function(){
				ajaxsingleViews('', "services/settings/tree_export", $scope,$rootScope);
			}
		}])
		.controller("manualCtrl", ["$scope", "$rootScope", function($scope,$rootScope){
			ajaxsingleViews('',"services/settings/manuals_view",$scope,$rootScope);
		}])
		.controller("manualEditCntl", ["$scope","$rootScope", function($scope,$rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/manuals_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		.controller("workguideCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews('', "services/settings/workguide_export", $scope,$rootScope);
			$scope.work_print=function(alias){
				window.location="services/settings/workguide_print.php?alias="+alias;
			}
			$scope.work_download=function(alias){
				window.open("services/settings/workguide_download.php?alias="+alias,'_blank');
			}
		}]).controller("workguideEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/workguide_view", $scope,$rootScope);//alert($rootScope.alias);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
			
		}])
		//change log Controller
		.controller("changelogCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews('', "services/settings/changelog_export", $scope,$rootScope);
			$scope.changelog_print=function(alias){window.location="services/settings/changelog_print.php?alias="+alias;}
			$scope.changelog_download=function(alias){window.open("services/settings/changelog_download.php?alias="+alias,'_blank');}
		}])
		.controller("changelogEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/changelog_view", $scope,$rootScope);
			reset_click($scope);
		}])
		//Privacy & policy and help
		.controller("privacyController", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews('', "services/settings/privacy_policy_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// Zones Table
		.controller("zoneController", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.zonesview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/zone_view", $scope,$rootScope);
				//$scope.zone_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.zone_open = $scope.zone_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.zone_open = false;
					$timeout(function() {
						$scope.zone_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removezonesView = function() {
				$scope.zone_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.zone_open){
					 $scope.zone_open = false;
				}
			};
			$scope.zoneexport=function(){
				ajaxsingleViews('', "services/settings/zone_export", $scope,$rootScope);
			}
		}]).controller("zoneEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/zone_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// State Table
		.controller("stateCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.stateview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/state_view", $scope,$rootScope);
				//$scope.state_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.state_open = $scope.state_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.state_open = false;
					$timeout(function() {
						$scope.state_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removestateView = function() {
				$scope.state_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.state_open){
					 $scope.state_open = false;
				}
			};
		}]).controller("stateEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/state_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// District Table
		.controller("DistrictCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.districtview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/district_view", $scope,$rootScope);
				//$scope.district_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.district_open = $scope.district_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.district_open = false;
					$timeout(function() {
						$scope.district_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removedistrictView = function() {
				$scope.district_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.district_open){
					 $scope.district_open = false;
				}
			};
		}]).controller("districtEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/district_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// Designation Table
		.controller("DesignationCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.designationview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/designation_view", $scope,$rootScope);
				//$scope.designation_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.designation_open = $scope.designation_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.designation_open = false;
					$timeout(function() {
						$scope.designation_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removedesignationView = function() {
				$scope.designation_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.designation_open){
					 $scope.designation_open = false;
				}
			};
			$scope.designationexport=function(){
				ajaxsingleViews('', "services/settings/designation_export", $scope,$rootScope);
			}
		}]).controller("designationEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/designation_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		//THS Table
		.controller("shiftCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.shiftview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/shift_view", $scope,$rootScope);
				//$scope.designation_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.shift_open = $scope.shift_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.shift_open = false;
					$timeout(function() {
						$scope.shift_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeshiftView = function() {
				$scope.shift_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.shift_open){
					 $scope.shift_open = false;
				}
			};
			$scope.shiftexport=function(){
				ajaxsingleViews('', "services/settings/shift_export", $scope,$rootScope);
			}
		}]).controller("shiftEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/shift_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		//THS Table
		.controller("mocCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.mocview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/moc_view", $scope,$rootScope);
				//$scope.designation_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.moc_open = $scope.moc_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.moc_open = false;
					$timeout(function() {
						$scope.moc_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removemocView = function() {
				$scope.moc_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.moc_open){
					 $scope.moc_open = false;
				}
			};
			$scope.mocexport=function(){
				ajaxsingleViews('', "services/settings/moc_export", $scope,$rootScope);
			}
		}]).controller("mocEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/moc_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		
		.controller("dynamiclevelCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.dynamiclevelview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/dynamic_level_view", $scope,$rootScope);
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.dynamiclevel_open = $scope.dynamiclevel_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.dynamiclevel_open = false;
					$timeout(function() {
						$scope.dynamiclevel_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removedynamiclevelView = function() {
				$scope.dynamiclevel_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.dynamiclevel_open){
					 $scope.dynamiclevel_open = false;
				}
			};
			$scope.dynamiclevelexport=function(){
				ajaxsingleViews('', "services/settings/dynamic_level_export", $scope,$rootScope);
			}
			depend_drop("services/dynamiclevel_privilage_order_drop?x=view", "", "", $scope);
		}]).controller("dynamiclevelEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/dynamic_level_view", $scope,$rootScope);
			depend_drop("services/dynamiclevel_privilage_order_drop?x=edit", "", "", $scope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}]).controller("dynamiclevelprivilagesorderdropCntrl", ["$scope", function($scope) {
			depend_drop("services/dynamiclevel_privilage_order_drop?x=add", "", "", $scope);
		}])

		.controller("emailAndSmsRecipientCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.email_sms_recipientview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/email_sms_recipient_view", $scope,$rootScope);
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.email_sms_recipient_open = $scope.email_sms_recipient_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.email_sms_recipient_open = false;
					$timeout(function() {
						$scope.email_sms_recipient_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeEmailSmsRecipientView = function() {
				$scope.email_sms_recipient_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.email_sms_recipient_open){
					 $scope.email_sms_recipient_open = false;
				}
			};
			$scope.listSorting = function(e) {
				var url = $(".forms_ec").attr('url');
				var data = $(".forms_ec").serializeArray();
				data.push({
					name: 'emp_alias',
					value: readCookie('emp_alias')
				}, {
					name: 'token',
					value: readCookie('token')
				}, {
					name: 'ip_addr',
					value: readCookie('ip_addr')
				});
				var data = serializeToJson(data);
				var result = ajaxViews(data, url, $scope,$rootScope);
			}
			$scope.email_sms_export=function(){
				ajaxsingleViews('', "services/settings/email_sms_recipient_export", $scope,$rootScope);
			}
		}])
		.controller("emailAndSmsRecipientEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/email_sms_recipient_view", $scope,$rootScope);
			depend_drop("services/settings/privileges_mul_view?perpagecount=100", "", "", $scope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		
		// Remarks Bucketing Table
		.controller("bucketCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			/*var lastUsed = null;
			$scope.bucketview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/bucket_view", $scope,$rootScope);
				//$scope.bucket_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.bucket_open = $scope.bucket_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.bucket_open = false;
					$timeout(function() {
						$scope.bucket_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removebucketView = function() {
				$scope.bucket_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.bucket_open){
					 $scope.bucket_open = false;
				}
			};*/
			$scope.bucketexport=function() {
				ajaxsingleViews('', "services/settings/bucket_export",$scope,$rootScope);
			}
		}]).controller("bucketEditCntl", ["$scope","$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/bucket_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// Employeerole Table
		.controller("EmployeeroleCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.employeeroleview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/employee_role_view", $scope,$rootScope);
				//$scope.employeerole_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.employeerole_open = $scope.employeerole_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.employeerole_open = false;
					$timeout(function() {
						$scope.employeerole_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeemployeeroleView = function() {
				$scope.employeerole_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.employeerole_open){
					 $scope.employeerole_open = false;
				}
			};
			$scope.emproleexport=function(){
				ajaxsingleViews('', "services/settings/employee_role_export", $scope,$rootScope);
			}
		}]).controller("employeeroleEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/employee_role_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// Privilages Table
		.controller("PrivilagesCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.privilagesview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/privileges_view", $scope,$rootScope);
				//$scope.employeerole_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.privilagesView = $scope.privilagesView ? false : true;
					event.stopPropagation();
				} else {
					$scope.privilagesView = false;
					$timeout(function() {
						$scope.privilagesView = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeprivilagesView = function() {
				$scope.privilagesView = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.privilagesView){
					 $scope.privilagesView = false;
				}
			};
			$scope.privilegesexport=function(){
				ajaxsingleViews('', "services/settings/privileges_export", $scope,$rootScope);
			}
		}]).controller("privilagesEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/privileges_view", $scope,$rootScope);
			$scope.privilege_model = [];
			$scope.myModelCopy = angular.copy( $scope.singleViews );
			$scope.check_All=function(mod,sing){
				angular.forEach(sing, function(v,k) {
					$scope.privilege_model[k] = [];
					angular.forEach(v, function(j,i) {
						if(k!='name' && k!='alias') {
							$scope.privilege_model[k][i]=true;
						}
					})
				})
			}
			$scope.privilege_value_click=function(mod){$scope.checkAll=mod;}
		}])
		.controller("privilagesAddCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			$scope.privilege_model = [];
			$scope.myModelCopy = angular.copy( $scope.singleViews );
			$scope.check_All=function() {
				for(var k in $scope.privilege_model) {
					for(var i in $scope.privilege_model[k]) {
						$scope.privilege_model[k][i]=true;
					}
				}
			}
			$scope.privilege_value_click=function(mod){$scope.checkAll=mod;}
		}])
		
		.controller("PrivilegesCheckCntrl", ["$scope","$rootScope", function($scope,$rootScope) {
			ajaxsingleViews1($rootScope.alias, "services/settings/privileges_init", $scope,$rootScope);
		}])
		// Warehousecode Table
		.controller("WarehousecodeCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.warehousecodeview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/warehouse_view", $scope,$rootScope);
				//$scope.warehousecode_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.warehousecode_open = $scope.warehousecode_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.warehousecode_open = false;
					$timeout(function() {
						$scope.warehousecode_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removewarehouseView = function() {
				$scope.warehousecode_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.warehousecode_open){
					 $scope.warehousecode_open = false;
				}
			};
		}]).controller("warehouseEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/warehouse_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// Stockcode Table
		.controller("StockcodeCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.stockcodeview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/stockcode_view", $scope,$rootScope);
				//$scope.stockcode_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.stockcode_open = $scope.stockcode_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.stockcode_open = false;
					$timeout(function() {
						$scope.stockcode_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removestockcodeView = function() {
				$scope.stockcode_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.stockcode_open){
					 $scope.stockcode_open = false;
				}
			};
			$scope.stockcodeexport=function(){
				ajaxsingleViews('', "services/settings/stockcode_export", $scope,$rootScope);
			}
		}]).controller("stockcodeEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/stockcode_view", $scope,$rootScope);
		}])
		// Segment Table
		.controller("SegmentCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.segmentview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/segment_view", $scope,$rootScope);
				//$scope.segment_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.segment_open = $scope.segment_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.segment_open = false;
					$timeout(function() {
						$scope.segment_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removesegmentView = function() {
				$scope.segment_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.segment_open){
					 $scope.segment_open = false;
				}
			};
			$scope.segmentexport=function(){
				ajaxsingleViews('', "services/settings/segment_export", $scope,$rootScope);}
		}]).controller("segmentEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/segment_view", $scope,$rootScope);
		}])
		// Department Table
		.controller("DepartmentCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.departmentview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/department_view", $scope,$rootScope);
				//$scope.department_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.department_open = $scope.department_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.department_open = false;
					$timeout(function() {
						$scope.department_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removedepartmentView = function() {
				$scope.department_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.department_open){
					 $scope.department_open = false;
				}
			};
			$scope.departmentexports=function(){
				ajaxsingleViews('', "services/settings/department_export", $scope,$rootScope);
			}
		}]).controller("departmentEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/department_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// Customer Table
		.controller("CustomerCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.customerview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/customer_view", $scope,$rootScope);
				//$scope.customer_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.customer_open = $scope.customer_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.customer_open = false;
					$timeout(function() {
						$scope.customer_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removecustomerView = function() {
				$scope.customer_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.customer_open){
					 $scope.customer_open = false;
				}
			};
		}]).controller("customerEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/customer_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}]).controller("customerAddCntl", ["$scope", function($scope) {
			/*$scope.resetForm = function (customerForm) {
				$scope.customerForm.$setPristine();
				alert('after');
			}*/
			$scope.reset = function(master) {
				var master = { customername: '' }; 
				$scope.temp = angular.copy(master);
				$scope.customerForm.$setPristine();
				alert(master);
			}  
		}])
		// Product Table
		.controller("ProductCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.productview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/product_view", $scope,$rootScope);
				//$scope.product_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.product_open = $scope.product_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.product_open = false;
					$timeout(function() {
						$scope.product_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeproductView = function() {
				$scope.product_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.product_open){
					 $scope.product_open = false;
				}
			};
			$scope.productexport = function() {
				ajaxsingleViews('', "services/settings/product_export", $scope,$rootScope);
			};
		}]).controller("productEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/product_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// Ticketcomplaint Table
		.controller("TicketcomplaintCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.ticketcomplaintview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/ticketcomplaint_view", $scope,$rootScope);
				//$scope.ticketcomplaint_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.ticketcomplaint_open = $scope.ticketcomplaint_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.ticketcomplaint_open = false;
					$timeout(function() {
						$scope.ticketcomplaint_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removepticketcomplaintView = function() {
				$scope.ticketcomplaint_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.ticketcomplaint_open){
					 $scope.ticketcomplaint_open = false;
				}
			};
			$scope.tktcomplaintexport=function(){
				ajaxsingleViews('', "services/settings/ticket_complaint_export", $scope,$rootScope);}
		}]).controller("ticketcomplaintEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/ticketcomplaint_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// Faultycode Table
		.controller("FaultycodeCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.faultycodeview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/faultycode_view", $scope,$rootScope);
				//$scope.faultycode_open = true; 
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.faultycode_open = $scope.faultycode_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.faultycode_open = false;
					$timeout(function() {
						$scope.faultycode_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removepfaultycodeView = function() {
				$scope.faultycode_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.faultycode_open){
					 $scope.faultycode_open = false;
				}
			};
			$scope.faultyexport=function(){
				ajaxsingleViews('', "services/settings/faulty_code_export", $scope,$rootScope);}
		}]).controller("faultycodeEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/faultycode_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// Ticketactivity Table
		.controller("TicketactivityCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.ticketactivityview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/ticketactivity_view", $scope,$rootScope);
				//$scope.ticketactivity_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.ticketactivity_open = $scope.ticketactivity_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.ticketactivity_open = false;
					$timeout(function() {
						$scope.ticketactivity_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removepticketactivityView = function() {
				$scope.ticketactivity_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.ticketactivity_open){
					 $scope.ticketactivity_open = false;
				}
			};
			$scope.tktactivityexport=function(){
				ajaxsingleViews('', "services/settings/ticket_activity_export", $scope,$rootScope);
			}
		}]).controller("ticketactivityEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/ticketactivity_view", $scope,$rootScope);
		}])
//Usertracking Table
		.controller("userTrackingCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.usertrackingview = function(x) {
				$rootScope.alias=x;
				ajaxsingleViews(x,"services/usertracking/usertracking_single_view",$scope,$rootScope);
				var prevClicked = lastUsed;
				if (prevClicked == x){$scope.usertracking_open = $scope.usertracking_open ? false : true;
				event.stopPropagation();}
				else {
					$scope.usertracking_open = false;
					$timeout(function(){ $scope.usertracking_open = true; }, 300);
				}
				lastUsed = x;
				ajaxViews1(x,"services/usertracking/usertracking_history",$scope,$rootScope);
			};
			$scope.usertrackingexport=function(alias){
				//ajaxsingleViews1(alias, "services/usertracking/user_tracking_export", $scope,$rootScope);
				$rootScope.loading=true;
				$timeout(function(){
					if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('ip_addr') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0' && readCookie('ip_addr') != '0') {
						$.ajax({
							type: 'POST',
							url: base_url_2 + "services/usertracking/user_tracking_export",
							data: "emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token') + "&ip_addr=" + readCookie('ip_addr') + "&alias=" + alias,
							cache: false,
							async: false,
							error: function(result) {$rootScope.loading=false;toast_msg($rootScope,'danger','Request failed, Contact Admin',5000);console.log(result);},
							beforeSend:function(result){$rootScope.loading=true;},
							success: function(result) { $rootScope.loading=false;
								sing = JSON.parse(result);console.log(result);
								//$scope.singleViews1 = sing;
								if(sing.ErrorDetails.ErrorCode=='0')window.location=base_url_2+"exports/"+sing.file_name+".xlsx";
								else toast_msg($rootScope,'danger',sing.ErrorDetails.ErrorMessage,3000);
							}
						});
					}
				},100);
			}
			$scope.historySorting = function(alias){
				var pagno=$('select[name="page_no"] option:selected').text().substring(1);
				var limit=$('select[name="perpagecount"] option:selected').text().substring(2);
				if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('ip_addr') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0' && readCookie('ip_addr') != '0') {
					$.ajax({
						type: 'POST',
						url: base_url_2 + "services/usertracking/usertracking_history",
						data: "emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token') + "&ip_addr=" + readCookie('ip_addr') + "&alias=" + alias + "&page_no=" + pagno + "&perpagecount=" + limit,
						cache: false,
						async: false,
						error: function(result) {/* alert('error occured'); */},
						beforeSend:function(result){$rootScope.loading=true;},
						success: function(result) {$rootScope.loading=false;
							$scope.datasingle = JSON.parse(result);
						}
					});
				}
			};
			$scope.removeusertrackingView = function() {$scope.usertracking_open = false;};	
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.usertracking_open && !$(event.target).prop("tagName")=='IMG'){
					 $scope.usertracking_open = false;
				}
			};
			$scope.usermapPlots = function(x){
//				ajaxViews1(x,"services/usertracking/usertracking_single_view_map",$scope,$rootScope);
				if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('ip_addr') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0' && readCookie('ip_addr') != '0') {
					var datemapsort=$('input:text[name="mapdatesort"]').val();
					$.ajax({
						type: 'POST',
						url: base_url_2+"services/usertracking/usertracking_single_view_map",
						data: "emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token') + "&ip_addr=" + readCookie('ip_addr') + "&datemap="+datemapsort+"&alias=" + x,
						cache: false,
						async: false,
						error: function(result) { /* alert('error occured'); */	},
						beforeSend:function(result){$rootScope.loading=true;},
						success: function(result) {$rootScope.loading=false;
							$timeout(function(){
								var geocoder = new google.maps.Geocoder;
								var infowindow = new google.maps.InfoWindow;
								var J_res = JSON.parse(result);
								var cities = (J_res!=null ? J_res : []);
								var mapOptions = {
									zoom: 5,
									center: new google.maps.LatLng(23.549359, 77.725512),
									mapTypeId: google.maps.MapTypeId.TERRAIN
								}
								$scope.map = new google.maps.Map(document.getElementById('map'), mapOptions);
								$scope.markers = [];
								var createMarker = function (info,id){
									var marker = new google.maps.Marker({
										map: $scope.map,
										position: new google.maps.LatLng(info.lat, info.long),
										title: info.datetime
									});
									google.maps.event.addListener(marker, 'click', function(){
										infowindow.id=id;
										geocodeLatLng(id,geocoder, $scope.map, infowindow,info.lat, info.long, info.datetime,info.type);
									});
									$scope.markers.push(marker);
								} 
								var i=0,resu;
								for (i = 0; i < cities.length; i++){createMarker(cities[i],i);}
								$scope.openInfoWindow = function(e, selectedMarker){
									e.preventDefault();
									google.maps.event.trigger(selectedMarker, 'click');
								}
								google.maps.event.addListener(infowindow, 'closeclick', function() {
									createMarker(cities[infowindow.id],infowindow.id);
								});
								function geocodeLatLng(id,geocoder, map, infowindow,lnn,lgg,dtime,type) {
								  var latlng = {lat: parseFloat(lnn), lng: parseFloat(lgg)};
								  geocoder.geocode({'location': latlng}, function(results, status) {
									if (status === google.maps.GeocoderStatus.OK) {
									  if (results[1])resu=results[1].formatted_address;
									  else resu=" lat: "+ parseFloat(lnn)+", lng: "+parseFloat(lgg);
									}else resu=" lat: "+ parseFloat(lnn)+", lng: "+parseFloat(lgg);									
									var marker = new google.maps.Marker({
									  position: latlng,
									  map: map
									});
									infowindow.setContent(parseInt(id+1)+") "+dtime+" "+type+"<hr>"+resu);
									infowindow.open(map, marker);			
								  });
								}
							},0);
						}
					});
				}
			};
		}])
		
		/*.controller("usertrackingexportCtrl", ["$scope","$rootScope", function($scope, $rootScope) {
			$scope.usertrackingexport=function(alias){
				ajaxsingleViews1(alias, "services/usertracking/user_tracking_export", $scope,$rootScope);
			}
		}])*/
		// Levels Table
		.controller("LevelsCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.levelsview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/levels_view", $scope,$rootScope);
				//$scope.levels_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.levels_open = $scope.levels_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.levels_open = false;
					$timeout(function() {
						$scope.levels_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removelevelsView = function() {
				$scope.levels_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.levels_open){
					 $scope.levels_open = false;
				}
			};
			$scope.levelexport=function(){
				ajaxsingleViews('', "services/settings/level_export", $scope,$rootScope);
			}
		}]).controller("levelsEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/levels_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// SiteType Table
		.controller("SitetypeCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.sitetypeview = function(x) { 
				$rootScope.alias=x;
				ajaxsingleViews(x,"services/settings/sitetype_view",$scope,$rootScope);
				//$scope.assets_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x){$scope.sitetype_open = $scope.sitetype_open ? false : true;
				event.stopPropagation();}
				else {
					$scope.sitetype_open = false;
					$timeout(function(){ $scope.sitetype_open = true; }, 300);
				}
				lastUsed = x; 
			};
			$scope.removesitetypeView = function() {$scope.sitetype_open = false;};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.sitetype_open){
					 $scope.sitetype_open = false;
				}
			};
			$scope.sitetypeexport=function(){
				ajaxsingleViews('', "services/settings/sitetype_export", $scope,$rootScope);
			}
		}])
		.controller("sitetypeEditCntl", ["$scope", "$rootScope",  function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias,"services/settings/sitetype_view",$scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// SiteType Table
		.controller("SitestatusCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.sitestatusview = function(x) { 
				$rootScope.alias=x;
				ajaxsingleViews(x,"services/settings/sitestatus_view",$scope,$rootScope);
				//$scope.assets_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x){$scope.sitestatus_open = $scope.sitestatus_open ? false : true;}
				else {
					$scope.sitestatus_open = false;
					$timeout(function(){ $scope.sitestatus_open = true; }, 300);
				}
				lastUsed = x; 
			};
			$scope.removesitestatusView = function() {$scope.sitestatus_open = false;};
		}])
		.controller("sitestatusEditCntl", ["$scope", "$rootScope",  function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias,"services/settings/sitestatus_view",$scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// Accessories Table
		.controller("AccessoriesCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.accessoriesview = function(x) { 
				$rootScope.alias=x;
				ajaxsingleViews(x,"services/settings/accessories_view",$scope,$rootScope);
				//$scope.assets_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x){$scope.accessories_open = $scope.accessories_open ? false : true;
				event.stopPropagation();}
				else {
					$scope.accessories_open = false;
					$timeout(function(){ $scope.accessories_open = true; }, 300);
				}
				lastUsed = x; 
			};
			$scope.removeaccessoriesView = function() {$scope.accessories_open = false;};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.accessories_open){
					 $scope.accessories_open = false;
				}
			};
			$scope.accessexport=function(){
				ajaxsingleViews('', "services/settings/accessories_export", $scope,$rootScope);
			}
		}])
		.controller("accessoriesEditCntl", ["$scope", "$rootScope",  function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias,"services/settings/accessories_view",$scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// Milestone Table
		.controller("MilestoneCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.milestoneview = function(x) { 
				$rootScope.alias=x;
				ajaxsingleViews(x,"services/settings/milestone_view",$scope,$rootScope);
				//$scope.assets_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x){$scope.milestone_open = $scope.milestone_open ? false : true;
				event.stopPropagation();}
				else {
					$scope.milestone_open = false;
					$timeout(function(){ $scope.milestone_open = true; }, 300);
				}
				lastUsed = x; 
			};
			$scope.removemilestoneView = function() {$scope.milestone_open = false;};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.milestone_open){
					 $scope.milestone_open = false;
				}
			};
			$scope.milestoneexport=function(){
				ajaxsingleViews('', "services/settings/milestone_export", $scope,$rootScope);
			}
		}])
		.controller("milestoneEditCntl", ["$scope", "$rootScope",  function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias,"services/settings/milestone_view",$scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// Assets Table
		.controller("AssetsCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.assetsview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/assets_view", $scope,$rootScope);
				//$scope.assets_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.assets_open = $scope.assets_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.assets_open = false;
					$timeout(function() {
						$scope.assets_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeassetsView = function() {
				$scope.assets_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.assets_open){
					 $scope.assets_open = false;
				}
			};
			$scope.assetexport=function(){
				ajaxsingleViews('', "services/settings/assets_export", $scope,$rootScope);
			}
		}]).controller("assetsEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/assets_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// Settings Count
		.controller("settingscountCtrl", ["$scope","$rootScope", function($scope,$rootScope) {
			ajaxsingleViews("","services/settings_count", $scope,$rootScope);
		}])
		.controller("contractPriceCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.contractprice = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/expense/expense_single_view", $scope,$rootScope);
				//$scope.siteMaster_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.contractprice_open = $scope.contractprice_open ? false : true;
				} else {
					$scope.contractprice_open = false;
					$timeout(function() {
						$scope.contractprice_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeContractprice = function() {
				$scope.contractprice_open = false;
			};
		}]).controller("contractpriceEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/expense/expense_single_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		.controller("escaCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.escaview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/esca_view", $scope,$rootScope);
				//$scope.siteMaster_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.esca_open = $scope.esca_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.esca_open = false;
					$timeout(function() {
						$scope.esca_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeescaView = function() {
				$scope.esca_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.esca_open){
					 $scope.esca_open = false;
				}
			};
			$scope.escaexport=function(){
				ajaxsingleViews('', "services/settings/esca_export", $scope,$rootScope);
			}
		}]).controller("escaEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/esca_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// By Jagan
		// MATERIAL BALANCE Table
		.controller("MaterialbalanceCtrl", ["$scope", "$route", "$rootScope","$timeout", function($scope,$route,$rootScope,$timeout){
			//var lastUsed=null;
			$scope.archive=function(){
				if(confirm("Are you sure want to Submit ?")){
					var data1='emp_alias='+readCookie('emp_alias')+'&token='+readCookie('token')+'&ip_addr='+readCookie('ip_addr');
					ajaxpost_finance(data1, "services/inventory/finance_archive", "#/Materialbalance", $route, $rootScope);
				}
			}
			$scope.financ_exp_fun=function(finance){
				$scope.financ_exp=!finance;
				$timeout(function(){
					angular.element('#parent').scope().listSorting();
				   $('.tktid').click(function(){
					  var thw=($(this).parent('th').width());
					   $('.droptxt1').filter(function(){
							if($(this).val()==''){
							   $(this).width($(this).parent('th').width());
							   $(this).addClass('hidden');
							   $(this).siblings('.inptClose').addClass('hidden');
							   $(this).siblings('.tktid').removeClass('hidden');
							}
					   });
					   $(this).siblings('.droptxt1, .inptClose').removeClass('hidden');
					   $(this).siblings('.droptxt1').focus();
					   $(this).addClass('hidden');
				   });
					$('.droptxt1').click(function(){
					   $('.droptxt1').not(this).filter(function(){
							if($(this).val()==''){
							   $(this).width($(this).parent('th').width());
							   $(this).addClass('hidden');
							   $(this).siblings('.inptClose').addClass('hidden');
							   $(this).siblings('.tktid').removeClass('hidden');
							}
					   });
				   });
				   $('.inptClose').click(function(){
					   $(this).siblings('.droptxt1').val('');
					   $(this).addClass('hidden');
					   $(this).siblings('.tktid').removeClass('hidden');
					   $(this).siblings('.droptxt1').addClass('hidden');
				   });
				   $(document).click(function(e){
						if (!$(e.target).hasClass("tktid") && $(".tktid").hasClass("hidden") && !$(e.target).hasClass("droptxt1")){
							$('.droptxt1').filter(function(){
								if($(this).val()==''){
									$(this).siblings(".tktid").removeClass('hidden');
									$(this).addClass('hidden');
									$(this).siblings(".inptClose").addClass('hidden');
								}
							});
						}
					});
				}, 0);
			}
		}])
		// INWARD BALANCE Table
		.controller("inwardbalanceCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout,$rootScope){var lastUsed=null;}])
		// OUTWARD BALANCE Table
		.controller("outwardbalanceCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout,$rootScope){var lastUsed=null;}])
		// MATERIAL Inward Table
		.controller("MaterialinwardCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout,$rootScope){
			var lastUsed=null;
			$scope.materialinwardsingleview=function(x){
				$rootScope.alias=x;
				ajaxsingleViews(x,"services/inventory/material_inward_single_view", $scope,$rootScope);
				var prevClicked=lastUsed;
				if(prevClicked == x){$scope.mInward_open = $scope.mInward_open ? false : true; event.stopPropagation();}
				else{$scope.mInward_open = false;$timeout(function(){$scope.mInward_open = true;},300);}
				lastUsed=x;
			};
			$scope.removeMinward=function(){$scope.mInward_open=false;};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.mInward_open){
					 $scope.mInward_open = false;
				}
			};
			$scope.materialinwardexport=function(){
				ajaxsingleViews('', "services/inventory/material_inward_export", $scope,$rootScope);
			}
		}])
		.controller("matrialinwardEdit", ["$scope", "$filter", "$rootScope", function($scope, $filter, $rootScope) {
			drop_down("services/state_emp_drop", "", $scope, "third");
			ajaxsingleViews($rootScope.alias, "services/inventory/material_inward_single_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		.controller("matrialoutwardEdit", ["$scope", "$filter", "$rootScope", function($scope, $filter, $rootScope) {
			$scope.editTicket = false;
			$scope.empAlias = readCookie('emp_alias');
			$scope.changeEditTicket = function(from_wh) {
				$scope.editTicket = !$scope.editTicket;
				depend_drop("services/inventory/ticketsList_mo?x="+$scope.empAlias+"&from_wh="+from_wh,"services/inventory/buffersjolist_scrp_full?x="+$scope.empAlias+"&in_out=out&from_wh="+from_wh,"",$scope);
			};
			drop_down("services/state_emp_drop", "", $scope, "third");
			ajaxsingleViews($rootScope.alias, "services/inventory/material_outward_single_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
			$scope.deleteItemFromMaterialOutward = function(materialOutwardAlias, itemAlias, itemType) {
				deleteItemFromMaterialOutward($rootScope, $scope, materialOutwardAlias, itemAlias, itemType)
			};
		}])
		// MATERIAL Outward Table
		.controller("MaterialoutwardCtrl", ["$scope", "$timeout","$rootScope", function($scope,$timeout,$rootScope){
			var lastUsed=null;
			$scope.materialoutwardsingleview=function(x){
				$rootScope.alias=x;
				ajaxsingleViews(x,"services/inventory/material_outward_single_view",$scope,$rootScope);
				var prevClicked=lastUsed;
				if(prevClicked == x){$scope.mInward_open = $scope.mInward_open ? false : true; event.stopPropagation();}
				else{$scope.mInward_open=false;$timeout(function(){$scope.mInward_open = true;},300);}
				lastUsed = x;
			};
			$scope.removeMinward=function(){$scope.mInward_open=false;};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.mInward_open){
					 $scope.mInward_open = false;
				}
			};
			$scope.materialoutwardexport=function(){
				ajaxsingleViews('', "services/inventory/material_outward_export", $scope,$rootScope);
			}
		}])
		// Revival Table
		//.controller("RevivalCtrl", ["$scope", "$timeout", function($scope, $timeout){}])
		// Refreshing Table
		//.controller("RefreshingCtrl", ["$scope", "$timeout", function($scope, $timeout){}])
		// MaterialRequest Table
		.controller("MaterialRequestCtrl", ["$scope", "$timeout","$rootScope", function($scope,$timeout,$rootScope){
			var lastUsed = null;
			$scope.materialRequestview=function(x){
				$rootScope.alias=x;
				ajaxsingleViews(x,"services/inventory/material_request_single_view",$scope,$rootScope);
				var prevClicked=lastUsed;
				if(prevClicked == x){$scope.mRequest_open = $scope.mRequest_open ? false : true; event.stopPropagation();}
				else{$scope.mRequest_open=false;$timeout(function(){$scope.mRequest_open=true;},300);}
				lastUsed=x;
			};
			$scope.removeMrequest=function(){$scope.mRequest_open=false;};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.mRequest_open){
					 $scope.mRequest_open = false;
				}
			};
			//$scope.materialrequestexport=function(){ ajaxsingleViews('', "services/inventory/material_request_export",$scope,$rootScope);}
		}])
		// Sjo Search
		.controller("sjoSearchCtrl", ["$scope", "$timeout", "$rootScope","all_apiRoute", function($scope,$timeout,$rootScope,all_apiRoute){
			var lastUsed = null;
			$scope.cellhistoryDetails=function(x){
				$rootScope.alias=x;
				ajaxsingleViews(x,"services/inventory/cellhistoryDetails",$scope,$rootScope);
				var prevClicked=lastUsed;
				if(prevClicked == x){$scope.mInward_open = $scope.mInward_open ? false : true; event.stopPropagation();}
				else{$scope.mInward_open=false;$timeout(function(){$scope.mInward_open=true;},300);}
				lastUsed=x;
			};
			$scope.removeMinward=function(){$scope.mInward_open=false;};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.mInward_open){
					 $scope.mInward_open = false;
				}
			};
			$scope.sjo_export = function(sjo_no){
				$timeout(function(){
					$rootScope.loading=true;
					all_apiRoute.getAll(base_url_2+'services/inventory/sjo_search_export?alias='+sjo_no+'&emp_alias='+readCookie('emp_alias')+'&token='+readCookie('token')).then(function (response) {
						location.href = base_url_2+"exports/"+response.data.file_name+".xlsx";
						$rootScope.loading=false;
					}, function(error){ console.log("Error: " + error); });
				},0);
			}
			//$scope.sjo_export=function(sjo_no){ajaxsingleViews(sjo_no, "services/inventory/sjo_search_export",$scope,$rootScope);}
		}])
		// Stocks(Item Code) Table
		.controller("itemsCtrl", ["$scope", "$timeout", "$rootScope", function($scope,$timeout,$rootScope){
			var lastUsed=null;
			$scope.itemview=function(x){
				$rootScope.alias=x;
				ajaxsingleViews(x,"services/inventory/item_code_view",$scope,$rootScope);
				var prevClicked=lastUsed;
				if(prevClicked == x){$scope.item_open=$scope.item_open ? false : true; event.stopPropagation();}
				else{$scope.item_open=false;$timeout(function(){$scope.item_open=true;},300);}
				lastUsed=x;
			};
			$scope.removeitemView=function(){$scope.item_open=false;};
			//$scope.itemsexport=function(){ajaxsingleViews('', "services/inventory/item_code_export",$scope,$rootScope);}
			//$scope.itemsexport=function(){ajaxsingleViews('', "services/inventory/stocks_export",$scope,$rootScope);}
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.item_open){
					 $scope.item_open = false;
				}
			};
			$scope.advUpdateStock = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/inventory/item_code_view", $scope, $rootScope, $scope.itemseditOpen);
			};
			$scope.delStock = function(deleteData) {
				$rootScope.deleteData = deleteData;
				$scope.itemsdelOpen();
			};
		}])
		// By Jagan
		//Naresh
		.controller("invenoryLevelsCtrl", ["$scope", function($scope){
			depend_drop("services/inventory/inventorylevels","","",$scope);
		}])
		.controller("totalCellDropCtrl", ["$scope","$rootScope", function($scope,$rootScope){
			drop_down("services/inventory/state_whcode_drop", readCookie('emp_alias'), $scope, 'first');
			$scope.secondDrop = [];
			
			$scope.upload_report = function(e,type){
				file_loading(e,$scope,$rootScope,type);
			}
			$scope.wh_revival = function(alias){
				drop_down("services/inventory/total_cell_revival", alias, $scope, 'second');
			}
			$scope.wh_refreshing = function(alias){
				drop_down("services/inventory/total_cell_refreshing", alias, $scope, 'second');
			}
		}])
		.controller("revivalCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.setAlias = function(x) {
				$rootScope.alias = x;
			}
			$scope.revival_view = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/inventory/material_revival_view", $scope,$rootScope);
				//$scope.ticket_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.revival_open = $scope.revival_open ? false : true;
					 event.stopPropagation();
				} else {
					$scope.revival_open = false;
					$timeout(function() {
						$scope.revival_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removerevival = function() {
				$scope.revival_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.revival_open){
					 $scope.revival_open = false;
				}
			};
		}]).controller("revivalEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/inventory/material_revival_view", $scope,$rootScope);
			$scope.upload_report = function(e,type){ file_loading(e,$scope,$rootScope,type);}
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}]).controller("refreshingCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.setAlias = function(x) {
				$rootScope.alias = x;
			}
			$scope.refreshing_view = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/inventory/material_refreshing_view", $scope,$rootScope);
				//$scope.ticket_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.refreshing_open = $scope.refreshing_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.refreshing_open = false;
					$timeout(function() {
						$scope.refreshing_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removerefreshing = function() {
				$scope.refreshing_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.refreshing_open){
					 $scope.refreshing_open = false;
				}
			};
		}]).controller("refreshingEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/inventory/material_refreshing_view", $scope,$rootScope);
			$scope.upload_report = function(e,type){ file_loading(e,$scope,$rootScope,type);}
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		//Naresh
		.controller("dprCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.dprview = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/settings/dpr_view", $scope,$rootScope);
				//$scope.zone_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.dpr_open = $scope.dpr_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.dpr_open = false;
					$timeout(function() {
						$scope.dpr_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removedprView = function() {
				$scope.dpr_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.dpr_open){
					 $scope.dpr_open = false;
				}
			};
			$scope.dprexport=function(){
				ajaxsingleViews('', "services/settings/dpr_export", $scope,$rootScope);
			}
		}]).controller("dprEditCntl", ["$scope", "$rootScope", function($scope,$rootScope) {
			ajaxsingleViews($rootScope.alias, "services/settings/dpr_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		//esca
		.controller("ticketescaCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.createing = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/esca/ticket_view", $scope,$rootScope);
				//$scope.ticket_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.ticket_open = $scope.ticket_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.ticket_open = false;
					$timeout(function() {
						$scope.ticket_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeTickets = function() {
				$scope.ticket_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.ticket_open){
					 $scope.ticket_open = false;
				}
			};
			$scope.tabtickets = function(t_id,t_ali,l_code,l_color,lvl) {
				$scope.main_ticket_id=t_id;
				$scope.ticket_alias=t_ali;
				$scope.level_code=l_code;
				$scope.levelcolor=l_color;
				$scope.level=lvl;
			};
			var ctrlAs = this;
			ctrlAs.scrlTabsApi = {};
			ctrlAs.scrollIntoView = function(arg) {if(ctrlAs.scrlTabsApi.scrollTabIntoView)ctrlAs.scrlTabsApi.scrollTabIntoView(arg);};
		}])
		.controller("EmployeeMasterEscaCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.employeemaster = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/esca/employeemaster_single_view", $scope,$rootScope);
				//$scope.employeeMaster_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.employeeMaster_open = $scope.employeeMaster_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.employeeMaster_open = false;
					$timeout(function() {
						$scope.employeeMaster_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeemployeeMaster = function() {
				$scope.employeeMaster_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.employeeMaster_open){
					 $scope.employeeMaster_open = false;
				}
			};
		}])
		//end esca
		//customer
		.controller("ticketcustomerCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.createing = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/customer/ticket_view", $scope,$rootScope);
				//$scope.ticket_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.ticket_open = $scope.ticket_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.ticket_open = false;
					$timeout(function() {
						$scope.ticket_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeTickets = function() {
				$scope.ticket_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.ticket_open){
					 $scope.ticket_open = false;
				}
			};
			$scope.tabtickets = function(t_id,t_ali,l_code,l_color,lvl) {
				$scope.main_ticket_id=t_id;
				$scope.ticket_alias=t_ali;
				$scope.level_code=l_code;
				$scope.levelcolor=l_color;
				$scope.level=lvl;
			};
			var ctrlAs = this;
			ctrlAs.scrlTabsApi = {};
			ctrlAs.scrollIntoView = function(arg) {if(ctrlAs.scrlTabsApi.scrollTabIntoView)ctrlAs.scrlTabsApi.scrollTabIntoView(arg);};
		}])
		.controller("SiteMasterCustCtrl", ["$scope", "$timeout", "$rootScope", function($scope, $timeout, $rootScope) {
			var lastUsed = null;
			$scope.sitemaster = function(x) {
				$rootScope.alias = x;
				ajaxsingleViews(x, "services/customer/sitemaster_view", $scope,$rootScope);
				//$scope.siteMaster_open = true;
				var prevClicked = lastUsed;
				if (prevClicked == x) {
					$scope.siteMaster_open = $scope.siteMaster_open ? false : true;
					event.stopPropagation();
				} else {
					$scope.siteMaster_open = false;
					$timeout(function() {
						$scope.siteMaster_open = true;
					}, 300);
				}
				lastUsed = x;
			};
			$scope.removeSitemaster = function() {
				$scope.siteMaster_open = false;
			};
			document.onclick = function(event) {
				if (!$(event.target).parents('#ticketviesw').html() && $scope.siteMaster_open){
					 $scope.siteMaster_open = false;
				}
			};
		}])
		//end customer
}());
!(function() {
	"use strict";
	angular.module("app.ui.ctrls", [])
		/// Modal Demo Ctrl
		.controller("ModalDemoCtrl", ["$scope", "$modal", "$mdDialog", "$rootScope", function($scope, $modal, $mdDialog, $rootScope) {

			$scope.checkAddOption = function(privilegeName, privilegeValue, option = null) {
				if(privilegeValue) {
					console.log("privilegeName :: ", privilegeName);
					switch(privilegeName) {
						case "designation":
							$scope.designationOpen()
							break;
						case "department":
							$scope.departmentaddOpen()
							break;
						case "zone":
							$scope.zoneOpen()
							break;
						case "work_guide":
							$scope.workguideaddOpen()
							break;
						case "warehouse":
							$scope.warehouseOpen()
							break;
						case "shift":
							$scope.shiftOpen()
							break;
						case "state":
							$scope.stateOpen()
							break;
						case "sitetype":
							$scope.siteTypeaddOpen()
							break;
						case "product":
							$scope.productOpen()
							break;
						case "accessories":
							$scope.accessoriesaddOpen()
							break;
						case "assets":
							$scope.assetaddOpen()
							break;
						case "changelog":
							$scope.changelogaddOpen()
							break;
						case "complaint":
							$scope.ticketcomplOpen()
							break;
						case "customer":
							$scope.customerOpen()
							break;
						case "district":
							$scope.districtOpen()
							break;
						case "dpr":
							$scope.dpraddopen()
							break;
						case "dynamic_level":
							$scope.dynamiclevelOpen(option)
							break;
						case "employeerole":
							$scope.employeeOpen()
							break;
						case "esca":
							$scope.escaaddOpen()
							break;
						case "faulty":
							$scope.faultcodeOpen()
							break;
						case "milestone":
							$scope.milestoneaddOpen()
							break;
						case "moc":
							$scope.mocOpen()
							break;
						case "privacy":
							$scope.privacyeditOpen()
							break;
						case "privileges":
							$scope.privilagesOpen()
							break;
						case "approvers":
							$scope.approversOpen()
							break;
						case "limits":
							$scope.limitsOpen()
							break;
						default:
							toast_msg($rootScope, "danger", "Invalid request please contact admin",3000);
					}
				} else {
					toast_msg($rootScope, "danger", "You don't have access", 3000);
				}
			}
			$scope.setSettingsAlias = function(x) {
				$rootScope.alias =x;
			}
			$scope.modalAnim = "modalRapid";
			$scope.accessoriesaddOpen = function() {modelpopup("includes/settings/accessories/accessories_add.php","md",$modal,$scope);}
			$scope.approversOpen = function() {modelpopup("includes/settings/approvers/approvers_add.php","md",$modal,$scope);}
			$scope.limitsOpen = function() {modelpopup("includes/settings/limits/limits_add.php","md",$modal,$scope);}
			$scope.allowancesOpen = function() {modelpopup("includes/settings/allowances/allowances.php","sm",$modal,$scope);}
			$scope.accessorieseditOpen = function() {modelpopup("includes/settings/accessories/accessories_edit.php","md",$modal,$scope);}
			$scope.milestoneaddOpen = function() {modelpopup("includes/settings/milestone/milestone_add.php","md",$modal,$scope);}
			$scope.milestoneeditOpen = function() {modelpopup("includes/settings/milestone/milestone_edit.php","md",$modal,$scope);}
			$scope.ticketOpen = function() {modelpopup("includes/tickets/tickets_add.php","lg",$modal,$scope);}
			$scope.ticketsExportOpen = function() {modelpopup("includes/tickets/tickets_export.php","lg",$modal,$scope);}
			$scope.deacteditOpen = function(x) {$rootScope.alias=x;modelpopup("includes/imeicontrol/imei_edit.php","md",$modal,$scope);}
			$scope.deactExportOpen = function() {modelpopup("includes/imeicontrol/imei_export.php","md",$modal,$scope);}
			$scope.shiftOpen = function() {modelpopup("includes/settings/shift/shift_add.php","md",$modal,$scope);}
			$scope.shifteditOpen = function() {modelpopup("includes/settings/shift/shift_edit.php","md",$modal,$scope);}
			$scope.mocOpen = function() {modelpopup("includes/settings/moc/moc_add.php","md",$modal,$scope);}
			$scope.moceditOpen = function() {modelpopup("includes/settings/moc/moc_edit.php","md",$modal,$scope);}
			$scope.dynamiclevelOpen = function(x) {
				if(x!='0')modelpopup("includes/settings/dynamiclevel/dynamic_level_add.php","md",$modal,$scope);
				else {
					var confirm = $mdDialog.confirm()
					.title('There is No Privilage to add as Dynamic Level')
					.content('Set Material Request Special True in Privilages to add another Privilage in Dynamic Level. Would you like to continue?')
					.ariaLabel('Lucky day')
					.ok('OK')
					.cancel('Cancel');
					//.targetEvent(ev);
					$mdDialog.show(confirm).then(function() {
						location.href=base_url+"#/settings/privilages/privilages_view";
						$scope.alert = 'OK';
					}, function() {
						$scope.alert = 'Not OK';
					});
				}
			}
			$scope.dynamicleveleditOpen = function() {modelpopup("includes/settings/dynamiclevel/dynamic_level_edit.php","md",$modal,$scope);}
			$scope.email_sms_recipientOpen = function() {
				modelpopup("includes/settings/email_sms_recipient/edit.html","md",$modal,$scope);
			}
			$scope.smsEmailDeleteOpen = function(data) { 
				$rootScope.deleteData = data; 
				modelpopup("includes/settings/email_sms_recipient/delete.html","md",$modal,$scope);
			}
			$scope.bucketeditOpen = function(x) { $rootScope.alias=x;modelpopup("includes/settings/buckets/bucket_edit.php","md",$modal,$scope);}
			$scope.zoneOpen = function() {modelpopup("includes/settings/zone/zone_add.php","md",$modal,$scope);}
			$scope.stateOpen = function() {modelpopup("includes/settings/state/state_add.php","md",$modal,$scope);}
			$scope.stateexportOpen = function() {modelpopup("includes/settings/state/state_export.php","md",$modal,$scope);}
			$scope.districtOpen = function() {modelpopup("includes/settings/district/district_add.php","md",$modal,$scope);}
			$scope.districtexportOpen = function() {modelpopup("includes/settings/district/district_export.php","md",$modal,$scope);}
			$scope.designationOpen = function() {modelpopup("includes/settings/designation/designation_add.php","md",$modal,$scope);}
			$scope.employeeOpen = function() {modelpopup("includes/settings/emprole/employeerole_add.php","md",$modal,$scope);}
			$scope.privilagesOpen = function() {modelpopup("includes/settings/privilages/privilages_add.php","lg",$modal,$scope);}
			$scope.warehouseOpen = function() {modelpopup("includes/settings/warehouse/warehousecode_add.php","md",$modal,$scope);}
			$scope.warehouseexportOpen = function() {modelpopup("includes/settings/warehouse/warehouse_export.php","md",$modal,$scope);}
			$scope.stockOpen = function() {modelpopup("includes/settings/stockcode/stockcode_add.php","md",$modal,$scope);}
			$scope.departmentaddOpen = function() {modelpopup("includes/settings/department/department_add.php","md",$modal,$scope);}
			$scope.departmenteditOpen = function() {modelpopup("includes/settings/department/department_edit.php","md",$modal,$scope);}
			$scope.customerOpen = function() {modelpopup("includes/settings/customer/customer_add.php","lg",$modal,$scope);}
			$scope.customerexportOpen = function() {modelpopup("includes/settings/customer/customer_export.php","md",$modal,$scope);}
			$scope.productOpen = function() {modelpopup("includes/settings/product/product_add.php","md",$modal,$scope);}
			//$scope.productexportOpen = function() {modelpopup("includes/settings/product/product_export.php","md",$modal,$scope);}
			$scope.assetaddOpen = function() {modelpopup("includes/settings/assets/asset_add.php","md",$modal,$scope);}
			$scope.asseteditOpen = function() {modelpopup("includes/settings/assets/asset_edit.php","md",$modal,$scope);}
			$scope.ticketcomplOpen = function() {modelpopup("includes/settings/complaint/complaint_add.php","md",$modal,$scope);}
			$scope.faultcodeOpen = function() {modelpopup("includes/settings/faultycode/faultcode_add.php","md",$modal,$scope);}
			$scope.sitemasteraddOpen = function() {modelpopup("includes/sitemaster/sitemaster_add.php","lg",$modal,$scope);}
			$scope.siteMasterDeleteOpen = function(data) { 
				deleteSiteMaster(data, $scope, $rootScope, $modal);
			}
			$scope.siteMasterRestoreOpen = function(data) { 
				// restoreSiteMaster(data, $scope, $rootScope, $modal);
				$rootScope.deleteData = data; 
				modelpopup("includes/sitemaster/sitemaster_restore.html","md",$modal,$scope);
			}
			$scope.sitemasterexportOpen = function() {modelpopup("includes/sitemaster/sitemaster_export.php","md",$modal,$scope);}
			$scope.sitemasterimportOpen = function() {modelpopup("includes/sitemaster/sitemaster_import.php","md",$modal,$scope);}
			$scope.employeemasteraddOpen = function() {modelpopup("includes/employeemaster/create.php","lg",$modal,$scope);}
			$scope.employeemasterexportOpen = function() {modelpopup("includes/employeemaster/export.php","lg",$modal,$scope);}
			$scope.cexportOpen = function() {modelpopup("includes/calender/cexport.php","lg",$modal,$scope);}
			$scope.dprexportOpen = function(x) { modelpopup("includes/calender/dprexport.php?drop_hide="+x,"md",$modal,$scope);}
			$scope.calenderDeleteOpen = function(data) { $rootScope.deleteData = data; modelpopup("includes/calender/delete.html","md",$modal,$scope);}
			$scope.sitemastereditOpen = function() {modelpopup("includes/sitemaster/sitemaster_edit.php","lg",$modal,$scope);}
			$scope.ticketseditOpen = function() {modelpopup("includes/tickets/tickets_edit.php","lg",$modal,$scope);}
			$scope.spotticketseditOpen = function(x){ $rootScope.alias = x;
				ajaxsingleViews(x, "services/tickets/spotticket_view", $scope,$rootScope);
				modelpopup("includes/tickets/spottickets_edit.php","lg",$modal,$scope);
			}
			$scope.spotTicketDeleteOpen = function(data) { 
				deleteSpotTicket(data, $scope, $rootScope, $modal);
			}
			$scope.ticketDeleteOpen = function(data) { 
				deleteTicket(data, $scope, $rootScope, $modal);
			}
			$scope.ticketSplEditOpen = function(data) { 
				return;
				deleteSpotTicket(data, $scope, $rootScope, $modal);
			}
			$scope.ticketTransferEditOpen = function(data) { 
				return;
				deleteSpotTicket(data, $scope, $rootScope, $modal);
			}
			$scope.ticketsEditPopup = function(result) {
				$rootScope.editData = result;
				modelpopup("includes/tickets/tickets_edit_popup.html", "md", $modal, $scope);
			}
			$scope.ticketsEditEfsrPopup = function(result) {
				$rootScope.editData = result;
				modelpopup("includes/tickets/tickets_efsr_edit_popup.html", "md", $modal, $scope);
			}
			$scope.ticketsDelEfsrPopup = function(result) {
				console.log(result);
				$rootScope.delData = result;
				modelpopup("includes/tickets/tickets_efsr_del_popup.html", "md", $modal, $scope);
			}
			$scope.setEfsrTickets = function(result) {
				$rootScope.efsrTickets = result.result;
				re_drop();
			}
			$scope.ticketsAdveditOpen = function() {
				modelpopup("includes/tickets/tickets_adv_edit.php","lg",$modal,$scope);
			}
			$scope.ticketsEfsrEditOpen = function() {
				modelpopup("includes/tickets/tickets_efsr_edit.html","lg",$modal,$scope);
			}
			$scope.employeemastereditOpen = function() {modelpopup("includes/employeemaster/edit.php","lg",$modal,$scope);}
			$scope.empMasterDeleteOpen = function(data) { $rootScope.deleteData = data; modelpopup("includes/employeemaster/delete.html","md",$modal,$scope);}
			$scope.empMasterUnDeleteOpen = function(data) { $rootScope.deleteData = data; modelpopup("includes/employeemaster/un-delete.html","md",$modal,$scope);}
			$scope.zoneeditOpen = function() {modelpopup("includes/settings/zone/zone_edit.php","md",$modal,$scope);}
			$scope.privacyviewOpen = function(x){$rootScope.alias=x; modelpopup("includes/settings/mobile_app/privacy_policy_view.php","lg",$modal,$scope);}
			$scope.privacyeditOpen = function() {modelpopup("includes/settings/mobile_app/privacy_policy_edit.php","lg",$modal,$scope);}
			$scope.stateeditOpen = function() {modelpopup("includes/settings/state/state_edit.php","md",$modal,$scope);}
			$scope.districteditOpen = function() {modelpopup("includes/settings/district/district_edit.php","md",$modal,$scope);}
			$scope.designationeditOpen = function() {modelpopup("includes/settings/designation/designation_edit.php","md",$modal,$scope);}
			$scope.employeeroleeditOpen = function() {modelpopup("includes/settings/emprole/employeerole_edit.php","md",$modal,$scope);}
			$scope.privilageseditOpen = function() {modelpopup("includes/settings/privilages/privilages_edit.php","lg",$modal,$scope);}
			$scope.stockcodeeditOpen = function() {modelpopup("includes/settings/stockcode/stockcode_edit.php","md",$modal,$scope);}
			$scope.customereditOpen = function() {modelpopup("includes/settings/customer/customer_edit.php","lg",$modal,$scope);}
			$scope.producteditOpen = function() {modelpopup("includes/settings/product/product_edit.php","md",$modal,$scope);}
			$scope.ticketcomplainteditOpen = function() {modelpopup("includes/settings/complaint/complaint_edit.php","md",$modal,$scope);}
			$scope.faultcodeeditOpen = function() {modelpopup("includes/settings/faultycode/faultcode_edit.php","md",$modal,$scope);}
			$scope.levelseditOpen = function() {
				$modal.open({
					templateUrl: "includes/settings/levels/levels_edit.php",
					size: "md",
					controller: "ModalDemoCtrl",
					resolve: {
						deps: ["$ocLazyLoad", function(a) {
							return a.load(["colorpicker.module", "ui.slider"])
						}]
					},
					windowClass: $scope.modalAnim,
					keyboard: false,
					backdrop: 'static'
				});
			}
			$scope.warehouseeditOpen = function() {modelpopup("includes/settings/warehouse/warehousecode_edit.php","md",$modal,$scope);}
			//$scope.assetexportOpen = function() {modelpopup("includes/settings/assets/asset_export.php","md",$modal,$scope);}
			$scope.advancerequestOpen = function() {modelpopup("includes/expense/advancerequest.php","lg",$modal,$scope);}
			$scope.submitexpenseOpen = function() {modelpopup("includes/expense/submitexpense.php","lg",$modal,$scope);}
			$scope.siteTypeaddOpen = function() {modelpopup("includes/settings/sitetype/sitetype_add.php","md",$modal,$scope);}
			$scope.siteTypeeditOpen = function() {modelpopup("includes/settings/sitetype/sitetype_edit.php","md",$modal,$scope);}
			$scope.siteStatusaddOpen = function() {modelpopup("includes/settings/sitestatus/sitestatus_add.php","md",$modal,$scope);}
			$scope.siteStatuseditOpen = function() {modelpopup("includes/settings/sitestatus/sitestatus_edit.php","md",$modal,$scope);}
			$scope.contractpriceaddOpen = function() {modelpopup("includes/settings/contractprice/contractprice_add.php","md",$modal,$scope);}
			$scope.contractpriceeditOpen = function() {modelpopup("includes/settings/contractprice/contractprice_edit.php","md",$modal,$scope);}
			$scope.manualeditOpen = function(x) {$rootScope.alias=x; modelpopup("includes/settings/mobile_app/manuals_edit.php","md",$modal,$scope);}
			$scope.manualsexport = function() {modelpopup("includes/settings/mobile_app/manuals_export.php","md",$modal,$scope);}
			$scope.workguideaddOpen = function() {modelpopup("includes/settings/mobile_app/workguide_add.php","md",$modal,$scope);}
			$scope.workguideeditOpen = function(x) {$rootScope.alias = x;modelpopup("includes/settings/mobile_app/workguide_edit.php","md",$modal,$scope);}
			$scope.changelogaddOpen = function() {modelpopup("includes/settings/mobile_app/changelog_add.php","md",$modal,$scope);}
			$scope.changelogeditOpen = function(x) {$rootScope.alias = x;modelpopup("includes/settings/mobile_app/changelog_edit.php","md",$modal,$scope);}
			$scope.escaaddOpen = function() {modelpopup("includes/settings/esca/esca_add.php","md",$modal,$scope);}
			$scope.escaeditOpen = function() {modelpopup("includes/settings/esca/esca_edit.php","md",$modal,$scope);}
			$scope.escaexportOpen = function() {modelpopup("includes/settings/esca/esca_export.php","md",$modal,$scope);}
			$scope.sendMessage = function() {modelpopup("includes/notifications/sendMessage.php","md",$modal,$scope);}
			$scope.dpraddopen = function() {modelpopup("includes/settings/dpr/dpr_add.php","md",$modal,$scope);}
			$scope.dpreditopen = function() {modelpopup("includes/settings/dpr/dpr_edit.php","md",$modal,$scope);}
			$scope.modalClose = function() {$scope.$close();}
			$scope.ticketClose = function() {$rootScope.site_obj='';$scope.$close();}
			$rootScope.rootModalClose = $scope;
			// By Jagan
			$scope.itemsaddOpen = function() {modelpopup("includes/inventory/stocks/items_add.php","lg",$modal,$scope);}
			$scope.itemseditOpen = function() {modelpopup("includes/inventory/stocks/items_edit.php","lg",$modal,$scope);}
			$scope.itemsdelOpen = function() {modelpopup("includes/inventory/stocks/delete.html","md",$modal,$scope);}
			$scope.itemsexport = function() {modelpopup("includes/inventory/stocks/items_export.php","lg",$modal,$scope);}
			
			$scope.materialRequestOpen = function() {modelpopup("includes/inventory/material_request/materialrequest_add.php","lg",$modal,$scope);}
			$scope.materialRequestedit = function(){modelpopup("includes/inventory/material_request/materialrequest_edit.php","lg",$modal,$scope);}
			$scope.materialRequestAdveditOpen = function(){modelpopup("includes/inventory/material_request/materialrequest_adv_edit.php","lg",$modal,$scope);}
			$scope.materialRequestexportOpen = function() {modelpopup("includes/inventory/material_request/Materialrequest_export.php","lg",$modal,$scope);}
			
			$scope.materialbalexportOpen = function() {modelpopup("includes/inventory/material_balance/materialbal_export.php","md",$modal,$scope);}
			$scope.materialinwardbalexportOpen = function() {modelpopup("includes/inventory/material_balance/materialinwardbal_export.php","md",$modal,$scope);}
			$scope.materialoutwardbalexportOpen = function() {modelpopup("includes/inventory/material_balance/materialoutwardbal_export.php","md",$modal,$scope);}
			
			$scope.materialinwardaddOpen = function() {modelpopup("includes/inventory/material_inward/materialinward_add.php","lg",$modal,$scope);}
			$scope.materialinwardeditOpen = function() {modelpopup("includes/inventory/material_inward/materialinward_edit.php","lg",$modal,$scope);}
			$scope.materialinwardexportOpen = function() {modelpopup("includes/inventory/material_inward/materailinward_export.php","lg",$modal,$scope);}
			
			$scope.materialoutwardaddOpen = function() {modelpopup("includes/inventory/material_outward/materialoutward_add.php","lg",$modal,$scope);}
			$scope.materialoutwardeditOpen = function() {modelpopup("includes/inventory/material_outward/materialoutward_edit.php","lg",$modal,$scope);}
			$scope.materialoutwardexportOpen = function() {modelpopup("includes/inventory/material_outward/materialoutward_export.php","lg",$modal,$scope);}
			
			$scope.revivaladdOpen = function() {modelpopup("includes/inventory/material_revival/revival_add.php","lg",$modal,$scope);}
			$scope.revivaleditOpen = function() {modelpopup("includes/inventory/material_revival/revival_edit.php","lg",$modal,$scope);}
			$scope.revivalexport = function() {modelpopup("includes/inventory/material_revival/revival_export.php","lg",$modal,$scope);}
			$scope.revivaladveditOpen = function() {modelpopup("includes/inventory/material_revival/revival_adv_edit.php","lg",$modal,$scope);}
			$scope.revivaldelOpen = function(data) {
				$rootScope.deleteData = data; 
				modelpopup("includes/inventory/material_revival/delete.html","md",$modal,$scope);
			}
			$scope.refreshingaddOpen = function() {modelpopup("includes/inventory/material_refreshing/refreshing_add.php","lg",$modal,$scope);}
			$scope.refreshingeditOpen = function() {modelpopup("includes/inventory/material_refreshing/refreshing_edit.php","lg",$modal,$scope);}
			$scope.refreshingexport = function() {modelpopup("includes/inventory/material_refreshing/refreshing_export.php","lg",$modal,$scope);}
			$scope.refreshingadveditOpen = function() {modelpopup("includes/inventory/material_refreshing/refreshing_adv_edit.php","lg",$modal,$scope);}
			$scope.refreshingdelOpen = function(data) {
				$rootScope.deleteData = data; 
				modelpopup("includes/inventory/material_refreshing/delete.html","md",$modal,$scope);
			}
			$scope.sjobalexportOpen = function() {modelpopup("includes/inventory/material_balance/sjo_bal_export.php","lg",$modal,$scope);}
		// By Jagan
		//customer
			$scope.ticketcustomerOpen = function() {modelpopup("includes/customer/tickets_add.php","lg",$modal,$scope);}
			$scope.ticketcustexportOpen = function() {modelpopup("includes/customer/tickets_export.php","lg",$modal,$scope);}
			$scope.sitemastercustexrtOpen = function() {modelpopup("includes/customer/sitemaster_export.php","md",$modal,$scope);}
			$scope.ticketescasexportOpen = function() {modelpopup("includes/esca/tickets_export.php","lg",$modal,$scope);}
			$scope.employeexportOpen = function() {modelpopup("includes/esca/export.php","md",$modal,$scope);}
			$scope.settingsDeleteOpen = function(setting, data) {
				deleteSetting(setting, data, $scope, $rootScope, $modal);
			}
		//end customer
		}])
		// Datepicker Demo Ctrl
		.controller("DatepickerDemoCtrl", ["$scope", function($scope) {
			$scope.open = function($event,$opened) {
				$event.preventDefault();
				$event.stopPropagation();
				$scope.opened= true;
				if($opened=='opened'){$scope.opened1= $scope.opened2= false;$scope.opened= true;}
				if($opened=='opened1'){$scope.opened= $scope.opened2= false;$scope.opened1= true;}
				if($opened=='opened2'){$scope.opened= $scope.opened1= false;$scope.opened2= true;}
				$scope.format = 'dd-MM-yyyy';
				$scope.format2 = 'yyyy-MM-dd';
				$scope.dt = Date.now();
				var currentDate = new Date();
				$scope.FromDate  = new Date();
				$scope.ToDate  = currentDate.setDate(currentDate.getDate());
			};
		}])
		.controller("monthYearCtrl", ["$scope", function($scope) {
			$scope.open = function($event,$opened) {
				$scope.formatt = 'yyyy-MM';
				$event.preventDefault();
				$event.stopPropagation();
				$scope.opened= true;
				$scope.dt = Date.now();
			};
		}])	
		.controller("loadingCtrl", ["$scope","$timeout","$rootScope",function($scope,$timeout,$rootScope) {
			var lists = $('.nav-list').find("ul").parent("li");
			lists.not(parent).removeClass("open");
			$rootScope.enerlod = true;
			$.ajax({
				type: 'POST',
				url: base_url_2+'services/loadingF',
				data: 'emp_alias=' + readCookie('emp_alias')+"&token=" + readCookie('token')+"&ip_addr=" + readCookie('ip_addr'),
				cache: false,
				async: false,
				success: function(result){
					var json = jQuery.parseJSON(result);
					$timeout(function(){
						var emp_ali = readCookie('emp_alias');
						ajaxsingleViews1(emp_ali, "services/profile_view", $rootScope, $rootScope);
						menuItems(emp_ali, "services/left_menu",$rootScope);
						$rootScope.adminProfile=(readCookie('employee_type')== '0' ? 'javascript:void(0);' : '#/Profile');
						$rootScope.adminProfileDis=(readCookie('employee_type')== '0' ? 'disabled' : '');
						if(emp_ali!==undefined && emp_ali!=null && emp_ali!==''){
							var emp_alias = emp_ali.toUpperCase();
							if(emp_alias=='ADMIN' || emp_alias=='EADMIN')$rootScope.settings_hide=true;
							else $rootScope.settings_hide = json.admin_privilege;
						}else $rootScope.settings_hide=false;
						window.location=base_url+json.empwent;
						//if(json.empwent!='#/dashboard')$rootScope.enerlod=false;
					},500);
				}
			});
		}])		
		.controller("singinRedirectCtrl", ["$scope", "$rootScope", "$http", "$route", "$routeParams", function($scope, $rootScope, $http, $route, $routeParams) {
			var value = $routeParams.value;
			$scope.hideLoginForm = true;
			validateToken(value, $scope);
		}])
		.controller("loginform", ["$scope", "$rootScope", "$http", "$route", "$routeParams", function($scope, $rootScope, $http, $route, $routeParams) {
			var loginStatus = $routeParams.loginStatus;
			var value = $routeParams.value;
			$scope.hideLoginForm = false;
			$scope.showClientLogin = false;
			if(loginStatus == "success") {
				$scope.hideLoginForm = true;
				validateToken(value, $scope);
			} else if (loginStatus == "fail") {
				setCookie("emp_alias", "", -1);
				setCookie("ip_addr", "", -1);
				setCookie("token", "", -1);
				setCookie("employee_type", "", -1);
				$rootScope.navFull = false;
				$rootScope.navOffCanvas = false;
				$rootScope.navHorizontal = false;
				$rootScope.fixedHeader = false;
				toast_msg($rootScope,'danger', value, 5000);
			}
			$scope.toggleClientLogin = function() {
				$scope.showClientLogin = $scope.showClientLogin ? false : true;
			}
			$scope.loginValidate = function() {
					//$.get('https://jsonip.com', function (res) {
						//var myip_addr = res.ip;
						var myip_addr = myip_addr !== '' && myip_addr !== null && myip_addr !== undefined ? myip_addr : 'IP NOT WORKING';
						var went = $(".forms_ec").attr('data-went')
						var url = $(".forms_ec").attr('url');
						var data = $(".forms_ec").serializeArray();
						setCookie("ip_addr", myip_addr, 1);
						//setCookie("ip_addr", '192.168.1.15', 1);
						//$.getJSON("https://jsonip.com?callback=?", function (dat) { setCookie("ip_addr", dat.ip, 1); });
						data.push({name: "ip_addr", value: readCookie('ip_addr')});
						var data = serializeToJson(data);
						loginCall(data, url, went, $scope, $rootScope, $route);
					//});
				},
				$scope.user_welcome = function() {
					var email = $("input[type='text']").val();
					if (email!="") {
						$.ajax({
							url: base_url_2 + "services/welcomenote",
							type: "POST",
							data: 'user_auth=' + $("input[type='text']").val(),
							success: function(result) {
								var json = jQuery.parseJSON(result);

								if (json.ErrorDetails.ErrorCode == '0') {
									if(json.token.loginType == 'okta') {
										toast_msg($scope, "danger", "Please use OKTA authentications to login!", 5000);
									} else {
										toast_msg($scope, "success", "Hi " + json.token.user_name + ", Welcome To Enersys Care!! <br>Can I have your Password!", 5000);	
									}
								} else if(json.ErrorDetails.ErrorCode == '2') {
									toast_msg($scope,"info","Hi Your account has Locked, Please contact admin!",5000);
								} else {
									toast_msg($scope,"info","Hi Your Employee ID \'" + $("input[type='text']").val() + "\' is not Registered<br>Please Contact Admin",5000);
								}
							}
						});
					}
				}
		}]).controller("addingform", ["$scope", "$http", "$route", "$rootScope", function($scope, $http, $route, $rootScope) {
			$scope.sendPost = function() {
				var went = $(".forms_add").attr('data-went');
				var url = $(".forms_add").attr('url');
				/*var data = $(".forms_add").serializeArray();
				data.push({
					name: 'emp_alias',
					value: readCookie('emp_alias')
				}, {
					name: 'token',
					value: readCookie('token')
				}, {
					name: 'ip_addr',
					value: readCookie('ip_addr')
				});
				var data = serializeToJson(data);
				var result = ajaxpost(data, url, went, $scope, $route, $rootScope);*/
				
				var data = new FormData($('.forms_add')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result=ajaxpost(data,url,went, $scope, $route, $rootScope);
			}
		}]).controller("addingform1", ["$scope", "$http", "$route", "$rootScope", function($scope, $http, $route, $rootScope) {
			$scope.sendPost1 = function() {
				var went = $(".forms_add1").attr('data-went');
				var url = $(".forms_add1").attr('url');
				/*var data = $(".forms_add").serializeArray();
				data.push({
					name: 'emp_alias',
					value: readCookie('emp_alias')
				}, {
					name: 'token',
					value: readCookie('token')
				}, {
					name: 'ip_addr',
					value: readCookie('ip_addr')
				});
				var data = serializeToJson(data);
				var result = ajaxpost(data, url, went, $scope, $route, $rootScope);*/
				
				var data = new FormData($('.forms_add1')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result=ajaxpost(data,url,went, $scope, $route, $rootScope);
			}
		}]).controller("lockScreenform", ["$scope", "$http", function($scope, $http) {
			$scope.unLock = function() {
				var url = $(".forms_lock").attr('url');
				var data = new FormData($('.forms_lock')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result=lockScn(data,url,$scope);
			}
		}]).controller("mul_view_form", ["$scope", "$http", "$rootScope","$timeout", function($scope, $http, $rootScope, $timeout) {
			$timeout(function() {
				var url = $(".forms_ec").attr('url');
				var data = $(".forms_ec").serializeArray();
				data.push({
					name: 'emp_alias',
					value: readCookie('emp_alias')
				}, {
					name: 'token',
					value: readCookie('token')
				}, {
					name: 'ip_addr',
					value: readCookie('ip_addr')
				});
				var data = serializeToJson(data);
				var result = ajaxViews(data, url, $scope,$rootScope);
			}, 0);
			$scope.listSorting = function(e) {
				var url = $(".forms_ec").attr('url');
				var data = $(".forms_ec").serializeArray();
				data.push({
					name: 'emp_alias',
					value: readCookie('emp_alias')
				}, {
					name: 'token',
					value: readCookie('token')
				}, {
					name: 'ip_addr',
					value: readCookie('ip_addr')
				});
				var data = serializeToJson(data);
				var result = ajaxViews(data, url, $scope,$rootScope);
			}
		}]).controller("dash_view_form", ["$scope", "$http", "$rootScope", function($scope, $http, $rootScope) {
			$scope.listSortingdb = function(e) {
				var url = $(".forms_tec").attr('url');
				var data = new FormData($('.forms_tec')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				dashViews(data,url,$scope,$rootScope);
			}
		}])
		.controller("customer_pulse_view",["$scope","$rootScope", function($scope,$rootScope) {
			$scope.listSortingcust = function(e){
				var url = $(".forms_cust").attr('url');
				var data = new FormData($('.forms_cust')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result=dashViews(data,url,$scope,$rootScope);
			}
						
		}]).controller("today_info_view",["$scope","$rootScope", function($scope,$rootScope) {
			$scope.listSortinginfo = function(e) {
				var url = $(".forms_today").attr('url');
				var data = new FormData($('.forms_today')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result=dashViews(data,url,$scope,$rootScope);
			}
		}])
		.controller("tat_view",["$scope","$rootScope", function($scope,$rootScope) {
			$scope.listSortingtat = function(e) {
				var url = $(".forms_tat").attr('url');
				var data = new FormData($('.forms_tat')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result=dashViews(data,url,$scope,$rootScope);
			}
		}])
		.controller("tktdash_view_form",["$scope","$rootScope", function($scope,$rootScope) {
			$scope.listSortingmnth = function(e) {
				var url = $(".forms_analysis").attr('url');
				var data = new FormData($('.forms_analysis')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result=dashViews(data,url,$scope,$rootScope);
			}
		}])
		.controller("activity_view",["$scope","$rootScope", function($scope,$rootScope) {
			$scope.listSortingacty = function(e) {
				var url = $(".forms_activity").attr('url');
				var data = new FormData($('.forms_activity')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result=dashViews(data,url,$scope,$rootScope);
			}
		}])
		.controller("faultydash_view_form",["$scope","$rootScope", function($scope,$rootScope) {
			$scope.listSortingfaulty = function(e) {
				var url = $(".forms_fec").attr('url');
				var data = new FormData($('.forms_fec')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				dashViews(data,url,$scope,$rootScope);
			}
		}])
		.controller("manuf_month_failure_form",["$scope","$rootScope", function($scope,$rootScope) {
			$scope.listSortingdbspm = function(e) {
				var url = $(".forms_fecpm").attr('url');
				var data = new FormData($('.forms_fecpm')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result=dashViews(data,url,$scope,$rootScope);
			}
						
		}])
		.controller("product_cont_failure_form",["$scope","$rootScope", function($scope,$rootScope) {
			$scope.listSortingdbsp = function(e) {
				var url = $(".forms_fecp").attr('url');
				var data = new FormData($('.forms_fecp')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result=dashViews(data,url,$scope,$rootScope);
			}
						
		}])
		//esca
		.controller("esca_dash_view_form", ["$scope","$rootScope", function($scope,$rootScope) {
			$scope.listSortingdb = function(e) {
				var url = $(".forms_esca").attr('url');
				var data = new FormData($('.forms_esca')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				dashViews(data,url,$scope,$rootScope);
			}			
		}])
		
		.controller("esca_customer_pulse_view", ["$scope","$rootScope", function($scope,$rootScope) {
			$scope.listSortingdb = function(e) {
				var url = $(".forms_custesca").attr('url');
				var data = new FormData($('.forms_custesca')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result=dashViews(data,url,$scope,$rootScope);
			}			
		}])
		.controller("escatodayinfoCtrl", ["$scope","$rootScope", function($scope,$rootScope) {
			$scope.listSortingdb = function(e) {
				var url = $(".forms_esca_tdinfo").attr('url');
				var data = new FormData($('.forms_esca_tdinfo')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result=dashViews(data,url,$scope,$rootScope);
			}			
		}])
		.controller("escatatconfigCtrl", ["$scope","$rootScope", function($scope,$rootScope) {
			$scope.listSortingdb = function(e) {
				var url = $(".forms_esca_tat").attr('url');
				var data = new FormData($('.forms_esca_tat')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result=dashViews(data,url,$scope,$rootScope);
			}			
		}])
		.controller("escaactivityconfigCtrl", ["$scope","$rootScope", function($scope,$rootScope) {
			$scope.listSortingdb = function(e) {
				var url = $(".forms_esca_na").attr('url');
				var data = new FormData($('.forms_esca_na')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));

				data.append("ip_addr", readCookie('ip_addr'));
				var result=dashViews(data,url,$scope,$rootScope);
			}			
		}])
		//end esca
		//customer
		.controller("cust_dash_view_form", ["$scope","$rootScope", function($scope,$rootScope) {
			$scope.listSortingdb = function(e) {
				var url = $(".forms_customer").attr('url');
				var data = new FormData($('.forms_customer')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result=dashViews(data,url,$scope,$rootScope);
			}			
		}])
		.controller("custtodayinfoCtrl", ["$scope","$rootScope", function($scope,$rootScope) {
			$scope.listSortingdb = function(e) {
				var url = $(".forms_cust_info").attr('url');
				var data = new FormData($('.forms_cust_info')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result=dashViews(data,url,$scope,$rootScope);
			}			
		}])
		.controller("custactivityconfigCtrl", ["$scope","$rootScope", function($scope,$rootScope) {
			$scope.listSortingdb = function(e) {
				var url = $(".forms_cust_na").attr('url');
				var data = new FormData($('.forms_cust_na')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				var result=dashViews(data,url,$scope,$rootScope);
			}			
		}])
		//end customer
		.controller('tatDropCntrl', ["$scope", function($scope) {
			$scope.tats = [{
				"name": "TAT-1"
			}, {
				"name": "TAT-2"
			}, {
				"name": "TAT-3"
			}];
		}]).controller('qualifDropCntrl', ["$scope", function($scope) {
			$scope.qualifications = [{
				"name": "10TH"
			}, {
				"name": "INTERMEDIATE"
			}, {
				"name": "ITI"
			}, {
				"name": "DIPLOMA"
			}, {
				"name": "B.TECH"
			}, {
				"name": "GRADUATION"
			}, {
				"name": "POST GRADUATION"
			}];
		}]).controller("ItemcodeDropCntrl", ["$scope", function($scope) {
			$scope.itemtypes = [{
					"name": "CELLS", "alias":"1"
				}, {
					"name": "ACCESSORIES", "alias":"2"
			}];
			$scope.dep_drop_item = function(alias) {
				if(alias==""){$scope.firstDrop='';}
				else if(alias=="1"){depend_drop("services/product_desc_drop","","", $scope);}
				else{depend_drop("services/accessory_desc_drop","","", $scope);}
			}
		}]).controller("tktactivitydropCntrl", ["$scope", function($scope){
			depend_drop("services/ticket_activity_mul","","",$scope);
		}])
		.controller("tktsitedropCntrl", ["$scope", function($scope){
			depend_drop("services/ticket_site_mul","","",$scope);
		}])
		
 		.controller("tktsegmentdropCntrl", ["$scope", function($scope){
			depend_drop("services/segment_drop","","",$scope);
		}])
		
		.controller("tktcomplaintdropCntrl", ["$scope", function($scope){
			depend_drop("services/ticket_complaint_mul","","",$scope);
		}])
		
		.controller("tktcustomerdropCntrl", ["$scope", function($scope){
			depend_drop("services/ticket_customer_mul","","",$scope);
		}])
		
		.controller("tktleveldropCntrl", ["$scope", function($scope){
			depend_drop("services/ticket_level_mul","","",$scope);
		}])
		
		.controller("tktagingdropCntrl", ["$scope", function($scope){
			depend_drop("services/aging_drop","","",$scope);
		}]).controller("siteMulNamedropCntrl", ["$scope", function($scope){
			depend_drop("services/site_prod_mul_drop","","",$scope);
		}]).controller("assetnamedropCntrl", ["$scope", function($scope){
			depend_drop("services/asset_drop","","",$scope);
		}]).controller('assetdropCntrl', ["$scope",function($scope){                     
			$scope.assets = [
				  {"name": "TOOLS"},
				  {"name": "ELECTRONICS"},
				  {"name": "OTHERS"}
			];
		}]) .controller('natureofassetDropCntrl', ["$scope", function($scope) {
			$scope.natureofassets = [{
				"name": "CONSUMABLE"
			}, {
				"name": "NON CONSUMABLE"
			}];
		}]).controller('scheduleDropCtrl', ["$scope",function($scope){                     
			$scope.schedules = [{
				"name": "0"
			}, {
				  "name": "1"
			}, {
				  "name": "2"
			}, {
				  "name": "3"
			}, {
				  "name": "4"
			}, {
				  "name": "5"
			}, {
				  "name": "6"
			}, {
				  "name": "7"
			}, {
				  "name": "8"
			}, {
				  "name": "9"
			}, {
				  "name": "10"
			}, {
				  "name": "11"
			}, {
				  "name": "12"
			}];
		}]) .controller('noofstringsDropCntrl', ["$scope", function($scope) {
			$scope.noofstring = [{
				"name": "1"
			}, {
				"name": "2"
			}, {
				"name": "3"
			}, {
				"name": "4"
			}, {
				"name": "5"
			}];
		}]).controller('onlinetktCtrl', ["$scope",function($scope){                     
			$scope.onlinetickets = [{
				"name": "Accept", "value": "1"
			}, {
				"name": "Reject", "value": "0"
			}];
		}])
		.controller('paymentCtrl', ["$scope",function($scope){                     
			$scope.paymentterms = [{
				"name": "100"
			}, {
				"name": "90"
			}, {
				"name": "80"
			}, {
				"name": "70"
			}];
		}])
		.controller('zonalactionCtrl', ["$scope",function($scope){                     
			$scope.zonalactions = [{
				"id" : "1","name": "CLOSE TICKET"
			}, {
				"id" : "2","name": "BB NOT MAINTAIN PROPERLY"
			}, {
				"id" : "3","name": "NHS APPROVAL REQUIRED"
			}, {
				"id" : "4","name": "NEXT VISIT"
			}];
		}])
		.controller('NHSactionCtrl', ["$scope",function($scope){                     
			$scope.nhsactions = [{
				"id" : "1", "name": "CLOSE TICKET"
			}, {
				"id" : "2", "name": "BB NOT MAINTAIN PROPERLY"
			}, {
				"id" : "3", "name": "TS APPROVAL REQUIRED"
			}, {
				"id" : "4", "name": "NEXT VISIT"
			}];
		}])
		.controller("general", ["$scope", function($scope) {
			$scope.options = [{
				"label": 'General', "value": "0"
			}, {
				"label": 'Cell Required', "value": "1"
			}, {
				"label": 'Declined', "value": "2"
			}];
			$scope.thisValue = $scope.options[0];
			depend_drop("services/general_emprole_drop_downs", "services/general_emprole_emplist_drop_downs", "", $scope);
		}])
		.controller("planned", ["$scope", function($scope) {			
			$scope.options = [{
				"label": 'Planned Date', "value": "0"
			}, {
				"label": 'Declined', "value": "1"
			}];
			$scope.thisValue = $scope.options[0];
		}])
		.controller("settingsHideCtrl", ["all_apiRoute","$rootScope", function(all_apiRoute,$rootScope) {
			console.log("Calledthis....")
			var emp_ali = readCookie('emp_alias');
			if(emp_ali!==undefined && emp_ali!=null && emp_ali!=='') {
				var emp_alias = emp_ali.toUpperCase();
				$.ajax({
					type: 'POST',
					url: base_url_2 + 'services/settings_hide?alias='+emp_alias,
					cache: false,
					async: false,
					error: function(result) {
						$rootScope.loading=false;
						toast_msg($rootScope,'danger', 'Request failed, Contact Admin',5000);console.log(result);
					}, beforeSend: function(result){
						$rootScope.loading=true;
					}, success: function(result) { 
						$rootScope.loading=false;
						$rootScope.settings_hide = JSON.parse(result).admin_privilege;
					}
				});
			} else $rootScope.settings_hide = false;
		}])
		.controller("leftMenuCtrl", ["$scope","$rootScope", function($scope,$rootScope) {
			menuItems(readCookie('emp_alias'), 'services/left_menu',$rootScope);
		}])
		.controller("unitDropCtrl", ["$scope", function($scope) {		
			$scope.units = [{
				"name": 'Per Bank'
			}, {
				"name": 'Per Site'
			}];
		}])
		.controller("itemTypeDropCtrl", ["$scope", function($scope) {		
			$scope.itemtypes = [{
				"name": 'CELLS'
			}, {
				"name": 'ACCESSORIES'
			}];
		}])
		.controller("jobePerformCtrl", ["$scope", function($scope) {		
			$scope.jobperforms = [{
				"name": 'PARITIALLY CLOSED'
			}, {
				"name": 'CELL REPLACED'
			},{
				"name": 'SITE VISIT'
			},{
				"name": 'ACCEPTANCE TEST'
			},{
				"name": 'INSTALLATION & COMMISSIONING'
			}];
		}])
		//By Jagan
		// Add of Fields
		.controller("addFieldsCtrl", ["$scope", function($scope) {
			$scope.forms = [{name: "field1",itemtype:[{ ac: '', auth: '', autname: ''}]}];
			$scope.addFields = function (field) {
				event.preventDefault();
				field.itemtype.push({ ac: '', auth: '', autname: '' });
				re_drop();
			}
			$scope.removeFields = function(field){
				if(field.itemtype.length!=1){
					event.preventDefault();
					field.itemtype.splice( field.itemtype.indexOf(field), 1);
				}
			}; 
		}])
		.controller("addFieldsCtrl1", ["$scope", function($scope) {
			$scope.forms = [{name: "field1",itemtype:[{ ac: '', auth: '', autname: ''}]}];
			$scope.addFields = function (field) {
				event.preventDefault();
				field.itemtype.push({ ac: '', auth: '', autname: '' });
				re_drop();
			}
			$scope.removeFields = function(field,key){ alert(key); alert(field.itemtype.indexOf(field));
				if(field.itemtype.length!=1){
					event.preventDefault();
					field.itemtype.splice(key, 1);
				}
			}; 
		}])
		.controller("addFieldsCtrl2", ["$scope", function($scope) {
			$scope.fields = [];
			$scope.addFields = function () {
				event.preventDefault();
				$scope.fields.push({name:"", qty:""});
				re_drop();
			}
			$scope.removeFields = function(key){
				event.preventDefault();
				$scope.fields.splice(key, 1);
				console.log(key, $scope.fields);
			}; 
		}])
		// Add of Fields
		.controller("addCellsTktCtrl", ["$scope", function($scope) {	
			$scope.forms = [{name: "field1",itemtype:[{ ac: '', auth: '', autname: ''},{ ac: '', auth: '', autname: ''},{ ac: '', auth: '', autname: ''}]}];
			$scope.addFields = function (field) {
				event.preventDefault();
				field.itemtype.push({ ac: '', auth: '', autname: '' });
			}
			$scope.removeFields = function(field){
				if(field.itemtype.length!=1){
					event.preventDefault();
					field.itemtype.splice( field.itemtype.indexOf(field), 1);
					//field.itemtype.splice(field, 1);
				}
			}; 
		}])
// Stocks(Item Code) Edit
		.controller("itemEditCntl", ["$scope", "$rootScope", function($scope, $rootScope) {
			ajaxsingleViews($rootScope.alias, "services/inventory/item_code_view", $scope,$rootScope);
			$scope.myModelCopy = angular.copy( $scope.singleViews );
		}])
		// MaterialRequest Add
		.controller("materialRequestAdd",["$scope","$timeout","$rootScope",function($scope,$timeout, $rootScope){
			
			//$scope.rand = "MRF-"+Math.floor(10000 + Math.random() * 90000);
			ajaxsingleViews('', "services/inventory/material_request_rand", $scope,$rootScope);
			
			var datef = new Date();
			$scope.date ={value: datef.getDate()+'-'+datef.getMonth()+'-'+datef.getFullYear()};
			$.ajax({
				type: 'POST',
				url: 'services/inventory/loginhwtype',
				data: 'x='+ readCookie('emp_alias'),
				cache: false,
				async: false,
				error: function(result) { /*alert('error occured');*/	},
				beforeSend:function(result){$rootScope.loading=true;},
				success: function(result) {$rootScope.loading=false;
					$scope.datasflo = JSON.parse(result);
				}
			});
			$scope.getitemslistfromticket = function (alias) {
				$scope.bufferTT = alias;
				$.ajax({
					type: 'POST',
					url: 'services/inventory/getitemslistfromticket',
					data: 'alias=' + alias+'&x='+ readCookie('emp_alias'),
					cache: false,
					async: false,
					beforeSend:function(result){$rootScope.loading=true;},
					success: function(result) {$rootScope.loading=false;
						$scope.datas = JSON.parse(result);
					}
				});
			}
			$scope.sjo_scanned_copy = function(e,type){
				file_loading(e,$scope,$rootScope,type);
				/*$scope.toasts = [{
					anim: "bouncyflip",
					type: "success",
					msg: "Successfully PDF file loaded."
				}];
				$timeout(function(){$scope.toasts.splice(0, 1);}, 15000);*/
			}
			$scope.getNumbersdf = function(num){return new Array(parseInt(num));}
			$scope.itemRequestApprovedTickets = function (alias) {
				$.ajax({
					type: 'POST',
					url: 'services/inventory/nhsApprovedTickets',
					data:  'wh_alias=' + alias+'&ref=add&x='+ readCookie('emp_alias'),
					cache: false,
					async: false,
					error: function(result){},
					beforeSend:function(result){$rootScope.loading=true;},
					success: function(result){$rootScope.loading=false;
						$timeout(function(){
							$('select[name="ticketID"]')[0].sumo.unload();
							$('.testSelAll2').SumoSelect();
							$('.testSelAll3').SumoSelect({selectAll:true});
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
						$scope.ticketList = JSON.parse(result);
					}
				});
			}
		}])
		// MaterialRequest Edit
		.controller("materialRequestEdit", ["$scope","$timeout","$rootScope", function($scope,$timeout,$rootScope) {
			ajaxsingleViews($rootScope.alias, "services/inventory/material_request_single_view", $scope,$rootScope);
			$scope.parsefloat = function(e,clr,lft) {
			  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 96 || e.which > 105)) {
				  e.preventDefault();
				  e.target.value=0;
				  $scope.clr_qty_total=add_amount(e,lft,clr);
			   }else{
					lft=(isNaN(lft) || lft==null ? 0 : lft);
					clr=(isNaN(clr) || clr==null ? 0 : clr);
					$scope.clr_qty_total=add_amount(e,lft,clr);
			   }
			}
			function add_amount(e,lft,clr){
				if(parseInt(lft) >= parseInt(clr)){var total=0;
					  $('.add_clr').each(function(){
						var v_ch = $(this).val();
						if(isNaN(v_ch) || v_ch==null || v_ch=='') total+=0;
						else total+= parseInt($(this).val());
					  }); return total;
				}else{ e.preventDefault();e.target.value=0; return add_amount(e,lft,clr);}
			}
			var datef = new Date();
			$scope.date ={value: datef.getDate()+'-'+datef.getMonth()+'-'+datef.getFullYear()};
			$scope.getitemslistfromticket = function (alias) {
				$scope.bufferTT = alias;
				$.ajax({
					type: 'POST',
					url: 'services/inventory/getitemslistfromticket',
					data: 'alias=' + alias+'&x='+ readCookie('emp_alias'),
					cache: false,
					async: false,
					beforeSend:function(result){$rootScope.loading=true;},
					success: function(result) {$rootScope.loading=false;
						$scope.datas = JSON.parse(result);
					}
				});
			}
			$scope.sjo_scanned_copy = function(e,type){
				file_loading(e,$scope,$rootScope,type);
				/*$scope.toasts = [{
					anim: "bouncyflip",
					type: "success",
					msg: "Successfully PDF file loaded."
				}];
				$timeout(function(){$scope.toasts.splice(0, 1);}, 15000);*/
			}
			$scope.getNumbersdf = function(num){return new Array(parseInt(num));}
			$scope.itemRequestApprovedTickets = function (alias) {
				$.ajax({
					type: 'POST',
					url: 'services/inventory/nhsApprovedTickets',
					data:  'wh_alias=' + alias+'&ref=edit&x='+ readCookie('emp_alias'),
					cache: false,
					async: false,
					error: function(result){},
					beforeSend:function(result){$rootScope.loading=true;},
					success: function(result){$rootScope.loading=false;
						$timeout(function(){
							$('select[name="ticketID"]')[0].sumo.unload();
							$('.testSelAll2').SumoSelect();
							$('.testSelAll3').SumoSelect({selectAll:true});
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
						$scope.ticketList = JSON.parse(result);
					}
				});
			}
			
			
			
		}])
		//Stocks Add
		.controller("stocksAdd",["$scope","$timeout","$rootScope",function($scope,$timeout,$rootScope){
			$scope.getitemslistfromsjo_ic = function (alias) {$rootScope.loading=true;
				$timeout(function(){
					$.ajax({
						type: 'POST',
						url: 'services/inventory/getitemslistfromsjo_ic',
						data: 'alias=' + alias+'&x='+ readCookie('emp_alias'),
						cache: false,
						async: false,
						error: function(result) { /*alert('error occured');*/ },
						beforeSend:function(result){$rootScope.loading=true;},
						success: function(result) { re_drop();
							//$('.uploadFile').val('');
							//$('#file').val('');
							var json = JSON.parse(result);
							if(json.ehfrommrf!="No Records Found")$scope.datas = json;else $rootScope.loading=false;
						}
					});
				},300);
			}
			$scope.closeloadings = function(e){$rootScope.loading=false;}
			$scope.imp_closeloadings = function(e){
				$rootScope.loading=false;
				$("input[type='hidden']").removeAttr("name");
				$("input[name='cellNumber_Quanty[]']").removeAttr("name");
			}
			$scope.itemslistimport = function(e,type){
				var data = new FormData($('.forms_add')[0]);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				file_loading(e,$scope,$rootScope,type);
				ajaxImport(data,"services/inventory/stocks_import",$scope,$rootScope);
			}
			$scope.getNumbersdf = function(num){return new Array(parseInt(num));}
		}])
		// Self Warehouse Dropdown 
		.controller("selfWarehouse",["$scope","$rootScope",function($scope, $rootScope){
			$scope.person = {};
			$.ajax({
				type: 'POST',
				url: base_url_2+'services/inventory/selfWarehouse',
				data: 'alias=' + readCookie('emp_alias'),
				cache: false,
				async: false,
				beforeSend:function(result){$rootScope.loading=true;},
				success: function(result){$rootScope.loading=false;
					re_drop();
					$scope.firstDrop = JSON.parse(result);
				}
			});
		}])
		// Employee List Dropdown 
		.controller("emprolenameCntrl",["$scope","$rootScope",function($scope, $rootScope){
			$scope.person = {};
			$.ajax({
				type: 'POST',
				url: base_url_2+'services/inventory/emprolenamelist',
				data: 'alias=' + readCookie('emp_alias'),
				cache: false,
				async: false,
				beforeSend:function(result){$rootScope.loading=true;},
				success: function(result){$rootScope.loading=false;$scope.firstDrop = JSON.parse(result);}
			});
		}])
		// Zone List Balance Dropdown 
		.controller("zoneslistsCntrl",["$scope","$rootScope",function($scope,$rootScope){
			$scope.person = {};
			$.ajax({
				type: 'POST',
				url: base_url_2+'services/inventory/zoneslistsCntrl',
				data: 'alias=' + readCookie('emp_alias'),
				cache: false,
				async: false,
				beforeSend:function(result){$rootScope.loading=true;},
				success: function(result){$rootScope.loading=false;
					re_drop();
					$scope.firstDrop = JSON.parse(result);
				}
			});
			
		}])
		// Material Request To Dropdown 
		.controller("materialRequestTo",["$scope","$rootScope",function($scope, $rootScope){
			$.ajax({
				type: 'POST',
				url: base_url_2+'services/inventory/materialRequestTo',
				data: 'alias=' + readCookie('emp_alias'),
				cache: false,
				async: false,
				beforeSend:function(result){$rootScope.loading=true;},
				success: function(result){$rootScope.loading=false;$scope.firstDrop = JSON.parse(result);}
			});
		}])
		// Get Approved SJO Number Dropdown
		.controller("getapprovedsjonumber",["$scope","$rootScope",function($scope,$rootScope){
			$.ajax({
				type: 'POST',
				url: base_url_2+'services/inventory/getselectedsjo',
				data: 'alias=' + readCookie('emp_alias'),
				cache: false,
				async: false,
				error: function(result){},
				beforeSend:function(result){$rootScope.loading=true;},
				success: function(result){$rootScope.loading=false;
					re_drop();
					$scope.ticketList = JSON.parse(result);
				}
			});
		}])

		// Item Request Approved Tickets Dropdown
		.controller("matrialAddcCtlr", ["$scope", "$rootScope", function($scope, $rootScope) {
			$scope.rand = "MRF-"+Math.floor(1000 + Math.random() * 9000);
			var datef = new Date();
			$scope.date ={value: datef.getDate()+'-'+datef.getMonth()+'-'+datef.getFullYear()};
			$scope.person = {};
			$.ajax({
				type: 'POST',
				url: 'services/employeeWh',
				data: 'alias=' + readCookie('emp_alias'),
				cache: false,
				async: false,
				error: function(result) {/*alert('error occured');*/},
				beforeSend:function(result){$rootScope.loading=true;},
				success: function(result) {$rootScope.loading=false;
					$scope.datas = JSON.parse(result);
				}
			});
		}])
		.controller("matrialoutwatdAddcCtlr", ["$scope","$timeout","$rootScope","all_apiRoute", function($scope,$timeout,$rootScope,all_apiRoute) {
			var datef = new Date();
			$scope.date ={value: datef.getDate()+'-'+datef.getMonth()+'-'+datef.getFullYear()};
			$.ajax({
				type: 'POST',
				url: 'services/inventory/empfaccheck',
				data: 'x='+ readCookie('emp_alias'),
				cache: false,
				async: false,
				beforeSend:function(result){$rootScope.loading=true;},
				success: function(result){$rootScope.loading=false;$scope.empfac = JSON.parse(result);}
			});
			
			$scope.ware_bal_count = function(wh_alias) {
					$scope.wh_name = $("select[name='from_wh']").find(':selected').html();
				all_apiRoute.getAll(base_url_2+'services/inventory/ware_bal_count?wh_alias='+wh_alias).then(function (response) {
					$scope.bal_show = response.data;
				}, function(error){console.log("Error: " + error); });
			}
			
			/*$scope.ware_bal_count = function(wh_alias){
				$.ajax({
					type: 'POST',
					url: 'services/inventory/ware_bal_count',
					data: 'wh_alias='+wh_alias+'&x='+ readCookie('emp_alias'),
					cache: false,
					async: false,
					beforeSend:function(result){$rootScope.loading=true;},
					success: function(result) {$rootScope.loading=false;
						$scope.bal_show = JSON.parse(result);
					}
				});
			}*/
			
			$scope.material_to = function(x) {
				//if(x!='1'&&x!='2'&&x!='3'&&x!='4')$('select[name="materialToType"]').val('');
				if(x!='1'&&x!='2'&&x!='3'&&x!='4'){
					var slctdIndx = $("select[name='materialToType'] option:selected").index();
					if(slctdIndx>=1 && slctdIndx<=4)setTimeout(function(){$scope.material_to(slctdIndx);},100);
				}else {$scope.singleViews={};$scope.buffer_stocks={};$scope.datas={};}
				$('select[name="materialToType"]')[0].sumo.unload();
				$scope.materialTo = x;
				//$scope.datas.itemcount=$scope.buffer_stocks.itemcount='';
			}
			$scope.sitemasterlist_outward = function(alias) {
				$.ajax({
					type: 'POST',
					url: 'services/inventory/sitelistemp',
					data: 'alias=' + alias+'&x='+ readCookie('emp_alias'),
					cache: false,
					async: false,
					error: function(result) { /*alert('error occured');*/ },
					beforeSend:function(result){$rootScope.loading=true;},
					success: function(result) {$rootScope.loading=false;
						$scope.datas = JSON.parse(result);
					}
				});
			}
			$scope.getlistTicketsnhsaproved = function(alias) {
				$.ajax({
					type: 'POST',
					url: 'services/inventory/nhsApprovedTickets',
					data: 'site_id=' + alias.site_id+'&x='+ readCookie('emp_alias'),
					cache: false,
					async: false,
					error: function(result) {
						/*alert('error occured');*/
					},
					beforeSend:function(result){$rootScope.loading=true;},
					success: function(result) {$rootScope.loading=false;
						$scope.ticketList = JSON.parse(result);
					}
				});
			}
			$scope.getitemslistfromsjo = function (alias) { 
				$.ajax({
					type: 'POST',
					url: 'services/inventory/getitemslistfromsjo',
					data: 'alias=' + alias+'&x='+ readCookie('emp_alias'),
					cache: false,
					async: false,
					error: function(result) {
						/*alert('error occured');*/
					},
					beforeSend:function(result){$rootScope.loading=true;},
					success: function(result) {$rootScope.loading=false;
						re_drop();
						$scope.datas = JSON.parse(result);
					}
				});
			}
			$scope.getrequiredCellsTickets = function(alias) {
				$rootScope.loading=true;
				$timeout(function(){
					$.ajax({
						type: 'POST',
						url: 'services/inventory/getrequiredCellsTickets',
						data: 'ticketID=' + alias+'&x='+ readCookie('emp_alias'),
						cache: false,
						async: false,
						//error: function(result) {alert('error occured');},
						beforeSend:function(result){$rootScope.loading=true;},
						success: function(result) {$rootScope.loading=false;
							$scope.datas = JSON.parse(result);
							re_drop();
						}
					});
				},300);
			}
			$scope.getbufferstocksforow = function(alias) {
				$rootScope.loading=true;
				$timeout(function(){
					$.ajax({
						type: 'POST',
						url: 'services/inventory/getbufferstocksforow',
						data: 'buffersjo=' + alias+'&x='+ readCookie('emp_alias'),
						cache: false,
						async: false,
						beforeSend:function(result){$rootScope.loading=true;},
						success: function(result) {$rootScope.loading=false;
							$scope.buffer_stocks = JSON.parse(result);
						}
					});
				},300);
			}
			$scope.scraplistcells = function(alias) {
				$rootScope.loading=true;
				$timeout(function(){
					$scope.outstand_count=$("select[name='ref_no']").find(':selected').attr('data-count');
					var from_wh_a=$('select[name="from_wh"]').val();
					$.ajax({
						type: 'POST',
						url: 'services/inventory/scrapcellsget',
						data: 'sjo=' + alias+'&x='+ readCookie('emp_alias')+'&y='+from_wh_a,
						cache: false,
						async: false,
						error: function(result) {
							/*alert('error occured');*/
						},
						beforeSend:function(result){$rootScope.loading=true;},
						success: function(result) {$rootScope.loading=false;
							$scope.singleViews = JSON.parse(result);
						}
					});
				},300);
			}
		}])
		.controller("matrialinwardwatdAddcCtlr", ["$scope","$timeout","$rootScope", function($scope,$timeout,$rootScope) {
			ajaxsingleViews(readCookie('emp_alias'), "services/profile_view", $scope,$rootScope);
			$scope.temp=true;
			$scope.closeloadings = function(e){$rootScope.loading=false;}
			$scope.imp_closeloadings = function(e){
				$rootScope.loading=false;
				$("input[type='hidden']").removeAttr("name");
				$("input[name='cell_no[]']").removeAttr("name");
			}
			$scope.itemsimport = function(e,type){
				//var url = $(".forms_ec").attr('url');
				var data = new FormData($('.forms_add')[0]);
				var to_wh=$('select[name="to_wh"]').val();
				data.append("to_wh", to_wh);
				data.append("emp_alias", readCookie('emp_alias'));
				data.append("token", readCookie('token'));
				data.append("ip_addr", readCookie('ip_addr'));
				file_loading(e,$scope,$rootScope,type);
				var result=ajaxImport(data,"services/inventory/material_inward_import",$scope,$rootScope);
				$scope.temp=false;
			}
			$scope.clear = function() {
		    	angular.element("input[type='file']").val(null);
			}
			$scope.checkAll = function(rlAll){ var recv_all,lost_all;
				if(rlAll=='rl_all'){ //Check All CheckBox
					if($('#rl_all').is(':checked')){
						recv_all=true; lost_all=false;
					}else{lost_all=true;recv_all=false; }
				}else{ //Uncheck All Button
					$scope.check_all=recv_all=lost_all=false;
				}
				if(recv_all)$('.sngl_unch_recv').addClass('chck');else $('.sngl_unch_recv').removeClass('chck');
				if(lost_all)$('.sngl_unch_lst').addClass('chck');else $('.sngl_unch_lst').removeClass('chck');
				angular.forEach($scope.datas.scrapdetails, function (item){
					item.recv_selected = recv_all;
					item.lost_selected = lost_all;
				});
			}
			$scope.material_from = function(x) {
				//if(x!='1'&&x!='2'&&x!='3'&&x!='4')$('select[name="materialToType"]').val('');
				if(x!='1'&&x!='2'&&x!='3'&&x!='4'){
					var slctdIndx = $("select[name='materialToType'] option:selected").index();
					if(slctdIndx>=1 && slctdIndx<=4)setTimeout(function(){$scope.material_from(slctdIndx);},300);
				}else{$scope.datas={}; $scope.field={};}
				$('select[name="materialToType"]')[0].sumo.unload();
				$scope.materialFrom = x;
			}
			$.ajax({
				type: 'POST',
				url: 'services/inventory/loginhwtype',
				data: 'x='+ readCookie('emp_alias'),
				cache: false,
				async: false,
				error: function(result) {
					/*alert('error occured');*/
				},
				beforeSend:function(result){$rootScope.loading=true;},
				success: function(result) {$rootScope.loading=false;
					$scope.datasflo = JSON.parse(result);
				}
			});
			var datef = new Date();
			$scope.date ={value: datef.getDate()+'-'+datef.getMonth()+'-'+datef.getFullYear()};
			$scope.getsjodetails = function(alias) {
				$.ajax({
					type: 'POST',
					url: 'services/inventory/sjodetails',
					data: 'alias=' + alias+'&x='+ readCookie('emp_alias'),
					cache: false,
					async: false,
					error: function(result) {
						/*alert('error occured');*/
					},
					beforeSend:function(result){$rootScope.loading=true;},
					success: function(result) {$rootScope.loading=false;
						$scope.datas = JSON.parse(result);
					}
				});
			}
			$scope.getitemfromoutward = function(alias) {
				$rootScope.loading=true;
				$timeout(function(){
					$.ajax({
						type: 'POST',
						url: 'services/inventory/outwarditemlist',
						data: 'alias=' + alias+'&x='+ readCookie('emp_alias'),
						cache: false,
						async: false,
						//error: function(result) {alert('error occured');},
						beforeSend:function(result){$rootScope.loading=true;},
						success: function(result) {//$rootScope.loading=false;
							$scope.datas = JSON.parse(result);
							$('input[name="invoice_date"]').val('');
						}
					});
				},300);
			}
			$scope.getscrapitemsfrmwh = function(alias) {
				$rootScope.loading=true;
				$timeout(function(){
					$.ajax({
						type: 'POST',
						url: 'services/inventory/getscrapitemsfrmwh',
						data: 'alias=' + alias+'&x='+ readCookie('emp_alias'),
						cache: false,
						async: false,
						error: function(result) {
							/*alert('error occured');*/
						},
						beforeSend:function(result){$rootScope.loading=true;},
						success: function(result) {$rootScope.loading=false;
							$scope.datas = JSON.parse(result);
							$timeout(function(){
								$("input[type='radio']").on('click',function(){
									var ths = $(this);
									if(ths.hasClass('chck')){
										ths.prop('checked',false);
										ths.removeClass('chck');
									}else{
										ths.prop('checked',true);
										ths.addClass('chck');
									}
									ths.parent().siblings('label').children().removeClass('chck');
								});
							},300);
						}
					});
				},300);
			}
			
			$scope.person = {};
			$scope.sitemasterlist_outward = function(alias) {
				$.ajax({
					type: 'POST',
					url: 'services/sitelistemp',
					data: 'alias=' + alias+'&x='+ readCookie('emp_alias'),
					cache: false,
					async: false,
					error: function(result) {
						/*alert('error occured');*/
					},
					beforeSend:function(result){$rootScope.loading=true;},
					success: function(result) {$rootScope.loading=false;
						$scope.datas = JSON.parse(result);
					}
				});
			}
			$scope.getlistTicketszonalaproved = function(alias) {
				$.ajax({
					type: 'POST',
					url: 'services/zonalApprovedTickets',
					data: 'site_id=' + alias.site_id+'&x='+ readCookie('emp_alias'),
					cache: false,
					async: false,
					error: function(result) {
						/*alert('error occured');*/
					},
					beforeSend:function(result){$rootScope.loading=true;},
					success: function(result) {$rootScope.loading=false;
						$scope.ticketList = JSON.parse(result);
					}
				});
			}
			$scope.faultycellsDetails = function(alias) {
				$rootScope.loading=true;
				$timeout(function(){
					$.ajax({
						type: 'POST',
						url: 'services/inventory/faultycellsDetails',
						data: 'ticketID=' + alias+'&x='+ readCookie('emp_alias'),
						cache: false,
						async: false,
						error: function(result) {
							/*alert('error occured');*/
						},
						beforeSend:function(result){$rootScope.loading=true;},
						success: function(result) {//$rootScope.loading=false;
							$scope.datas = JSON.parse(result);
						}
					});
				},300);
			}
		}])
		.controller("scrapcellsbyemployee", ["$scope", "$rootScope", function($scope,$rootScope) {
			var from_wh=$('select[name="from_wh"]').val();
			ajaxsingleViews(readCookie('emp_alias'), "services/scrapcellsget?from_wh="+from_wh, $scope,$rootScope);
		}]).controller("mrf_nhsapproved", ["$scope", function($scope){
			var from_wh=$('select[name="from_wh"]').val();
			depend_drop("services/inventory/mrf_nhsapproved?x="+readCookie('emp_alias')+"&from_wh="+from_wh,"","",$scope);
		}]).controller("sjolist", ["$scope", function($scope){
			depend_drop("services/inventory/sjolist","","",$scope);
		}]).controller("ticketsList_mi", ["$scope", function($scope){
			var to_wh=$('select[name="to_wh"]').val();
			depend_drop("services/inventory/ticketsList_mi?x="+readCookie('emp_alias')+"&to_wh="+to_wh,"","",$scope);
		}]).controller("ticketsList_mo", ["$scope", function($scope){
			var from_wh=$('select[name="from_wh"]').val();
			depend_drop("services/inventory/ticketsList_mo?x="+readCookie('emp_alias')+"&from_wh="+from_wh,"","",$scope);
		}]).controller("buffersjolist", ["$scope", function($scope){
			var from_wh=$('select[name="from_wh"]').val();
			depend_drop("services/inventory/buffersjolist?x="+readCookie('emp_alias')+"&from_wh="+from_wh,"","",$scope);
		}]).controller("buffersjolist_scrp", ["$scope", function($scope){
			
			
			/*var ticket_site_alias="",from_wh="",from_type="";
			from_wh=$('select[name="to_wh"]').val();
			from_type=$('select[name="materialToType"]').val();
			if(from_type!=='' && from_type!==null && from_type!==undefined){
				if(from_type=='1' || from_type=='2')ticket_site_alias=$('select[name="ref_no"]').val(); //ticket_alias //site_alias
			}depend_drop("services/inventory/buffersjolist_scrp_full?x="+readCookie('emp_alias')+"&in_out=in&from_wh="+from_wh+"&ticket_site_alias="+ticket_site_alias+"&from_type="+from_type,"","",$scope);
			$scope.outstand_sent=function(){
				$scope.outstand_count=$("select[name='main_sjo_number']").find(':selected').attr('data-count');
			}
			*/
			
			
			var from_wh=$('select[name="to_wh"]').val();
			depend_drop("services/inventory/buffersjolist_scrp?x="+readCookie('emp_alias')+"&from_wh="+from_wh,"","",$scope);
			$scope.outstand_sent=function(){
				$scope.outstand_count=$("select[name='buffer_sjo']").find(':selected').attr('data-count');
			}
			
			
			
		}]).controller("buffersjolist_scrp_full_out", ["$scope", function($scope){
			var from_wh=$('select[name="from_wh"]').val();			
			depend_drop("services/inventory/buffersjolist_scrp_full?x="+readCookie('emp_alias')+"&in_out=out&from_wh="+from_wh,"","",$scope);
		}]).controller("buffersjolist_scrp_full_in", ["$scope", function($scope){
			var ticket_site_alias="",from_wh="",from_type="";
			from_wh=$('select[name="to_wh"]').val();
			from_type=$('select[name="materialToType"]').val();
			if(from_type!=='' && from_type!==null && from_type!==undefined){
				if(from_type=='1' || from_type=='2')ticket_site_alias=$('select[name="ref_no"]').val(); //ticket_alias //site_alias
			}depend_drop("services/inventory/buffersjolist_scrp_full?x="+readCookie('emp_alias')+"&in_out=in&from_wh="+from_wh+"&ticket_site_alias="+ticket_site_alias+"&from_type="+from_type,"","",$scope);
			$scope.outstand_sent=function(){
				$scope.outstand_count=$("select[name='main_sjo_number']").find(':selected').attr('data-count');
			}
		}]).controller("sjoFullListforScrap", ["$scope", function($scope){
			var from_wh=$('select[name="from_wh"]').val();
			depend_drop("services/inventory/sjoFullListforScrap?x="+readCookie('emp_alias')+"&from_wh="+from_wh,"","",$scope);
		}]).controller("siteList_mi", ["$scope", function($scope){
			var to_wh=$('select[name="to_wh"]').val();
			depend_drop("services/inventory/siteList_mi?x="+readCookie('emp_alias')+"&to_wh="+to_wh,"","",$scope);
		}]).controller("mrfList_mi", ["$scope", function($scope){
			var to_wh=$('select[name="to_wh"]').val();
			depend_drop("services/inventory/mrfList_mi?x="+readCookie('emp_alias')+"&to_wh="+to_wh,"","",$scope);
		}]).controller("whfList_mi", ["$scope", function($scope){
			depend_drop("services/inventory/whfList_mi","","",$scope);
		}])
		//By Jagan
		.controller("activityComplaintCntrl", ["$scope", "$modal", "$mdDialog","$rootScope", function($scope, $modal, $mdDialog,$rootScope) {
			var datef = new Date();
			$scope.date ={value: datef.getDate()+'-'+(datef.getMonth()+1)+'-'+datef.getFullYear()};
			$scope.activitychange=function(){
				$scope.this_act_type=$("#Activity").find(':selected').attr('data-type');
				var site_obj = $rootScope.site_obj;
				if(site_obj!=null && site_obj!=undefined && site_obj!='')dddd(site_obj,$scope,$rootScope,$mdDialog);
			}
			$scope.autotickets = function(alias) { $rootScope.site_obj=alias;
				if (alias.site_alias == "Add to Site Master") {
					$scope.modalAnim = "modalRapid";
					$scope.$close();
					modelpopup("includes/sitemaster/sitemaster_add.php","lg",$modal,$scope);
				} else dddd(alias,$scope,$rootScope,$mdDialog);
			}
			$scope.person = {};
			$scope.sitemasterlist = function(alias,seg_alias) {
				$.ajax({
					type: 'POST',
					url: 'services/tickets/ticket_autocomplete',
					data: 'alias=' + alias+'&seg_alias=' + seg_alias+'&emp_alias='+readCookie('emp_alias'),
					cache: false,
					async: false,
					//error: function(result) {},
					beforeSend:function(result){$rootScope.loading=true;},
					success: function(result) {$rootScope.loading=false;
						$scope.datas = JSON.parse(result);
					}
				});
			}
			depend_drop("services/activity_drop", "services/activity_complaint_drop", "", $scope);
		}]).controller("onlineticketsCtrl", ["$scope", "$mdDialog","$rootScope", function($scope, $mdDialog,$rootScope) {
			var datef = new Date();
			$scope.date ={value: datef.getDate()+'-'+(datef.getMonth()+1)+'-'+datef.getFullYear()};
			$scope.onlinetickets = function(alias) {
				if (alias.site_id == "Add Manually") {
					window.location = base_url + '#/onlinetickets';
				} else {
					$scope.sit = {
						"alias": alias.site_id
					};
					// dialog demo
					if(alias.site_status){
						ajaxsingleViews(alias.site_id, "services/sitemaster/sitemaster", $scope,$rootScope);
					}else{
						var confirm = $mdDialog.confirm()
						.title('Selected site ID '+alias.site_id+' is out of warranty!')
						.content('Would you like to continue?')
						.ariaLabel('Lucky day')
						.ok('Continue!')
						.cancel('Cancel');
						//.targetEvent(ev);
						$mdDialog.show(confirm).then(function() {
							ajaxsingleViews(alias.site_id, "services/sitemaster/sitemaster", $scope,$rootScope);	
							$scope.alert = 'OK';
						}, function() {
							$scope.alert = 'Not OK';
						});
					}
				}
			}
			$scope.person = {};
			$scope.sitemasterlist = function(alias) {
				$.ajax({
					type: 'POST',
					url: 'services/tickets/onlineTickets',
					data: 'alias=' + alias+'&emp_alias='+readCookie('emp_alias'),
					cache: false,
					async: false,
					error: function(result) {/* alert('error occured'); */},
					beforeSend:function(result){$rootScope.loading=true;},
					success: function(result) {$rootScope.loading=false;
						$scope.sitemasterlists = JSON.parse(result);
					}
				});
			}
			depend_drop("services/activity_drop", "services/activity_complaint_drop", "", $scope);
		}])//customer
		.controller("activityCompCustCntrl", ["$scope", "$mdDialog", "$rootScope", function($scope, $mdDialog, $rootScope) {
			var datef = new Date();
			$scope.date ={value: datef.getDate()+'-'+(datef.getMonth()+1)+'-'+datef.getFullYear()};
			$scope.autotickets1 = function(alias) {
				if (alias.site_alias == "No Results Found") {
				} else {
					$scope.sit = {
						"alias": alias.site_alias
					};
					// dialog demo
					if(alias.site_status){
						ajaxsingleViews(alias.site_alias, "services/sitemaster/sitemaster", $scope,$rootScope);
					}else{
						var confirm = $mdDialog.confirm()
						.title('Selected site ID '+alias.site_id+' is out of warranty!')
						//.content('Would you like to continue?')
						.ariaLabel('Lucky day')
						.ok('OK');
						//.cancel('Cancel');
						//.targetEvent(ev);
						$mdDialog.show(confirm).then(function() {
							ajaxsingleViews('', "services/sitemaster/sitemaster", $scope,$rootScope);	
							$scope.sit={'alias':'NA'};
							$scope.alert = 'OK';
						}, function() {
							$scope.alert = 'Not OK';
						});
					}
				}
			}
			$scope.person = {};
			$scope.sitemasterlist1 = function(alias){
				$.ajax({
					type: 'POST',
					url: 'services/customer/onlineTickets',
					data: 'alias=' + alias+'&emp_alias='+readCookie('emp_alias'),
					cache: false,
					async: false,
					error: function(result) {},
					beforeSend:function(result){$rootScope.loading=true;},
					success: function(result) {$rootScope.loading=false;
						$scope.datas = JSON.parse(result);
						var jso = JSON.parse(result);
						if (jso[0].site_status == "online")toast_msg($rootScope,"danger","Your Site ID is not available, Please Contact To 'ADMIN'",3000);
					}
				});
			}
			depend_drop("services/activity_drop", "services/activity_complaint_drop", "", $scope);
		}])
		//end customer
		.controller("activitycomMulDrop", ["$scope", function($scope){
			depend_drop("services/activity_drop","services/activity_complaint_mul_drop","",$scope);
			$scope.dep_drop_activity = function() {
				var activityalias=$('select[name="activity_alias[]"]').val();
				drop_down("services/activity_complaint_mul_drop", activityalias, $scope, 'second');
				$('select[name="complaint_alias[]"]')[0].sumo.unload();
			}
		}]).controller("zoneStateMulCntrl", ["$scope", function($scope){
			depend_drop("services/zone_drop","services/zone_state_mul_drop","services/state_whcode_mul_drop",$scope);
			$scope.dep_drop_mul = function() {
				var zonealias=$('select[name="zone_alias[]"]').val();
				drop_down("services/zone_state_mul_drop", zonealias, $scope, 'second');
				$('select[name="state_alias[]"]')[0].sumo.unload();
			}
			$scope.state_wh_mul = function(){
				var statealias=$('select[name="state_alias[]"]').val();
				drop_down("services/state_whcode_mul_drop", statealias, $scope, 'third');
				$('select[name="wh_alias[]"]')[0].sumo.unload();
			}
		}]).controller("segmentCustMuldropCntrl", ["$scope", function($scope){
			depend_drop("services/segment_drop","services/segment_cust_mul_drop","",$scope);
			$scope.dep_drop_mul = function() {
				var segalias=$('select[name="segment_alias[]"]').val();
				drop_down("services/segment_cust_mul_drop", segalias, $scope, 'second');
				$('select[name="customer_alias[]"]')[0].sumo.unload();
			}
		}]).controller("expzoneStateMulCntrl", ["$scope", function($scope){
			depend_drop("services/zone_mul_drop_export","services/zone_state_mul_drop_export","services/zone_state_district_mul_dropexport",$scope);
			$scope.dep_drop_mul_exp = function() {
				var zonealias=$('select[name="zone_alias[]"]').val();
				drop_down("services/zone_state_mul_drop_export", zonealias, $scope, 'second');
				$('select[name="state_alias[]"]')[0].sumo.unload();
			}	
			$scope.dep_drop_third = function() {
				var statealias=$('select[name="state_alias[]"]').val();
				drop_down("services/zone_state_district_mul_dropexport", statealias, $scope, 'third');
				$('select[name="district_alias[]"]')[0].sumo.unload();
			}
		}]).controller("expzoneWareMulCntrl", ["$scope", function($scope){
			depend_drop("services/zone_mul_drop_export","services/zone_ware_mul_drop_export","",$scope);
			$scope.dep_drop_mul_exp = function() {
				var zonealias=$('select[name="zone_alias[]"]').val();
				drop_down("services/zone_ware_mul_drop_export", zonealias, $scope, 'second');
				$('select[name="wh_alias[]"]')[0].sumo.unload();
			}
		}]).controller("stockcodeexpCtrl_cell", ["$scope", "$rootScope", function($scope, $rootScope) {
			var result = ajaxViews('', "services/stockexp_drop_downs?x=0&em_alias="+readCookie('emp_alias'), $scope,$rootScope);
		}]).controller("stockcodeCtrl_cell", ["$scope", function($scope) {
			depend_drop("services/stock_code_drop?x=0", "", "", $scope);
		}]).controller("warehousedropCtrl", ["$scope", function($scope) {
			depend_drop("services/warehouse_drop", "", "", $scope);
		}]).controller("warehouseEmpdropCtrl", ["$scope", function($scope) {
			drop_down("services/warehouse_emp_drop", readCookie('emp_alias'), $scope, 'first');
		}]).controller("warehousedropdepCtrl_t", ["$scope", function($scope) {
			depend_drop("services/warehouse_drop", "services/transit_mrf_drop?x="+readCookie('emp_alias'), "", $scope);
		}]).controller("productdropCntrl", ["$scope", function($scope){
			depend_drop("services/product_desc_drop","","",$scope);
		}]).controller("productbatteryratingdropCntrl", ["$scope", function($scope){
			depend_drop("services/product_battery_rating_drop","","",$scope);
		}]).controller("accessorydropCntrl", ["$scope","$rootScope", function($scope,$rootScope){
			depend_drop("services/accessory_desc_drop","","",$scope);
			$scope.acc_measur_change=function(key){
				var measurement = $("#measurement_"+key).find(':selected').attr('data');
				$('#qty_measure_'+key).html('Quantity'+(measurement!='' && measurement!=null && measurement!=undefined ? ' in ('+measurement+')' : ''));
			}
		}]).controller("faultycodedropCntrl", ["$scope", function($scope){
			depend_drop("services/faulty_code_drop","","",$scope);
		}]).controller("activitylistCtrl", ["$scope", function($scope) {
			depend_drop("services/activity_code_drop", "", "", $scope);
		}]).controller("zoneStateCntrl", ["$scope", function($scope) {
			depend_drop("services/zone_drop", "services/zone_state_drop", "services/state_district_drop", $scope);
		}]).controller("selectStateCntrl", ["$scope", function($scope) {
			depend_drop("services/state_drop", "", "", $scope);
		}]).controller("selectZoneCntrl", ["$scope", function($scope) {
			depend_drop("services/zone_drop", "", "", $scope);
		}]).controller("stateEmpCntrl", ["$scope", function($scope) {
			depend_drop("services/zone_drop", "services/zone_state_drop", "services/state_emp_drop", $scope);
		}]).controller("segmentdropCntrl", ["$scope", function($scope) {
			depend_drop("services/segment_drop", "", "", $scope);
		}]).controller("activitydropCntrl", ["$scope", function($scope) {
			depend_drop("services/activity_drop", "", "", $scope);
		}]).controller("leveldropCntrl", ["$scope", function($scope) {
			depend_drop("services/level_drop", "", "", $scope);
		}]).controller("selectShiftCntrl", ["$scope", function($scope) {
			depend_drop("services/shift_drop", "", "", $scope);
		}]).controller("mocDropCntrl", ["$scope", function($scope) {
			depend_drop("services/moc_drop", "", "", $scope);
			$scope.mochange=function(){
				$scope.this_text_show=$("#file_text").find(':selected').html();
				$scope.this_moc_file=$("#file_text").find(':selected').attr('data-file');
				$scope.this_moc_text=$("#file_text").find(':selected').attr('data-text');
			}
		}]).controller("segmentCustSiteCntrl", ["$scope","all_apiRoute","$rootScope", function($scope,all_apiRoute,$rootScope) {
			ajaxsingleViews('', "services/other_seg", $scope,$rootScope);
			/*all_apiRoute.getAll(base_url_2+'services/other_seg').then(function (response) {
				$scope.otherseg_alias = response.data.alias;
				$scope.otherseg_name=response.data.name;
			}, function(error){console.log("Error: " + error); });*/
			depend_drop2("services/segment_drop", "services/segment_cust_drop?all=1", "services/segment_sitetype_drop", $scope);
			$scope.dep_drop_product = function(alias) {
				all_apiRoute.getAll(base_url_2+'services/cust_product_mul_drop?alias='+alias).then(function (response) {
					$('select[name="product_alias"]')[0].sumo.unload();
					re_drop();
					$scope.productDrop = response.data;
				}, function(error){console.log("Error: " + error); });
			}
		}]).controller("segmentCustSitetypedropCntrl", ["$scope","all_apiRoute","$rootScope", function($scope,all_apiRoute,$rootScope) {
			ajaxsingleViews('', "services/other_seg", $scope,$rootScope);
			/*all_apiRoute.getAll(base_url_2+'services/other_seg').then(function (response) {
				$scope.otherseg_alias = response.data.alias;
				$scope.otherseg_name=response.data.name;
			}, function(error){console.log("Error: " + error); });*/
			depend_drop2("services/segment_drop", "services/segment_cust_drop", "services/segment_sitetype_drop", $scope);
			$scope.dep_drop_product = function(alias) {
				all_apiRoute.getAll(base_url_2+'services/cust_product_mul_drop?alias='+alias).then(function (response) {
					$('select[name="product_alias"]')[0].sumo.unload();
					re_drop();
					$scope.productDrop = response.data;
				}, function(error){console.log("Error: " + error); });
			}
		}]).controller("CustproductdropCntrl", ["$scope", function($scope) {
			depend_drop("services/cust_product_mul_drop", "", "", $scope);
		}]).controller("designationdropCntrl", ["$scope", function($scope) {
			depend_drop("services/designation_drop", "", "", $scope);
		}])
		.controller("measurementdropCntrl", ["$scope", function($scope) {
			$scope.measurementdrop = [ //If change any drop value please update existed values in database.
				  {"name": "M"},
				  {"name": "PC"},
				  {"name": "ST"},
				  {"name": "OTHERS"}
			];
		}]).controller("assetmuldropCntrl", ["$scope", function($scope) {
			$scope.assets = [
				  {"name": "TOOLS"},
				  {"name": "ELECTRONICS"},
				  {"name": "OTHERS"}
			];
			depend_drop("services/asset_mul_drop","services/asset_make_mul_drop","services/asset_sno_mul_drop",$scope);
			$scope.dep_drop_mul = function() {
				var assetname=$('select[name="asset_type[]"]').val();
				drop_down("services/asset_mul_drop", assetname, $scope, 'first');
				$('select[name="asset_name[]"]')[0].sumo.unload();
			}
			$scope.asset_make_drop = function() {
				var assetmake=$('select[name="asset_name[]"]').val();
				drop_down("services/asset_make_mul_drop", assetmake, $scope, 'second');
				$('select[name="asset_make[]"]')[0].sumo.unload();
			}
			$scope.asset_sno_drop = function() {
				var assetsno=$('select[name="asset_make[]"]').val();
				drop_down("services/asset_sno_mul_drop", assetsno, $scope, 'third');
				$('select[name="asset_alias[]"]')[0].sumo.unload();
			}
		}])
		.controller("dprdropCntrl", ["$scope", function($scope) {
			depend_drop("services/event_dpr", "", "", $scope);
		}]).controller("empdropCntrl", ["$scope", function($scope) {
			depend_drop("services/mulempdrop", "", "", $scope);
		}])
		
		.controller("departmentdropCntrl", ["$scope", function($scope) {
			depend_drop("services/department_drop", "", "", $scope);
		}]).controller("emproledropCntrl", ["$scope", function($scope) {
			depend_drop("services/employeerole_drop", "", "", $scope);
		}]).controller("emproledropPlannerCntrl", ["$scope", function($scope) {
			depend_drop("services/inventory/emprolenamelist_planner", "", "", $scope);
		}]).controller("employeelistDropctrl", ["$scope", function($scope){
			depend_drop("services/employee_list_drop","","",$scope);
		}]).controller("empstatusdropCntrl", ["$scope", function($scope) {		
			$scope.statusDrop = [{
				"name": 'WORKING'
			}, {
				"name": 'RESIGNED'
			},{
				"name": 'RELIEVED'
			},{
				"name": 'DELETED'
			}];
		}]).controller("imeiactdropCntrl", ["$scope", function($scope) {
			$scope.imeiactDrop = [{
				"name": 'INACTIVE DEVICES', "alias" : "INACTIVE"
			}, {
				"name": 'ACTIVE DEVICES', "alias" : "ACTIVE"
			}];
		}]).controller("privilagesdropCntrl", ["$scope", function($scope) {
			depend_drop("services/privilage_drop", "", "", $scope);
		}]).controller("customerdropCntrl", ["$scope", function($scope) {
			depend_drop("services/customer_drop", "", "", $scope);
		}]).controller("segment_customerdropCntrl", ["$scope", function($scope) {
			depend_drop("services/customer_drop", "", "", $scope);
		}]).controller("milestoneDropCtrl", ["$scope", function($scope) {
			depend_drop("services/milestone_drop", "", "", $scope);
		}]).controller("escanameDropCtrl", ["$scope","$rootScope", function($scope,$rootScope) {
			depend_drop("services/esca_name_drop", "", "", $scope);
			$scope.zone_state = function(escas){
				$.ajax({
					type: 'POST',
					url: base_url_2 + "services/settings/esca_view",
					data: "emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token') + "&ip_addr=" + readCookie('ip_addr') + "&alias=" + escas,
					cache: false,
					async: false,
					error: function(result) {/* alert('error occured'); */},
					beforeSend:function(result){$rootScope.loading=true;},
					success: function(result) {$rootScope.loading=false;$scope.zoneStates = JSON.parse(result);}
				});
			}
		}]).controller("escaservicedropCtrl", ["$scope", function($scope) {
			depend_drop("services/esca_service_drop", "", "", $scope);
		}]).controller("profileCtrl", ["$scope","$rootScope", function($scope,$rootScope) {
			ajaxsingleViews1(readCookie('emp_alias'), "services/profile_view",$rootScope,$rootScope);
			$rootScope.adminProfile=(readCookie('employee_type')== '0' ? 'javascript:;' : '#/Profile');
			$rootScope.adminProfileDis=(readCookie('employee_type')== '0' ? 'disabled' : '');
		}]).controller("profileViewCtrl", ["$scope","$route","$rootScope", function($scope, $route, $rootScope){
			profilepic_upload($scope,$route,$rootScope);
			ajaxsingleViews(readCookie('emp_alias'), "services/employeemaster/employeemaster_single_view", $scope,$rootScope);
		}]).controller("sjolist", ["$scope", function($scope){
			depend_drop("services/inventory/sjolist","","",$scope);
		}]).controller("fromToDateCtrl", ["$scope", function($scope){
			$scope.fromtocal = function(fromDate,toDate){
				var fromDate=$('input[name="from_date"]').val().split('-');
				var toDate=$('input[name="to_date"]').val();
				$scope.dateDiff=fromDate['1']+'-'+fromDate['0']+'-'+fromDate['2'];
			}
		}])
		.controller("warrantycalCtrl", ["$scope","$rootScope", function($scope,$rootScope) {
			$scope.manfdatescal = function(cust,svdate,idate){
				if(cust=='warr' && svdate=='warr' && idate=='warr'){
					var cust=$('select[name="customer_alias"]').val();
					var svdate=$('input[name="sale_invoice_date"]').val().split('-');
					var idate=$('input[name="install_date"]').val();
					$scope.pr=svdate['1']+'-'+svdate['0']+'-'+svdate['2'];
				}
				if(cust=="" || svdate==""){
					toast_msg($rootScope,"danger","Please "+(cust=="" ? "Select a Customer" : "")+(cust==""&&svdate=="" ? " and " : "")+(svdate=="" ? "Choose Sale Invoice Date" : ""),3000);
					$scope.mafdates ='';
				}
				else{
					$.ajax({
						type: 'POST',
						url: base_url_2 + "services/sitemaster/sitemanfdate",
						data: "customer=" + cust + "&svdate=" + svdate + "&idate=" + idate,
						cache: false,
						async: false,
						error: function(result) {
							/* alert('error occured'); */
						},
						beforeSend:function(result){$rootScope.loading=true;},
						success: function(result) {$rootScope.loading=false;$scope.mafdates = JSON.parse(result);}
					});

				}		
			}
			/*function datefor(a){
				var date = new Date(a);
				var dd = date.getDate();
				var mm = date.getMonth()+1;
				var yyyy = date.getFullYear();
				
				if(dd<10){dd='0'+dd}
				if(mm<10){mm='0'+mm}
				return mm + '-' + dd + '-' + yyyy ;
			}*/
		}])
		.controller("employeenameDropCtrl", ["$scope", function($scope) {
			depend_drop("services/employeerole_drop", "", "", $scope);
			$scope.dep_drop_mul = function() {
				var rolealias=$('select[name="role_alias[]"]').val();
				drop_down("services/role_employee_mul_drop", rolealias, $scope, 'second');
				$('select[name="employee_alias[]"]')[0].sumo.unload();
			}
			$scope.dep_drop_mul_all = function() {
				var rolealias=$('select[name="role_alias[]"]').val();
				drop_down("services/role_employee_mul_drop_all", rolealias, $scope, 'second');
				$('select[name="employee_alias[]"]')[0].sumo.unload();
			}
		}])
		.controller("roleEmpDropCtrl", ["$scope", function($scope) {
			depend_drop("services/employeerole_drop", "", "", $scope);
			$scope.role_emp_mul = function() {
				var rolealias=$('select[name="role_alias1[]"]').val(); 
				drop_down("services/role_employee_mul_drop", rolealias, $scope, 'second');
				$('select[name="employee_alias1[]"]')[0].sumo.unload();
			}
			$scope.role_emp_mul_all = function() {
				if(typeof $scope.detailEvents != 'undefined' && typeof $scope.detailEvents.role_alias != 'undefined') {
					var rolealias = $scope.detailEvents.role_alias;
				} else {
					var rolealias = $('select[name="role_alias1[]"]').val();
				}
				drop_down("services/role_employee_mul_drop_all", rolealias, $scope, 'second');
				if(typeof $('select[name="employee_alias1[]"]')[0].sumo != 'undefined')
					$('select[name="employee_alias1[]"]')[0].sumo.unload();
			}
				
		}])
		.controller("notificationsCtrl", ["$scope","$interval","$rootScope", function($scope,$interval,$rootScope){ $scope.ng_show = true;
			$.ajax({
					type: 'POST',
					url: base_url_2 + "services/notifications/notifications_view",
					data: "emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token') + "&ip_addr=" + readCookie('ip_addr'),
					cache: false,
					async: false,
					error: function(result) {/* alert('error occured'); */},
					success: function(result) {
						$scope.notificationsView = JSON.parse(result);
						$scope.notifLimit = 10;
				   }
				});
			$scope.notifInterval=function(){
				$.ajax({
					type: 'POST',
					url: base_url_2 + "services/notifications/notifications_view",
					data: "emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token') + "&ip_addr=" + readCookie('ip_addr'),
					cache: false,
					async: false,
					error: function(result) {/* alert('error occured'); */},
					success: function(result) {$scope.notificationsView = JSON.parse(result);
						$scope.notifLimit = 10;
				   }
				});
			}
			$interval( function(){ $scope.notifInterval(); $scope.ng_show = true; }, 60000);
			$scope.viewNotifi=function(){ajaxsingleViews('', "services/notifications/notification_chng", $scope,$rootScope);$scope.ng_show = false;};
			
		}])
		.controller("lockScreenCtrl", ["$rootScope","$scope", function($rootScope,$scope){
			$scope.lockScreen = function(){
				$.ajax({
					type: 'POST',
					url: base_url_2 + "services/lockAdd",
					data: "emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token') + "&ip_addr=" + readCookie('ip_addr'),
					cache: false,
					async: false,
					beforeSend:function(result){$rootScope.loading=true;},
					success: function(result){$rootScope.loading=false;
						if(result.trim()=='1'){
							lockScreen($scope);
							var pass=$('input[name="password"]').val('');
						}else toast_msg($rootScope,'danger','Lock Feature Disabled for You',3000);
					}
				});
			};
		}])
		.controller("passwordManagementCtrl", ["$rootScope","$scope", function($rootScope,$scope){
			$scope.userTypeChange = function(userType){
				switch(userType){
					case '1' : drop_down("services/esca_employeename_drop", "", $scope, 'first');break;
					case '2' : drop_down("services/esca_name_drop", "", $scope, 'first');break;
					case '3' : drop_down("services/customer_drop", "", $scope, 'first');break;
					default : $scope.firstDrop = [];
				}
				$('select[name="user_alias"]')[0].sumo.unload();
				setTimeout(function(){ $('.forms_add').find('.SumoSelect').addClass('singleSelect'); },0);
			}
		}])
}());

function depend_drop(first_path, second_path, third_path, $scope) {
	drop_down(first_path, '', $scope, 'first');
	$scope.dep_drop_asset_emp = function(alias) {
		drop_down(first_path, alias, $scope, 'first');
	}
	$scope.dep_drop = function(alias,name) {
		drop_down(second_path, alias, $scope, 'second');
		if(typeof name != 'undefined' && typeof $('select[name="'+name+'"]')[0].sumo != 'undefined') 
			$('select[name="'+name+'"]')[0].sumo.unload();
	}
	$scope.dep_drop2 = function(alias,name) {
		drop_down(third_path, alias, $scope, 'third');
		$('select[name="'+name+'"]')[0].sumo.unload();
	}
	$scope.role_emp_mul_all = function() {
		drop_down(first_path, alias, $scope, 'first');
	}
}

function depend_drop2(first_path, second_path, third_path, $scope) {
	drop_down(first_path, '', $scope, 'first');
	$scope.dep_drop = function(alias,name,name2) {
		drop_down(second_path, alias, $scope, 'second');
		drop_down(third_path, alias, $scope, 'third');
		$('select[name="'+name+'"]')[0].sumo.unload();
		$('select[name="'+name2+'"]')[0].sumo.unload();
	}
}! function() {
	"use strict";
	angular.module("app.ui.directives", [])
}();

function setCookie(e, t, a) {
	var o = new Date;
	o.setDate(o.getDate() + a);
	var n = escape(t) + (null == a ? "" : "; expires=" + o.toUTCString()) + "; path=/";
	document.cookie = e + "=" + n
}

function readCookie(name) {
	name += '=';
	for (var ca = document.cookie.split(/;\s*/), i = ca.length - 1; i >= 0; i--)
		if (!ca[i].indexOf(name)) return ca[i].replace(name, '');
}

function delCookie() {
	$.ajax({
		type: 'POST',
		url: base_url_2 + "services/logout",
		data: "emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token') + "&ip_addr=" + readCookie('ip_addr'),
		cache: false,
		async: false,
		error: function(result) {/* alert('error occured'); */},
		success: function(result) {
			/*$.cookie("emp_alias", null, { path: '/' });
			$.cookie("token", null, { path: '/' });
			$.cookie("employee_type", null, { path: '/' });
			$.cookie("ip_addr", null, { path: '/' });*/
			setCookie("emp_alias", "", -1);
			setCookie("ip_addr", "", -1);
			setCookie("token", "", -1);
			setCookie("employee_type", "", -1);
			console.log("Redirected to signin")
			window.location = base_url + "#/signin";		
		}
	});
}
function serializeToJson(formArray) {
	var obj = {};
	$.each(formArray, function(i, pair) {
		var cObj = obj,
			pObj, cpName;
		$.each(pair.name.split("."), function(i, pName) {
			pObj = cObj;
			cpName = pName;
			cObj = cObj[pName] ? cObj[pName] : (cObj[pName] = {});
		});
		pObj[cpName] = pair.value;
	});
	return obj;
}

function validateToken(token, $scope) {
	$.ajax({
		url: base_url_2 + "services/validate_token",
		type: "POST",
		data: "token=" + token,
		success: function(result) {
			var json = jQuery.parseJSON(result);
			if (json.ErrorDetails.ErrorCode == '0') {
				setCookie("emp_alias", json.token.user_auth, 1);
				setCookie("token", json.token.token, 1);
				setCookie("employee_type", json.token.employee_type, 1);
				setCookie("ip_addr", "ipAddr", 1);
				console.log("Redirecting to ", json.went1)
				window.location = base_url + json.went1;
			} else if (json.ErrorDetails.ErrorCode > '0') {
				toast_msg($scope,'danger',json.ErrorDetails.ErrorMessage,3000);
			}
		}
	});
}

function loginCall(data, url, went, $scope, $rootScope, $route) {
	$.ajax({
		url: base_url_2 + url,
		type: "POST",
		data: data,
		success: function(result) {
			var json = jQuery.parseJSON(result);
			if (json.ErrorDetails.ErrorCode == '0') {
				setCookie("emp_alias", json.token.user_auth, 1);
				setCookie("token", json.token.token, 1);
				setCookie("employee_type", json.token.employee_type, 1);
				//$.getJSON("https://jsonip.com?callback=?", function (data){ setCookie("ip_addr", data.ip, 1); });
				window.location = base_url + json.went1;
				//window.location.reload();
				//$route.reload();
			} else if (json.ErrorDetails.ErrorCode > '0') {
				toast_msg($rootScope,'danger',json.ErrorDetails.ErrorMessage,3000);
			}
		}
	});
}

function checkLogin(emp_alias, token, ip_addr, $scope) {
	if (emp_alias != null && token != null && ip_addr != null && emp_alias != '0' && token != '0' && ip_addr != '0') {
		$.ajax({
			url: base_url_2 + "services/checklogin",
			type: "POST",
			data: "emp_alias=" + emp_alias + "&token=" + token + "&ip_addr=" + ip_addr,
			success: function(result){
				console.log("Redirected to signin")
				"3"==result.trim()?lockScreen($scope):result.trim()>"0"&&(window.location=base_url+"#/signin");
			}
		});
	} else {
		console.log("Redirected to signin")
		window.location = base_url + '#/signin';
	}
}
function ajaxpost(data, url, went, $scope, $route, $rootScope) {
	$.ajax({
		url: base_url_2 + url,
		type: "POST",
		data: data,
		processData: false,
		contentType: false,
		error: function(result) {$rootScope.loading=false;toast_msg($rootScope,'danger','Request failed, Contact Admin',5000);console.log(result);},
		beforeSend:function(result){$rootScope.loading=true;},
		success: function(result) { $rootScope.loading=false;
			var json = jQuery.parseJSON(result);
			console.log(json);
			if (json.ErrorDetails.ErrorCode == '0') { $(".sendMail").hide();
				if(url!='services/employeemaster/profile_upload' && url!='services/tickets/online_ticket_add' && url!='services/tickets/mail_send' && url!='services/forgot' && url!='services/change_password' && url!='services/password_management' && url!='services/settings/tree_add_update_disable')$scope.$close();
				if(json.ErrorDetails.ErrorMessage=='export')window.location='exports/'+json.file_name+'.xlsx';
				else{
					if(url === 'services/password_management'){
						$('#adminPwdModal').modal('hide');
						$(".modal-backdrop").remove();
						//window.reload();
  					}
					//$fg = (url=='services/tickets/online_ticket_add' ? $rootScope : $scope);
					toast_msg($rootScope,'success',json.ErrorDetails.ErrorMessage,3000);
					if(url!='services/tickets/mail_send' && url!='services/settings/privacy_policy_update'){
						if(url.indexOf("efsr_services.php") !== -1 )angular.element('.ion-android-close').click();
						else {window.location = went; $route.reload();}
					}
				}
			} else if(json.ErrorDetails.ErrorCode > '0') {$(".sendMail").show(); //alert(json.ErrorDetails.ErrorMessage);
				//$fg = (url=='services/tickets/online_ticket_add' ? $rootScope : $scope);
				toast_msg($rootScope,'danger',json.ErrorDetails.ErrorMessage,3000);
				$('button[type="submit"], input[type="submit"]').removeAttr('disabled','disabled');
			}
		}
	});
}
function ajaxDelete(data, url, went, $scope, $route, $rootScope) {
	$.ajax({
		url: base_url_2 + url,
		type: "POST",
		data: data,
		processData: false,
		contentType: false,
		error: function(result) {$rootScope.loading=false;toast_msg($rootScope,'danger','Request failed, Contact Admin',5000);console.log(result);},
		beforeSend:function(result){$rootScope.loading=true;},
		success: function(result) { $rootScope.loading=false;
			var json = jQuery.parseJSON(result);
			if (json.ErrorDetails.ErrorCode == '0') {$(".sendMail").hide();
				if(url!='services/employeemaster/profile_upload' && url!='services/tickets/online_ticket_add' && url!='services/tickets/mail_send' && url!='services/forgot' && url!='services/change_password' && url!='services/password_management' && url!='services/settings/tree_add_update_disable')
					$(".close").click();
				if(json.ErrorDetails.ErrorMessage=='export')window.location='exports/'+json.file_name+'.xlsx';
				else{
					if(url === 'services/password_management'){
						$('#adminPwdModal').modal('hide');
						$(".modal-backdrop").remove();
  					}
					toast_msg($rootScope,'success',json.ErrorDetails.ErrorMessage,3000);
					if(url!='services/tickets/mail_send' && url!='services/settings/privacy_policy_update'){
						if(url.indexOf("efsr_services.php") !== -1 )angular.element('.ion-android-close').click();
						else {window.location = went; $route.reload();}
					}
				}
			} else if(json.ErrorDetails.ErrorCode > '0') {
				$(".sendMail").show();
				toast_msg($rootScope,'danger',json.ErrorDetails.ErrorMessage,3000);
				$('button[type="submit"], input[type="submit"]').removeAttr('disabled','disabled');
			}
		}
	});
}
function ajaxpost_finance(data, url, went, $route, $rootScope) {
	$rootScope.loading=true;
	setTimeout(function(){
		$.ajax({
			url: base_url_2 + url,
			type: "POST",
			data: data,
			cache: false,
			async: false,
			error: function(result) {$rootScope.loading=false;toast_msg($rootScope,'danger','Request failed, Contact Admin',3000);console.log(result);},
			beforeSend:function(result){$rootScope.loading=true;},
			success: function(result) { $rootScope.loading=false;
				var json = jQuery.parseJSON(result);
				toast_msg($rootScope,(json.ErrorCode == '0' ? "success" : "danger"),json.ErrorMessage,3000);
				if(json.ErrorCode == '0')window.location = went;$route.reload();
			}
		});
	},300);
}
function lockScn(data, url, $scope) {
	$.ajax({
		url: base_url_2 + url,
		type: "POST",
		data: data,
		processData: false,
		contentType: false,
		error: function(result) {/*alert("error occured");*/},
		success: function(result) {
			var json = jQuery.parseJSON(result);
			if (json.ErrorDetails.ErrorCode == '0') {
				$("#lockscreen").css("display", "none");
				$('#screen').css("display", "none");
				$('body').css({"overflow":"auto"});
			} else if (json.ErrorDetails.ErrorCode > '0') toast_msg($scope,'danger',json.ErrorDetails.ErrorMessage,3000);
		}
	});
}
/* function drop_down(url, alias, $scope, help) {
	$.ajax({
		type: 'POST',
		url: base_url_2 + url,
		data: 'alias=' + alias,
		cache: false,
		async: false,
		//error: function(result) { alert('error occured'); },
		success: function(result) { re_drop();
			switch (help) {
				case 'first': $scope.firstDrop = JSON.parse(result); break
				case 'second': $scope.secondDrop = JSON.parse(result); break
				case 'third': $scope.thirdDrop = JSON.parse(result); break
			}
		}
	});
} */
function drop_down(url, alias, $scope, help) {

	if(url == '' || typeof url == 'undefind')
		return;
	//setTimeout(function(){ $(".loadingg").show(); },0);
	$.ajax({
		//beforeSend: function(e) { $(".loadingg").show(); },
		//complete:function() { $(".loadingg").hide(); },
		type: 'POST',
		url: base_url_2 + url,
		data: "alias="+alias + "&emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token') + "&ip_addr=" + readCookie('ip_addr'),
		cache: false,
		async: false,
		//error: function(result) { console.log(result); },
		success: function(result) {
			//setTimeout(function(){ $(".loadingg").hide(); },1000);
			re_drop();
			switch (help) {
				case 'first': $scope.firstDrop = JSON.parse(result); break
				case 'second': $scope.secondDrop = JSON.parse(result); break
				case 'third': $scope.thirdDrop = JSON.parse(result); break
			}
			window.$scope = $scope;
		}
	});
}
function re_drop(){
	setTimeout(function(){
		$('.testSelAll2').SumoSelect();
		$('.testSelAll3').SumoSelect({selectAll:true});
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
				$(this).siblings('.select-all').addClass('hidden');
		   }else{
				$(this).siblings('.options').find('.no_rec').remove(); 
				$(this).siblings('.select-all').removeClass('hidden');
		   };
		   $('.forms_add').find('.SumoSelect').addClass('singleSelect');
		});
	},0);
}
function at_ic_act_check(act_alias,site_alias, url) {
	if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('ip_addr') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0' && readCookie('ip_addr') != '0') {
		var res = $.ajax({
			type: 'POST',
			url: base_url_2 + url,
			data: "emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token') + "&ip_addr=" + readCookie('ip_addr') + "&act_alias=" + act_alias + "&site_alias=" + site_alias,
			cache: false,
			async: false,
		});
		return res.responseText;
	}else return false;
}
function eeee(act_name,site_alias,$scope,$rootScope,$mdDialog){
	var confirm = $mdDialog.confirm()
	.title('Selected Activity is already exist!')
	.content('Would you like to continue? If yes, Please fill "Remarks"')
	.ariaLabel('Lucky day')
	.ok('Continue!')
	.cancel('Cancel');
	$mdDialog.show(confirm).then(function() {
		ajaxsingleViews(site_alias, "services/sitemaster/sitemaster", $scope,$rootScope);
		$scope.at_ic_enable = true;
		$scope.alert = 'OK';
	}, function(){
		$scope.singleViews=$scope.sit_alias='';
		$scope.at_ic_enable = false;
		$scope.alert = 'Not OK';
	});
}

function dddd(site_obj,$scope,$rootScope,$mdDialog){
	var type=$("#Activity").find(':selected').attr('data-type');
	var act_alias=$("#Activity").find(':selected').val();
	var act_name=$("#Activity").find(':selected').html();
	var site_alias = site_obj.site_alias;
	$scope.sit_alias = site_alias;
	$.ajax({
		type: 'POST',
		url: base_url_2+'services/site_warranty_check',
		data: "alias=" + site_alias,
		cache: false,
		async: false,
		beforeSend:function(result){$rootScope.loading=true;},
		success: function(result) { $rootScope.loading=false;
			var site_status = JSON.parse(result);
			if(site_status){
				if(type=='0'){
					var at_ic = at_ic_act_check(act_alias,site_alias,"services/at_ic_check");
					if(at_ic==1)ajaxsingleViews(site_alias, "services/sitemaster/sitemaster", $scope,$rootScope);
					else eeee(act_name,site_alias,$scope,$rootScope,$mdDialog);
				}else ajaxsingleViews(site_alias, "services/sitemaster/sitemaster", $scope,$rootScope);
			}else{
				var confirm = $mdDialog.confirm()
				.title('Selected site ID '+site_obj.site_id+' is out of warranty!')
				.content('Would you like to continue? If yes, Please fill "Remarks"')
				.ariaLabel('Lucky day')
				.ok('Continue!')
				.cancel('Cancel');
				//.targetEvent(ev);
				$mdDialog.show(confirm).then(function() {
					if(type=='0'){
						var at_ic = at_ic_act_check(act_alias,site_alias,"services/at_ic_check");
						if(at_ic==1)ajaxsingleViews(site_alias, "services/sitemaster/sitemaster", $scope,$rootScope);
						else eeee(act_name,site_alias,$scope,$rootScope,$mdDialog);
					}else ajaxsingleViews(site_alias, "services/sitemaster/sitemaster", $scope,$rootScope);
					$scope.warranty_enable = true;
					$scope.alert = 'OK';
				}, function() {
					$scope.singleViews=$scope.sit_alias='';
					$scope.at_ic_enable = $scope.warranty_enable = false;
					$scope.alert = 'Not OK';
				});
			}
		}
	});
}
function reset_click($scope){
	$scope.initial = JSON.parse(JSON.stringify($scope.singleViews));
	$scope.reset_click = function(){
		$scope.singleViews = angular.copy($scope.initial);
	};
}
function ajaxsingleViews(alias, url, $scope, $rootScope, callbackFun = null) {
	if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('ip_addr') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0' && readCookie('ip_addr') != '0') {
		$.ajax({
			type: 'POST',
			url: base_url_2 + url,
			data: "emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token') + "&ip_addr=" + readCookie('ip_addr') + "&alias=" + alias,
			cache: false,
			async: false,
			error: function(result) {$rootScope.loading=false;toast_msg($rootScope,'danger','Request failed, Contact Admin',5000);console.log(result);},
			beforeSend:function(result){$rootScope.loading=true;},
			success: function(result) { $rootScope.loading=false;
				if (url == 'services/usertracking/usertracking_single_view_map')tracks = JSON.parse(result);
				else if (url == 'services/settings/privacy_policy_view')$scope.singleViews = JSON.parse(decodeURIComponent(result.replace(/\+/g, ' ')));
				else $scope.singleViews = JSON.parse(result);
				if(callbackFun != null) {
					var json = jQuery.parseJSON(result);
					callbackFun(json);
				}
			}
		});
	}
}
function menuItems(alias, url, $rootScope) {
	if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('ip_addr') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0' && readCookie('ip_addr') != '0') {
		$.ajax({
			type: 'POST',
			url: base_url_2 + url,
			data: "emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token') + "&ip_addr=" + readCookie('ip_addr') + "&alias=" + alias,
			cache: false,
			async: false,
			beforeSend:function(result){$rootScope.loading=true;},
			success: function(result) {$rootScope.loading=false;
				$rootScope.menuitems = JSON.parse(result);
			}
		});
	}
}
function ajaxsingleViews1(alias, url, $scope,$rootScope) {
	if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('ip_addr') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0' && readCookie('ip_addr') != '0') {
		$.ajax({
			type: 'POST',
			url: base_url_2 + url,
			data: "emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token') + "&ip_addr=" + readCookie('ip_addr') + "&alias=" + alias,
			cache: false,
			async: false,
			error: function(result) {$rootScope.loading=false;toast_msg($rootScope,'danger','Request failed, Contact Admin',5000);console.log(result);},
			beforeSend:function(result){$rootScope.loading=true;},
			success: function(result) { $rootScope.loading=false;
				if (url == 'services/usertracking/usertracking_single_view_map') {
					tracks = JSON.parse(result);
				} else {
					$scope.singleViews1 = JSON.parse(result);
				}
			}
		});
	}
}
//User Tracking Problem
function ajaxViews1(alias, url, $scope,$rootScope){
	if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('ip_addr') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0' && readCookie('ip_addr') != '0') {
		$.ajax({
			type: 'POST',
			url: base_url_2 + url,
			data: "emp_alias=" + readCookie('emp_alias') + "&token=" + readCookie('token') + "&ip_addr=" + readCookie('ip_addr') + "&alias=" + alias,
			cache: false,
			async: false,
			error: function(result) {$rootScope.loading=false;toast_msg($rootScope,'danger','Request failed, Contact Admin',5000);console.log(result);},
			beforeSend:function(result){$rootScope.loading=true;},
			success: function(result) {$rootScope.enerlod = false; $rootScope.loading=false;
				$scope.datasingle = JSON.parse(result);
			}
		});
	}
}
function ajaxViews(data, url, $scope,$rootScope) {
	if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('ip_addr') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0' && readCookie('ip_addr') != '0') {
		$.ajax({
			url: base_url_2 + url,
			type: "POST",
			data: data,
			beforeSend:function(result){
				$rootScope.loading=true;
			},
			error: function(result) {
				$rootScope.loading=false;
				toast_msg($rootScope,'danger','Request failed, Contact Admin',5000);
				console.log(result);
			},
			success: function(result) {
				$rootScope.enerlod = false;
				$rootScope.loading=false;
				$scope.datas = JSON.parse(result);
				if($scope.datas.ErrorCode == 1 || $scope.datas.ErrorCode == 2) {
					toast_msg($rootScope, "danger", $scope.datas.ErrorMessage, 5000);
					window.location = base_url + '#/signin';
				} else if ($scope.datas.ErrorCode == 0) {
					$rootScope.add = $scope.datas.add;
					$rootScope.export = $scope.datas.export;
				} else {
					if($scope.datas.ErrorDetails.ErrorCode == 1 || $scope.datas.ErrorDetails.ErrorCode == 2) {
						toast_msg($rootScope, "danger", $scope.datas.ErrorMessage, 5000);
						window.location = base_url + '#/signin';
					} else {
						$rootScope.add = $scope.datas.add;
						$rootScope.export = $scope.datas.export;
					}
				}
			}
		});
	} else {
		console.log("Redirected to signin")
		window.location = base_url + '#/signin';
	}
}
function ajaxImport(data, url, $scope, $rootScope) {
	if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('ip_addr') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0' && readCookie('ip_addr') != '0') {
		$rootScope.loading=true;
		setTimeout(function(){
			$.ajax({
				url: base_url_2 + url,
				type: "POST",
				data: data,
				cache: false,
				async: false,
				processData: false,
				contentType: false,
				error: function(result) {$rootScope.loading=false;toast_msg($rootScope,'danger','Request failed, Contact Admin',5000);console.log(result);},
				beforeSend:function(result){$rootScope.loading=true;},
				success: function(result) {
					var json=JSON.parse(result);
					$scope.datas =json;
					if(json.ErrorDetails.ErrorCode=='0'){var tp="success";}else{var tp="danger";$rootScope.loading=false;}
					toast_msg($rootScope,tp,json.ErrorDetails.ErrorMessage,15000);
				}
			});
		},300);
	}else {
		console.log("Redirected to signin")
		window.location = base_url + '#/signin';
	}
}
var arrrr=new Array();
var sing;
function dashViews(data, url, $scope, $rootScope) {
	if (readCookie('emp_alias') != null && readCookie('token') != null && readCookie('ip_addr') != null && readCookie('emp_alias') != '0' && readCookie('token') != '0' && readCookie('ip_addr') != '0') {
		$rootScope.loading=true;
		setTimeout(function(){
			$.ajax({
				url: base_url_2 + url,
				type: "POST",
				data: data,
				cache: false,
				async: false,
				processData: false,
				contentType: false,
				error: function(result) {/*alert("error occured");*/},
				beforeSend:function(result){$rootScope.loading=true;},
				success: function(result) {$rootScope.enerlod = false;$rootScope.loading=false;
					if(url=="services/dashboard/ticket_status" || url=="services/esca/ticket_status" || url=="services/customer/ticket_status"){$scope.datas = JSON.parse(result);}
					else {
						if(jQuery.inArray(url, arrrr) !== -1)sing.load( JSON.parse(result));
						else {
							$scope.td_info_show=url;
							setTimeout(function(){
								var sing = c3.generate( JSON.parse(result));
								if(url=='services/dashboard/today_info_report_block')$scope.extdata = JSON.parse(result);
							},100);
						}
						/*else{
							arrrr.push(url);
							sing = c3.generate( JSON.parse(result));
						}$scope.extdata = JSON.parse(result);*/
					}
				}
			});
		}, 100);
	} else {
		console.log("Redirected to signin")
		window.location = base_url + '#/signin';
	}
}
function toast_msg(rscope,type,msg,time){
	rscope.toasts = [{
		anim: "bouncyflip",
		type: type,
		msg: msg
	}];
	setTimeout(function(){
		rscope.toasts.splice(0, 1);
	}, time);
}
function profilepic_upload($scope, $route, $rootScope){
    var readURL = function(input) {
        if (input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.profile-pic').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".file-upload").on('change', function(){
		var data = new FormData($('.forms_add')[0]);
		data.append("emp_alias", readCookie('emp_alias'));
		data.append("token", readCookie('token'));
		data.append("ip_addr", readCookie('ip_addr'));
		var result=ajaxpost(data,"services/employeemaster/profile_upload","#/Profile", $scope, $route, $rootScope);
        readURL(this);
		//location.reload();
    });
    $(".upload-button").on('click', function() {
       $(".file-upload").click();
    });
	$rootScope.enerlod = false;
}
function lockScreen($scope){
	$("#lockscreen").css("display", "block");
	$('#screen').css({	"display": "block","height":$(document).height()});
	$('body').css({"overflow":"hidden"});
	$("#screen").css("width","100%")
	$('#box').click(function(){
		$("#lockscreen").css("display", "none");
		$('#screen').css("display", "none");
		$('body').css({"overflow":"auto"});
	});
	$("#lockscreen").bind('keyup keypress',function(e){	
		if(e.keyCode==113){ return false; }
	});
	/*document.onkeydown = function (event)
	{event = (event || window.event);
		 if (event.keyCode == 123 || event.keyCode == 116 || event.keyCode == 16 || event.keyCode == 17 || event.keyCode == 18 || event.keyCode == 82)
		 {return false;}
	}*/
}
/*function timerIncrement($scope) {
    idleTime = idleTime + 1;
    if (idleTime > 19) { // 20 minutes
        lockScreen($scope);
    }
}*/

function modelpopup(url,size,$modal,$scope){
	$modal.open({
		templateUrl: url,
		size: size,
		controller: "ModalDemoCtrl",
		resolve: function() {},
		windowClass: $scope.modalAnim, // Animation Class put here.
		keyboard: false,
		backdrop: 'static'
	});
}
function file_loading(files,$scope,$rootScope,type){
	var fileName=files[0].name;
	var file_ext=fileName.substr(fileName.lastIndexOf('.')+1);
	if(type=='pdf')var ext_arr=["pdf","PDF"];else if(type=='xls')var ext_arr=["xls","xlsx","XLS","XLSX"];else var ext_arr=[];
	if(ext_arr.indexOf(file_ext)!=-1){
		if((files[0].size)<5242880){
			$scope.prg_shw_hde=true;
			$scope.determinateValue = $scope.determinateValue2 = 0;//5242880
			var dv=0,size = Math.floor((files[0].size)/10000),
			set_int=setInterval(function(){
				$scope.determinateValue += 1;
				$scope.determinateValue2 += 1.5;
				dv=$scope.determinateValue;
				$scope.file_name=dv+"%";
				if(dv>100){clearInterval(set_int);$scope.file_name=fileName;$scope.prg_shw_hde=false;}
			}, size);
		}else{
			$scope.file_name='';
			angular.element("input[type='file']").val(null);
			$scope.determinateValue=100;
			toast_msg($rootScope,"danger","File size must be less than 5MB",3000);
		}
	}else{$scope.file_name='';
		angular.element("input[type='file']").val(null);
		$scope.determinateValue=100;
		toast_msg($rootScope,"danger","Invalid File..",3000);
	}
}
var settingsDetails = {
	'material_req' : {
		'redirectTo': '#/Materialrequest',
		'verifyUrl': 'services/inventory/material_request_check_delete_status',
		'formUrl': 'services/inventory/material_request_delete',
		'alias': 'mrf_alias'
	},
	'material_req_stock' : {
		'redirectTo': '#/Materialrequest',
		'verifyUrl': 'services/inventory/material_request_check_delete_status',
		'formUrl': 'services/inventory/material_request_delete',
		'alias': 'mrf_alias'
	},
	'material_inward' : {
		'redirectTo': '#/Materialinward',
		'verifyUrl': 'services/inventory/material_inward_check_delete_status',
		'formUrl': 'services/inventory/material_inward_delete',
		'alias': 'mrf_alias'
	},
	'material_outward' : {
		'redirectTo': '#/Materialoutward',
		'verifyUrl': 'services/inventory/material_outward_check_delete_status',
		'formUrl': 'services/inventory/material_outward_delete',
		'alias': 'mrf_alias'
	},
	'stocks' : {
		'redirectTo': '#/items_view',
		'verifyUrl': 'services/inventory/item_code_delete_check',
		'formUrl': 'services/inventory/item_code_delete',
		'alias': 'item_code_alias'
	},
	'mo_del_cell' : {
		'redirectTo': '#/Materialoutward',
		'verifyUrl': '',
		'formUrl': 'services/inventory/material_outward_item_delete',
		'alias': 'item_description_alias'
	},
	'accessories' : {
		'redirectTo': '#/settings/accessories/accessories_view',
		'verifyUrl': 'services/settings/accessories_check_delete_status',
		'formUrl': 'services/settings/accessories_delete',
		'alias': 'accessories_alias'
	},
	'assets' : {
		'redirectTo': '#/settings/assets/assets_view',
		'verifyUrl': 'services/settings/assets_check_delete_status',
		'formUrl': 'services/settings/assets_delete',
		'alias': 'asset_alias'
	},
	'complaints' : {
		'redirectTo': '#/settings/complaint/complaint_view',
		'verifyUrl': 'services/settings/ticket_complaint_check_delete_status',
		'formUrl': 'services/settings/ticket_complaint_delete',
		'alias': 'complaint_alias'
	},
	'customers' : {
		'redirectTo': '#/settings/customer/customer_view',
		'verifyUrl': 'services/settings/customer_check_delete_status',
		'formUrl': 'services/settings/customer_delete',
		'alias': 'customer_alias'
	},
	'departments' : {
		'redirectTo': '#/settings/department/department_view',
		'verifyUrl': 'services/settings/department_check_delete_status',
		'formUrl': 'services/settings/department_delete',
		'alias': 'department_alias'
	},
	'designations' : {
		'redirectTo': '#/settings/designation/designation_view',
		'verifyUrl': 'services/settings/designation_check_delete_status',
		'formUrl': 'services/settings/designation_delete',
		'alias': 'designation_alias'
	},
	'districts' : {
		'redirectTo': '#/settings/district/district_view',
		'verifyUrl': 'services/settings/district_check_delete_status',
		'formUrl': 'services/settings/district_delete',
		'alias': 'district_alias'
	},
	'dpr' : {
		'redirectTo': '#/settings/dpr/dpr_view',
		'verifyUrl': 'services/settings/dpr_check_delete_status',
		'formUrl': 'services/settings/dpr_delete',
		'alias': 'category_alias'
	},
	'emproles' : {
		'redirectTo': '#/settings/emprole/employeerole_view',
		'verifyUrl': 'services/settings/employee_role_check_delete_status',
		'formUrl': 'services/settings/employee_role_delete',
		'alias': 'role_alias'
	},
	'esca' : {
		'redirectTo': '#/settings/esca/esca_view',
		'verifyUrl': 'services/settings/esca_check_delete_status',
		'formUrl': 'services/settings/esca_delete',
		'alias': 'esca_alias'
	},
	'faultycode' : {
		'redirectTo': '#/settings/faultycode/faultcode_view',
		'verifyUrl': 'services/settings/faultycode_check_delete_status',
		'formUrl': 'services/settings/faultycode_delete',
		'alias': 'faulty_alias'
	},
	'milestone' : {
		'redirectTo': '#/settings/milestone/milestone_view',
		'verifyUrl': 'services/settings/milestone_check_delete_status',
		'formUrl': 'services/settings/milestone_delete',
		'alias': 'mile_stone_alais'
	},
	'moc' : {
		'redirectTo': '#/settings/moc/moc_view',
		'verifyUrl': 'services/settings/moc_check_delete_status',
		'formUrl': 'services/settings/moc_delete',
		'alias': 'moc_alias'
	},
	'privilege' : {
		'redirectTo': '#/settings/privilages/privilages_view',
		'verifyUrl': 'services/settings/privileges_check_delete_status',
		'formUrl': 'services/settings/privileges_delete',
		'alias': 'privilege_alias'
	},
	'sitetype' : {
		'redirectTo': '#/settings/sitetype/sitetype_view',
		'verifyUrl': 'services/settings/sitetype_check_delete_status',
		'formUrl': 'services/settings/sitetype_delete',
		'alias': 'site_type_alias'
	},
	'product' : {
		'redirectTo': '#/settings/product/product_view',
		'verifyUrl': 'services/settings/product_check_delete_status',
		'formUrl': 'services/settings/product_delete',
		'alias': 'product_alias'
	},
	'state' : {
		'redirectTo': '#/settings/state/state_view',
		'verifyUrl': 'services/settings/state_check_delete_status',
		'formUrl': 'services/settings/state_delete',
		'alias': 'state_alias'
	},
	'zone' : {
		'redirectTo': '#/settings/zone/zone_view',
		'verifyUrl': 'services/settings/zone_check_delete_status',
		'formUrl': 'services/settings/zone_delete',
		'alias': 'zone_alias'
	},
	'shift' : {
		'redirectTo': '#/settings/shift/shift_view',
		'verifyUrl': 'services/settings/shift_check_delete_status',
		'formUrl': 'services/settings/shift_delete',
		'alias': 'shift_alias'
	},
	'warehouse' : {
		'redirectTo': '#/settings/warehouse/warehouse_view',
		'verifyUrl': 'services/settings/warehouse_check_delete_status',
		'formUrl': 'services/settings/warehouse_delete',
		'alias': 'wh_alias'
	},
	'workguide' : {
		'redirectTo': '#/settings/mobile_app/workguide_view',
		'verifyUrl': 'services/settings/workguide_check_delete_status',
		'formUrl': 'services/settings/workguide_delete',
		'alias': 'mainguide_alias'
	},
	'changelog' : {
		'redirectTo': '#/settings/mobile_app/changelog_view',
		'verifyUrl': 'services/settings/changelog_check_delete_status',
		'formUrl': 'services/settings/changelog_delete',
		'alias': 'changelog_alias'
	},
	'dynamiclevel' : {
		'redirectTo': '#/settings/dynamiclevel/dynamic_level_view',
		'verifyUrl': 'services/settings/dynamic_level_check_delete_status',
		'formUrl': 'services/settings/dynamic_level_delete',
		'alias': 'dynamic_alias'
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
	if(!settingDetails['verifyUrl']) {
		data.setting = setting; 
		data.verifyUrl = settingDetails.verifyUrl;
		data.formUrl = settingDetails.formUrl;
		data.redirectTo = settingDetails.redirectTo;
		data.alias = data[settingDetails.alias];
		$rootScope.deleteData = data;
		modelpopup("includes/settings/delete.html", "md", $modal, $scope);
	} else {
		
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
				data.setting = setting; 
				data.verifyUrl = settingDetails.verifyUrl;
				data.formUrl = settingDetails.formUrl;
				data.redirectTo = settingDetails.redirectTo;
				data.alias = data[settingDetails.alias];
				$rootScope.deleteData = data;
				if(setting == 'material_req_stock') {
					modelpopup("includes/inventory/material_request/delete.html", "md", $modal, $scope);
				} else {
					modelpopup("includes/settings/delete.html", "md", $modal, $scope);
				}
			} else if(json.ErrorDetails.ErrorCode > '0') {
				$(".sendMail").show();
				toast_msg($rootScope,'danger',json.ErrorDetails.ErrorMessage,3000);
				$('button[type="submit"], input[type="submit"]').removeAttr('disabled','disabled');
			}
		}
	});
	}
}

function deleteSiteMaster(data, $scope, $rootScope, $modal) {
	
	var postData = new FormData();
	postData.append("emp_alias", readCookie('emp_alias'));
	postData.append("token", readCookie('token'));
	postData.append("ip_addr", readCookie('ip_addr'));
	postData.append("site_id", data.site_id);
	postData.append("site_alias", data.site_alias);
	$.ajax({
		url: base_url_2 + 'services/sitemaster/sitemaster_can_be_deleted',
		type: "POST",
		data: postData,
		processData: false,
		contentType: false,
		error: function(result) {
			$rootScope.loading=false;
			toast_msg($rootScope,'danger','Request failed, Contact Admin',5000);
			console.log(result);
		},
		beforeSend:function(result){
			$rootScope.loading=true;
		},
		success: function(result) { 
			$rootScope.loading=false;
			var json = jQuery.parseJSON(result);
			if (json.ErrorDetails.ErrorCode == '0') {
				$rootScope.deleteData = data; 
				modelpopup("includes/sitemaster/sitemaster_delete.html","md",$modal,$scope);
			} else if(json.ErrorDetails.ErrorCode > '0') {
				$(".sendMail").show();
				toast_msg($rootScope,'danger',json.ErrorDetails.ErrorMessage,3000);
				$('button[type="submit"], input[type="submit"]').removeAttr('disabled','disabled');
			}
		}
	});
}

function deleteTicket(ticket_id, ticket_alias, efsrExists, $scope, $rootScope, $modal) {
	
	$rootScope.ticket_id = ticket_id; 
	$rootScope.ticket_alias = ticket_alias; 
	$rootScope.efsrExists = efsrExists; 
	modelpopup("includes/tickets/ticket_delete.html","md",$modal,$scope);
	return;
}

function deleteTicketEfsr(ticket_id, ticket_alias, $scope, $rootScope, $modal) {
	
	$rootScope.ticket_id = ticket_id; 
	$rootScope.ticket_alias = ticket_alias; 
	modelpopup("includes/tickets/ticket_delete_efsr.html","md",$modal,$scope);
	return;
}

function deleteItemFromMaterialOutward($rootScope, $scope, materialOutwardAlias, itemAlias, itemType) {
	
	var postData = new FormData();
	postData.append("emp_alias", readCookie('emp_alias'));
	postData.append("token", readCookie('token'));
	postData.append("ip_addr", readCookie('ip_addr'));
	postData.append("alias", materialOutwardAlias);
	postData.append("item_alias", itemAlias);
	postData.append("item_type", itemType);
	$.ajax({
		url: base_url_2 + 'services/inventory/material_outward_item_delete',
		type: "POST",
		data: postData,
		processData: false,
		contentType: false,
		error: function(result) {
			$rootScope.loading=false;
			toast_msg($rootScope, 'danger', 'Request failed, Contact Admin', 5000);
			console.log(result);
		},
		beforeSend:function(result){
			$rootScope.loading=true;
		},
		success: function(result) { 
			$rootScope.loading=false;
			var json = jQuery.parseJSON(result);
			if (json.ErrorDetails.ErrorCode == '0') {
				toast_msg($rootScope, 'success', json.ErrorDetails.ErrorMessage, 3000);
				ajaxsingleViews($rootScope.alias, "services/inventory/material_outward_single_view", $scope, $rootScope);
			} else if(json.ErrorDetails.ErrorCode > '0') {
				$(".sendMail").show();
				toast_msg($rootScope, 'danger', json.ErrorDetails.ErrorMessage, 3000);
				$('button[type="submit"], input[type="submit"]').removeAttr('disabled','disabled');
			}
		}
	});
}
