$(document).ready(function(){
    


  /*********************Login Validation*********************/
    $("#login_form").submit(function(e){
      e.preventDefault();
      //alert("login");
      var username = $("#username").val();
      var password = $("#password").val();
      var error = 0;
        if(username == "")
        {
            $("#username_error").html("<i class='fa fa-exclamation-triangle'></i> Provide UserName ");
            $("#username").css("border-color","red");
            error++;
        }
        else
        {
            $("#username").css("border-color","rgba(0, 40, 100, 0.12)");
            $("#username_error").empty();
        }
        
        if(password == "")
        {
            $("#password_error").html("<i class='fa fa-exclamation-triangle'></i> Provide Password ");
            $("#password").css("border-color","red");
            error++;
        }
        else
        {
            $("#password").css("border-color","rgba(0, 40, 100, 0.12)");
            $("#password_error").empty();
        }
      
        if(error == 0)
        {
          $("#login").attr("disabled", true);
          $.ajax({
            url: $("#login_form").attr("action"),
            method : "post",
            data :$("#login_form").serialize(),
            dataType : "json",
            success:function(response)
            {
              //console.log(response);
              if(response.status == 'success')
              {
                $.notify({
                  //options
                  message:response.msg
                },{
                  //setting
                  type:response.type
                }); //End of nootify
                //$("#login_form")[0].reset();
                window.setTimeout(function(){window.location = response.redirect_url},500);
              }
              else
              {
                $.notify({
                  //options
                  message:response.msg
                },{
                  //setting
                  type:response.type
                }); //End of nootify
              }
              
            }
          });
        }
    });//end of login form function


  /*********************Login Validation*********************/

    
  // alphanumeric input
  $(document).on("keypress", ".alphanumeric" ,function(e){
    charCode=e.which;
    if((charCode>=48 && charCode <=57) || (charCode==65  ||  charCode==70 || charCode==97 || charCode==102) )
      return true;
      return false;
  });// alphanumeric input ends here

  //Subjects input field hide and show starts here
	$("#semester").change(function(){
        if($(this).val()=="select")
    	{
    		$('#add_form').addClass('d-none');
    	}
    	else
    	{
    		$('#add_form').removeClass('d-none');	
    	}

    	var sem_id = $('#semester').val();
    	var sub_url = $(this).data("sub_url");
    	
        $('#hidden_sem_id').val(sem_id);
    	if(sem_id != "select" )
    	{
    		$.ajax({
    			url : sub_url,
    			method : "POST",
    			data : {id_sem : sem_id},
    			success : function(data)
    			{
    				//console.log(data);
    				$("#vtu_no").focus();
    				$('#subjects').html(data);
    			}
    		});//ajax ends here
    	}
	 });//Subjects input field hide and show  ends here

    //add form code
	$("#add_form").submit(function(e){
		e.preventDefault();
		var formData = $('#add_form').serialize();
		//console.log(formData);

        $.ajax({
            url : $(this).attr("action"),
            method : "POST",
            data : formData,
            dataType : "JSON",
            success:function(response)
            {
                $("#vtu_no").focus();
              //$("#submit").attr("disabled", true);
                //console.log(response);
                if (response.status == "success")
                {
                    $.notify({
                        //options
                        message:response.msg
                      },{
                        //setting
                        type:response.type
                      }); //End of nootify
                    $("#add_form")[0].reset();
                }
                else
                {
                    $.notify({
                        //options
                        message:response.msg
                      },{
                        //setting
                        type:response.type
                      }); //End of nootify
                }
            }
        }); //end of ajax
	}); // End add form code

    //Show list starts here
    $("#semester_list").change(function(){
        var sem_id = $(this).val();
        var sub_url = $(this).data("sub_url");
             $.ajax({
                url : sub_url,
                method : "POST",
                data : {sem_id : sem_id},
                dataType : "JSON",
                success : function(data)
                {
                    //console.log(data);
                    
                    $("#marks_list thead ").empty();
                    $("#marks_list thead ").append(
                            '<tr><th> VTU NO</th></tr>' 
                            ); //End of append
                              
                    $.each(data, function(key,value){
                        $("#marks_list thead tr").append(
                            '<th>'+value.sub_code +'</th>'
                            ); //End of append
                        
                    }); //End of each 
                    $("#marks_list thead tr ").append(
                            '<th>Action</th>' 
                            ); //End of append

                    var mark_list_url = $("#mark_list_url").val();
                    $.ajax({
                        url : mark_list_url,
                        method : "POST",
                        data : {sem_id:sem_id},
                        success : function(data)
                        {
                            //console.log(data);
                            $("#marks_list tbody ").empty();
                            $("#marks_list tbody ").append(data); //End of append
                        }
                    });
                                                  
                }
            });// End of ajax       
    });//Show list ends here
    
    //Export Excel Code Starts here
        $(document).on("click" , "#export_excel", function(){
            var sem_id = $("#semester_list").val();
            var sem = $("#semester_list option:selected").html();
            if( sem_id == "")
            {
                bootbox.alert({
                    message: "Select Semester To Download!",
                    size: 'medium'
                }); //End of bootbox
            }
            else
            {
                var downloadLink;
                var filename =sem+" "+"Sem Marks list";
                var dataType = 'application/vnd.ms-excel';
                var tableSelect = document.getElementById("marks_list");
                var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
                
                // Specify file name
                filename = filename?filename+'.xls':'excel_data.xls';
                
                // Create download link element
                downloadLink = document.createElement("a");
                
                document.body.appendChild(downloadLink);
                
                if(navigator.msSaveOrOpenBlob){
                    var blob = new Blob(['\ufeff', tableHTML], {
                        type: dataType
                    });
                    navigator.msSaveOrOpenBlob( blob, filename);
                }else{
                    // Create a link to the file
                    downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
                
                    // Setting the file name
                    downloadLink.download = filename;
                    
                    //triggering the function
                    downloadLink.click();
                }
            }
        }); //Clicl function ends here
    //Export Excel Code ends here
    




   /* $("#semester_list").change(function(){
        var sem_id = $(this).val();
        var sub_url = $(this).data("sub_url");
       
             $.ajax({
                url : sub_url,
                method : "POST",
                data : {sem_id : sem_id},
                dataType : "JSON",
                success : function(data)
                {
                    //console.log(data);
                    $("#marks_list thead ").empty();
                    $("#marks_list thead ").append(
                            '<tr><th> VTU NO</th></tr>' 
                            ); //End of append
                              
                    $.each(data, function(key,value){
                        $("#marks_list thead tr").append(
                            '<th>'+value.sub_code +'</th>'
                            ); //End of append
                        
                    }); //End of each 
                    $("#marks_list thead tr ").append(
                            '<th>Action</th>' 
                            ); //End of append

                    var mark_list_url = $("#mark_list_url").val();
                    var edit_url = $("#edit_url").val();
                    $.ajax({
                        url : mark_list_url,
                        method : "POST",
                        data : {sem_id:sem_id},
                        dataType: "JSON",
                        success : function(data)
                        {
                            //console.log(data);
                            //$("#marks_list tbody ").empty();
                            //$("#marks_list tbody ").append(data); //End of append
                            $('#marks_list').DataTable({
                            "destroy" : true,
                            "data" : data,
                            "scrollX": true,
                            "responsive" : true,
                            dom: 
                              "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-3'B><'col-sm-12 col-md-4'f>>" +
                              "<'row'<'col-sm-12'tr>>" +
                              "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                              //(l->Length changing input control) (B->Buttons) (f->Filtering Input)
                              //tr ->The Table! + Processing Display Element
                              //(i->Table Information Summary) (p->Pagination Control)
                            buttons: [
                              'copy', 'excel', 'pdf'
                              ],
                            "columns" : [
                                {"data" : "vtu_no"},
                                {"data" : "marks_list", 
                                  "render":function(data)
                                  { var mark = data.split(',');
                                    return mark[0];  }
                                },
                                {"data" : "marks_list", 
                                  "render":function(data)
                                  { var mark = data.split(',');
                                    return mark[1];  }
                                },
                                {"data" : "marks_list", 
                                  "render":function(data)
                                  { var mark = data.split(',');
                                    return mark[2];  }
                                },
                                {"data" : "marks_list", 
                                  "render":function(data)
                                  { var mark = data.split(',');
                                    return mark[3];  }
                                },
                                {"data" : "marks_list", 
                                  "render":function(data)
                                  { var mark = data.split(',');
                                    return mark[4];  }
                                },
                                {"data" : "marks_list", 
                                  "render":function(data)
                                  { var mark = data.split(',');
                                    return mark[5];  }
                                },
                                {"data" : "marks_list", 
                                  "render":function(data)
                                  { var mark = data.split(',');
                                    return mark[6];  }
                                },
                                {"data" : "marks_list", 
                                  "render":function(data)
                                  { var mark = data.split(',');
                                    return mark[7];  }
                                },
                                /*{"data" : "marks_list", 
                                  "render":function(data)
                                  { var mark = data.split(',');
                                    return mark[8];  }
                                },
                                {"data" : "marks_list", 
                                  "render":function(data)
                                  { var mark = data.split(',');
                                    return mark[9];  }
                                },*/
                                /*{"data" : "marks_list", 
                                  "render":function( data )
                                  { var markArr = data.split(',');
                                    //alert(markArr);
                                    $.each(markArr, function(index,value){
                                      //alert(value);
                                      return value;
                                    });
                                    //return markArr[0]; 
                                  }
                                },*/
                                
                                /*{"render" : function(data,type,row)
                                    {
                                    var action = /*'<div class="dropdown">'+
                                  '<a href="#" class="btn btn-outline-secondary btn-xs text-dark" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>'+
                                        '<div class="dropdown-menu " aria-labelledby="dropdownMenuLink">'+
                                        '<a href="'+edit_url+'/'+row.vtu_no+'/'+row.sem_id+'"  id="client_edit"  class="dropdown-item text-warning" ><i class="fa fa-pencil-square-o mr-1" aria-hidden="true"></i>Edit</a>'+
                                        '<a href="javascript:;" id="client_delete" data-delete_vtu="'+row.vtu_no+'" class="dropdown-item text-danger"><i class="fa fa-trash mr-1" aria-hidden="true"></i>Delete</a>'+
                                        '</div></div>';*/
                                        /*'<a href="'+edit_url+'/'+row.vtu_no+'/'+row.sem_id+'"  id="client_edit"  class=" text-warning" ><i class="fa fa-pencil-square-o mr-1" aria-hidden="true"></i></a>'+
                                        ' <span class="text-info">|</span>  '+
                                        '<a href="javascript:;" id="client_delete" data-delete_vtu="'+row.vtu_no+'" class=" text-danger"><i class="fa fa-trash mr-1" aria-hidden="true"></i></a>';
                                        return action;
                                    }
                                }   
                            ]   
                          }); //End of data table
                        }
                    });//end of ajax
                                                  
                }
            });// End of ajax
        }); */



    //update form
    $('#update_marks').submit(function(e){
        e.preventDefault();
        //alert("update ok");
        var formData = $('#update_marks').serialize();
        var url = $(this).attr("action");
        $.ajax({
            url : url,
            method : "POST",
            data : formData,
            dataType : "JSON",
            success : function(response)
            {
                //console.log(response);
                if (response.status == "success")
                {
                    $.notify({
                        //options
                        message:response.msg
                      },{
                        //setting
                        type:response.type
                      }); //End of nootify
                    window.setTimeout(function(){window.location =response.redirect_url },1000);
                }
                else
                {
                    $.notify({
                        //options
                        message:response.msg
                      },{
                        //setting
                        type:response.type
                      }); //End of nootify   
                }
            }
        }); //End of ajax
    });//End of update


    //Delete function
    $(document).on("click","#client_delete" ,function(e){
        e.preventDefault();
        //alert("delete ok");
        var delete_vtu = $(this).data("delete_vtu");
        var url = $("#marks_list").data("delete_url");
        bootbox.confirm("Do you really want to delete record?",function(result){
        if(result)
        {
            $.ajax({
                url: url,
                method : "POSt",
                data : {delete_vtu:delete_vtu},
                dataType : "JSON",
                success:function(response)
                {
                    //console.log(response);
                    if (response.status == "success")
                    {
                      $.notify({
                        //options
                        message:response.msg
                      },{
                        //setting
                        type:response.type
                      }); //End of nootify
                      window.setTimeout(function(){window.location =""},1000);
                    }
                    else
                    {
                      $.notify({
                        //options
                        message:response.msg
                      },{
                        //setting
                        type:response.type
                      }); //End of nootify
                    }
                }
            }); //End of ajax
          }
        }); //End of bootbox
    }); //End of delete


    //Truncate function
    $("#truncate").click(function(e){
      e.preventDefault();
      //alert("Truncate OK");
      var sem_id = $("#semester_list").val();
      var truncate_url = $("#semester_list").data("truncate_url");
      if(sem_id!="")
      {
        bootbox.confirm("Do you really want to delete record?",function(result){
          if(result)
          {
            $.ajax({
              url : truncate_url,
              method : 'POST',
              data : {sem_id:sem_id},
              dataType : 'JSON',
              success : function(response)
              {
                  //console.log(response);
                  if (response.status == "success")
                    {
                      $.notify({
                        //options
                        message:response.msg
                      },{
                        //setting
                        type:response.type
                      }); //End of nootify
                      window.setTimeout(function(){window.location =""},1000);
                    }
                    else
                    {
                      $.notify({
                        //options
                        message:response.msg
                      },{
                        //setting
                        type:response.type
                      }); //End of nootify
                    }
              }

            });//end of ajax 
          }
        });//end of bootbox
      }
      else
      {
        bootbox.alert({
          message: "Select semester to truncate!",
          size: 'small'
        }); //End of bootbox
      }

    });//End of truncate
   
    //Start of Result analysis
    $("#result").change(function(){
        //e.preventDefault();
        //alert("get resu");
        var sem_id = $("#result").val();
        var calc_url = $("#calc_url").val();
        if(sem_id=="")
        {
            bootbox.alert({
              message: "Select semester to Get Result!",
              size: 'small'
            }); //End of bootbox
        }
        else
        {
            $.ajax({
                url : calc_url,
                method: 'POST',
                data : {sem_id:sem_id},
                dataType : "JSON",
                success : function(data)
                {
                  $("#result_table").removeClass("d-none");
                  //console.log(data);
                   $('#result_table').DataTable({
                        order : false,
                        destroy : true,
                        "data" : data,
                        "responsive" : true,
                        dom: 
                          "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-3'B><'col-sm-12 col-md-4'f>>" +
                          "<'row'<'col-sm-12'tr>>" +
                          "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                          //(l->Length changing input control) (B->Buttons) (f->Filtering Input)
                          //tr ->The Table! + Processing Display Element
                          //(i->Table Information Summary) (p->Pagination Control)
                        buttons: [
                          'copy', 'excel', 'pdf'
                          ],
                        "columns" : [
                            {"data" : "subject"},
                            {"data" : "appeared"},
                            {"data" : "fcd" },
                            {"data" : "fc" },
                            {"data" : "sc" },
                            {"data" : "just_pass" },
                            {"data" : "fail" },
                            {"data" : "passing_percentage" }
                        ]   
                    }); //End of data table    

                } //End of success function

            });//end of ajax
        } //End of if condition
        
    }); //End of change event result analysis
}); //End of document ready