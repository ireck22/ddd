


function songlist(){
		$.post("songlist.php", {}, function(data)
			{
			var xcv=data.split("^");//把資料庫的資料分割放到陣列
			//var table = document.getElementById("ss").createCaption();
			
			$("#song").html(xcv);
			}
		);
	
	setTimeout('songlist()',1000);   
				
}
	

		
		
