<?php

include('libs/load.php');

include_class('session');
include_class('admin');
include_class('database');

$session = new Session;
$session->start_access();

$db = new Database;
$conn = $db->access_database_connection();

$email = $session->get_access('email');

$login = $session->get_access('login');
if (empty($email) or $login == false) {
    header("Location: login");
} else {
    $admin = new BikeServiceAdmin;
    $admin_verify = new VerificationCustomer; // verify admin
    $verification = $admin_verify->verification($email);
    if ($verification) { 
        // logout 
        if(isset($_POST['logout'])){
            $session->destroy_access();
            echo "logout";
            return "";
        }

        // add service
        if(isset($_POST['service_name']) and isset($_POST['price'])){
            $service_name = $conn->real_escape_string($_POST["service_name"]);
            $price = $conn->real_escape_string($_POST["price"]);
            $service_name = htmlspecialchars($service_name);
            $price = htmlspecialchars($price);
            $service = $admin->add_service_access($service_name,$price);
            if($service == "add"){
                echo "add";
                return "";
            }else{
                echo $service;
                return "";
            }
        }

        // fetch services data into database
        if(isset($_POST['id'])){
            $id = $conn->real_escape_string($_POST["id"]);
            $id = htmlspecialchars($id);
            $fetch_data = $admin->fetch_service_access($id);
            if($fetch_data == "null"){
                echo "null";
                return "";
            }else{
                echo implode(",",$fetch_data);
                return "";
            }
        }
        
        // update service data
        if(isset($_POST['name']) && isset($_POST['service_price']) && isset($_POST['service_id'])){
            $service_name = $conn->real_escape_string($_POST["name"]);
            $price = $conn->real_escape_string($_POST["service_price"]);
            $id = $conn->real_escape_string($_POST["service_id"]);
            $service_name = htmlspecialchars($service_name);
            $price = htmlspecialchars($price);
            $id=htmlspecialchars($id);
            $update = $admin->update_service_access($service_name,$price,$id);
            if($update == "update"){
                echo "update";
                return "";
            }else{
                echo $update;
                return "";
            }
        }

        // delete service data
        if(isset($_POST['get_id'])){
            $get_id = $conn->real_escape_string($_POST["get_id"]);
            $get_id = htmlspecialchars($get_id);
            $delete = $admin->delete_service_access($get_id);
            if($delete == "delete"){
                echo "delete";
                return "";
            }else{
                echo $delete;
                return "";
            }
        }

        // fetch order data into database
        if(isset($_POST['order_id'])){
            $order_id = $conn->real_escape_string($_POST["order_id"]);
            $order_id = htmlspecialchars($order_id);
            $fetch_order = $admin->fetch_order_access($order_id);
            if($fetch_order == "null"){
                echo "null";
                return "";
            }else{
                echo implode(",",$fetch_order);
                return "";
            }
        }

        // update status
        if(isset($_POST['get_status_id']) and isset($_POST['status'])){
            $id = $conn->real_escape_string($_POST["get_status_id"]);
            $id = htmlspecialchars($id);
            $status = $conn->real_escape_string($_POST["status"]);
            $status = htmlspecialchars($status);
            $update = $admin->update_status_access($email,$id,$status);
            if($update == "updated"){
                echo "updated";
                return "";
            }else{
                echo $update;
                return "";
            }
        }

        
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <?php load_template('__head') ?>

        <body>
            <?php load_template('__loading')  ?>
            <div class="bg_plur">
                <?php load_template('__dashboard')  ?>
            </div>
        </body>

        </html>
<?php
    } else {
        header("Location: login");
    }
}

?>