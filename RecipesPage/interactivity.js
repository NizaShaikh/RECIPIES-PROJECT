// <!-- javascript -->

/* <script type="text/javascript"> */

function search() {
let filter = document.getElementById('find').value.toUpperCase();
let item = document.querySelectorAll('.food');
let l = document.getElementsByTagName('.recipes p');
for(var i = 0;i<=l.length;i++){
let a=item[i].getElementsByTagName('.recipes p')[0];
let value=a.innerHTML || a.innerText || a.textContent;
if(value.toUpperCase().indexOf(filter) > -1) {
item[i].style.display="";
}
else
{
item[i].style.display="none";
}
}
}
