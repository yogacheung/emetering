var log = console.log.bind(console);

///////////////////////////////////////////////////////////

var resList = [];

function geteMeterData(date, callback){
  $.ajax({            
      url: "/emetering.php?date=" + date + "&tlength=12",      
      dataType:"json",  
    })
    .done(callback);
}

///////////////////////////////////////////////////////////

function onReset() {
  document.getElementById("createtable").innerHTML = '<table class="ui selectable celled table"> <thead> <tr> <th>Begin Date</th> <th>End Date</th> <th>Unit</th> <th>Reading</th> </tr> </thead> <tbody> <tr> <td>-</td> <td>-</td> <td>-</td> <td>-</td> </tr> </tbody> </table>';
}

function onSearch(){
  var date = "";
  date = document.getElementById("date").value;
  //alert(date);
  if(date == ""){
    alert("Please select the cut-off date!");
  }else {
    geteMeterData(date, function(msg) {    
      resList = msg;          
      //log(resList);          
      redraw();
    });       
  }

}

function redraw() {    
  document.getElementById("createtable").innerHTML = '';

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