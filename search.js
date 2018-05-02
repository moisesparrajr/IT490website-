function search() {

 var name = document.getElementById("searchForm").elements["searchItem"].value;
   var pattern = name.toLowerCase();
   var targetId = "";
   var responds = $.ajax({
      url : 'rpc_client.php',
      type : 'GET',
      data:  {'user':$in_user,},
      datatype: "text",

  var input, filter, table, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
}