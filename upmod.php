<?php 
	if(isset($_POST["mycon"])&&isset($_POST["mypl"])&&isset($_POST["mypri"]))
	{
    include_once 'conn.php';
    mysql_query("SET NAMES 'utf8'"); 
    mysql_query("SET CHARACTER_SET_CLIENT=utf8"); 
    mysql_query("SET CHARACTER_SET_RESULTS=utf8"); 
    date_default_timezone_set("PRC");
    $temcon=$_POST["mycon"];
    $templ=$_POST["mypl"];
    $pri=$_POST["mypri"];
    $mdt=strtotime(date("Y-m-d H:i:s"));
    //写入数据库
    $sql_addtester="INSERT INTO mocon(mdplace,mdcon,mdtime,isprivate) VALUES('$templ','$temcon','$mdt','$pri')";
    if(!mysql_query($sql_addtester))
    {
      echo mysql_error();
    }
	}
?>
