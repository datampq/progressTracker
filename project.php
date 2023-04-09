   <?php
    include '_main.php';
    $data = gatherProjects();
    $id = '';
    if (!empty($_GET['id'])) {
        $id = Database::$conn->real_escape_string($_GET['id']);
    } else {
        if (!empty($_POST['id'])) {
            $id = Database::$conn->real_escape_string($_POST['id']);
        } else {
            header('Location:project.php?id=' . $id . '');
            exit;
        }
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
        header('Location:project.php?id=' . $id . '&outcome=' . $outcome);
        exit;
    }

    if (!empty($_POST['addTodo'])) {

        $content = Database::$conn->real_escape_string($_POST['content']);
        $dateEdited = date('Y-m-d H:i:s');
        $request = "INSERT INTO todos (projectid, content, dateEdited) VALUES ('$id', '$content', '$dateEdited')";
        if (mysqli_query(Database::$conn, $request)) {
            $outcome = 'all good';
        } else {
            $outcome = 'Error: ' . $sql . '<br>' . mysqli_error(Database::$conn);
            echo $outcome;
            exit;
        }
        header('Location:project.php?id=' . $id . '&outcome=' . $outcome);
        exit;
    }


    if (!empty($_POST['editTodo'])) {
        $idtodo = Database::$conn->real_escape_string($_POST['idtodo']);
        $content = Database::$conn->real_escape_string($_POST['content']);
        $dateEdited = date('Y-m-d H:i:s');
        $request = "UPDATE todos SET content = '$content', dateEdited = '$dateEdited' WHERE id = '$idtodo'";
        if (mysqli_query(Database::$conn, $request)) {
            $outcome = 'all good todo';
        } else {
            $outcome = 'Error: ' . $sql . '<br>' . mysqli_error(Database::$conn);
            echo $outcome;
            exit;
        }
        header('Location:project.php?id=' . $id . '&outcome=' . $outcome);
        exit;
    }
    if (!empty($_POST['deleteTodo'])) {
        $idtodo = Database::$conn->real_escape_string($_POST['idtodo']);
        $request = "DELETE FROM todos WHERE id = '$idtodo'";
        if (mysqli_query(Database::$conn, $request)) {
            $outcome = 'all good';
        } else {
            $outcome = 'Error: ' . $sql . '<br>' . mysqli_error(Database::$conn);
            echo $outcome;
            exit;
        }
        header('Location:project.php?id=' . $id . '&outcome=' . $outcome);
        exit;
    }







    if (!empty($_POST['addCredential'])) {

        $note = Database::$conn->real_escape_string($_POST['note']);
        $username = Database::$conn->real_escape_string($_POST['username']);
        $pass = Database::$conn->real_escape_string($_POST['pass']);
        $title = Database::$conn->real_escape_string($_POST['title']);
        $dateEdited = date('Y-m-d H:i:s');
        $request = "INSERT INTO credentials (dateEdited, note, projectid, title, username, pass) VALUES ('$dateEdited', '$note', '$id', '$title', '$username', '$pass')";
        if (mysqli_query(Database::$conn, $request)) {
            $outcome = 'ok';
        } else {
            $outcome = 'Error: ' . $sql . '<br>' . mysqli_error(Database::$conn);
            echo $outcome;
        }
        exit;
    }


    if (!empty($_POST['editCredential'])) {
        $idtodo = Database::$conn->real_escape_string($_POST['credentialid']);
        $note = Database::$conn->real_escape_string($_POST['note']);
        $username = Database::$conn->real_escape_string($_POST['username']);
        $pass = Database::$conn->real_escape_string($_POST['pass']);
        $title = Database::$conn->real_escape_string($_POST['title']);
        $dateEdited = date('Y-m-d H:i:s');
        $request = "UPDATE credentials SET note = '$note', dateEdited = '$dateEdited', username = '$username', pass = '$pass', title = '$title'  WHERE id = '$idtodo'";
        if (mysqli_query(Database::$conn, $request)) {
            $outcome = 'ok';
        } else {
            $outcome = 'Error: ' . $sql . '<br>' . mysqli_error(Database::$conn);
            echo $outcome;
        }
        exit;
    }
    if (!empty($_POST['deleteCredential'])) {
        $idtodo = Database::$conn->real_escape_string($_POST['credentialid']);
        $request = "DELETE FROM credentials WHERE id = '$idtodo'";
        if (mysqli_query(Database::$conn, $request)) {
            $outcome = 'ok';
        } else {
            $outcome = 'Error: ' . $sql . '<br>' . mysqli_error(Database::$conn);
            echo $outcome;
        }
        exit;
    }

























    if (!empty($_POST['addChange'])) {
        $idpage = Database::$conn->real_escape_string($_POST['idpage']);
        $content = Database::$conn->real_escape_string($_POST['note']);
        $startd = Database::$conn->real_escape_string($_POST['startd']);
        $endd = Database::$conn->real_escape_string($_POST['endd']);
        $date = date('Y-m-d H:i:s');
        //get author from project:
        $sql = "SELECT author FROM project WHERE id = '" . $id . "'";
        $result = mysqli_query(Database::$conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $author = $row['author'];
        $request = "INSERT INTO changet (dateEdited, note, author, pageId, projectId, startd, endd) VALUES ( '" . $date . "', '" . $content . "', '" . $author . "', '" . $idpage . "', '" . $id . "', '" . $startd . "', '" . $endd . "')";
        if (mysqli_query(Database::$conn, $request)) {
            $outcome = 'all good';
        } else {
            $outcome = 'Error: ' . $sql . '<br>' . mysqli_error(Database::$conn);
            echo $outcome;
            exit;
        }
        header('Location:project.php?id=' . $id . '&outcome=' . $outcome);
        exit;
    }
    if (!empty($_POST['editChange'])) {
        $idchange = Database::$conn->real_escape_string($_POST['idchange']);
        $content = Database::$conn->real_escape_string($_POST['note']);
        $startd = Database::$conn->real_escape_string($_POST['startd']);
        $endd = Database::$conn->real_escape_string($_POST['endd']);

        $date = date('Y-m-d H:i:s');
        $request = "UPDATE changet SET dateEdited = '" . $date . "', note = '" . $content . "', startd = '" . $startd . "', endd = '" . $endd . "' WHERE id = '" . $idchange . "'";
        if (mysqli_query(Database::$conn, $request)) {
            $outcome = 'all good';
        } else {
            $outcome = 'Error: ' . $sql . '<br>' . mysqli_error(Database::$conn);
            echo $outcome;
            exit;
        }
        header('Location:project.php?id=' . $id . '&outcome=' . $outcome);
        exit;
    }

    if (!empty($_POST['deleteChange'])) {
        $idchange = Database::$conn->real_escape_string($_POST['idchange']);
        $request = "DELETE FROM changet WHERE id = '" . $idchange . "'";
        if (mysqli_query(Database::$conn, $sql)) {
            $outcome = 'all good';
        } else {
            $outcome = 'Error: ' . $sql . '<br>' . mysqli_error(Database::$conn);
            echo $outcome;
            exit;
        }
        header('Location:project.php?id=' . $id . '&outcome=' . $outcome);
        exit;
    }

    if (!empty($_POST['addPage'])) {
        $projectId = $id;
        $title = Database::$conn->real_escape_string($_POST['title']);
        $dateEdited = date('Y-m-d H:i:s');
        $controller = Database::$conn->real_escape_string($_POST['controller']);
        $databaseObject = Database::$conn->real_escape_string($_POST['databaseObject']);
        $repository = Database::$conn->real_escape_string($_POST['repository']);
        $note = Database::$conn->real_escape_string($_POST['note']);
        $stat = Database::$conn->real_escape_string($_POST['stat']);
        $versi = Database::$conn->real_escape_string($_POST['versi']);
        $admi = Database::$conn->real_escape_string($_POST['admi']);
        $moda = Database::$conn->real_escape_string($_POST['moda']);
        $logic = Database::$conn->real_escape_string($_POST['logic']);
        $client = Database::$conn->real_escape_string($_POST['client']);
        $request = "INSERT INTO page (title, dateEdited, controller, databaseObject, repository, note, stat, versi, admi, moda, logic, client, projectId) VALUES ('" . $title . "', '" . $dateEdited . "', '" . $controller . "', '" . $databaseObject . "', '" . $repository . "', '" . $note . "', '" . $stat . "', '" . $versi . "', '" . $admi . "', '" . $moda . "', '" . $logic . "', '" . $client . "', '" . $projectId . "')";
        if (mysqli_query(Database::$conn, $request)) {
            $outcome = 'all good';
        } else {
            $outcome = 'Error: ' . $sql . '<br>' . mysqli_error(Database::$conn);
            echo $outcome;
            exit;
        }
        header('Location:project.php?id=' . $id . '&outcome=' . $outcome);
        exit;
    }


    if (!empty($_POST['editPage'])) {
        $pageid = Database::$conn->real_escape_string($_POST['pageid']);
        $title = Database::$conn->real_escape_string($_POST['title']);
        $dateEdited = date('Y-m-d H:i:s');
        $controller = Database::$conn->real_escape_string($_POST['controller']);
        $databaseObject = Database::$conn->real_escape_string($_POST['databaseObject']);
        $repository = Database::$conn->real_escape_string($_POST['repository']);
        $note = Database::$conn->real_escape_string($_POST['note']);
        $stat = Database::$conn->real_escape_string($_POST['stat']);
        $versi = Database::$conn->real_escape_string($_POST['versi']);
        $admi = Database::$conn->real_escape_string($_POST['admi']);
        $moda = Database::$conn->real_escape_string($_POST['moda']);
        $logic = Database::$conn->real_escape_string($_POST['logic']);
        $client = Database::$conn->real_escape_string($_POST['client']);

        $request = "UPDATE page SET title = '" . $title . "', dateEdited = '" . $dateEdited . "', controller = '" . $controller . "', databaseObject = '" . $databaseObject . "', repository = '" . $repository . "', note = '" . $note . "', stat = '" . $stat . "', versi = '" . $versi . "', admi = '" . $admi . "', moda = '" . $moda . "', logic = '" . $logic . "', client = '" . $client . "' WHERE id = '" . $pageid . "'";
        if (mysqli_query(Database::$conn, $request)) {
            $outcome = 'all good';
        } else {
            $outcome = 'Error: ' . $sql . '<br>' . mysqli_error(Database::$conn);
            echo $outcome;
            exit;
        }
        header('Location:project.php?id=' . $id . '&outcome=' . $outcome);
        exit;
    }


    if (!empty($_POST['removePage'])) {
        $pageid = Database::$conn->real_escape_string($_POST['pageid']);
        $request = "DELETE FROM page WHERE id = '" . $pageid . "'";
        if (mysqli_query(Database::$conn, $request)) {
            $outcome = 'all good';
        } else {
            $outcome = 'Error: ' . $sql . '<br>' . mysqli_error(Database::$conn);
            echo $outcome;
            exit;
        }
        header('Location:project.php?id=' . $id . '&outcome=' . $outcome);
        exit;
    }

    $pheader = '';
    //get project data:
    $request = "SELECT * FROM project WHERE id = '" . $id . "'";
    $results = mysqli_query(Database::$conn, $request);
    if (mysqli_num_rows($results) > 0) {
        while ($row = mysqli_fetch_array($results)) {
            $pheader = '     <h4>' . $row['title'] . '</h4>
                       <div class="modal fade " id="editproject_' . $row['id'] . '" tabindex="-1" aria-labelledby="ep" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="ep">edit <strong>' . $row['title'] . '</strong> </h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
   <form class="" action="index.php" method="post">
                       <input type="hidden" name="editProject" value="true">
                          <input type="hidden" name="id" value="' . $row['id'] . '">
                       <div class="form-group ">
                           <input type="text" class="form-control" value="' . $row['title'] . '" name="title" placeholder="Title">
                       </div>
                       <div class=" form-group ">
                           <textarea placeholder="description" class="form-control" name="description" id="" cols="6" rows="6">' . $row['description'] . '</textarea>
                       </div>
                       <div class="form-group ">
                           <input type="text" class="form-control" value="' . $row['author'] . '" name="author" placeholder="author">
                       </div>

                       <div class="form-group ">
                           <input type="text" class="form-control" value="' . $row['hoursW'] . '" name="hoursW" placeholder="hoursW">
                       </div>

                       <div class="form-group ">
                           <input type="text" class="form-control" value="' . $row['startd'] . '" name="startd" placeholder="startd">
                       </div>

                       <div class="form-group ">
                           <input type="text" class="form-control" value="' . $row['endd'] . '" name="endd" placeholder="endd">
                       </div>
                                <div class="d-grid mt-2">
               <button type="submit" class="btn  btn-indigo">Submit <i class="fa-solid fa-arrow-right"></i></button>
              </div>
                   </form>
               </div>

           </div>
       </div>
   </div>';
        }
    }

    $todos = '';
    $request = "SELECT * FROM todos WHERE projectid = '" . $id . "'";
    $results = mysqli_query(Database::$conn, $request);
    if (mysqli_num_rows($results) > 0) {
        while ($row = mysqli_fetch_array($results)) {
            $todos .= '<div class="col-12 p-3 mt-2">
            <div class="row fancy p-2">
              <div class="col-lg-6 col-12">
            <h6>' . $row['dateEdited'] . '</h6>
            </div>
                <div class="col-lg-6 col-12 text-end">
                            <a class="btn toggleDrowExpand" href="#"  data-target="id_' . $row['id'] . '">
<i class="fa-solid fa-expand"></i></a>
            <a class="btn " href="#"  data-bs-toggle="modal" data-bs-target="#deletetd_' . $row['id'] . '">
<i class="fa-solid fa-trash"></i></a>
            </div>
                <div class="mt-2 col-12">
              <form class="" action="project.php" method="post">
                       <input type="hidden" name="editTodo" value="true">
                          <input type="hidden" name="idtodo" value="' . $row['id'] . '">
                          <input type="hidden" name="id"  value="' . $id . '">
           
                       <div class=" form-group ">
                           <textarea placeholder="content" class="form-control" name="content" id="" cols="6" rows="6">' . $row['content'] . '</textarea>
                       </div>
                           <div class="d-grid mt-2">
               <button type="submit" class="btn  btn-indigo"><i class="fa-regular fa-save"></i> Save</button>
              </div>
                   </form>
            </div>
            </div>
            
            </div>
            <div class="DrowExpand id_' . $row['id'] . '">
            <div class="row">
                 <div class="col-lg-6 col-12">
            <h6>' . $row['dateEdited'] . '</h6>
            </div>
                 <div class="col-lg-6 col-12 text-end">
                    <a class="btn toggleDrowExpand" href="#"  data-target="id_' . $row['id'] . '">
<i class="fa-solid fa-expand"></i></a>
            </div>
  <div class="mt-2 col-12">
    <form class="" action="project.php" method="post">
                       <input type="hidden" name="editTodo" value="true">
                          <input type="hidden" name="idtodo" value="' . $row['id'] . '">
                          <input type="hidden" name="id"  value="' . $id . '">
           
                       <div class=" form-group ">
                           <textarea placeholder="content" class="form-control" name="content" id="" cols="6" rows="6">' . $row['content'] . '</textarea>
                       </div>
                           <div class="d-grid mt-2">
               <button type="submit" class="btn  btn-indigo"><i class="fa-solid fa-trash"></i> Save</button>
              </div>
                   </form>
 </div>
            </div>
            </div>
            
   




            
            
            
                        
                       <div class="modal fade " id="deletetd_' . $row['id'] . '" tabindex="-1" aria-labelledby="ep" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="ep">delete <strong>note</strong> </h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
   <form class="" action="project.php" method="post">
                       <input type="hidden" name="deleteTodo" value="true">
                          <input type="hidden" name="idtodo" value="' . $row['id'] . '">
              <input type="hidden" name="id" value="' . $id . '">
              <div class="d-grid mt-2">
               <button type="submit" class="btn  btn-indigo"><i class="fa-solid fa-trash"></i> delete</button>
              </div>
                      
                   </form>
               </div>

           </div>
       </div>
   </div>

            
            
            
                            

            
            
            
            
            
            
            
            ';
        }
    }
    $data = '';


    //get pages:
    $request = "SELECT * FROM page WHERE projectId = '" . $id . "'";
    $results = mysqli_query(Database::$conn, $request);
    if (mysqli_num_rows($results) > 0) {
        while ($row = mysqli_fetch_array($results)) {
            //$row['id']

            $eChanges = getChanges($row['id'], $id);
            $data .= '<div class="col-12 mt-4 p-4 fancy">

            <div class="row">
             <div class="col-lg-4 col-12">
                <h4>' . $row['title'] . '</h4>
                  <h6>' . $row['dateEdited'] . '</h6>
         

            
            </div>
                <div class="col-lg-12 col-12">
           <form class="" action="project.php" method="post">
             <div class="row">
                       <input type="hidden" name="editPage" value="true">
                                 <input type="hidden" name="id" value="' . $id . '">
                          <input type="hidden" name="pageid" value="' . $row['id'] . '">
                       <div class="form-group col-4">
                           <input type="text" class="form-control" value="' . $row['title'] . '" name="title" placeholder="Title">
                             <input type="text" class="form-control" value="' . $row['controller'] . '" name="controller" placeholder="controller">
                               <input type="text" class="form-control" value="' . $row['stat'] . '" name="stat" placeholder="stat">
                                 <input type="text" class="form-control" value="' . $row['versi'] . '" name="versi" placeholder="versi">
                       </div>
                       <div class=" form-group col-8">
                           <textarea placeholder="note" class="form-control" name="note" id="" cols="6" rows="6">' . $row['note'] . '</textarea>
                       </div>
                   

                       <div class="form-group col">
                           <input type="text" class="form-control" value="' . $row['databaseObject'] . '" name="databaseObject" placeholder="databaseObject">
                       </div>

                       <div class="form-group col">
                           <input type="text" class="form-control" value="' . $row['repository'] . '" name="repository" placeholder="repository">
                       </div>

                   

                  

                           <div class="form-group col">
                           <input type="text" class="form-control" value="' . $row['admi'] . '" name="admi" placeholder="admi">
                       </div>


                           <div class="form-group col">
                           <input type="text" class="form-control" value="' . $row['moda'] . '" name="moda" placeholder="moda">
                       </div>

                           <div class="form-group col">
                           <input type="text" class="form-control" value="' . $row['logic'] . '" name="logic" placeholder="logic">
                       </div>


                           <div class="form-group col">
                           <input type="text" class="form-control" value="' . $row['client'] . '" name="client" placeholder="client">
                       </div>
 </div>

   <div class="row">
 <div class="d-grid col-lg-3 col-12 mt-2">

                       <button type="submit" class="btn  btn-indigo"><i class="fa-regular fa-save"></i> Save</button>
                        </div>

                         <div class="d-grid col-lg-3 col-12 mt-2">
<a class="btn btn-indigo" href="#"  data-bs-toggle="modal" data-bs-target="#add_Change' . $row['id'] . '">
<i class="fa-regular fa-plus"></i></a>
                        </div>



                         <div class="d-grid col-lg-3 col-12 mt-2">
<a class="btn   btn-indigo"
                data-bs-toggle="collapse" href="#collapseExample' . $row['id'] . '" role="button" aria-expanded="false" aria-controls="collapseExample' . $row['id'] . '"><i class="fa-regular fa-clock-rotate-left"></i></a>
                         
                        </div>

                        
         

                        
                         <div class="d-grid col-lg-3 col-12 mt-2">

                         <a class="btn  btn-indigo" href="#"
                data-bs-toggle="modal" data-bs-target="#deletep_' . $row['id'] . '"> <i class="fa-solid fa-trash"></i></a>
                        </div>

                          </div>
                   </form>
            </div>
            </div>
 
            <div class="row">
            <div class="collapse" id="collapseExample' . $row['id'] . '">
            ' . $eChanges . '
             </div> 
             </div>
            
            </div>
            
            
            
            
            
            
            
            
                       <div class="modal fade " id="deletep_' . $row['id'] . '" tabindex="-1" aria-labelledby="ep" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="ep">delete <strong>' . $row['title'] . '</strong> </h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
   <form class="" action="project.php" method="post">
                       <input type="hidden" name="removePage" value="true">
                          <input type="hidden" name="pageid" value="' . $row['id'] . '">
              <input type="hidden" name="id" value="' . $id . '">
              <div class="d-grid mt-2">
               <button type="submit" class="btn  btn-indigo"><i class="fa-solid fa-trash"></i> delete</button>
              </div>
                      
                   </form>
               </div>

           </div>
       </div>
   </div>

            
            
            
                            
                                             <div class="modal fade deleteChange" id="add_Change' . $row['id'] . '" tabindex="-1" aria-labelledby="ep" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="ep">add change to <strong>' . $row['title'] . '</strong> </h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
  <form class="" action="project.php" method="post">
                       <input type="hidden" name="addChange" value="true">
                          <input type="hidden" name="idpage" value="' . $row['id'] . '">
                          <input type="hidden" name="id"  value="' . $id . '">
               <div class="form-group ">
                           <input type="text" class="form-control" value="' . $dateTimeCurrentCHHeure . '" name="startd" placeholder="startd">
                       </div>
                          <div class="form-group ">
                           <input type="text" class="form-control" value="' . $dateTimeCurrentCHHeure . '" name="endd" placeholder="endd">
                       </div>
                       <div class=" form-group ">
                           <textarea placeholder="note" class="form-control" name="note" id="" cols="6" rows="6"></textarea>
                       </div>
                           <div class="d-grid mt-2">
               <button type="submit" class="btn  btn-indigo"><i class="fa-regular fa-save"></i> Save</button>
              </div>
                   </form>
               </div>

           </div>
       </div>
   </div> 
             
            
            
            
            
            
            ';
        }
    }

    $credentials = '     <div class="modal fade credentialsModal" id="credentialsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="exampleModalLabel">Add note</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                   </div>
                   <div class="modal-body">
                 
                   <div class="row credHolder">';
    //select from credentials where projectid = id:
    $request = "SELECT * FROM credentials WHERE projectid = '" . $id . "'";
    $results = mysqli_query(Database::$conn, $request);
    if (mysqli_num_rows($results) > 0) {
        while ($row = mysqli_fetch_array($results)) {
            $credentials .= '<div class="p-2 col-12 mt-2 credential"><div class="row fancy p-4">
                <div class="col-lg-5 col-12">
                <input type="hidden" class="form-control credentialid" value="' . $row['id'] . '" >
                   <input type="hidden" class="form-control id" value="' . $id . '" >
                    <input type="hidden" class="form-control editCredential" value="' . $id . '" >
                        <div class="form-group ">
                           <input type="text" class="form-control title" value="' . $row['title'] . '" name="endd" placeholder="title">
                       </div>
                         <div class="form-group ">
                           <input type="text" class="form-control username" value="' . $row['username'] . '" name="endd" placeholder="username">
                       </div>
                         <div class="form-group ">
                           <input type="text" class="form-control pass" value="' . $row['pass'] . '" name="endd" placeholder="password">
                       </div>
                       <h4 class="outcome p-2"></h4>
                       <div class="d-grid">
                       <a href="#" class="btn btn-indigo save"><i class="fa-regular fa-save"></i> Save</a>
                       </div>
                      
             </div>
                   <div class="col-lg-6 col-12">
                    <div class=" form-group ">
                           <textarea placeholder="note" class="form-control note" name="note" id="" cols="6" rows="6">' . $row['note'] . '</textarea>
                       </div>
             </div>
                   <div class="col-lg-1 col-12">
                   <a href="#" class="btn btn-indigo moveUp"><i class="fa-solid fa-arrow-up"></i></a>
                   <a href="#" class="btn btn-indigo moveDown"><i class="fa-solid fa-arrow-down"></i></a>
<a href="#" class="btn btn-indigo delCred" data-id="' . $id . '" data-credentialid="' . $row['id'] . '"><i class="fa-solid fa-trash"></i></a>
             </div>
            </div></div>';
        }
    }


    $credentials .= '</div>   <a href="#" class="btn btn-indigo addCredential mt-2 mb-4" data-project="' . $id . '"><i class="fa-regular fa-plus"></i> Credential</a></div>
               </div>
           </div>
       </div>
';


    ?>
   <!doctype html>
   <html lang="en">

   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <title>drow pt | </title>
       <link href="bootstrap.min.css" rel="stylesheet">
       <link href="fa/css/all.min.css" rel="stylesheet" />
       <link href="style.css" rel="stylesheet">
   </head>

   <div class="fixed-top row px-4 py-2 fancy">
       <div class="col-12 col-lg-1">
           <a href="index.php" class="addProject btn  text-start"><i class="fa-solid fa-home"></i></a>
       </div>
       <div class="col-12 col-lg-5 align-self-center">
           <?php echo $pheader; ?>
       </div>
       <div class="col-12 col-lg-6 text-end">
           <a href="#" class="editProject btn  text-start btn-indigo" data-bs-toggle="modal" data-bs-target="#editproject_<?php echo $id; ?>"><i class="fa-regular fa-edit"></i></a>

           <a href="#" class="addProject btn  text-start btn-indigo" data-bs-toggle="modal" data-bs-target="#addpage"><i class="fa-regular fa-plus"></i> Page</a>
           <a href="#" class="addNote btn  text-start btn-indigo" data-bs-toggle="modal" data-bs-target="#addnote"><i class="fa-regular fa-plus"></i> Note</a>
           <a href="doc.php?id=<?php echo $id; ?>" target="_blank" class="btn  text-start btn-indigo"><i class="fa-solid fa-download"></i> Doc</a>
           <a href="changelog.php?id=<?php echo $id; ?>" target="_blank" class="btn  text-start btn-indigo"><i class="fa-solid fa-download"></i> Log</a>
           <a href="#" class=" btn  text-start btn-indigo" data-bs-toggle="modal" data-bs-target="#credentialsModal"><i class="fa-solid fa-lock"></i> Credentials</a>
           <a href="#" class=" btn  text-start btn-indigo" data-bs-toggle="modal" data-bs-target="#invoice_<?php echo $id; ?>"><i class="fa-solid fa-file-invoice"></i> Invoice</a>
       </div>
   </div>

   <div class="container-fluid py-4 ">

       <div class="row p-4 ">




           <div class="col-lg-8 col-12">
               <div class="row">
                   <?php echo $data; ?>
               </div>
           </div>
           <div class="col-lg-4 col-12">
               <div class="row pullThis py-4">
                   <?php echo $todos; ?>
               </div>
           </div>

       </div>



       <div class="modal fade newPage" id="addnote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="exampleModalLabel">Add note</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                   </div>
                   <div class="modal-body">
                       <form class="" action="project.php" method="post">
                           <input type="hidden" name="addTodo" value="true">
                           <input type="hidden" name="id" value="<?php echo $id; ?>">

                           <div class=" form-group ">
                               <textarea placeholder="note" class="form-control" name="content" id="" cols="6" rows="6"></textarea>
                           </div>
                           <div class="d-grid mt-2">
                               <button type="submit" class="btn  btn-indigo">Submit <i class="fa-solid fa-arrow-right"></i></button>
                           </div>
                       </form>
                   </div>

               </div>
           </div>
       </div>





       <?php echo $credentials; ?>


       <div class="modal fade newPage" id="addpage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="exampleModalLabel">Add page</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                   </div>
                   <div class="modal-body">
                       <form class="" action="project.php" method="post">
                           <input type="hidden" name="addPage" value="true">
                           <input type="hidden" name="id" value="<?php echo $id; ?>">
                           <div class="form-group ">
                               <input type="text" class="form-control" value="" name="title" placeholder="Title">
                           </div>
                           <div class=" form-group ">
                               <textarea placeholder="note" class="form-control" name="note" id="" cols="6" rows="6"></textarea>
                           </div>
                           <div class="form-group ">
                               <input type="text" class="form-control" value="" name="controller" placeholder="controller">
                           </div>

                           <div class="form-group ">
                               <input type="text" class="form-control" value="" name="databaseObject" placeholder="databaseObject">
                           </div>

                           <div class="form-group ">
                               <input type="text" class="form-control" value="" name="repository" placeholder="repository">
                           </div>

                           <div class="form-group ">
                               <input type="text" class="form-control" value="" name="stat" placeholder="stat">
                           </div>

                           <div class="form-group ">
                               <input type="text" class="form-control" value="" name="versi" placeholder="versi">
                           </div>

                           <div class="form-group ">
                               <input type="text" class="form-control" value="" name="admi" placeholder="admi">
                           </div>


                           <div class="form-group ">
                               <input type="text" class="form-control" value="" name="moda" placeholder="moda">
                           </div>

                           <div class="form-group ">
                               <input type="text" class="form-control" value="" name="logic" placeholder="logic">
                           </div>


                           <div class="form-group ">
                               <input type="text" class="form-control" value="" name="client" placeholder="client">
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
           $(window).scroll(function fix_element() {
               $('.pullThis').css(
                   $(window).scrollTop() > 200 ? {
                       'position': 'fixed',
                       'top': '0px',
                       'background-color': 'var(--bg)',
                       'overflow': 'scroll',
                       'height': '100vh',
                       'z-index': '1',
                   } : {
                       'position': 'relative',
                       'top': 'auto',
                       'overflow': 'scroll',
                       'background-color': 'transparent',
                       'height': '100vh'
                   }
               );
               return fix_element;
           }());

           $('textarea').each(function() {
               this.style.height = (this.scrollHeight + 10) + 'px';
           });
           $('.addCredential').click(function(e) {
               e.preventDefault();
               var projectid = $(this).attr('data-project');
               $('.credHolder').append('<div class="p-2 col-12 mt-2 credential"><div class="row fancy p-4"><div class="col-lg-5 col-12"><input type="hidden" class="form-control id" value="' + projectid +
                   '" >  <div class="form-group "><input type="text" class="form-control title"  placeholder="title"> </div> ' +
                   '<div class="form-group "><input type="text" class="form-control username"  placeholder="username"></div>' +
                   '   <div class="form-group "> <input type="text" class="form-control pass" placeholder="password"> </div>' +
                   '<h4 class="outcome p-2"></h4> <div class="d-grid"> <a href="#" class="btn btn-indigo insert"><i class="fa-regular fa-save"></i> Save</a></div>' +
                   '</div><div class="col-lg-6 col-12"><div class=" form-group ">' +
                   '<textarea placeholder="note" class="form-control note"  id="" cols="6" rows="6"></textarea></div> </div><div class="col-lg-1 col-12"></div></div></div>');

           });
           $('.credHolder').on('click', '.insert', function(e) {
               e.preventDefault();
               var ref = $(this);
               var old = $(this).html();
               var parent = $(this).closest('.credential');
               var form_data = new FormData();
               form_data.append('id', parent.find('.id').val());
               form_data.append('addCredential', 'true');
               form_data.append('note', parent.find('.note').val());
               form_data.append('title', parent.find('.title').val());
               form_data.append('username', parent.find('.username').val());
               form_data.append('pass', parent.find('.pass').val());
               ref.html('<i class="fa-regular fa-spinner fa-spin"></i>');
               $.ajax({
                   url: 'project.php',
                   type: 'POST',
                   data: form_data,
                   contentType: false,
                   cache: false,
                   processData: false,
                   success: function(data) {
                       ref.html(old);
                       parent.find('.outcome').html(data);
                   }
               });
           });
           $('.credHolder').on('click', '.save', function(e) {
               e.preventDefault();
               var ref = $(this);
               var old = $(this).html();
               var parent = $(this).closest('.credential');
               var form_data = new FormData();
               form_data.append('id', parent.find('.id').val());
               form_data.append('editCredential', 'true');
               form_data.append('note', parent.find('.note').val());
               form_data.append('credentialid', parent.find('.credentialid').val());
               form_data.append('title', parent.find('.title').val());
               form_data.append('username', parent.find('.username').val());
               form_data.append('pass', parent.find('.pass').val());
               ref.html('<i class="fa-regular fa-spinner fa-spin"></i>');
               $.ajax({
                   url: 'project.php',
                   type: 'POST',
                   data: form_data,
                   contentType: false,
                   cache: false,
                   processData: false,
                   success: function(data) {
                       ref.html(old);
                       parent.find('.outcome').html(data);
                   }
               });
           });
           $('.pullThis').on('click', '.toggleDrowExpand', function(e) {
               e.preventDefault();
               var target = $(this).attr('data-target');
               $('.' + target).toggleClass('active');
           });


           $('.credHolder').on('click', '.delCred', function(e) {
               var form_data = new FormData();
               form_data.append('id', $(this).attr('data-id'));
               form_data.append('deleteCredential', 'true');
               form_data.append('credentialid', $(this).attr('data-credentialid'));
               var ref = $(this).closest('.credential');
               $.ajax({
                   url: 'project.php',
                   type: 'POST',
                   data: form_data,
                   contentType: false,
                   cache: false,
                   processData: false,
                   success: function(data) {
                       if (data == 'ok') {
                           ref.remove();
                       }
                   }
               });

           });
       </script>

       </body>

   </html>