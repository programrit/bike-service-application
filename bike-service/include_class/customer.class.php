<?php


class Customer
{
    // customer sugnup
    private function signup($name, $email, $phone, $password, $token)
    {
        $db = new Database;
        $conn = $db->access_database_connection();
        $option = [
            'cost' => 8,
        ];
        $password = password_hash($password, PASSWORD_BCRYPT, $option);
        $query = mysqli_query($conn, "SELECT * FROM customer WHERE email='$email'");
        $query1 = mysqli_query($conn, "SELECT * FROM customer WHERE phone='$phone'");
        if (mysqli_num_rows($query) > 0) {
            $signup = "Email already exist. Please login";
        } else if (mysqli_num_rows($query1) > 0) {
            $signup = "Phone no already exist. Please use different phone no";
        } else {
            $mail_send = new SendMail;
            $result = $mail_send->send_mail($email, $token);
            if ($result) {
                $sql = "INSERT INTO customer (name,email,phone,password,token) VALUES('$name','$email','$phone','$password','$token')";
                if ($conn->query($sql) === TRUE) {
                    $signup = "Signup successfully";
                } else {
                    $signup = "Something went wrong. please try again!";
                }
            } else {
                $signup = "Verification link send failed";
            }
        }
        return $signup;
    }

    // customer signup method access
    public function access_signup($name, $email, $phone, $password, $token)
    {
        return $this->signup($name, $email, $phone, $password, $token);
    }

    // customer login
    private function login($email, $password)
    {
        $db = new Database;
        $conn = $db->access_database_connection();
        $session = new Session();
        $session->start_access();
        $sql = mysqli_query($conn, "SELECT * FROM customer WHERE email='$email'");
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_array($sql);
            if (password_verify($password, $row['password'])) {
                if ($row['verify'] == 1) {
                    $session->set_access('email', $email);
                    $session->set_access('login', true);
                    $login = "Login Successfully";
                } else {
                    $mail_send = new SendMail;
                    $token = bin2hex(random_bytes(32));
                    $result = $mail_send->send_mail($email, $token);
                    if ($result) {
                        $sql = "UPDATE customer SET verify=0,token='$token' WHERE email='$email'";
                        if ($conn->query($sql) === TRUE) {
                            $login = "Please check your email verification link send successfully";
                        } else {
                            $login = "Something went wrong. please try again!";
                        }
                    } else {
                        $login = "Verification link send failed";
                    }
                }
            } else {
                $login = "Please enter correct password!";
            }
        } else {
            $login = "Email address not found. Please signup first";
        }
        return $login;
    }

    // customer mlogin access method
    public function access_login($email, $password)
    {
        return $this->login($email, $password);
    }

    // fetch price into database
    private function fetch_price($val)
    {
        $db = new Database;
        $conn = $db->access_database_connection();
        $sql = mysqli_query($conn, "SELECT * FROM services WHERE id='$val'");
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_array($sql);
            $id = $row['price'];
        } else {
            $id = "null";
        }

        return $id;
    }

    // fetch price into database access method
    public function fetch_price_access($val)
    {
        return $this->fetch_price($val);
    }

    // service book
    private function service_book($name, $price, $date, $email)
    {
        $db = new Database;
        $conn = $db->access_database_connection();
        include('verify_customer.class.php');
        $send_mail = new SendMail;
        $get_name = mysqli_query($conn, "SELECT * FROM services WHERE id='$name'");
        if (mysqli_num_rows($get_name) > 0) {
            $get_row = mysqli_fetch_array($get_name);
            $name = $get_row['name'];
            $sql = mysqli_query($conn, "SELECT * FROM service_book WHERE email='$email' AND order_date='$date' AND service_name='$name'");
            if (mysqli_num_rows($sql) > 0) {
                $book = "You can't book service same date";
            } else {
                $fetch = mysqli_query($conn, "SELECT * FROM customer WHERE email='$email'");
                if (mysqli_num_rows($fetch) > 0) {
                    $row = mysqli_fetch_array($fetch);
                    $customer_name = $row['name'];
                    $phone = $row['phone'];
                    $status = "pending";
                    $admin = mysqli_query($conn, "SELECT * FROM admin WHERE id='1'");
                    if (mysqli_num_rows($admin) > 0) {
                        $admin_data = mysqli_fetch_array($admin);
                        $admin_email = $admin_data['email'];
                        $order_send = $send_mail->order_send($email, $customer_name, $phone, $name, $price, $date, $admin_email);
                        if ($order_send) {
                            $insert = "INSERT INTO service_book (name,email,phone,service_name,price,order_date,status) VALUES ('$customer_name','$email','$phone','$name','$price','$date','$status')";
                            if ($conn->query($insert) === TRUE) {
                                $book = "booking";
                            } else {
                                $book = "Service booking failed. please try again later!";
                            }
                        } else {
                            $book = "Service booking failed";
                        }
                    } else {
                        $book = "Service booking failed";
                    }
                } else {
                    $book = "Customer not found";
                }
            }
        } else {
            $book = "Service not found";
        }
        return $book;
    }

    // service book access method
    public function service_book_access($name, $price, $date, $email)
    {
        return $this->service_book($name, $price, $date, $email);
    }

    // cancel service method
    private function cancel_service($get_id){
        $db = new Database;
        $conn = $db->access_database_connection();
        $sql = mysqli_query($conn, "SELECT * FROM service_book WHERE id='$get_id'");
        if (mysqli_num_rows($sql) > 0) {
            $update = "UPDATE service_book SET status='cancel' WHERE id='$get_id'";
            if ($conn->query($update) === TRUE) {
                $id = "cancel";
            } else {
                $id = "Service booking cancel failed. please try again later!";
            }
        } else {
            $id = "Order not found";
        }

        return $id;
    }

    // cancel service access method
    public function cancel_service_access($get_id){
        return $this->cancel_service($get_id);
    }
}


// verify the customer
class VerificationCustomer
{
    public function verification($email)
    {
        $db = new Database;
        $conn = $db->access_database_connection();
        $query = mysqli_query($conn, "SELECT * FROM customer WHERE email='$email'");
        if (mysqli_num_rows($query) > 0) {
            $verify = true;
        } else {
            $verify = false;
        }
        return $verify;
    }
}
