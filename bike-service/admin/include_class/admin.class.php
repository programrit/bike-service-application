<?php

class BikeServiceAdmin
{
    // login method
    private function login($email, $password)
    {
        $db = new Database;
        $conn = $db->access_database_connection();
        $session = new Session();
        $session->start_access();
        $sql = mysqli_query($conn, "SELECT * FROM admin WHERE email='$email'");
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_array($sql);
            if (password_verify($password, $row['password'])) {
                $session->set_access('email', $email);
                $session->set_access('login', true);
                $login = "Login Successfully";
            } else {
                $login = "Please enter correct password!";
            }
        } else {
            $login = "Email address not found. Please signup first";
        }
        return $login;
    }

    // login method access 
    public function access_login($email, $password)
    {
        return $this->login($email, $password);
    }

    // add service
    private function add_service($service_name, $price)
    {
        $db = new Database;
        $conn = $db->access_database_connection();
        $sql = mysqli_query($conn, "SELECT * FROM services WHERE name='$service_name'");
        if (mysqli_num_rows($sql) > 0) {
            $add = "Service name already exist";
        } else {
            $sql = "INSERT INTO services (name,price) VALUES('$service_name','$price')";
            if ($conn->query($sql) === TRUE) {
                $add = "add";
            } else {
                $add = "Something went wrong. please try again!";
            }
        }
        return $add;
    }

    // add service access method
    public function add_service_access($service_name, $price)
    {
        return $this->add_service($service_name, $price);
    }

    // fetch particular service 
    private function fetch_service($id){
        $db = new Database;
        $conn = $db->access_database_connection();
        $sql = mysqli_query($conn, "SELECT * FROM services WHERE id='$id'");
        if (mysqli_num_rows($sql) > 0) {
            $row = $sql->fetch_array(MYSQLI_ASSOC);
            $add = $row;
        } else {
            $add ="null";
        }
        return $add;
    }

    // fetch particular service  access method
    public function fetch_service_access($id)
    {
        return $this->fetch_service($id);
    }

    //update service
    private function update_service($service_name, $service_price,$id)
    {
        $db = new Database;
        $conn = $db->access_database_connection();
        $sql = mysqli_query($conn, "SELECT * FROM services WHERE name='$service_name' AND id <> '$id'");
        if (mysqli_num_rows($sql) > 0) {
            $update = "Service name already exist";
        } else{
            $update_data = "UPDATE services SET name='$service_name', price='$service_price' WHERE id='$id'";
            if ($conn->query($update_data) === TRUE) {
                $update = "update";
            } else {
                $update = "Something went wrong. please try again!";
            }
            return $update;
        }
    }

    // update service access method
    public function update_service_access($service_name,$service_price,$id){
        return $this->update_service($service_name, $service_price,$id);
    }

    // delete service 
    private function delete_service($get_id){
        $db = new Database;
        $conn = $db->access_database_connection();
        $sql = mysqli_query($conn, "SELECT * FROM services WHERE id='$get_id'");
        if (mysqli_num_rows($sql) > 0) {
            $delete_data = "DELETE FROM services WHERE id='$get_id'";
            if ($conn->query($delete_data) === TRUE) {
                $delete = "delete";
            }else{
                $delete = "Service delete failed";
            }
        } else {
            $delete ="Service not found";
        }

        return $delete;
    }

    /// delete service access method
    public function delete_service_access($get_id){
        return $this->delete_service($get_id);
    }


    // fetch order data 
    private function fetch_order($order_id){
        $db = new Database;
        $conn = $db->access_database_connection();
        $sql = mysqli_query($conn, "SELECT * FROM service_book WHERE id='$order_id'");
        if (mysqli_num_rows($sql) > 0) {
            $row = $sql->fetch_array(MYSQLI_ASSOC);
            $order = $row;
        } else {
            $order ="null";
        }
        return $order;
    }
    // fetch order data access method
    public function fetch_order_access($order_id)
    {
        return $this->fetch_order($order_id);
    }

    // update status
    private function update_status($email,$id,$status){
        $db = new Database;
        $conn = $db->access_database_connection();
        include('mail.class.php');
        $mail = new SendMail;
        $sql = mysqli_query($conn, "SELECT * FROM service_book WHERE id='$id'");
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_array($sql);
            $name = $row['name'];
            if($row['status'] == $status){
                $updated = "Status already exist";
            }else{
                if($status == "ready for delivery"){
                    $send = $mail->send_mail($email,$name);
                    if($send){
                        $update = "UPDATE service_book SET status='$status' WHERE id='$id'";
                        if ($conn->query($update) === TRUE) {
                            $updated = "updated";
                        } else {
                            $updated = "Something went wrong. please try again!";
                        }
                    }else{
                        $updated = "Mail send failed. Please try again later";
                    }
                }else{
                    $update = "UPDATE service_book SET status='$status' WHERE id='$id'";
                    if ($conn->query($update) === TRUE) {
                        $updated = "updated";
                    } else {
                        $updated = "Status update failed. please try again!";
                    }
                }
            }
        }
        return $updated;
    }

    // update status access method
    public function update_status_access($email,$id,$status){
        return $this->update_status($email,$id,$status);
    }

}

// verify admin class
class VerificationCustomer
{
    public function verification($email)
    {
        $db = new Database;
        $conn = $db->access_database_connection();
        $query = mysqli_query($conn, "SELECT * FROM admin WHERE email='$email'");
        if (mysqli_num_rows($query) > 0) {
            $verify = true;
        } else {
            $verify = false;
        }
        return $verify;
    }
}
