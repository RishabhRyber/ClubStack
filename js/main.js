
function show( a ){
		if(a==1){
		  document.getElementById("headClub").style.visibility="hidden";	
		  document.getElementById("headEvents").style.visibility="visible";	
		  document.getElementById("headRec").style.visibility="visible";
		  document.getElementById("moreClub").style.visibility="visible";	
		  document.getElementById("moreEvents").style.visibility="hidden";	
		  document.getElementById("moreRec").style.visibility="hidden";	
		}else if(a==2){
		  document.getElementById("headClub").style.visibility="visible";	
		  document.getElementById("headEvents").style.visibility="hidden";	
		  document.getElementById("headRec").style.visibility="visible";
		  document.getElementById("moreClub").style.visibility="hidden";	
		  document.getElementById("moreEvents").style.visibility="visible";	
		  document.getElementById("moreRec").style.visibility="hidden";	
		}else if (a==3){
		  document.getElementById("headClub").style.visibility="visible";	
		  document.getElementById("headEvents").style.visibility="visible";	
		  document.getElementById("headRec").style.visibility="hidden";	
		  document.getElementById("moreClub").style.visibility="hidden";	
		  document.getElementById("moreEvents").style.visibility="hidden";	
		  document.getElementById("moreRec").style.visibility="visible";	
		}
}
window.onload = function () {
var i = 0, j = 0;
var txt = 'The Life Of Your Dreams is One Right Step ';
var txt2 = 'Away, Get Involved and be Successful.'; 
var speed = 50;

function typeWriter1() {
  if (i < txt.length) {
    document.getElementById("para1").innerHTML += txt.charAt(i);
    i++;
    setTimeout(typeWriter1, speed);
  }
}
function typeWriter2() {
  if (j < txt2.length) {
    document.getElementById("para2").innerHTML += txt2.charAt(j);
    j++;
    setTimeout(typeWriter2, speed);
  }
}
typeWriter1();
typeWriter2();
};
