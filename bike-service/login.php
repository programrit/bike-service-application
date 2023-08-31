<?php

include('libs/load.php');


include_class('database');
include_class('customer');
include_class('verify_customer');
include_class('session');
$db = new Database;
$conn = $db->access_database_connection();
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $conn->real_escape_string($_POST["password"]);
    $customer = new Customer;
    $login = $customer->access_login($email, $password);
    if ($login == "Login Successfully") {
        echo "login";
        return "";
    } else if ($login == "Please check your email verification link send successfully") {
        echo "link send";
        return "";
    } else {
        echo $login;
        return "";
    }
}

$session = new Session;
$session->start_access();

$mail = $session->get_access('email');
$login = $session->get_access('login');
if (empty($mail) or $login == false) {
    $error = $session->get_access('error');
    $success = $session->get_access('success');
    if ($error) {
        echo "<script>
    alertify.set('notifier', 'position', 'top-right');
    alertify.error('$error');
    </script>";
    }
    $session->delete_access('error');
    if ($success) {
        echo "<script>
    alertify.set('notifier', 'position', 'top-right');
    alertify.success('$success');
    </script>";
    }
    $session->delete_access('success');
?>
    <!DOCTYPE html>
    <html lang="en">
    <?php load_template('__head') ?>

    <body>
        <?php load_template('__loading')  ?>
        <div class="bg_plur">
            <?php load_template('__login')  ?>
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