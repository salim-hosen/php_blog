$(document).ready(function(){

  $(document).on("submit","#subscribeForm",function(e){
    e.preventDefault();
    var dataValue = $(this).serialize()+"&action=subscribe";

    $.ajax({
      url: "ajax/blog.php",
      type: "POST",
      data: dataValue,
      dataType: "html",
      async: false,
      success: function(data){
        if(data === "success"){
          $(".modal").fadeIn('slow');
          $(".msgContent").html("<h2 style='color: #4CAF50;'>You Have Successfully Subscribed.</h2> <p>Thank You for Subscribing.</p>");
        }else{
          $(".modal").fadeIn('slow');
          $(".msgContent").html("<h2 style='color: #DC143C;'>"+data+"</h2><p>Try Again</p>");
        }
      },
      cache: false
    });
    return false;
  });

  $("#cross").click(function(){
    $(".modal").fadeOut('slow');
    return false;
  });

  $(window).click(function(event){
     if(event.target == $(".modal")[0]){
       $(".modal").fadeOut('slow');
     }
   });

   $(document).on("submit","#contactForm",function(e){
     e.preventDefault();
     var dataValue = $(this).serialize()+"&action=contact";

     $.ajax({
       url: "ajax/blog.php",
       type: "POST",
       data: dataValue,
       dataType: "html",
       async: false,
       success: function(data){
         if(data === "success"){
           $(".modal").fadeIn('slow');
           $(".msgContent").html("<h2 style='color: #4CAF50;'>Message Sent Successfully.</h2> <p>Thank You.</p>");
         }else{
           $(".modal").fadeIn('slow');
           $(".msgContent").html("<h2 style='color: #DC143C;'>"+data+"</h2><p>Try Again</p>");
         }
       },
       cache: false
     });
     return false;
   });

});
