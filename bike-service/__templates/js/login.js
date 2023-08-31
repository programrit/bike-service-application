function start_loading(){
    $('.bg_plur').css("filter", "blur(8px)");
    $('.bg_plur').find('*').prop('disabled',true);
    $('.bg_plur a').removeAttr('href').css('pointer-events','none');
    $('.loading').css("display","block");
}

function stop_loading(){
    $('.bg_plur').css("filter", "blur(0px)");
    $('.loading').css("display","none");
    $('.bg_plur').find('*').prop('disabled',false);
    $('.bg_plur a').attr('href','signup').css('pointer-events','auto');
}


$(document).ready(function(){
    $('.login').click(function(e){
        e.preventDefault();
        const email = $(".email").val().replace(/\s+/g,'');
        const password = $(".password").val().replace(/\s+/g,'');
        const validate_email = /^[a-z0-9]+@[a-z]+\.[a-z]{2,3}$/;
        if (email == "" || email == null) {
            alertify.set("notifier", "position", "top-right");
            alertify.error("Please enter your email address");
        } else if (!validate_email.test(email)) {
            alertify.set("notifier", "position", "top-right");
            alertify.error("Please enter valid email address");
        }else if(password==""|| password==null){
            alertify.set('notifier', 'position', 'top-right');
            alertify.error("Please enter your password");
        } else{
            start_loading();
            $.ajax({
                type: 'POST',
                url: 'login',
                data:{
                    email: email,
                    password:password,
                },success:function(response){
                    stop_loading();
                    if(response == "login"){
                        alertify.set("notifier", "position", "top-right");
                        alertify.success("Login Successfully :)");
                        setTimeout(function () {
                          window.location.href = "dashboard";
                        }, 1000);
                    }else if(response == "link send"){
                        alertify.set("notifier", "position", "top-right");
                        alertify.success("Please check your email verification link send successfully");
                        setTimeout(function () {
                          window.location.href = "login";
                        }, 1000);
                    }else{
                        alertify.set("notifier", "position", "top-right");
                        alertify.error(response);
                    }
                },error:function(error){
                    stop_loading();
                    alertify.set("notifier", "position", "top-right");
                    alertify.error("Something went wrong. Please try again later");
                }
            });
        }
    });
});


