<style>
.Exp_dashboard {padding: 5px 10px;margin: 10px 30px;border: 1px solid #eee;border-left-width: 5px;border-radius: 3px;border-left-color: #428bca;}
.Exp_dashboard h4{color:#428bca; margin-top: 0;margin-bottom: 5px; font-size:15px;}
.Exp_dashboard p{position: relative;text-indent: 10px; font-size:13px;}
.panel-dashboard{border:1px solid #428bca;}
.panel-heading {color: #ffffff;background-color: #428bca !important;border-color: #428bca !important;}
</style>
<div class="page page-ui-buttons" ng-controller="ModalDemoCtrl">
   		<div class="panel panel-lined table-responsive panel-hovered mb10">
            <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
                <li><a href="#/dashboard" class="padding-10">Home</a></li>
                <li><a href="" class="padding-10">Expence Traker</a></li>
                <li><a href="" class="padding-10">Dashboard</a></li>
            </ol>
       </div>
        <div class="row">
            <!-- Data Table -->
            <div class="col-md-12">
            	<div class="panel panel-info panel-hovered panel-dashboard">
					<div class="panel-heading">Dashboard</div>
					<div class="panel-body">
                        <div class="row">
                          <div class="col-md-10 col-md-offset-1">
                            <div class="col-md-5 Exp_dashboard"><h4>Employee Id</h4><p>ECOO1</p></div>
                            <div class="col-md-5 Exp_dashboard"><h4>Employee Name</h4><p>MANI RAJ</p></div>
                            <div class="col-md-5 Exp_dashboard"><h4>Department</h4><p>SALES</p></div>
                            <div class="col-md-5 Exp_dashboard"><h4>Designation</h4><p>ASST.MANAGER</p></div>
                            <div class="col-md-5 Exp_dashboard"><h4>Grade</h4><p>S2</p></div>
                            <div class="col-md-5 Exp_dashboard"><h4>Credit Limit</h4><p></p></div>
                            <div class="col-md-5 Exp_dashboard"><h4>Total Advances</h4><p>0</p></div>
                            <div class="col-md-5 Exp_dashboard"><h4>Total Expenses</h4><p>0</p></div>
                            <div class="col-md-5 Exp_dashboard"><h4>Total Outstanding Balance</h4><p>0</p></div>
                          </div>
                       </div>
                  </div>
				</div>
            </div>
        </div>           
</div>