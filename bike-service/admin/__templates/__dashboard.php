<?php
$db = new Database;
$conn = $db->access_database_connection();
?>
<nav class="navbar navbar-expand-lg bg-success sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand text-white fw-bold" href="dashboard"><i class="fa-solid fa-screwdriver-wrench text-warning"></i> Bike Service Admin</a>
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
    <div class="col-lg-6  mt-5 border rounded shadow-lg mb-5">
      <div class="table-responsive mt-3 tables">
        <div class="text-center mt-3 mb-4">
          <h5 class="fw-bold">User Table</h5>
        </div>
        <table id="datatablesSimple1" class="table table-striped table-bordered mt-3 mb-3">
          <thead>
            <tr class="text-white bg-danger">
              <th>S.No</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone No</th>
            </tr>
          </thead>
          <tbody>
            <?php $query = "SELECT * FROM customer";
            $result = $conn->query($query);
            $s_no = 1;
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
              <tr>
                <td><?php echo $s_no ?></td>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['phone'] ?></td>
              </tr>
              <?php $s_no += 1; ?>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-lg-6 mt-5 border rounded shadow-lg mb-5">
      <div class="table-responsive mt-3 tables">
        <div class="d-flex justify-content-between mt-3 mb-3 mx-3">
          <h5 class="fw-bold">Service List Table</h5>
          <div class="text-end mx-4">
            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-dismiss="modal"  data-bs-target="#staticBackdrop"><i class="fa-solid fa-plus"></i></button>
          </div>
        </div>
        <table id="datatablesSimple" class="table table-striped table-bordered mt-3 mb-3">
          <thead>
            <tr class="text-white bg-primary">
              <th>S.No</th>
              <th>Service Name</th>
              <th>Price</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $query = "SELECT * FROM services";
            $result = $conn->query($query);
            $s_no = 1;
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
              <tr>
                <td><?php echo $s_no ?></td>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['price'] ?></td>
                <td class="mx-auto">
                  <form action="dashboard" method="POST">
                    <button class="btn btn-primary edit" data-bs-toggle="modal"  data-bs-dismiss="modal"  data-bs-target="#staticBackdrop1" type="button" value="<?php echo $row['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="btn btn-danger delete" type="button" value="<?php echo $row['id'] ?>"><i class="fa-solid fa-trash"></i></button>
                  </form>
                </td>
              </tr>
              <?php $s_no += 1; ?>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="container mt-5 mb-5">
  <div class="row">
    <div class="col-lg-10 mx-auto border rounded shadow-lg mt-5">
      <div class="table-responsive mt-2 tables">
        <div class="text-center mt-3">
          <h5 class="fw-bold">Order list Table</h5>
        </div>
        <table id="datatablesSimple2" class="table table-striped table-bordered">
          <thead>
            <tr class="text-white bg-danger">
              <th>S.No</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone No</th>
              <th>Service Name</th>
              <th>Price</th>
              <th>Booking Date</th>
              <th>Status</th>
              <th>Order Place Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              <?php $query = "SELECT * FROM service_book";
            $result = $conn->query($query);
            $s_no = 1;
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
              <tr>
                <td><?php echo $s_no; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['service_name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['order_date']; ?></td>
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
                <td><?php echo $row['current_date_time']; ?></td>
                <td>
                  <form action="dashboard" method="POST">
                    <button class="btn btn-primary edit_service_order" value="<?php echo $row['id']; ?>" data-bs-toggle="modal"  data-bs-dismiss="modal"  data-bs-target="#staticBackdrop2" type="button"><i class="fa-solid fa-pen-to-square"></i></button>
                  </form>
                </td>
              </tr>
              <?php $s_no+=1 ?>
             <?php 
            } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<!-- add services modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-center" id="staticBackdropLabel">Add Services</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"  aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="col-lg-9 mx-auto">
          <form action="dashboard" method="POST">
            <div class="form-floating mb-3 mt-3">
              <input type="text" class="form-control name" id="floatingInput" placeholder="Enter Your Service Name">
              <label for="floatingInput">Service Name</label>
            </div>
            <div class="form-floating mb-3 mt-3">
              <input type="number" class="form-control price" id="floatingInput" placeholder="Enter Your Price">
              <label for="floatingInput">Price</label>
            </div>
            <div class="mt-3 text-center">
              <button class="btn btn-primary add" type="submit">Add Service</button>
              <button class="btn btn-danger reset_service" type="reset">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- update services modal -->
<div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-center" id="staticBackdropLabel1">Update Services</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
          <div class="col-lg-9 mx-auto">
            <div class="form-floating mb-3 mt-3">
              <input type="text" class="form-control service_name" id="floatingInput" placeholder="Enter Your Service Name">
              <label for="floatingInput">Service Name</label>
            </div>
            <div class="form-floating mb-3 mt-3">
              <input type="number" class="form-control service_price" id="floatingInput" placeholder="Enter Your Price">
              <label for="floatingInput">Price</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="mt-3 text-center">
            <button class="btn btn-primary update_data" type="button">Update</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- edit order service daata modal -->
<div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-center" id="staticBackdropLabel2">Update Services</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
          <div class="col-lg-9 mx-auto">
            <div class="form-floating mb-3 mt-3">
              <input type="text" class="form-control name1" disabled id="floatingInput" placeholder="Name">
              <label for="floatingInput">Name</label>
            </div>
            <div class="form-floating mb-3 mt-3">
              <input type="email" class="form-control email1" disabled id="floatingInput" placeholder="Email">
              <label for="floatingInput">Email</label>
            </div>
            <div class="form-floating mb-3 mt-3">
              <input type="text" class="form-control service_name1" disabled id="floatingInput" placeholder="Service Name">
              <label for="floatingInput">Service Name</label>
            </div>
            <div class="form-floating mb-3 mt-3">
              <select type="number" class="form-select select_status" id="floatingInput">
                <option selected>Please update status</option>
                <option value="ready for delivery">ready for delivery</option>
                <option value="completed">completed</option>
                <option value="cancel">cancel</option>
              </select>
              <label for="floatingInput">Status</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="mt-3 text-center">
            <button class="btn btn-primary update_status" type="button">Update Status</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>