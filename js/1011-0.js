/* 
 * Function: JavaScript form validation
 * Student ID: 026030491011-0
 * Author: Sorawit Puttaso
 */
function calTax(){
	// Coding starts here.
    let a = true;
    let b = "Text";
    let vat = 0;
    let total = 0.00;
    let in_come = document.getElementById('income').value;
    if (in_come >= 0 && in_come <= 150000) {
        vat = 0;
    }else if (in_come >= 150001 && in_come <= 300000) {
        vat = 5;
    }else if (in_come >= 300001 && in_come <= 500000) {
        vat = 10;
    }else {
        vat = 15;
    }
    total = in_come * (vat/100);
    /*alert("..."+total);
    console.log("..."+total);
    document.write("..."+total);*/
    document.getElementById('msgout').innerHTML = total;
    document.getElementById('vat').innerHTML = vat;
}

function getInto() {
    let my_name = document.getElementById('myname').value;
    let my_day = document.getElementById('myday').value;
    let my_month = document.getElementById('mymonth').value;
    let my_year = document.getElementById('myyear').value;
    let my_addr = document.getElementById('myaddr').value;
    let my_sex0 = document.getElementById('mysex0').checked;
    let my_sex1 = document.getElementById('mysex1').checked;
    let my_sex2 = document.getElementById('mysex2').checked;
    let my_cont0 = document.getElementById('mycont0').checked;
    let my_cont1 = document.getElementById('mycont1').checked;
    let my_cont2 = document.getElementById('mycont2').checked;
    let txt = "";

    let my_cont_txt = "";
    let my_sex_txt = "";

    if (my_cont0 == true) {
        my_cont_txt+= document.getElementById('mycont0').value+" , ";
    }
    if (my_cont1 == true) {
        my_cont_txt+= document.getElementById('mycont1').value+" , ";
    }
    if (my_cont2 == true) {
        my_cont_txt+= document.getElementById('mycont2').value+" , ";
    }

    if (my_sex0 == true) {
        my_sex_txt = document.getElementById('mysex0').value;
    }else if(my_sex1 == true) {
        my_sex_txt = document.getElementById('mysex1').value;
    }else {
        my_sex_txt = document.getElementById('mysex2').value;
    }

    my_cont_txt = my_cont_txt.substring(0, my_cont_txt.length - 2);

    txt+= "ข้อมูลผู้ใช้\n";
    txt+= "ชื่อ-สกุล: "+my_name+"\n";
    txt+= "วัน/เดือน/ปี: "+my_day+"/"+my_month+"/"+my_year+"\n";
    txt+= "ที่อยู่: "+my_addr+"\n";
    txt+= "เพศ: "+my_sex_txt+"\n";
    txt+= "ช่องทางติดต่อ: "+my_cont_txt+"\n";
    txt+= "Thank You.";
    alert(txt);


}

function openCity(cityName) {
  var i;
  var x = document.getElementsByClassName("book");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  document.getElementById(cityName).style.display = "block";  
}
