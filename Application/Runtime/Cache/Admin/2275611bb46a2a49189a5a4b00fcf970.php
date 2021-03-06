<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>TPSHOP | 后台登陆</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/Public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="/Public/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    <style>#imgVerify{width: 120px;margin: 0 auto; text-align: center;display: block;}	</style>
    <script>    
    function detectBrowser()
    {
	    var browser = navigator.appName
	    if(navigator.userAgent.indexOf("MSIE")>0){ 
		    var b_version = navigator.appVersion
			var version = b_version.split(";");
			var trim_Version = version[1].replace(/[ ]/g,"");
		    if ((browser=="Netscape"||browser=="Microsoft Internet Explorer"))
		    {
		    	if(trim_Version == 'MSIE8.0' || trim_Version == 'MSIE7.0' || trim_Version == 'MSIE6.0'){
		    		alert('请使用IE9.0版本以上进行访问');
		    		return;
		    	}
		    }
	    }
   }
    detectBrowser();
   </script>
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><b>TPshop</b></a>
      </div>
      <div class="login-box-body">
        <p class="login-box-msg">管理后台</p>
          <div class="form-group has-feedback">
            <input type="text" name="username" id="username" class="form-control" placeholder="账号" />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" id="password" placeholder="密码" />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>

          <!-- 
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label><input type="checkbox"> 记住密码  </label>
              </div>
            </div>
            <div class="col-xs-4">
              <div class="checkbox icheck">
                <label><a href="#">找回密码</a></label>
              </div>
            </div>
          </div> --> 
          <div class="form-group">
          	 <button type="button" id="popup-submit" class="btn btn-primary btn-block btn-flat">立即登陆 </button>
              <div id="popup-captcha"></div>
          </div>
      </div>
      
	    <div class="margin text-center">
	        <div class="copyright">
	            2014-<?php echo date('Y');?> &copy; <a href="http://www.99soubao.com/tpshop.html">TPSHOP v2.0.0</a>
	            <br/>
	            <a href="http://www.99soubao.com">深圳搜豹网络有限公司</a>出品
	        </div>
	    </div>
    </div><!-- /.login-box -->
    <!-- jQuery 2.1.4 -->
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="/Public/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
	<script src="/Public/js/layer/layer.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
    <script src="http://static.geetest.com/static/tools/gt.js"></script>
    <script>
	  
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
         

      function fleshVerify(){
          //重载验证码
          $('#imgVerify').attr('src','/index.php?m=Admin&c=Admin&a=vertify&r='+Math.floor(Math.random()*100));
      }
      

      jQuery.fn.center = function () {
          this.css("position", "absolute");
          this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
          $(window).scrollTop()) - 30 + "px");
          this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
          $(window).scrollLeft()) + "px");
          return this;
      }
	
      function checkLogin(){
          var username = $('#username').val();
          var password = $('#password').val();
          if( username == '' || password ==''){
        	  layer.alert('用户名或密码不能为空', {icon: 2}); //alert('用户名或密码不能为空');
        	  return;
          }
          $.ajax({
  			url:'/index.php?m=Admin&c=Admin&a=login&t='+Math.random(),
			type:'post',
			dataType:'json',
			data:{username:username,password:password},
			success:function(res){
				if(res.status==1){
			     	top.location.href = res.url;
				}else{
					layer.alert(res.msg, {icon: 2});
				}
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				layer.alert('网络失败，请刷新页面后重试', {icon: 2});
			}
          })
      }
        //geetest
      var handlerPopup = function (captchaObj) {
          $("#popup-submit").click(function () {
              var validate = captchaObj.getValidate();
              if (!validate) {
                  alert('请先完成验证！');
                  return;
              }
              $.ajax({
                  url: "/index.php/home/index/geetest_s", // 进行二次验证
                  type: "post",
                  // dataType: "json",
                  data: {
                      // 二次验证所需的三个值
                      geetest_challenge: validate.geetest_challenge,
                      geetest_validate: validate.geetest_validate,
                      geetest_seccode: validate.geetest_seccode
                  },
                  success: function (result) {
                      checkLogin();
                  }
              });
          });
          // 弹出式需要绑定触发验证码弹出按钮
          captchaObj.bindOn("#popup-submit");
          // 将验证码加到id为captcha的元素里
          captchaObj.appendTo("#popup-captcha");
          // 更多接口参考：http://www.geetest.com/install/sections/idx-client-sdk.html
      };
      $.ajax({
          // 获取id，challenge，success（是否启用failback）
          url: "/index.php/home/index/geetest/t/" + (new Date()).getTime(), // 加随机数防止缓存
          type: "get",
          dataType: "json",
          success: function (data) {
              // 使用initGeetest接口
              // 参数1：配置参数
              // 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
              initGeetest({
                  gt: data.gt,
                  challenge: data.challenge,
                  product: "popup", // 产品形式，包括：float，embed，popup。注意只对PC版验证码有效
                  offline: !data.success // 表示用户后台检测极验服务器是否宕机，与SDK配合，用户一般不需要关注
              }, handlerPopup);
          }
      });


    </script>
  </body>
</html>