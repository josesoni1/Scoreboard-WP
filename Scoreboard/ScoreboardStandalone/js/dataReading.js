/*
GLOBAL VARIABLES
*/
 var consulta;


/*
======================================================================
      Main function. To be loaded when on document 'ready' event      
======================================================================
*/
$(function(){
	getDatos();
});





//get the data from the dt with a php request
//TODO query based on parameters
function getDatos(){

	consulta = JSON.parse(localStorage.getItem("data"));
	if (consulta == null){
    	$.ajax({
    		type: "GET",
    		url: "./php/temp.php",
    		data: {
    		},
    		success: function (data) {
    			consulta = JSON.parse(data);
				localStorage.setItem("data", data);


				showData(consulta);

	    	}
		});
	}else{

		showData(consulta);
	}
}


function showData(a){
			document.getElementById('statusbar').innerHTML= JSON.stringify(a.Aguascalientes.a2015.ap);

	for(var i in a){
				var tres = document.getElementById("results").tBodies.item(0);
				var newrow = tres.insertRow(-1);
				var col;

				var ap2015 = a[i].a2015.ap;
				var re2015 = a[i].a2015.re;
				var ap2016 = a[i].a2016.ap;
				var re2016 = a[i].a2016.re;

				col = newrow.insertCell(-1);
				col.innerHTML=i;
				col = newrow.insertCell(-1);
				col.innerHTML=ap2015||0;
				col = newrow.insertCell(-1);
				col.innerHTML=re2015||0;
	

				col = newrow.insertCell(-1);
				col.innerHTML=ap2016||0;
				col = newrow.insertCell(-1);
				col.innerHTML=re2016||0;


				col = newrow.insertCell(-1);
				col.innerHTML=(((ap2016-ap2015)/ap2015)*100).toFixed(2)||0;
				col = newrow.insertCell(-1);
				col.innerHTML=(((re2016-re2015)/re2015)*100).toFixed(2)||0;

				col = newrow.insertCell(-1);
				col.innerHTML=(ap2016-ap2015)||0;
				col = newrow.insertCell(-1);
				col.innerHTML=(re2016-re2015)||0;
		}
}








