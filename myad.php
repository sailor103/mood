<?php
session_start();
if ($_SESSION['username']==""){
  header("Location:login.php");
}
/*
 * 根据腾讯IP分享计划的地址获取IP所在地，比较精确
 * By YQC 2012-11-24
 */
function getIPLoc($queryIP){
$url = 'http://ip.qq.com/cgi-bin/searchip?searchip1='.$queryIP;
$ch = curl_init($url);
curl_setopt($ch,CURLOPT_ENCODING ,'gb2312');
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
$result = curl_exec($ch);
$result = mb_convert_encoding($result, "utf-8", "gb2312"); // 编码转换，否则乱码
   curl_close($ch);
preg_match("@<span>(.*)</span></p>@iU",$result,$ipArray);
$loc = $ipArray[1];
return $loc;
}
/**
 * PHP 获取IP地址
 * 2012-11-24 By YQC
*/
function GetIP()  
{  
if(!empty($_SERVER["HTTP_CLIENT_IP"]))  
   $cip = $_SERVER["HTTP_CLIENT_IP"];  
else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))  
   $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];  
else if(!empty($_SERVER["REMOTE_ADDR"]))  
   $cip = $_SERVER["REMOTE_ADDR"];  
else  
   $cip = "无法获取！";  
return $cip;  
}
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8" />
<title>后台管理</title>
<link rel="stylesheet" href="mood.css" type="text/css" />
<script type="text/javascript" src="js/jq.js"></script>
<script type="text/javascript">
$(document).ready(function(){
		$('#bsub').click(function(){
			var mocon=$.trim($("#mocon").val());
			var mop=$.trim($("#moplace").val());
      //获取设置信息
      var pri=0;
      if($("#man_pri").attr("checked")=="checked")
      {
        pri=1;
      }
      if(mocon!=""&&mop!="")
      {
      	$.post(
				  'upmod.php',
				  {
				    mycon:mocon,
				    mypl:mop,
            mypri:pri
				  },
				  function(resp){
					  $("#man_rel").text("发布成功");
          }
			  );
      }
      else
      {
        $("#man_rel").text("提交数据不能为空"); 
      }

	  });
    /**
     * 退出登录
    **/
    $("#longinout").click(function(){
      window.location="loginout.php";    
    });
    /**
     * 查看首页
    */
    $("#man_to_index").click(function(){
      window.location="index.php";    
    });
	});
function reset(){
  $("#mocon").val("");
  $("#moplace").val("");
  $("#man_rel").text("");
}
</script>
</head>
<body>
<div id="man_title"><h1>只言片语心情发布</h1></div>
<div id="man_panel">
<div id="block_left">
<div class="bk_btn"><h2>写心情</h2></div>
<div class="bk_btn" id="longinout"><h2>退出登录</h2></div>
<div class="bk_btn" id="man_to_index"><h2>查看首页</h2></div>
</div>
<div id="block_right">
  <textarea id="mocon" name="" rows="10" cols="30"></textarea>
  <input type="text" id="moplace" value="中国湖北省武汉市洪山区中国地质大学"/>
  <input type="button" id="bsub" class="btn" value="提交" />
  <input type="reset" id="reset" class="btn" value="重置" onclick="reset();" />
  <div id="man_set">
    私密信息：<input type="checkbox" value="isprivate" id="man_pri" />&nbsp;
    分享到人人：<input type="checkbox" value="isprivate" id="man_ren" />&nbsp;
    分享到微博：<input type="checkbox" value="isprivate" id="man_wei" />&nbsp;
  </div>
  <div id="man_rel"></div>
</div>
</div>
</body>
</html>
