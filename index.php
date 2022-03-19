<?php 

$insert = false;
$update = false;
$delete = false;
$error = false;

// connect to database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Die if connection was not successful
if (!$conn){
    die("Sorry we failed to connect: ". mysqli_connect_error());
}

// code to delete.
if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $sql = "DELETE from `notes` WHERE `sno` = $sno";
  $result = mysqli_query($conn,$sql);

  if($result){
    $delete = true;
  }
  else{
    $error = true;
  }
}

// code to edit and add
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['snoEdit'])){
    $title = $_POST['titleEdit'];
    $description = $_POST['descriptionEdit'];
    $sno = $_POST['snoEdit'];

    if(strlen($title)>0 && strlen($description)>0){
      $sql = "UPDATE `notes` SET `title` = '$title' ,`description` = '$description'  WHERE `notes`.`sno` = $sno";
      $result = mysqli_query($conn,$sql);

      if($result){
        $update = true;
      }
      else{
        $error = true;
      }
    }
  }
  else{
    $title = $_POST['title'];
    $description = $_POST['description'];
   
    if(strlen($title)>0 && strlen($description)>0){
      $sql = "INSERT INTO `notes` (`title`,`description`) VALUES ('$title','$description')";
      $result = mysqli_query($conn,$sql);

      if($result){
        $insert = true;
      }
      else{
        $error = true;
      }
    }
  }  

}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" class="css">
    <title>NotesSpot - Keep Your Notes</title>
  </head>
  <body>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="/NotesSpot/index.php" method="POST">
      <div class="modal-body">
        <input type="hidden" name="snoEdit" class="snoEdit" id="snoEdit">
        <div class="form-floating my-3 mx-3">
          <textarea
            class="form-control"
            id="titleEdit"
            name="titleEdit"
            style="height: 60px"
          ></textarea>
          <label for="titleEdit">Title</label>
        </div>
        <div class="form-floating mx-3 my-3">
          <textarea
            class="form-control"
            id="descriptionEdit"
            name="descriptionEdit"
            style="height: 100px"
          ></textarea>
          <label for="descriptionEdit">Description</label>
        </div>

        <div class="modal-footer d-block mr-auto">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </div>
      </form>
  
    </div>
  </div>
</div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
      <img src="https://img.icons8.com/external-flaticons-lineal-color-flat-icons/512/000000/external-notes-literature-flaticons-lineal-color-flat-icons.png" style="height:42px;"/>
        <a class="navbar-brand" href="#">NotesSpot</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#">About</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#">Contact Us</a>
            </li>
          </ul>
          <form class="d-flex">
            <input
              class="form-control me-2"
              type="search"
              placeholder="Search"
              aria-label="Search"
            />
            <button class="btn btn-outline-success" type="submit">
              Search
            </button>
          </form>
        </div>
      </div>
    </nav>

    <?php 
    if($insert){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      Note has been added successfully!
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    else if($error){
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      Some error occured, please try again.
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    else if($update){
      echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
      Note has been updated successfully!
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    else if($delete){
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      Note has been deleted successfully!
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    ?>

    <div class="container my-3" style="width: 80%">
      <h3 class="d-flex align-items-center justify-content-center">
        Write a Note ✏️
      </h3>
      <form action="/NotesSpot/index.php" method="POST">
        <div class="form-floating my-3">
          <textarea
            class="form-control"
            id="title"
            name="title"
            style="height: 60px"
          ></textarea>
          <label for="title">Title</label>
        </div>
        <div class="form-floating">
          <textarea
            class="form-control"
            id="description"
            name="description"
            style="height: 100px"
          ></textarea>
          <label for="description">Description</label>
        </div>

        <button type="submit" class="btn btn-primary my-3">Add Note</button>
      </form>
    </div>

    <div class="container" style="width: 100%">

      <table class="table table-striped table-hover my-3" id="myTable">
        <thead>
          <tr>
            <th scope="col">Sno.</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>

        <?php 
        $sql = "SELECT * FROM `notes`";
        $result = mysqli_query($conn,$sql);
        $sno = 0;
        while($row = mysqli_fetch_assoc($result)){
          $sno++;
          echo "<tr>
          <th scope='row'>" . $sno . "</th>
          <td style='width:15%;'>" . $row['title'] . "</td>
          <td style='width:65%;'>" . $row['description'] . "</td>
          <td><button class='edit btn btn-sm btn-success my-1' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-danger' id=d".$row['sno'].">Delete</button>
          </td>
          </tr>";}

        ?>

        </tbody>
      </table>
      <hr class="my-4">
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
    ></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
      $(document).ready( function () {
      $('#myTable').DataTable();
      });
    </script>

    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
      element.addEventListener('click',(e)=>{

      tr = e.target.parentNode.parentNode;
      title = tr.getElementsByTagName("td")[0].innerText;
      description = tr.getElementsByTagName("td")[1].innerText;
      //console.log(title , description);

      document.getElementById('titleEdit').value = title;
      document.getElementById('descriptionEdit').value = description;
      document.getElementById('snoEdit').value = e.target.id;
      $('#editModal').modal('toggle');
      })
    })

      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element)=>{
      element.addEventListener('click',(e)=>{
      
      sno = e.target.id.substr(1,);
      if(confirm('Are you sure you want to Delete this?')){
        console.log('yes');
        window.location = `/NotesSpot/index.php?delete=${sno}`;
      } 
      })
    })
    </script>
  </body>
</html>
