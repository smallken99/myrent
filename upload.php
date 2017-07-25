<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="https://code.jquery.com/jquery-1.4.4.min.js" type="text/javascript"></script>
</head>
<body>
	<div id="result"  class="row"></div>
	<input id="upload" type="file" accept="image/*;" capture="camera" value="開始拍照">
	<img src="images/loading.gif" id="LoadingImage" style="display:none" />
	<script type="text/javascript">


		$(document).ready( function(){
		    h5_upload_ops.init();
		} );


	var h5_upload_ops = {
	    init:function(){
	        this.eventBind();
	    },
	    eventBind:function(){
	        var that = this;
	        $("#upload").change(function(){
	            var reader = new FileReader();
	            reader.onload = function (e) {
	                that.compress(this.result);
	            };
	            reader.readAsDataURL(this.files[0]);
	        });
	    },
	    compress : function (res) {
	        var that = this;
	        var img = new Image(),
	            maxH = 1000;
	 
	        img.onload = function () {
	            var cvs = document.createElement('canvas'),
	                ctx = cvs.getContext('2d');
	 
	            if(img.height > maxH) {
	                img.width *= maxH / img.height;
	                img.height = maxH;
	            }
	            cvs.width = img.width;
	            cvs.height = img.height;
	 
	            ctx.clearRect(0, 0, cvs.width, cvs.height);
	            ctx.drawImage(img, 0, 0, img.width, img.height);
	            var dataUrl = cvs.toDataURL('image/jpeg', 1);
	            //$(".img_wrap").attr("src",dataUrl);
	            //$(".img_wrap").show();
			    $("#LoadingImage").show().center(); //show loading image
	            // 上传略
	            that.upload( dataUrl );
	        };
	 
	        img.src = res;
	    },
	    upload:function( image_data ){
	       var fileName = new Date().getTime();
	       var ROOM = "B1";
           $.ajax({
                url: "api/receiveImage.php",
                type: "post",
                data: { ROOM: ROOM,
                	data: image_data.substr(22),
                	file: fileName
                },
                async: true,
                success: function (htmlVal) {
                $("#LoadingImage").hide();
        	    alert("照片上傳成功！");
        	    var imgContent ="";
        	    var src = "upload/" + ROOM + "/" + fileName + ".jpg";
        	    console.log(src);
        	    imgContent = imgContent + '<div class="col-sm-6">';
        	    imgContent = imgContent +   '<div class="thumbnail">';
        	    imgContent = imgContent +      '<img src="' + src +'" alt="Lights" style="width:100%">';
        	    imgContent = imgContent + "  </div>";
        	    imgContent = imgContent + "</div>";
                $("#result").append(imgContent);
                }, error: function (e) {
                    alert(e.responseText); //alert錯誤訊息
                }

            });
	    }
	};
	 
	 
		jQuery.fn.center = function () {
		    this.css("position","absolute");
		    this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + 
		                                                $(window).scrollTop()) + "px");
		    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + 
		                                                $(window).scrollLeft()) + "px");
		    return this;
		}

	</script>
</body>
</html>
