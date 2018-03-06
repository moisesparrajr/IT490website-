 var uc = getCookie("id");
var jc  = getCookie("jwt");

	$.ajax({
                url : 'validate.php',
                type : "POST",
                data: {'id':uc, 'jwt':jc},
                datatype: "text",
                success: function(data){
                        if(data == 'valid') 
                        {
                                return;
                        }       
                        else
                        {
                                location.href = "login.html";
                                return;
                        }
                }
        });

