<?php

include('libs/load.php');
include_class('database');

include_class('session');

$db = new Database;
$conn = $db->access_database_connection();
$session = new session;
$session->start_access();

// if customer click link verify the customer and link expired or not.
if(isset($_GET['token'])){
    $token = $conn->real_escape_string($_GET["token"]);
    $token = htmlspecialchars($token);
    $verify="SELECT * FROM customer WHERE token='$token' LIMIT 1";
    $result=$conn->query($verify);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();
        if($token==$row["token"]){
            if($row["verify"]==0){
                $times_ago=strtotime($row["current_date_time"]);
                $current_time=date("Y:m:d H:i:s");
                $check_time =date("Y:m:d H:i:s",strtotime($row["current_date_time"].'+15 minutes'));
                if($current_time>=$check_time){
                    $delete="DELETE FROM customer WHERE token='$token'";
                    if($conn->query($delete)===TRUE){
                        $session->set_access('error','Your token has been expired! please signup again!');
                        header("Location: signup"); 
                    }else{
                        $session->set_access('error','Something went wrong. try again or click link again!');
                        header("Location: login"); 
                    }
                }else{
                    $click=$row["token"];
                    $updated="UPDATE customer SET verify=1 WHERE token='$click'";
                    if($conn->query($updated)===TRUE){
                        $session->set_access('success','Your account has been verified successfully!');
                        header("Location: login"); 
                    }else{
                        $session->set_access('error','Verfication failed. Please try again later!');
                        header("Location: login"); 
                    }
                }
            }else{
                $session->set_access('error','Email already verify. please login!');
                header("Location: login"); 
            }

        }else{
            $delete="DELETE FROM customer WHERE token='$token'";
            if($conn->query($delete)===TRUE){
                $session->set_access('error','This token does not exist. Please signup');
                header("Location: signup");  
            }else{
                $session->set_access('error','Something went wrong. try again or click link again!');
                header("Location: login"); 
            }
        }
    }else{
        $delete="DELETE FROM customer WHERE token='$token'";
        if($conn->query($delete)===TRUE){
            $session->set_access('error','This token does not exist. Please signup');
            header("Location: signup");  
        }else{
            $session->set_access('error','Something went wrong. try again or click link again!');
            header("Location: login"); 
        }
    }

}else{
    $session->set_access('error','Unauthorized person :(');
    header("Location: login");
}


?>

<!DOCTYPE html>
<html lang="en">
    <?php  load_template('__head') ?>
<body>
<?php load_template('__loading')  ?>
    <div class="bg_plur">
    </div>
</body>
</html>