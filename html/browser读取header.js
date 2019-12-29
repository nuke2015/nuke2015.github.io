xmlhttp = new XMLHttpRequest();
xmlhttp.open("HEAD", document.URL ,true);
xmlhttp.onreadystatechange=function() {
if (xmlhttp.readyState==4) {
  console.log(xmlhttp.getAllResponseHeaders());
  }
}
xmlhttp.send();