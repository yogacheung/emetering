var log = console.log.bind(console);

///////////////////////////////////////////////////////////

var resList = [];

function geteMeterData(date, callback){
  $.ajax({            
      url: "/emetering.php?date=" + date + "&tlength=1",      
      dataType:"json",  
    })
    .done(callback);
}

function geteMeterCurrent(callback){
  $.ajax({            
      url: "/emeteringcurrent.php",
      dataType:"json",  
    })
    .done(callback);
}

///////////////////////////////////////////////////////////

function onReset() {
  endloading();
  document.getElementById("createtable").innerHTML = '<table class="ui selectable celled table"> <thead> <tr> <th>Begin Date</th> <th>End Date</th> <th>Unit</th> <th>Reading</th> </tr> </thead> <tbody> <tr> <td>-</td> <td>-</td> <td>-</td> <td>-</td> </tr> </tbody> </table>';
}

function onSearch(){
  var date = "";
  date = document.getElementById("date").value;
  //alert(date);
  if(date == ""){
    alert("Please select the cut-off date!");
  }else {
  	loading();

    geteMeterData(date, function(msg) {    
      resList = msg;          
      //log(resList);          
      redraw();
    });       
  }

}

function logout(){
	if(confirm("Comfirm to logout?")){
		window.location.href = "./index.html";
	}
}

function getCurrent(){
	geteMeterCurrent(function(result){
		//log(result);		
		var content = '';
		for(var i=0; i<result.length; i++){			
			content += '<table class="ui celled table"><thead><tr class="center aligned"><th>'+result[i].Unit+'</th></tr></thead><tbody><tr class="center aligned"><td>'+result[i].Reading+'</td></tr></tbody></table>';
		}
  		document.getElementById("current").innerHTML = content;
	});
}

function loading(){
	document.getElementById("loading").innerHTML = '<div class="ui active inline loader"></div> Please wait. Data is loading ......';
}

function endloading(){
	document.getElementById("loading").innerHTML = '';
}

function redraw() {    
  document.getElementById("createtable").innerHTML = '';
  endloading();

  if(resList.length>0){
	  var content = '<table id="table" class="ui selectable celled table"><thead><tr><th>Begin Date</th><th>End Date</th><th>Unit</th><th>Reading</th></tr></thead><tbody>';        
  
	  for (var i = 0; i < resList.length; i++) {    
	    var row = resList[i];
	    //log(row);      
	  	content += '<tr>' +
	      '<td>'+ row.StartDate +'</td>' +
	      '<td>'+ row.EndDate +'</td>' +
	      '<td>'+ row.Unit +'</td>';
	      
	      if(row.Reading > 10){
	        content += '<td class="positive">'+ row.Reading +'</td>';
	      }else if(row.Reading >= 1 && row.Reading <= 10){
	        content += '<td class="warning">'+ row.Reading +'</td>';
	      }else if(row.Reading < 1){
	        content += '<td class="negative">'+ row.Reading +'</td>';
	      }
	      
	      content += '</tr>';
	  }
	
	   content += '</tbody></table>';
	
	  document.getElementById("createtable").innerHTML = content;    
  }else{
	  document.getElementById("createtable").innerHTML = '<table class="ui selectable celled table"> <thead> <tr> <th>Begin Date</th> <th>End Date</th> <th>Unit</th> <th>Reading</th> </tr> </thead> <tbody> <tr> <td>No Data</td> <td>-No Data-</td> <td>-No Data-</td> <td>-No Data-</td> </tr> </tbody> </table>';
  }
  
}