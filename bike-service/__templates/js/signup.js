function start_loading() {
  $(".bg_plur").css("filter", "blur(8px)");
  $(".bg_plur").find("*").prop("disabled", true);
  $(".bg_plur a").removeAttr("href").css("pointer-events", "none");
  $(".loading").css("display", "block");
}

function stop_loading() {
  $(".bg_plur").css("filter", "blur(0px)");
  $(".loading").css("display", "none");
  $(".bg_plur").find("*").prop("disabled", false);
  $(".bg_plur a").attr("href", "login").css("pointer-events", "auto");
}

$(document).ready(function () {
  $(".signup").click(function (e) {
    e.preventDefault();
    const name = $(".name").val().replace(/\s+/g,'');
    const phone = $(".phone").val().replace(/\s+/g,'');
    const email = $(".email").val().replace(/\s+/g,'');
    const password = $(".password").val().replace(/\s+/g,'');
    const valid_name = /^[a-zA-Z]+$/;
    const validate_email = /^[a-z0-9]+@[a-z]+\.[a-z]{2,3}$/;
    const validate_phone = /^[6-9]\d{9}$/;
    const validate_password = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{7,}$/;
    if (name == "" || name == null) {
      alertify.set("notifier", "position", "top-right");
      alertify.error("Please enter your name");
    } else if (name.length <= 2) {
      alertify.set("notifier", "position", "top-right");
      alertify.error("Please enter your full name without space");
    } else if (!valid_name.test(name)) {
      alertify.set("notifier", "position", "top-right");
      alertify.error("Please enter valid name");
    } else if (email == "" || email == null) {
      alertify.set("notifier", "position", "top-right");
      alertify.error("Please enter your email address");
    } else if (!validate_email.test(email)) {
      alertify.set("notifier", "position", "top-right");
      alertify.error("Please enter valid email address");
    } else if (phone == "" || phone == null) {
      alertify.set("notifier", "position", "top-right");
      alertify.error("Please enter your phone no");
    } else if (!validate_phone.test(phone)) {
      alertify.set("notifier", "position", "top-right");
      alertify.error("Please enter valid phone no");
    } else if(password==""|| password==null){
        alertify.set('notifier', 'position', 'top-right');
        alertify.error("Please enter your password");
    } else if(!password.match(validate_password)){
        alertify.set('notifier', 'position', 'top-right');
        alertify.error("Please enter your strong password");
    } else{
        start_loading();
        $.ajax({
            type: 'POST',
            url: 'signup',
            data:{
                name:name,
                email:email,
                phone:phone,
                password:password,
            },success:function(response){
                stop_loading();
                if(response == "email send"){
                    alertify.set("notifier", "position", "top-right");
                    alertify.success("Signup successfully. Verfication link send your email");
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
