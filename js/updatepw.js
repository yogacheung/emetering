function update(name, oldpassword, newpassword, callback){
  $.ajax({    
    url: "/updatepw.php?name="+name+"&oldpassword="+oldpassword+"&newpassword="+newpassword,
  })
  .done(callback);
}

///////////////////////////////////////////////////////////

function onupdate() {
  var gname = document.getElementById("name").value;
  var goldpw = document.getElementById("oldpassword").value;
  var mdoldpw = CryptoJS.MD5(goldpw).toString();
  var gnewpw1 = document.getElementById("newpassword1").value;
  var gnewpw2 = document.getElementById("newpassword2").value;

  if(gnewpw1 != gnewpw2){
    alert("New Passwords are NOT match!");
  }else{
    var mdnewpw = CryptoJS.MD5(gnewpw2).toString();

    update(gname, mdoldpw, mdnewpw, function(res){
      if(res == "no"){      
        alert("Error! Please input again!");
      }else{
	      if(confirm("Success!")) window.location.href = res;
      }
    });
  }  
}