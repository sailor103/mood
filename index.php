<?php
session_start();
$_SESSION['username']=!empty($_SESSION['username']) ? $_SESSION['username'] : null;
//验证page
if(isset($_GET['page'])&&is_numeric($_GET['page']))
{
	$page=intval($_GET['page']);    
}
else
{
	$page=1;
}
include_once 'conn.php';
mysql_query("SET NAMES 'utf8'"); 
mysql_query("SET CHARACTER_SET_CLIENT=utf8"); 
mysql_query("SET CHARACTER_SET_RESULTS=utf8"); 
date_default_timezone_set("PRC");
//每页显示数据    
$num=11;         
if($_SESSION['username']=="")
{
  $total=mysql_num_rows(mysql_query("select `id` from `mocon` where `isprivate`=0")); 
}
else
{
  $total=mysql_num_rows(mysql_query("select `id` from `mocon`")); 
}
$pagenum=ceil($total/$num);      
//假如传入的页数参数apge 大于总页数 pagenum，则显示错误信息
if($page>$pagenum || $page <= 0)
{
	header("Location:index.php"); 
}
//(传入的页数-1) * 每页的数据 得到limit第一个参数的值
$offset=($page-1)*$num;         
//获取相应页数所需要显示的数据
if($_SESSION['username']=="")
{
  $info=mysql_query("select * from `mocon` where `isprivate`=0 order by `mdtime` DESC limit $offset,$num");   
}
else
{
  $info=mysql_query("select * from `mocon` order by `mdtime` DESC limit $offset,$num");   
}
while($it=mysql_fetch_array($info))
{
   $tem[]=array($it['id'],date("Y-m-d H:i:s",$it['mdtime']),$it['mdplace'],$it['mdcon']);
}                                                              
//分页信息
$pre=$page-1;
$nex=$page+1;
?>  
<!DOCTYPE HTML>
<head>
<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="UTF-8" />
<title>只言片语</title>
<link rel="shortcut icon" href="/images/favicon.ico"/>
<link rel="stylesheet" href="mood.css" type="text/css"/>
<script type="text/javascript" src="js/jq.js"></script>
<script type="text/javascript">
  var allpage=<?php echo $pagenum;?>;
  var inipage=1;
  $(document).ready(function(){
    $("#a_more").click(function(){
      inipage=inipage+1;
      var url="index.php?page="+inipage;
      if(inipage<=allpage)
      {
        $.ajax({
          url:url,
          type:'get',
          dataType:'text',
          success:function(resp){
            $(".block_more").before($(resp).find(".block_item"));   
            if(inipage==allpage)
            {
              $(".block_more").remove();
            }
          }
        }); 
      }
    });
	<?php if($_SESSION['username']!=""):?>
	/**
	 * 删除一条心情
	 */
	$(".item_del").click(function(){
	  var v_mid=$(this).attr("id");
    var tem_this=$(this);
    $.ajax({
      url:"delmod.php",
      type:'post',
      data:{id:v_mid},
      dataType:'json',
      success:function(resp){
        if(resp['status']=="yes")
        {
          tem_this.parent().parent().remove();
        }
        else
        {
          alert(resp['msg']);
        }
      }
    });
	});
	<?php endif;?>
  });
</script>
</head>
<body>
<div id="dx_header">
  <div id="head_left"><h1><a href="index.php"><img src="images/logo.png"></a></h1></div>
  <div id="head_right">
    <a id="hd_home" href="index.php" class="nav1" title="返回首页"></a>
    <a id="hd_lab" href="http://lab.yqc.im" target="_blank" class="nav2" title="实验室"></a>
    <a id="hd_blog" href="http://blog.yqc.im" target="_blank" class="nav3" title="博客"></a>
    <a id="hd_about" href="http://about.yqc.im" target="_blank" class="nav4" title="关于我"></a>
  </div>
</div>
<div id="itemlist">
<?php foreach($tem as $item):?>
<div class="block_item">
  <div class="qb"></div>
  <p class="itemcon"><?php echo $item[3];?></p>
  <p class="itemmeta">时间：<?php echo $item[1];?>&nbsp;&nbsp;地点：<?php echo $item[2];?>
  <?php if($_SESSION['username']!=""):?>
	<a class="item_del" id="<?php echo $item[0];?>" href="javascript:void(0);">删除</a>
  <?php endif;?>
  </p>
  <div class="qa">”</div>
</div>
<?php endforeach;?>
<div class="block_more"><p class="con_more"><a id="a_more" href="javascript:void(0);">More</a></p></div>

</div>
</body>
</html>
