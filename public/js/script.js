accesIframe();
accesIframe1();
accesIframe3();
accesIframe4();
// Recuperation des chps de l'Iframe de capture d'écran
function accesIframe(){
	var Nbr = window.frames["myFrame"].document.getElementById("nbr").value;
	if (Nbr == 0){document.getElementById('myFrame').style.display = 'none';
	}else{document.getElementById('myFrame').style.display = '';}
	document.getElementById("nbr_image").innerHTML = "<input type='hidden' name='nbr' value='"+Nbr+"'><label>Ce jeux contient "+Nbr+" capture(s)</label>";
	if (Nbr > 0) {
		for (i = 1; i <= Nbr; i++)
		{
			var ImgIdFrame = window.frames["myFrame"].document.getElementById("id_capture_"+i).value;
			var ImgTitleFrame = window.frames["myFrame"].document.getElementById("titre_image_"+i).value;
			var ImgTextFrame = window.frames["myFrame"].document.getElementById("legend_capture_"+i).value;
			var maDiv = document.createElement("div");
			maDiv.id = "capture_"+i;
			document.getElementById("captures_chps").appendChild(maDiv);
			document.getElementById("capture_"+i).innerHTML = "<input type='hidden' name='id_capture_"+ +i+"' value='"
			+ImgIdFrame+"'> <input type='hidden' name='title_capture_"+ +i+"' value='"
			+ImgTitleFrame+"'> <input type='hidden' name='legend_capture_"+ +i+"' value='"
			+ImgTextFrame+"'>";
		}
	}
}

// Recuperation des chps de l'Iframe de videolink
function accesIframe1(){
	var Nbr1 = window.frames["myFrame1"].document.getElementById("nbr1").value;
	if (Nbr1 == 0){document.getElementById('myFrame1').style.display = 'none';
	}else{document.getElementById('myFrame1').style.display = '';}
	document.getElementById("nbr_videoslinks").innerHTML = "<input type='hidden' name='nbr1' value='"+Nbr1+"'><label>Ce jeux contient "+Nbr1+" vidéo(s)</label>";
	if (Nbr1 > 0) {
		for (i = 1; i <= Nbr1; i++)
		{
			var videolinkIdFrame = window.frames["myFrame1"].document.getElementById("id_videolink_"+i).value;
			var videolinkTitleFrame = window.frames["myFrame1"].document.getElementById("titre_videolink_"+i).value;
			var videolinkTextFrame = window.frames["myFrame1"].document.getElementById("link_videolink_"+i).value;
			var maDiv = document.createElement("div");
			maDiv.id = "videolink_"+i;
			document.getElementById("videoslinks_chps").appendChild(maDiv);
			document.getElementById("videolink_"+i).innerHTML = "<input type='hidden' name='id_videolink_"+ +i+"' value='"
			+videolinkIdFrame+"'> <input type='hidden' name='title_videolink_"+ +i+"' value='"
			+videolinkTitleFrame+"'> <input type='hidden' name='link_videolink_"+ +i+"' value='"
			+videolinkTextFrame+"'>";
		}
	}
}



// Recuperation des chps de l'Iframe de download
function accesIframe4(){
	var Nbr4 = window.frames["myFrame4"].document.getElementById("nbr4").value;
	if (Nbr4 == 0){document.getElementById('myFrame4').style.display = 'none';
	}else{document.getElementById('myFrame4').style.display = '';}
	document.getElementById("nbr_downloads").innerHTML = "<input type='hidden' name='nbr4' value='"+Nbr4+"'><label>Ce jeux contient "+Nbr4+" téléchargement(s)</label>";
	if (Nbr4 > 0) {
		for (i = 1; i <= Nbr4; i++)
		{
			var downloadIdFrame = window.frames["myFrame4"].document.getElementById("id_download_"+i).value;
			var downloadTitleFrame = window.frames["myFrame4"].document.getElementById("titre_download_"+i).value;
			var downloadTextFrame = window.frames["myFrame4"].document.getElementById("link_download_"+i).value;
			var maDiv = document.createElement("div");
			maDiv.id = "download_"+i;
			document.getElementById("downloads_chps").appendChild(maDiv);
			//console.log(ImgIdFrame); //alert(oFrame); //document.getElementById("demo").innerHTML = ImgIdFrame + ImgTitleFrame + ImgTextFrame;
			document.getElementById("download_"+i).innerHTML = "<input type='hidden' name='id_download_"+ +i+"' value='"
			+downloadIdFrame+"'> <input type='hidden' name='title_download_"+ +i+"' value='"
			+downloadTitleFrame+"'> <input type='hidden' name='link_download_"+ +i+"' value='"
			+downloadTextFrame+"'>";
		}
	}
}
// COnglet Classification
function accesIframe3(){
	var Nbr3 = window.frames["myFrame3"].document.getElementById("nbr3").value;
	if (Nbr3 == 0){document.getElementById('myFrame3').style.display = 'none';
	}else{document.getElementById('myFrame3').style.display = '';}
	document.getElementById("nbr_classifications").innerHTML = "<input type='hidden' name='nbr3' value='"+Nbr3+"'><label>Game classification</label>";
	if (Nbr3 > 0) {
		for (i = 1; i <= Nbr3; i++)
		{
			var idClassificationFrame = window.frames["myFrame3"].document.getElementById("id_classification"+i).value;
			var checkClassificationFrame = window.frames["myFrame3"].document.getElementById("check_classification"+i).value;
			var maDiv = document.createElement("div");
			maDiv.id = "classification_"+i;
			document.getElementById("classifications_chps").appendChild(maDiv);
			//console.log(ImgIdFrame); //alert(oFrame); //document.getElementById("demo").innerHTML = ImgIdFrame + ImgTitleFrame + ImgTextFrame;
			document.getElementById("classification_"+i).innerHTML = "<input type='hidden' name='id_classification"+ +i+"' value='"
			+idClassificationFrame+"'> <input type='hidden' name='check_classification"+ +i+"' value='"
			+checkClassificationFrame+"'>";
		}
	}
}
//-------------------------------------------------------------------------------------------------

// Recuperation des chps de l'Iframe des platforms
function accesIframe2(){
	var Nbr2 = window.frames["myFrame2"].document.getElementById("nbr2").value;
	if (Nbr2 == 0){document.getElementById('myFrame2').style.display = 'none';
	}else{document.getElementById('myFrame2').style.display = '';}
	document.getElementById("nbr_platform").innerHTML = "<input type='hidden' name='nbr_platform' value='"+Nbr2+"'><label>Ce jeu compte "+Nbr2+" platform(s)</label>";
	if (Nbr2 > 0) {
		for (i = 1; i <= Nbr2; i++)
		{
			var platformId_game_Frame = window.frames["myFrame2"].document.getElementById("platformId_game_"+i).value;
			var cover_game_Frame = window.frames["myFrame2"].document.getElementById("cover_game_name_"+i).value;
			var release_date_game_Frame = window.frames["myFrame2"].document.getElementById("datepicker"+(i-1)).value;
			var informations_game_Frame = window.frames["myFrame2"].document.getElementById("informations_game_"+i).value;
			var characteristics_game_Frame = window.frames["myFrame2"].document.getElementById("characteristics_game_"+i).value;
			var download_link_game_Frame = window.frames["myFrame2"].document.getElementById("download_link_game_"+i).value;
			var maDiv = document.createElement("div");
			maDiv.id = "plat"+i;
			document.getElementById("platform_chps").appendChild(maDiv);
			document.getElementById("plat"+i).innerHTML =
				"<input type='hidden' name='id_platform_"+ +platformId_game_Frame+"' value='"+platformId_game_Frame+"'>"+
				"<input type='hidden' name='cover_game_"+ +platformId_game_Frame+"' value='"+cover_game_Frame+"'>"+
				"<input type='hidden' name='release_date_game_"+ +platformId_game_Frame+"' value='"+release_date_game_Frame+"'>"+
				"<input type='hidden' name='informations_game_"+ +platformId_game_Frame+"' value='"+informations_game_Frame+"'>"+
				"<textarea name='characteristics_game_"+ +platformId_game_Frame+"' style='display:none;'>"+characteristics_game_Frame+"</textarea>"+
				"<input type='hidden' name='download_link_game_"+ +platformId_game_Frame+"' value='"+download_link_game_Frame+"'>";
		}
	}
}
