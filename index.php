<?php 
  $insert = false;
  $update = false;
  $deleted = false;
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "notes";

  $conn = mysqli_connect($servername , $username , $password , $database);

  if(!$conn){
    die("sorry failed to connect: ". mysqli_connect_error());
  }
  if(isset($_GET['delete'])){
      
    $sno = $_GET['delete'];
 
    $sql = "DELETE FROM `notes` WHERE `sno` = $sno" ;
    $result = mysqli_query($conn , $sql);
    if($result){
      
      $deleted = true;
      }
  
      else{
        echo "error have occured : ". mysqli_connect_error();
        
      }
   }
  if($_SERVER['REQUEST_METHOD']=='POST'){
   
     

    if(isset($_POST['snoEdit'])){
      $sno = $_POST["snoEdit"];
      $title = $_POST["titleEdit"];
      $description = $_POST["descriptionEdit"];

      $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = $sno";

      $result = mysqli_query($conn , $sql);
      if($result){
    
       $update = true;
       }
   
       else{
         echo "error have occured : ". mysqli_connect_error();
         
       }
    }
    else{

    $title = $_POST['title'];
    $description = $_POST['description'];
    $sql = "INSERT INTO `notes` ( `title`, `description`) VALUES ( '$title', '$description')";
    $result = mysqli_query($conn , $sql); 

    if($result){
     $insert = true;
    }

    else{
      echo "error have occured : ". mysqli_connect_error();
      $insert = false;
    }
  }

  }



 

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHP-CRUD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>  

  

  
</head>

<body>
 

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action = "/crud/index.php" method = "post">
      <div class="modal-body">
      
        <input type="hidden" name="snoEdit" id="snoEdit">
      <div class="mb-3">
        <label for="title">Note-title</label>
        <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">

      </div>

      <div class="mb-3">
        <label for="description">Note-description</label>
        <textarea class="form-control" id="descriptionEdit" name = "descriptionEdit" rows="3"></textarea>
      </div>
      
    
      </div>
      <div class="modal-footer d-block mr-auto">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">PHP-CRUD
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
          </li>


        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>

  <?php
       if($insert){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your data has been inserted to the database.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
       }

?>


<?php
       if($update){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Updated!</strong> Your data has been updated to the database.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
       }

?>


<?php
       if($deleted){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Deleted!</strong> Your data has been deleted to the database.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
       }

?>

  <div class="container my-4">
    <h2>Add a note here</h2>
    <form action = "/crud/index.php" method = "post">
      <div class="mb-3">
        <label for="title">Note-title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">

      </div>

      <div class="mb-3">
        <label for="description">Note-description</label>
        <textarea class="form-control" id="description" name = "description" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>

  <div class="container my-4">
 
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.NO</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
       
      </thead>
      <tbody>
      <?php
            $sql = "SELECT * FROM `notes`";
            $result = mysqli_query($conn , $sql);
            $sno = 1;
            while($row = mysqli_fetch_assoc($result)){
              echo " <tr>
              <th scope='row'>".$sno++."</th>
              <td>".$row['title']."</td>
              <td>".$row['description']."</td>
              <td>  <button class=' edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> 
              <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button></td>
            </tr>" ;
             
              // echo "<br>";
            }
        ?>
       
  
      </tbody>
       <button class=' edit btn btn-sm btn-primary'>Edit</button>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
   <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> 

  <script>
  let table = new DataTable('#myTable');
  </script>

<script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element)=>{
      element.addEventListener("click",(e)=>{
        console.log("edit" , );
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        titleEdit.value = title;
        descriptionEdit.value = description;
        $('#editModal').modal('toggle') ;
           })
      
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element)=>{
      element.addEventListener("click",(e)=>{
        console.log("edit" , );
        

        sno = e.target.id.substr(1,);
       
        if(confirm("Press a button!")){
          console.log("yes");
          window.location = `/crud/index.php?delete=${sno}`;
      }
      else{
        console.log("no");

      }
           })
      
    })
  </script>
</body>

</html>