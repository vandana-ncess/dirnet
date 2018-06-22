<html>  
      <head>  
           <title>Webslesson Tutorial | Autocomplete textbox using jQuery, PHP and MySQL</title>  
           <link rel="stylesheet" href="css/bootstrap.min.css" />  
           <script src="js/bootstrap.min.js"></script>  
           <script src="js/jquery.min.js"></script>  
           <style>  
           ul{  
                background-color:#eee;  
                cursor:pointer;  
           }  
           li{  
                padding:12px;  
           }  
           </style>  
      </head>  
      <body>  
           <br /><br />  
           <div class="container" style="width:500px;">  
                <h3 align="center">Autocomplete textbox using jQuery, PHP and MySQL</h3><br />  
                <label>Enter Country Name</label>  
                <input type="hidden" name="txtID" id="txtID" />
                <input type="text" name="country" id="country" class="form-control" placeholder="Enter Country Name" />  
                <div id="countryList"></div>  
           </div>  
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){  
      $('#country').keyup(function(){  
           var query = $(this).val();  
           if(query != '')  
           {  
                $.ajax({  
                     url:"getEmployee.php",  
                     data:{query:query},  
                     success:function(data)  
                     {  
                          $('#countryList').fadeIn();  
                          $('#countryList').html(data);  
                     }  
                });  
           }  
      });  
      $(document).on('click', 'li', function(){  
           $('#country').val($(this).text());  
           $('#txtID').val(this.id);
           $('#countryList').fadeOut();  
      });  
 });  
 </script>  