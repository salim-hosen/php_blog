$(document).ready(function(){
  $(document).on("click",".admSidebar p",function(){
    var height = $(this).parent().innerHeight();

    if(height <= 42){
      $(this).siblings("ul").slideDown('slow');
      $(this).parent().find("i").removeClass("fa-angle-down");
      $(this).parent().find("i").addClass("fa-angle-up");
    }else{
      $(this).siblings("ul").slideUp('slow');
      $(this).parent().find("i").removeClass("fa-angle-up");
      $(this).parent().find("i").addClass("fa-angle-down");
    }
  });

  $(document).on("click","#addCat",function(){
    $(".welcome").remove();
    $.ajax({
      url: "../ajax/category.php",
      type: "POST",
      data: "action=addCat",
      dataType: "html",
      success: function(data){
        if(data === ""){
          $('.admContent').html("Failed to Load Content.");
        }else{
          $('.admContent').html(data);
        }
      }
    });
  });

  $(document).on("submit","#userLogin",function(e){
    e.preventDefault();
    var dataValue = $(this).serialize()+"&action=userLogin";

    $.ajax({
      url: "../ajax/login.php",
      type: "POST",
      data: dataValue,
      dataType: "html",
      success: function(data){
        if(data === "success"){
          window.location = "index.php";
        }else{
          $("#notification>p").html(data);
          $("#notification").addClass("error");
          $(".notificationBox").css("top","10px");
          $("#notification").fadeIn();
        }
      }
    });
    setTimeout(function(){
      $("#notification").fadeOut();
    },2000);
    return false;
  });

  $(document).on("submit","#addCatForm",function(){
    var dataValue = $(this).serialize()+"&action=addCategory";

    $.ajax({
      url: "../ajax/category.php",
      type: "POST",
      data: dataValue,
      dataType: "html",
      success: function(data){
        if(data === "success"){
          $("#notification>p").html("Category Inserted Successfully");
          $("#notification").removeClass("error");
          $("#notification").addClass("success");
          $(".notificationBox").css("top","10px");
          $("#notification").fadeIn();
        }else{
          $("#notification>p").html(data);
          $("#notification").removeClass("success");
          $("#notification").addClass("error");
          $(".notificationBox").css("top","10px");
          $("#notification").fadeIn();
        }
      }
    });
    setTimeout(function(){
      $("#notification").fadeOut();
    },2000);
    return false;
  });

  $(document).on("click","#catList",function(){
    var dataValue = $(this).serialize()+"&action=getCatList";

    $.ajax({
      url: "../ajax/category.php",
      type: "POST",
      data: dataValue,
      dataType: "html",
      success: function(data){
        if(data != ""){
          $(".admContent").html(data);
        }else{
          alert("NO Data Found.");
        }
      }
    });
  });

  $(document).on("click","#catEdit,#catDel",function(){
    var catId = $(this).parent().siblings("td:nth-child(2)").children("input").attr("id");
    var dataValue = "";
    var action = "";
    var row = $(this).parent().parent();
    if(this.id === "catEdit"){
      var catName = $(this).parent().siblings("td:nth-child(2)").children("input").val();
      action = "upCategory";
      dataValue = "category="+catName+"&catId="+catId+"&action="+action;
    }else{
      if(confirm("Are you sure to Delete?")){
        action = "delCategory";
        dataValue = "catId="+catId+"&action="+action;
      }else{
        return false;
      }
    }

    $.ajax({
      url: "../ajax/category.php",
      type: "POST",
      data: dataValue,
      dataType: "html",
      success: function(data){
        if(data === "success"){
          if(action === "upCategory"){
            $("#notification>p").html("Category Updated Successfully");
          }else{
            row.remove();
            $("#notification>p").html("Category Deleted Successfully");
          }
          $("#notification").removeClass("error");
          $("#notification").addClass("success");
          $(".notificationBox").css("top","10px");
          $("#notification").fadeIn();
        }else{
          $("#notification>p").html(data);
          $("#notification").removeClass("success");
          $("#notification").addClass("error");
          $(".notificationBox").css("top","10px");
          $("#notification").fadeIn();
        }
      }
    });
    setTimeout(function(){
      $("#notification").fadeOut();
    },2000);
    return false;
  });

  $(document).on("click","#addPostPage",function(){
    $.ajax({
      url: "../ajax/post.php",
      type: "POST",
      data: "action=addPostPage",
      dataType: "html",
      success: function(data){
        if(data === ""){
          $('.admContent').html("Failed to Load Content.");
        }else{
          $('.admContent').html(data);
          CKEDITOR.replace("content_body");
        }
      }
    });

    return false;
  });

  $(document).on("submit","#postForm",function(e){
    e.preventDefault();
    $.ajax({
      url: "../ajax/post.php",
      type: "POST",
      data: new FormData(this),
      dataType: "html",
      async: false,
      success: function(data){
        if(data === "success"){
          $("#notification>p").html("Post Added Successfully");
          $("#notification").removeClass("error");
          $("#notification").addClass("success");
          $(".notificationBox").css("top","10px");
          $("#notification").fadeIn();
        }else{
          $("#notification>p").html(data);
          $("#notification").removeClass("success");
          $("#notification").addClass("error");
          $(".notificationBox").css("top","10px");
          $("#notification").fadeIn();
        }
      },
      cache: false,
      contentType: false,
      processData: false
    });

    setTimeout(function(){
      $("#notification").fadeOut();
    },2000);
    return false;
  });

  $(document).on("click","#postListPage",function(){
    $.ajax({
      url: "postList.php",
      success: function(data){
        if(data === ""){
          $('.admContent').html("Failed to Load Content.");
        }else{
          $('.admContent').html(data);
          $(".firstTable").DataTable({
            lengthMenu: [
            [ 5, 10, 15, -1 ],
              [ '5 rows', '10 rows', '15 rows', 'Show all' ]
            ]
          });
        }
      },
      cache: false
    });
    return false;
  });

  $(document).on("click","#postDel",function(){
    var postId = $(this).parent().attr("id");
    var row = $(this).parent().parent();
    var image = row.find("img").attr("src");

    if(confirm("Are you sure to Delete?")){
      var dataValue = "postId="+postId+"&image="+image+"&action=delPost";
      $.ajax({
        url: "../ajax/post.php",
        type: "POST",
        data: dataValue,
        dataType: "html",
        success: function(data){
          if(data === "success"){
            row.remove();
            $("#notification>p").html("Post Deleted Successfully");
            $("#notification").removeClass("error");
            $("#notification").addClass("success");
            $(".notificationBox").css("top","10px");
            $("#notification").fadeIn();
          }else{
            $("#notification>p").html(data);
            $("#notification").removeClass("success");
            $("#notification").addClass("error");
            $(".notificationBox").css("top","10px");
            $("#notification").fadeIn();
          }
        }
      });
      setTimeout(function(){
        $("#notification").fadeOut();
      },2000);
    }else{
      return false;
    }
    return false;
  });

  $(document).on("click","#postEdit",function(){
    $(".modal").fadeIn();
    var dataValue = "postId="+$(this).parent().attr("id");
    $.ajax({
      url: "upPost.php",
      type: "POST",
      data: dataValue,
      cache: false,
      dataType: "html",
      success: function(data){
        if(data == ""){
          $(".upBody").html("Failed to Load Data.");
        }else{
          $("#modal-content").html(data);
          CKEDITOR.replace("content");
        }
      }
    });
    return false;
  });

  $(document).on("click",".close,.cancel",function(){
    $(".modal").fadeOut();
    return false;
  })

  $(window).click(function(event){
     if(event.target == $(".modal")[0]){
       $(".modal").fadeOut();
     }
   });

   $(document).on("change","#image",function(){
     var image = this.files[0].name;
     var imgType = this.files[0].type;

     if(!(imgType == "image/png" || imgType == "image/jpg" || imgType == "image/jpeg" || imgType == "image/gif")){
       $("#notification>p").html("You can upload only png, jpg, jpeg and gif type image.");
       $("#notification").removeClass("success");
       $("#notification").addClass("error");
       $(".notificationBox").css("top","10px");
       $("#notification").fadeIn();
     }
     setTimeout(function(){
       $("#notification").fadeOut();
     },2000);
     return false;
   });

   $(document).on("submit","#upForm",function(e){
     e.preventDefault();

     $.ajax({
       url: "../ajax/post.php",
       type: "POST",
       data: new FormData(this),
       dataType: "html",
       async: false,
       success: function(data){
         if(data === "success"){
           $("#notification>p").html("Post Updated Successfully");
           $("#notification").removeClass("error");
           $("#notification").addClass("success");
           $(".notificationBox").css("z-index","10");
           $(".notificationBox").css("top","10px");
           $("#notification").fadeIn();
         }else{
           $("#notification>p").html(data);
           $("#notification").removeClass("success");
           $("#notification").addClass("error");
           $(".notificationBox").css("z-index","10");
           $(".notificationBox").css("top","10px");
           $("#notification").fadeIn();
         }
       },
       cache: false,
       contentType: false,
       processData: false
     });

     setTimeout(function(){
       $("#notification").fadeOut();
     },2000);
     return false;
   });

   $(document).on("click","#profilePage",function(e){
     e.preventDefault();
     $.ajax({
       url: "../ajax/users.php",
       type: "POST",
       data: "action=profilePage",
       dataType: "html",
       async: false,
       success: function(data){
         if(data){
           $(".admContent").html(data);
         }else{
           $(".admContent").html("Failed to Load Data.");
         }
       },
       cache: false
     });
     return false;
   });

   $(document).on("submit","#profileForm",function(e){
     e.preventDefault();
     $.ajax({
       url: "../ajax/users.php",
       type: "POST",
       data: $(this).serialize()+"&action=upProfile",
       dataType: "html",
       async: false,
       success: function(data){
         data = data.trim();
         if(data === "success"){
           $("#notification>p").html("Profile Updated Successfully");
           $("#notification").removeClass("error");
           $("#notification").addClass("success");
           $(".notificationBox").css("top","10px");
           $("#notification").fadeIn();
         }else{
           $("#notification>p").html(data);
           $("#notification").removeClass("success");
           $("#notification").addClass("error");
           $(".notificationBox").css("top","10px");
           $("#notification").fadeIn();
         }
       },
       cache: false
     });

     setTimeout(function(){
       $("#notification").fadeOut();
     },2000);
     return false;
   });

   $(document).on("click","#titlePage",function(e){
     e.preventDefault();
     $.ajax({
       url: "../ajax/blog.php",
       type: "POST",
       data: "action=titlePage",
       dataType: "html",
       async: false,
       success: function(data){
         if(data){
           $(".admContent").html(data);
         }else{
           $(".admContent").html("Failed to Load Data.");
         }
       },
       cache: false
     });
     return false;
   });

   $(document).on("submit","#titleForm",function(e){
     e.preventDefault();
     $.ajax({
       url: "../ajax/blog.php",
       type: "POST",
       data: $(this).serialize()+"&action=upTitle",
       dataType: "html",
       async: false,
       success: function(data){
         if(data === "success"){
           $("#notification>p").html("Title Updated Successfully");
           $("#notification").removeClass("error");
           $("#notification").addClass("success");
           $(".notificationBox").css("top","10px");
           $("#notification").fadeIn();
         }else{
           $("#notification>p").html(data);
           $("#notification").removeClass("success");
           $("#notification").addClass("error");
           $(".notificationBox").css("top","10px");
           $("#notification").fadeIn();
         }
       },
       cache: false
     });

     setTimeout(function(){
       $("#notification").fadeOut();
     },2000);
     return false;
   });

   $(document).on("click","#manageSubscribers",function(e){
     e.preventDefault();
     $.ajax({
       url: "subscribers.php",
       dataType: "html",
       async: false,
       success: function(data){
         if(data){
           $(".admContent").html(data);
           $(".secondTable").DataTable({
             lengthMenu: [
             [ 10, 15, 20, -1 ],
               [ '10 rows', '15 rows', '20 rows', 'Show all' ]
             ]
           });
         }else{
           $(".admContent").html("No Subscribers Found.");
         }
       },
       cache: false
     });
     return false;
   });

   $(document).on("click",".subDel",function(e){
     e.preventDefault();
     var elem = $(this).parent().parent();

     if(confirm("Are you sure to Delete?")){
       var dataValue = "id="+this.id+"&action=delSubscribers";
       $.ajax({
         url: "../ajax/users.php",
         type: "POST",
         dataType: "html",
         data: dataValue,
         async: false,
         success: function(data){
           data = data.trim();
           if(data === "success"){
             $("#notification>p").html("Subscribers Deleted Successfully");
             $("#notification").removeClass("error");
             $("#notification").addClass("success");
             $(".notificationBox").css("top","10px");
             $("#notification").fadeIn();
             $(elem).remove();
           }else{
             $("#notification>p").html(data);
             $("#notification").removeClass("success");
             $("#notification").addClass("error");
             $(".notificationBox").css("top","10px");
             $("#notification").fadeIn();
           }
         },
         cache: false
       });
     }
     setTimeout(function(){
       $("#notification").fadeOut();
     },2000);
     return false;
   });

   $(document).on("click","#contact",function(e){
     e.preventDefault();
     $.ajax({
       url: "contact.php",
       dataType: "html",
       async: false,
       success: function(data){
         if(data){
           $(".admContent").html(data);
           $(".messageList").DataTable({
             lengthMenu: [
             [ 5, 10, 15, -1 ],
               [ '5 rows', '10 rows', '15 rows', 'Show all' ]
             ]
           });
         }else{
           $(".admContent").html("No Subscribers Found.");
         }
       },
       cache: false
     });

     return false;
   });

   $(document).on("click","#delMsg",function(e){
     e.preventDefault();
     var id = $(this).parent().parent().attr("id");

     if(confirm("Are you sure to Delete?")){
       var dataValue = "id="+id+"&action=delMsg";
       $.ajax({
         url: "../ajax/users.php",
         type: "POST",
         dataType: "html",
         data: dataValue,
         async: false,
         success: function(data){
           data = data.trim();
           if(data === "success"){
             $("#notification>p").html("Message Deleted Successfully");
             $("#notification").removeClass("error");
             $("#notification").addClass("success");
             $(".notificationBox").css("top","10px");
             $("#notification").fadeIn();
             $(".contactList #"+id).remove();
           }else{
             $("#notification>p").html(data);
             $("#notification").removeClass("success");
             $("#notification").addClass("error");
             $(".notificationBox").css("top","10px");
             $("#notification").fadeIn();
           }
         },
         cache: false
       });
     }
     setTimeout(function(){
       $("#notification").fadeOut();
     },2000);
     return false;
   });

   $(document).on("click","#view",function(e){
     e.preventDefault();

     var id = $(this).parent().parent().attr("id");
       $.ajax({
         url: "message.php",
         type: "POST",
         dataType: "html",
         data: "id="+id,
         async: false,
         success: function(data){
           if(data){
             $(".modal").fadeIn();
             $("#modal-content").html(data);
           }else{
             $("#notification>p").html("Error has been occured.");
             $("#notification").removeClass("success");
             $("#notification").addClass("error");
             $(".notificationBox").css("top","10px");
             $("#notification").fadeIn();
           }
         },
         cache: false
       });

     return false;
   });

   $(document).on("submit","#replyMsg",function(e){
     e.preventDefault();
     $(".lcon").css("display","block");
     var dataValue = $(this).serialize()+"&action=replyMsg";
       $.ajax({
         url: "../ajax/users.php",
         type: "POST",
         dataType: "html",
         data: dataValue,
         async: false,
         success: function(data){
           
		   data = data.trim();
           if(data === "success"){
             $("#notification>p").html("Message Sent Successfully.");
             $("#notification").removeClass("error");
             $("#notification").addClass("success");
             $(".notificationBox").css("top","10px");
           }else{
             $("#notification>p").html(data);
             $("#notification").removeClass("success");
             $("#notification").addClass("error");
             $(".notificationBox").css("top","10px");
           }
         },
         cache: false
       });

       setTimeout(function(){
         $(".lcon").css("display","none");
         $("#notification").fadeIn();
       },2000);

       setTimeout(function(){
         $("#notification").fadeOut();
       },2000);

     return false;
   });

   $(document).on("click","#addUser",function(){
     $.ajax({
       url: "addUser.php",
       dataType: "html",
       async: false,
       success: function(data){
         if(data){
           $(".admContent").html(data);
         }else{
           $(".admContent").html("Failed to load data.");
         }
       },
       cache: false
     });
     return false;
   });

   $(document).on("submit","#addUserForm",function(e){
     e.preventDefault();
     var dataValue = $(this).serialize()+"&action=addUser";
       $.ajax({
         url: "../ajax/users.php",
         type: "POST",
         dataType: "html",
         data: dataValue,
         async: false,
         success: function(data){
           data = data.trim();
           if(data === "success"){
             $("#notification>p").html("User Added Successfully.");
             $("#notification").removeClass("error");
             $("#notification").addClass("success");
             $(".notificationBox").css("top","10px");
             $("#notification").fadeIn();
           }else{
             $("#notification>p").html(data);
             $("#notification").removeClass("success");
             $("#notification").addClass("error");
             $(".notificationBox").css("top","10px");
             $("#notification").fadeIn();
           }
         },
         cache: false
       });

       setTimeout(function(){
         $("#notification").fadeOut();
       },2000);
     return false;
   });

   $(document).on("click","#manageUsers",function(e){
	 e.preventDefault();
     $.ajax({
       url: "userList.php",
	   type: "GET",
       dataType: "html",
       async: false,
       success: function(data){
         if(data){
           $(".admContent").html(data);
         }else{
           $(".admContent").html("Failed to load data.");
         }
       },
       cache: false
     });
     return false;
   });

   $(document).on("click",".userDel",function(e){
     e.preventDefault();
     var id = $(this).parent().parent().attr("id");

     if(confirm("Are you sure to Delete?")){
       var dataValue = "userId="+id+"&action=delUser";
       $.ajax({
         url: "../ajax/users.php",
         type: "POST",
         dataType: "html",
         data: dataValue,
         async: false,
         success: function(data){
           data = data.trim();
           if(data === "success"){
             $("#notification>p").html("User Deleted Successfully");
             $("#notification").removeClass("error");
             $("#notification").addClass("success");
             $(".notificationBox").css("top","10px");
             $("#notification").fadeIn();
             $("#"+id).remove();
           }else{
             $("#notification>p").html(data);
             $("#notification").removeClass("success");
             $("#notification").addClass("error");
             $(".notificationBox").css("top","10px");
             $("#notification").fadeIn();
           }
         },
         cache: false
       });
     }
     setTimeout(function(){
       $("#notification").fadeOut();
     },2000);
     return false;
   });

   $(document).on("submit","#resetPassword",function(e){

     e.preventDefault();
     $(".lcon").css("display","block");
       var dataValue = $(this).serialize()+"&action=resetPassword";
       $.ajax({
         url: "../ajax/users.php",
         type: "POST",
         dataType: "html",
         data: dataValue,
         async: false,
         success: function(data){
           data = data.trim();
           if(data === "success"){
             $("#notification>p").html("Please Check your Email.");
             $("#notification").removeClass("error");
             $("#notification").addClass("success");
             $(".notificationBox").css("top","10px");
             $("#"+id).remove();
           }else{
             $("#notification>p").html(data);
             $("#notification").removeClass("success");
             $("#notification").addClass("error");
             $(".notificationBox").css("top","10px");
           }
         },
         cache: false
       });

       setTimeout(function(){
         $(".lcon").css("display","none");
         $("#notification").fadeIn();
       },1000);
     return false;
   });

   $(document).on("submit","#newPassword",function(e){
     e.preventDefault();
       var dataValue = $(this).serialize()+"&action=newPassword";
       $.ajax({
         url: "../ajax/users.php",
         type: "POST",
         dataType: "html",
         data: dataValue,
         async: false,
         success: function(data){
           data = data.trim();
           if(data === "success"){
             $("#notification>p").html("New Password has been Updated.");
             $("#notification").removeClass("error");
             $("#notification").addClass("success");
             $(".notificationBox").css("top","10px");
             $("#notification").fadeIn();
             $("#"+id).remove();
           }else{
             $("#notification>p").html(data);
             $("#notification").removeClass("success");
             $("#notification").addClass("error");
             $(".notificationBox").css("top","10px");
             $("#notification").fadeIn();
           }
         },
         cache: false
       });
     return false;
   });


});
