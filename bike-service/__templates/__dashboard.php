<?php
$db = new Database;
$conn = $db->access_database_connection();
$session = new Session;

?>
<nav class="navbar navbar-expand-lg bg-success sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand text-white fw-bold" href="dashboard"><i class="fa-solid fa-screwdriver-wrench text-warning"></i> Bike Service</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse col-md-10 justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav me-3 mb-2 mb-lg-0">
        <li class="nav-item">
          <form action="dashboard" method="POST">
            <a class="nav-link text-white logout" type="button"><i class="fa-solid fa-right-to-bracket mx-1"></i> Logout</a>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <div class="row">
    <div class="col-lg-5 mt-5">
      <div class="card mt-5 rounded shadow-lg">
        <div class="card-body">
          <h5 class="card-title text-center fw-bold">Booking Service</h5>
          <form class="mt-3 mx-auto col-lg-10" action="" method="POST">
            <div class="col-md-12 mb-2 mx-2 mt-5">
              <select class="form-select service" aria-label="Default select example">
                <option selected>Select your service</option>
                <?php $query = "SELECT * FROM services";
                $result = $conn->query($query);
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
                  <option value="<?php echo $row['id'] ?>"><?php echo $row['name']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-12 mb-2 mx-2 mt-3">
              <input type="number" class="form-control price" readonly name="price" autocomplete="off" placeholder="Price" aria-label="Recipient's date" aria-describedby="basic-addon2">
            </div>
            <div class="col-md-12 mb-2 mx-2 mt-3">
              <input type="text" class="form-control date" id="date" readonly name="from" autocomplete="off" placeholder="From Date" aria-label="Recipient's date" aria-describedby="basic-addon2">
            </div>
            <div class="col-md-12 mb-3 mt-4 text-center">
              <button class="btn btn-primary book" type="submit">Book</button>
              <button class="btn btn-danger cancel" type="reset">cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-lg-7 mt-5">
      <div class="table-responsive mt-4 tables">
        <div class="text-center mt-3">
          <h5 class="fw-bold text-center">Order list Table</h5>
        </div>
        <table id="datatablesSimple" class="table table-striped table-bordered">
          <thead>
            <tr class="">
              <th>S.No</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone No</th>
              <th>Service Name</th>
              <th>Price</th>
              <th>Booking Date</th>
              <th>Status</th>
              <th>Order Place date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
              $email = $session->get_access('email');
              $query = "SELECT * FROM service_book WHERE email='$email'";
              $result = $conn->query($query);
              $s_no = 1;
              while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
            <tr>
                <td><?php echo $s_no ?></td>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['phone'] ?></td>
                <td><?php echo $row['service_name'] ?></td>
                <td><?php echo $row['price'] ?></td>
                <td><?php echo $row['order_date'] ?></td>
                <td>
                  <?php if($row['status'] == "pending") {?>
                    <p class="text-warning fw-bold"><?php echo $row['status'] ?></p>
                    <?php } else if($row['status'] == "cancel"){?>
                      <p class="text-danger fw-bold"><?php echo $row['status'] ?></p>
                    <?php } else if($row['status'] == "completed"){?>
                      <p class="text-success fw-bold"><?php echo $row['status'] ?></p>
                    <?php } else if($row['status'] == "ready for delivery"){?>
                      <p class="text-primary fw-bold"><?php echo $row['status'] ?></p>
                    <?php } else{?>
                      <p class="text-danger fw-bold"><?php echo "Something went wrong";?></p>
                    <?php }?>
                </td>
                <td><?php echo $row['current_date_time'] ?></td>
                <td>
                  <form action="dashboard" method="POST">
                  <?php if($row['status'] == "cancel" or $row['status'] == "completed") {?>
                    <button class="btn btn-danger cancel_service" disabled value="<?php echo $row['id']; ?>"><i class="fa-solid fa-xmark"></i></button>
                  <?php } else{?>
                    <button class="btn btn-danger cancel_service" value="<?php echo $row['id']; ?>"><i class="fa-solid fa-xmark"></i></button>
                  <?php }?>
                  </form>
                </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>