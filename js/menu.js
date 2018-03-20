var linkset=new Array()
//設定子目錄,注意linkset[ ]中陣列數字需與主目錄的設定相同
linkset[0]='<div class="menuitems"><a href="pre_work.php">到校前經歷資料查詢</a></div>'
linkset[0]+='<div class="menuitems"><a href="incareer.php">校內經歷查詢</a></div>'

linkset[1]='<div class="menuitems"><a href="pre_work.php">到校前經歷資料查詢</a></div>'
linkset[1]+='<div class="menuitems"><a href="incareer.php">校內經歷查詢</a></div>'
linkset[1]+='<div class="menuitems"><a href="tea_plural.php">教師兼行政職查詢</a></div>'

linkset[2]='<div class="menuitems"><a href="hp_sketch_proc_main.php">履歷表填寫作業</a></div>'
linkset[2]+='<div class="menuitems"><a href="hp_sketch_rtp.php">產生履歷表PDF檔</a></div>'

linkset[3]='<div class="menuitems"><a href="hp_sketch_rtp.php?func=proc">履歷表填寫作業</a></div>'
linkset[3]+='<div class="menuitems"><a href="hp_sketch_rtp.php">產生履歷表PDF檔</a></div>'

var ie4=document.all&&navigator.userAgent.indexOf("Opera")==-1
var ns6=document.getElementById&&!document.all
var ns4=document.layers

function showmenu(e,which,menuid){

if (!document.all&&!document.getElementById&&!document.layers)
return

clearhidemenu()

//menuobj=ie4? document.all.popmenu : ns6? document.getElementById("popmenu_"+menuid) : ns4? document.popmenu : ""
menuobj=document.getElementById("popmenu_"+menuid);
menuobj.thestyle=(ie4||ns6)? menuobj.style : menuobj

if (ie4||ns6)
menuobj.innerHTML=which
else{
menuobj.document.write('<layer name=gui bgColor=#E6E6E6 width=165 onmouseover="clearhidemenu()" onmouseout="hidemenu()">'+which+'</layer>')
menuobj.document.close()
}

menuobj.contentwidth=(ie4||ns6)? menuobj.offsetWidth : menuobj.document.gui.document.width
menuobj.contentheight=(ie4||ns6)? menuobj.offsetHeight : menuobj.document.gui.document.height
eventX=ie4? event.clientX : ns6? e.clientX : e.x
eventY=ie4? event.clientY : ns6? e.clientY : e.y

//Find out how close the mouse is to the corner of the window
var rightedge=ie4? document.body.clientWidth-eventX : window.innerWidth-eventX
var bottomedge=ie4? document.body.clientHeight-eventY : window.innerHeight-eventY

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<menuobj.contentwidth)
//move the horizontal position of the menu to the left by it's width
menuobj.thestyle.left=ie4? document.body.scrollLeft+eventX-menuobj.contentwidth : ns6? window.pageXOffset+eventX-menuobj.contentwidth : eventX-menuobj.contentwidth
else
//position the horizontal position of the menu where the mouse was clicked
menuobj.thestyle.left=ie4? document.body.scrollLeft+eventX : ns6? window.pageXOffset+eventX : eventX

//same concept with the vertical position
if (bottomedge<menuobj.contentheight)
menuobj.thestyle.top=ie4? document.body.scrollTop+eventY-menuobj.contentheight : ns6? window.pageYOffset+eventY-menuobj.contentheight : eventY-menuobj.contentheight
else
menuobj.thestyle.top=ie4? document.body.scrollTop+event.clientY : ns6? window.pageYOffset+eventY : eventY
menuobj.thestyle.visibility="visible"
return false
}

function contains_ns6(a, b) {
//Determines if 1 element in contained in another- by Brainjar.com
while (b.parentNode)
if ((b = b.parentNode) == a)
return true;
return false;
}

function hidemenu(){
if (window.menuobj)
menuobj.thestyle.visibility=(ie4||ns6)? "hidden" : "hide"
}

function dynamichide(e){
if (ie4&&!menuobj.contains(e.toElement))
hidemenu()
else if (ns6&&e.currentTarget!= e.relatedTarget&& !contains_ns6(e.currentTarget, e.relatedTarget))
hidemenu()
}

function delayhidemenu(){
if (ie4||ns6||ns4)
delayhide=setTimeout("hidemenu()",500)
}

function clearhidemenu(){
if (window.delayhide)
clearTimeout(delayhide)
}

function highlightmenu(e,state,menuid){
if (document.all)
source_el=event.srcElement
else if (document.getElementById)
source_el=e.target
if (source_el.className=="menuitems"){
source_el.id=(state=="on")? "mouseoverstyle" : ""
}
else{
while(source_el.id!="popmenu_"+menuid){
source_el=document.getElementById? source_el.parentNode : source_el.parentElement
if (source_el.className=="menuitems"){
source_el.id=(state=="on")? "mouseoverstyle" : ""
}
}
}
}

if (ie4||ns6)
document.onclick=hidemenu

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}