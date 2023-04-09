   <?php
    include '_main.php';
    if (!empty($_POST['addProject'])) {
        $title = Database::$conn->real_escape_string($_POST['title']);
        $dateEdited = date('Y-m-d H:i:s');
        $description = Database::$conn->real_escape_string($_POST['description']);
        $author = Database::$conn->real_escape_string($_POST['author']);
        $hoursW = Database::$conn->real_escape_string($_POST['hoursW']);
        $startd = Database::$conn->real_escape_string($_POST['startd']);
        $endd = Database::$conn->real_escape_string($_POST['endd']);

        $sql = "INSERT INTO project (title, dateEdited, description, author, hoursW, startd, endd) VALUES ('$title', '$dateEdited', '$description', '$author', '$hoursW', '$startd', '$endd')";
        if (mysqli_query(Database::$conn, $sql)) {
            $outcome = 'all good';
        } else {
            $outcome = 'Error: ' . $sql . '<br>' . mysqli_error(Database::$conn);
            echo $outcome;
            exit;
        }
        header('Location:index.php?outcome=' . $outcome);
        exit;
    }
    if (!empty($_POST['editProject'])) {
        $id = Database::$conn->real_escape_string($_POST['id']);
        $title = Database::$conn->real_escape_string($_POST['title']);
        $dateEdited = date('Y-m-d H:i:s');
        $description = Database::$conn->real_escape_string($_POST['description']);
        $author = Database::$conn->real_escape_string($_POST['author']);
        $hoursW = Database::$conn->real_escape_string($_POST['hoursW']);
        $startd = Database::$conn->real_escape_string($_POST['startd']);
        $endd = Database::$conn->real_escape_string($_POST['endd']);
        $sql = "UPDATE project SET title = '$title', dateEdited = '$dateEdited', description = '$description', author = '$author', hoursW = '$hoursW', startd = '$startd', endd = '$endd' WHERE id = '$id'";
        if (mysqli_query(Database::$conn, $sql)) {
            $outcome = 'all good';
        } else {
            $outcome = 'Error: ' . $sql . '<br>' . mysqli_error(Database::$conn);
            echo $outcome;
            exit;
        }
        header('Location:index.php?outcome=' . $outcome);
        exit;
    }

    if (!empty($_POST['deleteProject'])) {
        $idchange = Database::$conn->real_escape_string($_POST['idchange']);
        $request = "DELETE FROM project WHERE id = '" . $idchange . "'";
        if (mysqli_query(Database::$conn, $sql)) {
            $outcome = 'all good';
        } else {
            $outcome = 'Error: ' . $sql . '<br>' . mysqli_error(Database::$conn);
            echo $outcome;
            exit;
        }
        header('Location:index.php?outcome=' . $outcome);
        exit;
    }

    $data = gatherProjects();
    ?>
   <!doctype html>
   <html lang="en">

   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <title>drow progress tracker</title>
       <link href="bootstrap.min.css" rel="stylesheet">
       <link href="fa/css/all.min.css" rel="stylesheet" />
       <link href="style.css" rel="stylesheet">
   </head>
   <div class="container-fluid  ">
       <div class="row">
           <div class="col-md-12  p-4 fancy">

               <h1>drow progress tracker</h1>
               <p>
                   This is a simple progress tracker.
               </p>
               <a href="#" class="addProject btn btn-indigo" data-bs-toggle="modal" data-bs-target="#addproject"><i class="fa-regular fa-plus"></i> Project</a>


           </div>

           <?php echo $data; ?>
       </div>

   </div>

   <div class="modal fade" id="addproject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel">Add project</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <form class="" action="index.php" method="post">
                       <input type="hidden" name="addProject" value="true">
                       <div class="form-group ">
                           <input type="text" class="form-control" name="title" placeholder="Title">
                       </div>
                       <div class=" form-group ">
                           <textarea placeholder="description" class="form-control" name="description" id="" cols="6" rows="6"></textarea>
                       </div>
                       <div class="form-group ">
                           <input type="text" class="form-control" name="author" placeholder="author">
                       </div>

                       <div class="form-group ">
                           <input type="text" class="form-control" name="hoursW" placeholder="hoursW">
                       </div>

                       <div class="form-group ">
                           <input type="text" class="form-control" name="startd" placeholder="startd">
                       </div>

                       <div class="form-group ">
                           <input type="text" class="form-control" name="endd" placeholder="endd">
                       </div>
                       <div class="d-grid mt-2">
                           <button type="submit" class="btn  btn-indigo">Submit <i class="fa-solid fa-arrow-right"></i></button>
                       </div>
                   </form>

               </div>

           </div>
       </div>
   </div>


   <?php
    if (!empty($_GET['outcome'])) {
        echo '<div class="alert fancy text-center"><h4>' . $_GET['outcome'] . '</h4></div>';
    }

    ?>


   <script src="bootstrap.bundle.min.js"></script>
   <script src="jquery-3.6.0.min.js"></script>

   <script>
       $('.alert').click(function() {
           $(this).fadeOut();
       });
   </script>

   </body>

   </html>