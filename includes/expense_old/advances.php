<div class="page page-ui-buttons" ng-controller="ModalDemoCtrl">
   		<div class="panel panel-lined table-responsive panel-hovered mb10">
            <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
                <li><a href="#/dashboard" class="padding-10">Home</a></li>
                <li><a href="" class="padding-10">Expence Traker</a></li>
                <li><a href="" class="padding-10">Advances</a></li>
            </ol>
       </div>
		
        <div class="row">
            <!-- Data Table -->
            <div class="col-md-12 table-height">
                <div class="panel panel-lined table-responsive panel-hovered" ng-controller="AdvanceCtrl">
                <div class="panel panel-default">
                    <table class="table table-condensed" >
                        <thead>
                        <tr>
                            <th>
                                <a class="tktid">Request ID&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" ng-model="searchKeywords.requestid" data-ng-keyup="search()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="search()"></span>
                            </th>
                            <th ng-controller="DatepickerDemoCtrl">
                                <a class="tktid"> Requested Date&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="form-control datepicker border-bottom droptxt1 hidden" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="dt" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/></td>
                                <span class="ion ion-ios-close-outline inptClose hidden"></span>
                            </th>
                            <th>
                                <a class="tktid">Requested Amount&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" ng-model="searchKeywords.requestedamount" data-ng-keyup="search()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="search()"></span>
                            </th>
                             <th>
                                <select multiple="multiple" placeholder="Approval Status" onchange="console.log($(this).children(':selected').length)" class="testSelAll2 form-control">
                                    <option value="DRAFTS">DRAFTS</option>
                                    <option value="HOD PENDING">HOD PENDING</option>
                                    <option value="HR PENDING">HR PENDING</option>
                                    <option value="FINANCE PENDING">FINANCE PENDING</option>
                                    <option value="MD PENDING">MD PENDING</option>
                                    <option value="APPROVED">APPROVED</option>
                                    <option value="CLOSED">CLOSED</option>
                                    <option value="REJECTED">REJECTED</option>
                                </select>
                            </th>
                        </tr>
                        </thead>
                    </table>
    
                    <div class="div-table-content">
                        <table class="table table-condensed">
                            <tbody>
                                <tr class="tktBackground" ng-repeat="data in currentPageStores track by $index | filter : searchKeywords">
                                    <td ng-click="materialinwardview(data.requestid)">{{data.requestid}}</td>
                                    <td>{{data.requesteddate}}</td>
                                    <td>{{data.requestedamount}}</td>
                                    <td>{{data.approvalstatus}}</td>
                                </tr>
                           </tbody>
                          	 <tfoot ng-if="currentPageStores.length=='0'"><tr><td>No Records</td></tr></tfoot>
                        </table>
                    </div>
                    <!-- #end data table -->	
                     <div class="panel-footer clearfix">
                        <p class="left small" style="margin:0px !important;">
                            Showing {{currentPageStores.length*(currentPage - 1) + 1}} to {{currentPageStores.length*currentPage}} of {{datas.length}} entries
                        </p>
                        <div class="small text-bold right ml15">
                            <span class="control-label">Count per page</span>
                                <select class="form-control input-sm page-count" data-ng-model="numPerPage"
                                    data-ng-options="num for num in numPerPageOpts"
                                    data-ng-change="onNumPerPageChange()">
                                </select> 
                        </div>
                        <pagination boundary-links="true" total-items="filteredData.length" ng-model="currentPage" class="pagination-sm right" 
                            max-size="5" ng-change="select(currentPage)" items-per-page="numPerPage" rotate="false"
                            previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;" style="margin:0px !important;"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <!-- #end row -->
    </div>
        <div><button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Addnew" tooltip-placement="top"  ng-click="advancerequestOpen()" md-ink-ripple></button></div>
</div>
<script>
	$(document).ready(function(){
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
	   /*---multiple-select dropdown-----*/
		window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3 });
		window.test = $('.testsel').SumoSelect({okCancelInMulti:true });
		window.testSelAll = $('.testSelAll').SumoSelect({okCancelInMulti:true, selectAll:true });
		window.testSelAll2 = $('.testSelAll2').SumoSelect({selectAll:true });
		
		//$('.compose-btn').fadeOut(4000); alert();
	});
</script>