$( document ).ready(function() {

var page = 1;
var current_page = 1;
var total_page = 0;
var is_ajax_fire = 0;

//var img = "http://2.bp.blogspot.com/-tsIDMPhBx18/VPGxHZtjsnI/AAAAAAAALIU/1b_VO721HDw/s1600/line-share-button.png"; // line 按鈕圖示

//href = "http://line.naver.jp/R/msg/text/?titleNam%0D%0A" + "電表說明";

//html = "<a href='" + href + "' target='_blank'><img src='" + img + "'/></a>";
//document.write(html);

$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });

manageData();


/* manage data list */
function manageData() {
    $.ajax({
        dataType: 'json',
        url: url+'myrent/api/getData.php',
        data: {page:page}
    }).done(function(data){
    	total_page = Math.ceil(data.total/10);
    	current_page = page;

    	$('#pagination').twbsPagination({
	        totalPages: total_page,
	        visiblePages: current_page,
	        onPageClick: function (event, pageL) {
	        	page = pageL;
                if(is_ajax_fire != 0){
	        	  getPageData();
                }
	        }
	    });

    	manageRow(data.data);
       // is_ajax_fire = 1;

    });

}

/* Get Page Data*/
function getPageData() {
	$.ajax({
    	dataType: 'json',
    	url: url+'myrent/api/getData.php',
    	data: {page:page}
	}).done(function(data){
		manageRow(data.data);
	});
}
/*計算房租快到期了沒有 */
function calculateDate(end_date){
    var myDate = new Date(end_date);
    var nowDate = new Date();
    nowDate.setDate(nowDate.getDate() + 40);
    if(myDate.getTime() > nowDate.getTime()){	
	return false;
    }else{
	return true;
    }

}
/* Add new Item table row */
function manageRow(data) {
	var	rows = '';
	$.each( data, function( key, value ) {
		var isEnd = calculateDate(value.END_DATE);
		console.log(isEnd);
	  	rows = rows + '<tr>';
	  	rows = rows + '<td>'+value.ROOM + " " + value.NAME+'</td>';
	  	rows = rows + '<td style="display:none">'+value.BEGIN_DATE+'</td>';
	if(isEnd){
		rows = rows + '<td style="color:red">'+value.END_DATE+'</td>';
	}else{
		rows = rows + '<td>'+value.END_DATE+'</td>';
	}
		rows = rows + '<td>'+parseInt(value.RENT_AMT)+'</td>';		
		rows = rows + '<td>'+parseInt(value.THIS_DEGREES)+'</td>';		
	  	rows = rows + '<td data-id="'+value.TIMES+'">';
		rows = rows + '<button data-toggle="modal" data-target="#ins-item" class="btn btn-success   ins-item">新增</button> ';		
		rows = rows + '<button data-toggle="modal" data-target="#list-item" class="btn btn-info   list-item">紀錄</button> ';		
       // rows = rows + '<button data-toggle="modal" data-target="#edit-item" class="btn btn-primary   edit-item">編輯</button> ';
       // rows = rows + '<button class="btn btn-danger   remove-item">刪除</button>';
        rows = rows + '</td>';
	  	rows = rows + '</tr>';
	});

	$(".mainTbody").html(rows);
}

$("#THIS_DEGREES").focus(function() {
	$("#THIS_DEGREES").val("");
});
	
/* Create new Item */
$(".crud-submit").click(function(e){
    e.preventDefault();
    var form_action = $("#create-item").find("form").attr("action");
    var title = $("#create-item").find("input[name='title']").val();
    var description = $("#create-item").find("textarea[name='description']").val();

    if(title != '' && description != ''){
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url + form_action,
            data:{title:title, description:description}
        }).done(function(data){
            $("#create-item").find("input[name='title']").val('');
            $("#create-item").find("textarea[name='description']").val('');
            getPageData();
            $(".modal").modal('hide');
            toastr.success('Item Created Successfully.', 'Success Alert', {timeOut: 5000});
        });
    }else{
        alert('You are missing title or description.')
    }

});

/* Remove Item */
$("body").on("click",".remove-item",function(){
    var id = $(this).parent("td").data('id');
	var CUSMER = $(this).parent("td").prev("td").prev("td").prev("td").prev("td").prev("td").text();
	var BEGIN_DATE = $(this).parent("td").prev("td").prev("td").prev("td").prev("td").text();
	var ROOM = CUSMER.substring(0,2);
    var c_obj = $(this).parents("tr");
	console.log(ROOM);
	console.log(BEGIN_DATE);	
	console.log(id);
    $.ajax({
        dataType: 'json',
        type:'POST',
        url: url + 'myrent/api/delete.php',
        data:{ROOM:ROOM,BEGIN_DATE:BEGIN_DATE}
    }).done(function(data){
        c_obj.remove();
        toastr.success('Item Deleted Successfully.', 'Success Alert', {timeOut: 2000});
        //getPageData();
    });

});

/* 新增繳費紀錄 */
$("body").on("click",".ins-item",function(){
    var times = $(this).parent("td").data('id');
	var CUSMER = $(this).parent("td").prev("td").prev("td").prev("td").prev("td").prev("td").text();
    var RENT_AMT = $(this).parent("td").prev("td").prev("td").text();
    var THIS_DEGREES = $(this).parent("td").prev("td").text();
	var ROOM = CUSMER.substring(0,2);
	var NAME = CUSMER.substring(2);
	console.log(times);
	var insitem= $("#ins-item");
	insitem.find("input[name='ROOM']").val(ROOM);
	insitem.find("#ROOM").text(ROOM);
	insitem.find("input[name='NAME']").val(NAME);
	insitem.find("#NAME").text(NAME);
	insitem.find("input[name='INPUT_DATE']").val("");
	insitem.find("input[name='LAST_DEGREES']").val(THIS_DEGREES);
	insitem.find("input[name='THIS_DEGREES']").val(THIS_DEGREES);
    insitem.find("input[name='RENT_AMT']").val(RENT_AMT);
	insitem.find("input[name='PUB_ELECTRIC_AMT']").val("");
    insitem.find("input[name='ELECTRIC_AMT']").val("");	
    insitem.find("input[name='DIPOSIT_AMT']").val("");	
    insitem.find("input[name='TOTAL_AMT']").val("");	
    insitem.find("textarea[name='MESSAGE']").val("");	
    insitem.find(".edit-times").val(times);
    $( "#datepicker" ).datepicker('setDate','today');
    insitem.find("div.THIS_DEGREES").addClass("has-error has-danger");
    insitem.find("div.THIS_DEGREES > div.with-errors").text("請輸入最新電表度數");

});

/* 新增繳費紀錄 - 即時計算個人電費*/
$(".crud-submit-count").click(function(e){

    e.preventDefault();
	console.log("計算"  );
	var insitem = $("#ins-item"); // 先找到頭,再把資料弄進來,效能比較好
	var times = insitem.find(".edit-times").val();
	var LAST_DEGREES = insitem.find("input[name='LAST_DEGREES']").val();
	var THIS_DEGREES = insitem.find("input[name='THIS_DEGREES']").val();
	
	//個人電費
	var ELECTRIC_AMT = Math.round((THIS_DEGREES-LAST_DEGREES)*times);
    	insitem.find("input[name='ELECTRIC_AMT']").val(ELECTRIC_AMT);
	
	// 公共電費
	var PUB_ELECTRIC_AMT = insitem.find("input[name='PUB_ELECTRIC_AMT']").val();
	if(PUB_ELECTRIC_AMT=='') PUB_ELECTRIC_AMT = '0';
	insitem.find("input[name='PUB_ELECTRIC_AMT']").val(PUB_ELECTRIC_AMT);
	
	//押金
	var DIPOSIT_AMT = insitem.find("input[name='DIPOSIT_AMT']").val();
	if(DIPOSIT_AMT=='') DIPOSIT_AMT = '0';
	insitem.find("input[name='DIPOSIT_AMT']").val(DIPOSIT_AMT);
	
	// 租金
	var RENT_AMT = insitem.find("input[name='RENT_AMT']").val();
	
	// 應繳房租
	var TOTAL_AMT = parseInt(RENT_AMT)+parseInt(ELECTRIC_AMT)+parseInt(PUB_ELECTRIC_AMT)+parseInt(DIPOSIT_AMT);
	insitem.find("input[name='TOTAL_AMT']").val(TOTAL_AMT);
		
	var MESSAGE ="";
	// 訊息
	if(parseInt(DIPOSIT_AMT) > 0){ //簽約
         MESSAGE="繳納押金 "+ DIPOSIT_AMT + " 元,房租 " + RENT_AMT + " 元,電費 " + ELECTRIC_AMT + " 元,合計 " + TOTAL_AMT + " 元"; 	

	}else{ // 月繳房租

	 MESSAGE = "你好，本月房租共 " + parseInt(TOTAL_AMT) + " 元 " ;
 	 MESSAGE =  MESSAGE + "(" + THIS_DEGREES + "-" + LAST_DEGREES + ")x" + times + "+" + RENT_AMT + "=" + TOTAL_AMT;
	}
	insitem.find("textarea[name='MESSAGE']").val(MESSAGE);
});


/* 新增繳費紀錄 - 新增資料庫 */
$(".crud-submit-ins").click(function(e){

    e.preventDefault();
	var insitem = $("#ins-item"); // 先找到頭,再把資料弄進來,效能比較好
    	var form_action = insitem.find("form").attr("action");
    	var ROOM = insitem.find("input[name='ROOM']").val();
	var NAME = insitem.find("input[name='NAME']").val().trim();
	var INPUT_DATE = insitem.find("input[name='INPUT_DATE']").val();
	var LAST_DEGREES = insitem.find("input[name='LAST_DEGREES']").val();
	var THIS_DEGREES  = insitem.find("input[name='THIS_DEGREES']").val();
	var RENT_AMT = insitem.find("input[name='RENT_AMT']").val();
	var PUB_ELECTRIC_AMT = insitem.find("input[name='PUB_ELECTRIC_AMT']").val();
	var ELECTRIC_AMT = insitem.find("input[name='ELECTRIC_AMT']").val();
	var DIPOSIT_AMT  = insitem.find("input[name='DIPOSIT_AMT']").val();
	var TOTAL_AMT  = insitem.find("input[name='TOTAL_AMT']").val();
	var MESSAGE = insitem.find("textarea[name='MESSAGE']").val();
 
	console.log("新增資料庫");
	console.log(form_action);
	console.log(ROOM);
	console.log(NAME);
	console.log(INPUT_DATE);	
	console.log(LAST_DEGREES);
	console.log(THIS_DEGREES);
	console.log(RENT_AMT);
	console.log(PUB_ELECTRIC_AMT);
	console.log(ELECTRIC_AMT);
	console.log(DIPOSIT_AMT);
	console.log(TOTAL_AMT);	
	console.log(MESSAGE);	

 
 
    if(INPUT_DATE != ''){
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url + form_action,
            data:{ROOM:ROOM, 
				  NAME:NAME ,
				  INPUT_DATE:INPUT_DATE,
				  LAST_DEGREES:LAST_DEGREES,
				  THIS_DEGREES:THIS_DEGREES,
				  RENT_AMT:RENT_AMT,
				  PUB_ELECTRIC_AMT:PUB_ELECTRIC_AMT,
				  ELECTRIC_AMT:ELECTRIC_AMT,
				  DIPOSIT_AMT:DIPOSIT_AMT,
				  TOTAL_AMT:TOTAL_AMT,
				  MESSAGE:MESSAGE
			}
        }).done(function(data){	
			console.log("新增成功");
			console.log(data);
            getPageData();
            $(".modal").modal('hide');
            toastr.success('新增成功', 'Success Alert', {timeOut: 1000});
			
			   // 新增一筆繳費紀錄後,顯示歷史繳費紀錄
			   $("#list-item").modal('show');
			   $.ajax({
					dataType: 'json',
					type:'POST',
					url: url + 'myrent/api/getList.php',
					data:{ROOM:ROOM}
				}).done(function(data){
					manageListRow(data.data); 
				}); 
		
			
        });
		
	
    }else{
        alert('未輸入日期,請重新操作')
    }

});


/* Edit Item */
$("body").on("click",".edit-item",function(){

 
	var CUSMER = $(this).parent("td").prev("td").prev("td").prev("td").prev("td").prev("td").text();
	var BEGIN_DATE = $(this).parent("td").prev("td").prev("td").prev("td").prev("td").text();
    var END_DATE = $(this).parent("td").prev("td").prev("td").prev("td").text();
    var RENT_AMT = $(this).parent("td").prev("td").prev("td").text();
	var edititem = $("#edit-item");
	edititem.find("input[name='CUSMER']").val(CUSMER);
	edititem.find("#CUSMER").text(CUSMER);
	edititem.find("input[name='BEGIN_DATE']").val(BEGIN_DATE);
	edititem.find("#BEGIN_DATE").text(BEGIN_DATE);
    edititem.find("input[name='END_DATE']").val(END_DATE);
    edititem.find("input[name='RENT_AMT']").val(RENT_AMT);
 

});




/* Updated new Item */
$(".crud-submit-edit").click(function(e){

    e.preventDefault();
	var edititem = $("#edit-item");
    var form_action = edititem.find("form").attr("action");
    var CUSMER = edititem.find("input[name='CUSMER']").val();
	var BEGIN_DATE = edititem.find("input[name='BEGIN_DATE']").val();
	var END_DATE = edititem.find("input[name='END_DATE']").val();
	var RENT_AMT = edititem.find("input[name='RENT_AMT']").val();
	var ROOM = CUSMER.substring(0,2);

	console.log(form_action);
	console.log(ROOM);
	console.log(BEGIN_DATE);
	console.log(END_DATE);
	console.log(RENT_AMT);
	
   

 
 
    if(CUSMER != ''){
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url + form_action,
            data:{ROOM:ROOM, BEGIN_DATE:BEGIN_DATE,END_DATE:END_DATE,RENT_AMT:RENT_AMT}
        }).done(function(data){
            getPageData();
            $(".modal").modal('hide');
            toastr.success('Item Updated Successfully.', 'Success Alert', {timeOut: 1000});
        });
    }else{
        alert('You are missing title or description.')
    }

});

/* List Item 繳費紀錄*/
$("body").on("click",".list-item",function(){
	var CUSMER = $(this).parent("td").prev("td").prev("td").prev("td").prev("td").prev("td").text();
	var ROOM = CUSMER.substring(0,2);
	console.log(ROOM + "繳費紀錄");	

    $.ajax({
        dataType: 'json',
        type:'POST',
        url: url + 'myrent/api/getList.php',
        data:{ROOM:ROOM}
    }).done(function(data){
 
        manageListRow(data.data); 
    }); 

});



/* List Item 繳費紀錄 加入 tbody */
function manageListRow(data) {
	var	rows = '';
	$.each( data, function( key, value ) {
		// 抬頭放目前的房客
		if(key==0) $("#list-item").find("#CUSMER").html("<h3>" + value.ROOM + " " + value.NAME + "</h3>");
		var input_date=value.INPUT_DATE.replace(/-/g,"");	
		// keyset
		var delIdData = '{"ROOM":"' + value.ROOM +'","INPUT_DATE":"'+ value.INPUT_DATE+'"}';
 
	  	rows = rows + '<tr class="isHidden">';
	  	rows = rows + '<td>'+input_date+'</td>';
		rows = rows + '<td>'+value.LAST_DEGREES+'</td>';			
		rows = rows + '<td>'+value.THIS_DEGREES+'</td>';
//		rows = rows + '<td>'+value.PUB_ELECTRIC_AMT+'</td>';
//		rows = rows + '<td>'+value.ELECTRIC_AMT+'</td>';
//		rows = rows + '<td>'+value.RENT_AMT+'</td>';		
//		rows = rows + '<td>'+value.DIPOSIT_AMT+'</td >';
		rows = rows + '<td>'+value.TOTAL_AMT+'</td>';		
	  	rows = rows + '</tr>';
		if(key==0){
		rows = rows + '<tr class="hiddenClass" >';
		}
		else{
		rows = rows + '<tr class="hiddenClass" style="display:none">';
		}
		rows = rows + '<td colspan="8">';
		rows = rows + '<textarea class="form-control msgcopy" >'+value.MESSAGE+'</textarea>';
		rows = rows + '<div class="pull-left"><a href="http://line.naver.jp/R/msg/text/?'+value.MESSAGE+'" target="_blank"><img src="images/share-a.png" style="width:50%"></a></div>';
		rows = rows + '<div class="del_wrapper pull-right"><a href="#" data-keyset='+ delIdData + ' class="del_button"><img src="images/icon_del.gif" border="0" /></a></div>';
		rows = rows + '</td><tr>';
	}); 

	 $(".listTbody").html(rows);
}

/*  滑鼠移入移出  標示區塊  繳費清單 */
$("#list-item").on("mouseenter", ".del_button", function(e) {
	    e.preventDefault();
 		var tr_textarea = $(this).parent("div").parent("td").parent("tr");
		var tr_basedata = $(tr_textarea).prev("tr");
		var textarea = $(this).parent("div").prev("div").prev("textarea");
		$(tr_textarea).addClass( "ui-state-error" );e.preventDefault();
	    $(tr_basedata).addClass( "ui-state-error" );
	    $(textarea).addClass( "ui-state-error" );
});

$("#list-item").on("mouseleave", ".del_button", function(e) {
	    e.preventDefault();
 		var tr_textarea = $(this).parent("div").parent("td").parent("tr");
		var tr_basedata = $(tr_textarea).prev("tr");
		var textarea = $(this).parent("div").prev("div").prev("textarea");
		$(tr_textarea).removeClass( "ui-state-error" );
	    $(tr_basedata).removeClass( "ui-state-error" );
	    $(textarea).removeClass( "ui-state-error" );
});


/*  刪除繳費清單 */
$("#list-item").on("click", ".del_button", function(e) {
	e.preventDefault();
	var KEYSET  = $(this).data("keyset"); 
	//console.log(KEYSET);
	console.log("整筆刪除,是否確認?");
	var isdel = confirm("整筆刪除,是否確認?");
 		var tr_textarea = $(this).parent("div").parent("td").parent("tr");
		var tr_basedata = $(tr_textarea).prev("tr");
		var textarea = $(this).parent("div").prev("textarea");

	if(isdel){
	    $(tr_textarea).addClass( "ui-state-error" );
	    $(tr_basedata).addClass( "ui-state-error" );
	    $(textarea).addClass( "ui-state-error" );
	    $.ajax({
        dataType: 'json',
        type:'POST',
        url: url + 'myrent/api/delList.php',
        data:KEYSET
	    }).done(function(data){
	    	$(tr_textarea).fadeOut("slow");
	    	$(tr_basedata).fadeOut("slow");
	 		toastr.success('', '已刪除!', {timeOut: 500});
 	    }); 

	}

});


/* 訊息 複製功能 */
$("#list-item").on("focusin",".msgcopy",function(e){
	e.preventDefault();
	$(this).select();
	document.execCommand("copy"); 
        toastr.success('', '訊息已複製!', {timeOut: 500});
});
/* 訊息 show() and hide() */
$("#list-item").on("click",".isHidden",function(e){
	e.preventDefault();
	$(this).next("tr").toggle("slow");
});

$("#list-item").on("click",".listThead",function(e){
	e.preventDefault();
	$("tr.hiddenClass").toggle();
});


});
