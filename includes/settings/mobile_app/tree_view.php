<style>
.uparrow{color:#fff;}
.uparrow:before{
	content:"\f067";
	font-family: FontAwesome;
}
.downarrow:after{
	content:"\f068";
	font-family: FontAwesome;
}
</style>
<div class="page page-ui-extras">
<div ng-controller="treeController">
	<div class="panel panel-lined table-responsive panel-hovered mb10" style="">
		<ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
			<li><a href="#/dashboard" class="padding-10">Home</a></li>
			<li><a href="#/settings" class="padding-10">Settings</a></li>
			<li><a href="" class="padding-10">Drop Downs</a></li>
		</ol>
         <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;">
            <li><a href="exports/{{singleViews.file_name}}.xlsx" ng-click="treeexport()" class="padding-10 export-btn" ng-if="export">Export</a></li>
        </ol>
	</div>
	<div class="row">
		<div class="col-md-12 table-height">
			<div class="panel panel-lined table-responsive panel-hovered">
				<div class="panel panel-default" ng-controller="addingform">
            	<form class="form-horizontal forms_add" name="treeForm" data-went="#/settings/mobile_app/tree_view" method="post" url="services/settings/tree_add_update_disable" novalidate>
					<div class="page-ui-treeview" ng-controller="TreeViewDemoCtrl">
							<div class="page-wrap">
								<!-- row -->
									<div class="col-md-6 col-sm-offset-3 mt30">
										<div ng-if="output !== undefined" class="alert alert-success">{{output}}</div>
										<div class="tree-api">
											<button ng-click="my_tree.select_parent_branch()" class="btn btn-default mb10" tooltip-placement="top" tooltip="Parent"><i class="fa fa-sitemap" aria-hidden="true"></i></button>
											<button ng-click="my_tree.select_first_branch()" class="btn btn-default mb10"  tooltip-placement="top" tooltip="First branch"><i class="fa fa-level-up" aria-hidden="true"></i></button>
											<button ng-click="my_tree.select_last_branch()" class="btn btn-default mb10"  tooltip-placement="top" tooltip="Last branch"><i class="fa fa-level-down" aria-hidden="true"></i></button>
											<button ng-click="my_tree.select_next_sibling()" class="btn btn-default mb10"  tooltip-placement="top" tooltip="Next Sibling"><i class="fa fa-forward fa-rotate-90" aria-hidden="true"></i></button>
											<button ng-click="my_tree.select_prev_sibling()" class="btn btn-default mb10"  tooltip-placement="top" tooltip="Prev Sibling"><i class="fa fa-backward fa-rotate-90" aria-hidden="true"></i></button>
											<button ng-click="my_tree.select_prev_branch()" class="btn btn-default mb10" tooltip-placement="top" tooltip="Prev Branch"><i class="fa fa-chevron-up" aria-hidden="true"></i></button>
											<button ng-click="my_tree.select_next_branch()" class="btn btn-default mb10"  tooltip-placement="top" tooltip="Next Branch"><i class="fa fa-chevron-down" aria-hidden="true"></i></button>
											<button ng-click="my_tree.expand_all()" class="btn btn-default mb10" tooltip-placement="top" tooltip="Expand All"><i class="fa fa-expand" aria-hidden="true"></i></button>
											<button ng-click="my_tree.collapse_all()" class="btn btn-default mb10" tooltip-placement="top" tooltip="Collapse All"></span><i class="fa fa-compress" aria-hidden="true"></i></button>
											<button ng-click="try_adding_a_branch()" class="btn btn-default mb10" tooltip-placement="top" tooltip="Add Branch"><i class="fa fa-plus" aria-hidden="true"></i></button>
											<button ng-click="try_remove_a_branch()" class="btn btn-default mb10" tooltip-placement="top" tooltip="Remove Branch"><i class="fa fa-minus" aria-hidden="true"></i></button>
											<!--<button ng-click="try_changing_the_tree_data()" class="btn btn-default mb10" tooltip-placement="top" tooltip="Exchange Tree"><i class="fa fa-exchange" aria-hidden="true"></i></button>-->
										</div>
										
										<div style="max-height:500px; overflow:auto; overflow-x:hidden;">
											<div class="tree-view treeview-nav">
												<span ng-if="doing_async">...loading...</span>
												<abn-tree
													 tree-data="my_data" 
													 tree-control="my_tree" 
													 on-select="my_tree_handler(branch)" 
													 expand-level="2" 
													 initial-selection="Vegetable"
													 icon-leaf="ion ion-document"
													 icon-expand="ion ion-plus"
													 icon-collapse="ion ion-minus">
												</abn-tree>
											</div>
										</div>
										 <div class="col-md-6 col-sm-offset-5 mb30">
											<button type="submit" click-once class="btn btn-info btn-sm subdisabled" ng-click="sendPost()">Save</button>
											<button type="reset" class="btn btn-info btn-sm" ng-click="treeForm.$setPristine(); treeForm.$setUntouched();">Reset</button>
										</div>
									</div>
							</div> <!-- #end page-wrap -->
						</div>
                      </form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>