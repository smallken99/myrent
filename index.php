<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<title>新牛租賃管理系統</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3.1/jquery.twbsPagination.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

	<script type="text/javascript">
    	 var url = "http://192.168.8.100/";
        </script>

        <script src="/myrent/js/item-ajax.js"></script>
</head>
<body>
<ul class="nav nav-pills">
  <li class="active"><a href="#">主頁</a></li>
  <li><a href="elec.php">公共電費</a></li>
</ul>
	<input id="msg_copy_input" type="hidden">
	<div class="container">
	
		<div class="row">
		    <div class="col-lg-12 margin-tb">					
		        <div class="pull-left">
		            <h2>房屋租賃管理系統</h2>
		        </div>
		        <div class="pull-right">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item">
					  新增租約
				</button>	
		        </div>
		    </div>
		</div>

		<table class="table table-bordered">
			<thead>
			    <tr>
				<th>房客</th>
				<th>租約結束</th>
				<th>租金</th>
				<th>電表度數</th>
				<th width="130px">動作</th>
			    </tr>
			</thead>
			<tbody class="mainTbody">
			</tbody>
		</table>

		<ul id="pagination" class="pagination-sm"></ul>

	        <!-- Create Item Modal -->
		<div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		        <h4 class="modal-title" id="myModalLabel">Create Item</h4>
		      </div>

		      <div class="modal-body">
		      		<form data-toggle="validator" action="myrent/api/create.php" method="POST">

		      			<div class="form-group">
							<label class="control-label" for="title">Title:</label>
							<input type="text" name="title" class="form-control" data-error="Please enter title." required />
							<div class="help-block with-errors"></div>
						</div>

						<div class="form-group">
							<label class="control-label" for="title">Description:</label>
							<textarea name="description" class="form-control" data-error="Please enter description." required></textarea>
							<div class="help-block with-errors"></div>
						</div>

						<div class="form-group">
							<button type="submit" class="btn crud-submit btn-success">Submit</button>
						</div>

		      		</form>

		      </div>
		    </div>

		  </div>
		</div> 

		<!-- Edit Item Modal -->
		<div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		        <h4 class="modal-title" id="myModalLabel">修改租約</h4>
		      </div>

		      <div class="modal-body">
		      		<form data-toggle="validator" action="myrent/api/update.php" method="put">
		      			<input type="hidden" name="id" class="edit-id">
						
		      			<div class="form-group">
							<label class="control-label" for="title">房客</label>
							<input type="hidden" name="CUSMER" />
							<div id="CUSMER" ></div>
						</div>
						
		      			<div class="form-group">
							<label class="control-label" for="title">租約起始</label>
							<input type="hidden" name="BEGIN_DATE" />
							<div id="BEGIN_DATE" ></div>
						</div>
						
		      			<div class="form-group">
							<label class="control-label" for="title">租約結束</label>
							<input type="text" name="END_DATE" class="form-control" data-error="Please enter title." required />
							<div class="help-block with-errors"></div>
						</div>

						<div class="form-group">
							<label class="control-label" for="title">租金</label>
							<input type="text" name="RENT_AMT" class="form-control" data-error="Please enter description." required></textarea>
							<div class="help-block with-errors"></div>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-success crud-submit-edit">修改</button>
						</div>

		      		</form>

		      </div>
		    </div>
		  </div>
		</div>
		
		<!-- Insert Item Modal -->
		<div class="modal fade" id="ins-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		        <h4 class="modal-title" id="myModalLabel">新增繳費紀錄</h4>
		      </div>

		      <div class="modal-body">
		      		<form data-toggle="validator" action="myrent/api/insert.php" method="put">
		      			<input type="hidden" name="times" class="edit-times">
						
		      			<div class="form-group">
							<label class="control-label" for="title">房號</label>
							<input type="hidden" name="ROOM"  />
							 <div id="ROOM" ></div>
						</div>

		      			<div class="form-group">
							<label class="control-label" for="title">房客姓名</label>
							<input type="hidden" name="NAME"  />
							 <div id="NAME" ></div>
						</div>
						
		      			<div class="form-group">
							<label class="control-label" for="title">日期</label>
							<input type="text" id="datepicker" name="INPUT_DATE" class="form-control" data-error="Please enter title." required />
						</div>
						
		      			<div class="form-group">

						<div class="form-group">
							<label class="control-label" for="title">上次電表</label>
							<input type="text" name="LAST_DEGREES" class="form-control" data-error="Please enter description." required>
							<div class="help-block with-errors"></div>
						</div>

						<div class="form-group THIS_DEGREES">
							<label class="control-label" for="title">本次電表</label>
							<input type="text" id="THIS_DEGREES" name="THIS_DEGREES" class="form-control THIS_DEGREES" data-error="請輸入最新電表度數" required>
							<div class="help-block with-errors"></div>
						</div>

						<div class="form-group">
							<label class="control-label" for="title">租金</label>
							<input type="text" name="RENT_AMT" class="form-control" data-error="Please enter description." required>
							<div class="help-block with-errors"></div>
						</div>

						<div class="form-group">
							<label class="control-label" for="title">公共電費</label>
							<input type="text" name="PUB_ELECTRIC_AMT" class="form-control"  >
						</div>
						
						<div class="form-group">
							<label class="control-label" for="title">個人電費</label>
							<input type="text" name="ELECTRIC_AMT" class="form-control">
						</div>
						
						<div class="form-group">
							<label class="control-label" for="title">押	金</label>
							<input type="text" name="DIPOSIT_AMT"  class="form-control">
						</div>
						
						<div class="form-group">
							<label class="control-label" for="title">應繳房租</label>
							<input type="text" name="TOTAL_AMT" class="form-control" data-error="Please enter description." required>
							<div class="help-block with-errors"></div>
						</div>	
						
						<div class="form-group">
							<label class="control-label" for="title">訊息</label>
							<textarea name="MESSAGE" class="form-control" data-error="Please enter description." ></textarea>
							<div class="help-block with-errors"></div>
						</div>							
						<div class="form-group">
						    <button type="submit" class="btn btn-success crud-submit-count">計算</button>
							<button type="submit" class="btn btn-success crud-submit-ins">新增</button>
							<div class="pull-right">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
 				

		      		</form>

		      </div>
		    </div>
		  </div>
		</div>
	   </div>

		<!-- List Item Modal -->
		<div class="modal fade" id="list-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		        <h4 class="modal-title" id="myModalLabel">歷史繳費紀錄</h4>
		      </div>

		      <div class="modal-body">
				<table class="table table-bordered">
				    <div id="CUSMER"></div> 
 
					<thead class="listThead">
						<tr>
						<th>輸入日期</th>
						<th>上次度數</th>
						<th>本次度數</th>						
			    <!--		<th>公共電費</th>
						<th>個人電費</th>	
						<th>租金</th>	
						<th>押金</th>	-->
						<th>應繳租金</th>							
					</thead>
					<tbody class="listTbody">
					</tbody>
			    </table>

		      </div>
		    </div>
		  </div>
		</div>
	   </div>	   

		<!-- List Cust Data -->
		<div class="modal fade" id="cus_data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		        <h4 class="modal-title" id="myModalLabel">房客基本資料</h4>
		      </div>

		      <div class="modal-body">
				<table class="table table-bordered">
				    <div id="CUSMER"></div> 
					<tbody class="CusTbody">
					</tbody>
			    </table>

		      </div>
		    </div>
		  </div>
		</div>
	   </div>	   


	</div>
</body>
</html>
