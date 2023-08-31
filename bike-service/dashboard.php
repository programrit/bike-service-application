<?php

include('libs/load.php');

include_class('session');
include_class('customer');
include_class('database');

$session = new Session;
$session->start_access();

$email = $session->get_access('email');

$db = new Database;
$conn = $db->access_database_connection();

$customers = new Customer;

$login = $session->get_access('login');
if (empty($email) or $login == false) {
    header("Location: login");
} else {
    $customer = new VerificationCustomer;
    $verification = $customer->verification($email);
    if ($verification) { 

        // logout
        if(isset($_POST['logout'])){
            $session->destroy_access();
            echo "logout";
            return "";
        }

        // fetch price into database
        if(isset($_POST['val'])){
            $val = $conn->real_escape_string($_POST["val"]);
            $val =htmlspecialchars($val);
            $id = $customers->fetch_price_access($val);
            if($id == "null"){
                echo "null";
                return "";
            }else{
                echo $id;
                return "";
            }
        }

        // book a service
        if(isset($_POST['name']) and isset($_POST['price']) and isset($_POST['date'])){
            $name = $conn->real_escape_string($_POST["name"]);
            $name =htmlspecialchars($name);
            $price = $conn->real_escape_string($_POST["price"]);
            $price =htmlspecialchars($price);
            $date = $conn->real_escape_string($_POST["date"]);
            $date =htmlspecialchars($date);
            $book = $customers->service_book_access($name, $price, $date, $email);
            if($book == "booking"){
                echo "book";
                return "";
            }else{
                echo $book;
                return "";
            }
        }

        // cancel service
        if(isset($_POST['get_id'])){
            $get_id = $conn->real_escape_string($_POST["get_id"]);
            $get_id =htmlspecialchars($get_id);
            $id = $customers->cancel_service_access($get_id);
            if($id == "cancel"){
                echo "cancel";
                return "";
            }else{
                echo $id;
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
        header("Location: signup");
    }
}

?>