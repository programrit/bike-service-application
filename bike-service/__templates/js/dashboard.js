function start_loading(){
    $('.bg_plur').css("filter", "blur(8px)");
    $('.bg_plur').find('*').prop('disabled',true);
    // $('.bg_plur a').removeAttr('href').css('pointer-events','none');
    $('.loading').css("display","block");
}

function stop_loading(){
    $('.bg_plur').css("filter", "blur(0px)");
    $('.bg_plur').find('*').prop('disabled',false);
    $('.loading').css("display","none");
    // $('.bg_plur a').attr('href','signup').css('pointer-events','auto');
}

$(document).ready(function() {
    $('#datatablesSimple').DataTable();
});



$(document).ready(function(){
    $('.logout').click(function(){
        start_loading();
        $.ajax({
            type: 'POST',
            url: 'dashboard',
            data:{
                logout: true,
            },success:function(response){
                stop_loading();
                if(response == "logout"){
                    alertify.set("notifier", "position", "top-right");
                    alertify.success("Logout Successfully");
                    setTimeout(function () {
                      window.location.href = "login";
                    }, 1000);
                }
            }
        });
    });
    // show date
    $("#date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        minDate: 0,
        autoSize: true,
    });

    // show price 
    $('.service').change(function(){
        const val= $(this).val();
        if(val == "" || val ==null){
            alertify.set("notifier", "position", "top-right");
            alertify.error("Invalid service");
        }else{
            $.ajax({
                type: 'POST',
                url:'dashboard',
                data:{
                    val:val,
                },success:function(response){
                    if(response == null){
                        alertify.set("notifier", "position", "top-right");
                        alertify.error("Service not found");
                    }else{
                        $('.price').val(response);
                    }
                },error:function(response){
                    alertify.set("notifier", "position", "top-right");
                    alertify.error("Something went wrong. Please try again later");
                }
            });
        }
    });

    // booking service
    $('.book').click(function(e){
        e.preventDefault();
        const name = $('.service').val();
        const price = $('.price').val().replace(/\s+/g,'');
        const date = $('.date').val().replace(/\s+/g,'');
        var current_date = new Date();
        var day = current_date.getDate();
        var month = current_date.getMonth()+1;
        var year = current_date.getFullYear();
        var dates = year+'-'+(month<10?'0':'')+month+'-'+(day<10?'0':'')+day;
        if(name == ''||name == null || name == "Select your service"){
            alertify.set("notifier", "position", "top-right");
            alertify.error("Please select service");
        }else if(price == ''|| price == null){
            alertify.set("notifier", "position", "top-right");
            alertify.error("Price not found. Please select your service");
        }else if(date == ""|| date == null){
            alertify.set("notifier", "position", "top-right");
            alertify.error("Please select your date");
        }else if(date == dates){
            alertify.set("notifier", "position", "top-right");
            alertify.error("You can't select today");
        }else{
            start_loading();
            $.ajax({
                type:'POST',
                url:'dashboard',
                data:{
                    name:name,
                    price:price,
                    date:date
                },success:function(response){
                    stop_loading();
                    if(response == "book"){
                        alertify.set("notifier", "position", "top-right");
                        alertify.success("Your service booking successfully");
                        setTimeout(function () {
                          window.location.href = "dashboard";
                        }, 1000);
                    }else{
                        alertify.set("notifier", "position", "top-right");
                        alertify.error(response);
                        console.log(response);
                    }
                },error:function(error){
                    stop_loading();
                    alertify.set("notifier", "position", "top-right");
                    alertify.error("Something went wrong. Please try again later");
                }
            });
        }
    });

    // cancel service
    $('.cancel_service').click(function(e){
        e.preventDefault();
        const get_id = $(this).val().replace(/\s+/g,'');
        if (get_id == "" || get_id == null) {
            alertify.set("notifier", "position", "top-right");
            alertify.error("Invalid service");
        } else{
            Swal.fire({
                title: 'Are you sure You want to cancel the service?',
                text: 'Once cancel you cannot recover the service!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                reverseButtons: true,
                allowOutsideClick: false,
              }).then((result) => {
                if (result.isConfirmed) {
                  // User clicked "Yes, delete it!"
                  // Perform the delete operation here
                  $.ajax({
                    type: 'POST',
                    url:'dashboard',
                    data: {
                        get_id:get_id
                    },success:function(response){
                      if (response == "cancel"){
                        swal.fire({
                          allowOutsideClick: false,
                          title: "Cancel",
                          text: "Your service has been cancel.",
                          icon: "success"
                        });
                        $("#datatablesSimple").load(location.href + " #datatablesSimple");
                      }else{
                        swal.fire({
                          allowOutsideClick: false,
                          title: "Cancel",
                          text: response,
                          icon: "error"
                        });
                      }
                    },error:function(error){
                      swal.fire({
                        allowOutsideClick: false,
                        title: "Cancel",
                        text: "Something Went Wrong. Please try again later",
                        icon: "error"
                      });
                    }
                  });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                  // User clicked "No, cancel!"
                  swal.fire({
                    allowOutsideClick: false,
                    title: "Not Cancel",
                    text: "Your service is safe.",
                    icon: "error"
                  });
                }
              }); 
        }
    });

});




