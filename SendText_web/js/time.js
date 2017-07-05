		var Today=new Date();
		function timeshow(){
			dayname= new Array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
			d=new Date();
			var show="";
			var y=(d.getYear()<10) ?"0"+ Today.getFullYear():d.getFullYear();
			var m=((d.getMonth()*1+1)<10)? "0"+(d.getMonth()*1+1):(d.getMonth()*1+1);
			var da=(d.getDate()<10)? "0"+d.getDate():d.getDate();
			var dd=(dayname[d.getDay()]<10)? "0"+dayname[d.getDay()]:dayname[d.getDay()];
			var hi=(d.getHours()<10) ? "0"+d.getHours():d.getHours();
			var mi=(d.getMinutes()<10)? "0"+d.getMinutes():d.getMinutes();
			var Si=(d.getSeconds()<10)? "0"+d.getSeconds():d.getSeconds();
		
			show+=y +"." +m +"." +da +"." +dd +"　" +hi +":" +mi +":" +Si;
			document.getElementById("show").innerHTML=show;
			setTimeout("timeshow()",1000);

		}