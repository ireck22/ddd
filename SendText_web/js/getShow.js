	var time = 0;
	var tmpdata = "";
function SetCookie(name,value)
{
    var exp  = new Date();    
    exp.setTime(exp.getTime() + 60*60*1000);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function getCookie(name)//取cookies函数        
{
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
     if(arr != null) return unescape(arr[2]); return null;

}
function delCookie(name)//删除cookie
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}
	
	
	
function myrefresh()
{
  window.location.reload();
}

function end()
{	
	var i=0;
	var s=0;
	var audio = document.getElementById("hello");
	var testtrue=audio.ended;  //偵測歌曲有沒有結束
	$("#you").text(testtrue);
	 i++;
	$("#you2").text(i);	
	setTimeout('end()',1000);  //每1秒鐘偵測歌曲有沒有結束
	if(testtrue==true){     //歌曲播完後進入repeat()跑下一首播放
	repeat();             
	}
}
	
    function getmessage(){
		$.post('query_message.php', {}, function(data)
		{
			//if(data!="noChange") {
			var res=data.split("^"); //"^"分隔符號
			var tmp2=res[1];
			var tmpdata=res[0];
			SetCookie("song",tmp2);
			$("#you").text(tmpdata);
			$("#music_name").text(tmpdata);//顯示歌名	
				if(tmpdata!="")
				{
					$.post("getmusic.php",{keyword:tmpdata}, function(tmpdata)
						{
							
							//alert(tmpdata); //網址測試區
							//$("#music_player").html(tmpdata);
							$("#music_player").html('<audio id="hello" src="'+ tmpdata +'" controls="autoplay"> </audio>');	//放歌
							//alert("test1");
							end();    //進入end()偵測歌曲有沒有結束
							
						}
					);	
				}
			
			//} 
			else 
			{
				$("#music_name").text(tmpdata);
			}
			
			
					
    		}
		);
		
		//setTimeout('getmessage()',10000);
}

//setTimeout('myrefresh()',600000);

function repeat(){	   //做下一首播放
			var On = getCookie('song');
			var tes=On;		
			//$("#you").text(tes);//顯示歌名
			$("#you2").text("56655");//顯示歌名
			$.post('sqlyou.php',{keyword:tes},function(tes2){
					$("#you2").text(tes2);
					$("#music_name").text(tes2);//顯示歌名
					  $.post("getmusic.php",{
						keyword:tes2
					}, function(tes2) {
						//alert(tes2);
						//$("#music_player").html(tmpdata);
						$("#music_player").html('<audio id="hello" src="'+ tes2 +'" controls="autoplay"> </audio>'); //放歌
							
							});
				
						}
					 );
				}




