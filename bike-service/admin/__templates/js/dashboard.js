function start_loading(){
    // // $('.bg_plur').css("filter", "blur(8px)");
    $('button').prop('disabled',true);
    $('input').prop('disabled',true);
    // $('.bg_plur').find('*').prop('disabled',true);
    // $('.bg_plur a').removeAttr('href').css('pointer-events','none');
    // $('.loading').css("display","block");
}

function stop_loading(){
    // $('.bg_plur').css("filter", "blur(0px)");
    $('button').prop('disabled',false);
    $('input').prop('disabled',false);
    // $('.bg_plur').find('*').prop('disabled',false);
    // $('.loading').css("display","none");
    // $('.bg_plur a').attr('href','signup').css('pointer-events','auto');
}

// datatable
$(document).ready(function() {
    $('#datatablesSimple').DataTable();
    $('#datatablesSimple1').DataTable();
    $('#datatablesSimple2').DataTable();
});


$(document).ready(function(){
    // logout
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

    // add services
    $('.add').click(function(e){
        e.preventDefault();
        const service_name = $(".name").val();
        const price = $(".price").val().replace(/\s+/g,'');
        const valid_name = /^[a-zA-Z ]+$/;
        const valid_price = /^\d+$/;
        if (service_name == "" || service_name == null) {
            alertify.set("notifier", "position", "top-right");
            alertify.error("Please enter your service name");
        } else if (service_name.length <= 2) {
            alertify.set("notifier", "position", "top-right");
            alertify.error("Please enter your full service name");
        } else if (!valid_name.test(service_name)) {
            alertify.set("notifier", "position", "top-right");
            alertify.error("Please enter valid service name");
        } else if (price == "" || price == null) {
            alertify.set("notifier", "position", "top-right");
            alertify.error("Please enter your price");
        } else if (!valid_price.test(price)) {
            alertify.set("notifier", "position", "top-right");
            alertify.error("Please enter valid price");
        } else{
            start_loading();
            // $('.add').prop('disabled',true);
            // $('.reset_service').prop('disabled',true);
            $.ajax({
                type: 'POST',
                url: 'dashboard',
                data:{
                    service_name:service_name,
                    price:price
                },success:function(response){
                    stop_loading();
                    // $('.add').prop('disabled',false);
                    // $('.reset_service').prop('disabled',false);
                    if(response == "add"){
                        alertify.set("notifier", "position", "top-right");
                        alertify.success("Service add successfully");
                        setTimeout(function(){
                            window.location.href = "dashboard";
                        },1000);
                    }else{
                        alertify.set("notifier", "position", "top-right");
                        alertify.error(response);
                    }
                },error:function(error){
                    stop_loading();
                    // $('.add').prop('disabled',false);
                    // $('.reset_service').prop('disabled',false);
                    alertify.set("notifier", "position", "top-right");
                    alertify.error("Something went wrong. Please try again later");
                    setTimeout(function(){
                        window.location.href = "dashboard";
                    },1000);
                }
            });
        }
    });

    // show data 
    $('.edit').click(function(e){
        e.preventDefault();
        const id = $(this).val().replace(/\s+/g,'');
        if(id== "" || id == null){
            alertify.set("notifier", "position", "top-right");
            alertify.error("Invalid Value");
        }else{
            $.ajax({
                type:'POST',
                url:'dashboard',
                data:{
                    id:id,
                },success:function(response){
                    if(response == "null"){
                        alertify.set("notifier", "position", "top-right");
                        alertify.error("Service not found");
                    }else{
                        $('.update_data').val(response.split(',')[0]);
                        $('.service_name').val(response.split(',')[1]);
                        $('.service_price').val(response.split(',')[2]);
                    }
                },error:function(error){
                    alertify.set("notifier", "position", "top-right");
                    alertify.error("Something went wrong. Please try again later");
                    setTimeout(function(){
                        window.location.href = "dashboard";
                    },1000);
                }
            });
        }
    });

     // update service data
     $('.update_data').click(function(e){
        e.preventDefault();
        const service_id = $(this).val().replace(/\s+/g,'');
        const name = $(".service_name").val();
        const service_price = $(".service_price").val().replace(/\s+/g,'');
        const valid_name = /^[a-zA-Z ]+$/;
        const valid_price = /^\d+$/;
        if (service_id == "" || service_id == null) {
            alertify.set("notifier", "position", "top-right");
            alertify.error("Invalid id");
        } else if (name == "" || name == null) {
            alertify.set("notifier", "position", "top-right");
            alertify.error("Please enter your service name");
        } else if (name.length <= 2) {
            alertify.set("notifier", "position", "top-right");
            alertify.error("Please enter your full service name");
        } else if (!valid_name.test(name)) {
            alertify.set("notifier", "position", "top-right");
            alertify.error("Please enter valid service name");
        } else if (service_price == "" || service_price == null) {
            alertify.set("notifier", "position", "top-right");
            alertify.error("Please enter your price");
        } else if (!valid_price.test(service_price)) {
            alertify.set("notifier", "position", "top-right");
            alertify.error("Please enter valid price");
        } else{
            // $('.update_data').prop('disabled',true);
            start_loading();
            $.ajax({
                type: 'POST',
                url: 'dashboard',
                data:{
                    name:name,
                    service_price:service_price,
                    service_id:service_id
                },success:function(data){
                    // $('.update_data').prop('disabled',false);
                    stop_loading();
                    if(data == "update"){
                        alertify.set("notifier", "position", "top-right");
                        alertify.success("Service update successfully");
                        setTimeout(function(){
                            window.location.href = "dashboard";
                        },1000);
                    }else{
                        alertify.set("notifier", "position", "top-right");
                        alertify.error(data);
                    }
                },error:function(error){
                    // $('.update_data').prop('disabled',false);
                    stop_loading();
                    alertify.set("notifier", "position", "top-right");
                    alertify.error("Something went wrong. Please try again later");
                    setTimeout(function(){
                        window.location.href = "dashboard";
                    },1000);
                }
            });
        }
    });

    // delete service

    $('.delete').click(function(e){
        e.preventDefault();
        const get_id = $(this).val().replace(/\s+/g,'');
        if (get_id == "" || get_id == null) {
            alertify.set("notifier", "position", "top-right");
            alertify.error("Invalid service");
        } else{
            Swal.fire({
                title: 'Are you sure You want to delete the service?',
                text: 'Once deleted you cannot recover the service!',
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
                      if (response == "delete"){
                        swal.fire({
                          allowOutsideClick: false,
                          title: "Deleted",
                          text: "Your service has been deleted.",
                          icon: "success"
                        });
                        $("#datatablesSimple").load(location.href + " #datatablesSimple");
                      }else{
                        swal.fire({
                          allowOutsideClick: false,
                          title: "Deleted",
                          text: response,
                          icon: "error"
                        });
                      }
                    },error:function(error){
                      swal.fire({
                        allowOutsideClick: false,
                        title: "Deleted",
                        text: "Something Went Wrong. Please try again later",
                        icon: "error"
                      });
                    }
                  });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                  // User clicked "No, cancel!"
                  swal.fire({
                    allowOutsideClick: false,
                    title: "Cancelled",
                    text: "Your service is safe.",
                    icon: "error"
                  });
                }
              }); 
        }
    });

    // status update 
    $('.edit_service_order').click(function(e){
        e.preventDefault();
        const order_id = $(this).val().replace(/\s+/g,'');
        if(order_id== "" || order_id == null){
            alertify.set("notifier", "position", "top-right");
            alertify.error("Invalid Value");
        }else{
            $.ajax({
                type:'POST',
                url:'dashboard',
                data:{
                    order_id:order_id,
                },success:function(response){
                    if(response == "null"){
                        alertify.set("notifier", "position", "top-right");
                        alertify.error("Service not found");
                    }else{
                        $('.update_status').val(response.split(',')[0]);
                        $('.name1').val(response.split(',')[1]);
                        $('.email1').val(response.split(',')[2]);
                        $('.service_name1').val(response.split(',')[4]);
                    }
                },error:function(error){
                    alertify.set("notifier", "position", "top-right");
                    alertify.error("Something went wrong. Please try again later");
                    setTimeout(function(){
                        window.location.href = "dashboard";
                    },1000);
                }
            });
        }
    });

    // update status value
    $('.update_status').click(function(e){
        e.preventDefault();
        const get_status_id = $(this).val().replace(/\s+/g,'');
        const status = $('.select_status').val();
        if(get_status_id== "" || get_status_id == null){
            alertify.set("notifier", "position", "top-right");
            alertify.error("Invalid Input");
        } else if(status == "" || status == null || status == "Please update status"){
            alertify.set("notifier", "position", "top-right");
            alertify.error("Please select status");
        } else{
            start_loading();
            $.ajax({
                type:'POST',
                url:'dashboard',
                data:{
                    get_status_id:get_status_id,
                    status:status,
                },success:function(response){
                    stop_loading();
                    if(response == "updated"){
                        alertify.set("notifier", "position", "top-right");
                        alertify.success("Status update successfully");
                        setTimeout(function(){
                            window.location.href = "dashboard";
                        },1000);
                    }else{
                        alertify.set("notifier", "position", "top-right");
                        alertify.error(response);
                    }
                },error:function(error){
                    stop_loading();
                    alertify.set("notifier", "position", "top-right");
                    alertify.error("Something went wrong. Please try again later");
                    setTimeout(function(){
                        window.location.href = "dashboard";
                    },1000);
                }
            });
        }
    });
});





