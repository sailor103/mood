function SetCookie(name,value)
{
    var Days = 30; 
    var exp  = new Date();    //new Date("December 31, 9998");
    exp.setTime(exp.getTime() + Days*24*60*60*1000);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function getCookie(name)  
{
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
     if(arr != null) return unescape(arr[2]); return null;

}
function delCookie(name)
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}
//vars
var endtime = new Date().getTime();
var timeID;

//time function
function lxfEndtime(tz){

	var nowtime = new Date().getTime();
	var youtime = endtime-nowtime;
	var seconds = youtime/1000;
	var minutes = Math.floor(seconds/60);
	var hours = Math.floor(minutes/60);
	var days = Math.floor(hours/24);
	var CDay= days ;
	var CHour= hours % 24;
	var CMinute= minutes % 60;
	var CSecond= Math.floor(seconds%60);
	var disMin;
	var disSec;
	if(endtime<=nowtime)
	{
		clearTimeout(timeID);
		//alert("ÒÑ¹ýÆÚ");
		//$('body').load("task2.php");
		var url='./'+tz;
		window.location.href=url;
	}
	else
	{
		//display ontime
		disMin=CMinute.toString(10);
		disSec=CSecond.toString(10);
		if(disMin.length==1)
		{
			disMin="0"+disMin;
		}
		if(disSec.length==1)
		{
			disSec="0"+disSec;
		}
		$("#timer_mins p").html(disMin);
		$("#timer_seconds p").html(disSec);
		timeID=setTimeout("lxfEndtime("+"'"+tz+"')",1000);
	}
}
