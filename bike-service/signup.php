<?php

include('libs/load.php');

include_class('database');
include_class('customer');
include_class('verify_customer');
include_class('session');
$db = new Database;
$conn = $db->access_database_connection();
$session = new Session;
$session->start_access();

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['password'])) {
    $token = bin2hex(random_bytes(32));
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $phone = $conn->real_escape_string($_POST["phone"]);
    $password = $conn->real_escape_string($_POST["password"]);
    $customer = new Customer;
    $signup = $customer->access_signup($name, $email, $phone, $password, $token);
    if ($signup == "Signup successfully") {
        echo "email send";
        return "";
    } else {
        echo $signup;
        return "";
    }
}

$mail = $session->get_access('email');
echo "<script>alert('$mail')</script>";
$login = $session->get_access('login');
if (empty($mail) or $login == false) {
    $error = $session->get_access('error');
    if ($error) {
        echo "<script>
    alertify.set('notifier', 'position', 'top-right');
    alertify.error('$error');
    </script>";
    }
    $session->delete_access('error');
?>
    <!DOCTYPE html>
    <html lang="en">
    <?php load_template('__head') ?>

    <body>
        <?php load_template('__loading')  ?>
        <div class="bg_plur">
            <?php load_template('__signup')  ?>
        </div>
    </body>

    </html>
<?php } else {
    $customer = new VerificationCustomer;
    $verification = $customer->verification($mail);
    if ($verification) {
        header("Location: dashboard");
    } else {
        header("Location: signup");
    }
}

?>