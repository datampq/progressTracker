<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
if (!is_file('_db.php')) {
    header('Location:install.php');
    exit;
} else {
    include '_db.php';
}
date_default_timezone_set('Europe/Berlin');
$dateTimeCurrentCHHeure = date("d-m-Y H:i");
function generateRandomString($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@-_';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function getChanges($pageid, $id)
{
    $data = '';
    $request = "SELECT * FROM changet WHERE pageId = '$pageid'";
    $results = mysqli_query(Database::$conn, $request);
    if (mysqli_num_rows($results) > 0) {
        while ($row = mysqli_fetch_array($results)) {
            $data .= '<div class="row mt-2 p-2">
    
                                   
                                    <div class="col-12 col-lg-2">
                                        <h6 >' . $row['dateEdited'] . '</h6>
                                    </div>
                                     <div class="col-12 col-lg-8">
                                        <h4 class="card-title">' . $row['note'] . '</h4>
                                    </div>
                                    <div class="col-12 col-lg-1 ">
                                         <a class="btn" data-bs-toggle="modal" data-bs-target="#edit_Change' . $row['id'] . '"><i class="fa-regular fa-edit"></i></a>
                                    </div>
                                    <div class="col-12 col-lg-1 ">
                                        <a class="btn" data-bs-toggle="modal" data-bs-target="#delete_Change' . $row['id'] . '"><i class="fa-solid fa-trash"></i></a>
                                    </div>
                               
                </div>
                
                
                
                                             <div class="modal fade editcga" id="edit_Change' . $row['id'] . '" tabindex="-1" aria-labelledby="ep" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="ep">edit <strong>change</strong> </h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
  <form class="" action="project.php" method="post">
                       <input type="hidden" name="editChange" value="true">
                                 <input type="hidden" name="id" value="' . $id . '">
                          <input type="hidden" name="idchange" value="' . $row['id'] . '">
               <div class="form-group ">
                           <input type="text" class="form-control" value="' . $row['startd'] . '" name="startd" placeholder="startd">
                       </div>
                          <div class="form-group ">
                           <input type="text" class="form-control" value="' . $row['endd'] . '" name="endd" placeholder="endd">
                       </div>
                       <div class=" form-group ">
                           <textarea placeholder="note" class="form-control" name="note" id="" cols="6" rows="6">' . $row['note'] . '</textarea>
                       </div>
                                       <div class="d-grid mt-2">
               <button type="submit" class="btn  btn-indigo">Submit <i class="fa-solid fa-arrow-right"></i></button>
              </div>
                   </form>
               </div>

           </div>
       </div>
   </div> 
             
                
                
                
                
                
                             <div class="modal fade deleteChange" id="delete_Change' . $row['id'] . '" tabindex="-1" aria-labelledby="ep" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="ep">delete <strong>this</strong> </h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
  <form class="" action="project.php" method="post">
                       <input type="hidden" name="deleteChange" value="true">
                                 <input type="hidden" name="id" value="' . $id . '">
                          <input type="hidden" name="idchange" value="' . $row['id'] . '">
            
                                    <div class="d-grid mt-2">
               <button type="submit" class="btn  btn-indigo">Submit <i class="fa-solid fa-arrow-right"></i></button>
              </div>
                   </form>
               </div>

           </div>
       </div>
   </div> 
                
                
                
                
                ';
        }
    }
    return $data;
}

function updateProjectDate($id)
{
    $dateEdited = date('Y-m-d H:i:s');
    $sql = "UPDATE project SET dateEdited = '$dateEdited' WHERE id = '$id'";
    if (Database::$conn->query($sql) === TRUE) {
    } else {
        echo "Error updating record: " . Database::$conn->error;
    }
}

function gatherProjects()
{
    $data = '';
    $request = "SELECT * FROM project";
    $results = mysqli_query(Database::$conn, $request);
    if (mysqli_num_rows($results) > 0) {
        while ($row = mysqli_fetch_array($results)) {
            $data .= '<div class="col-12 mt-2 p-2"><div class="row fancy p-2">
            <div class="col-12 col-lg-6">
            <div class="d-grid"><a href="project.php?id=' . $row['id'] . '" class="btn  text-start"><strong>' . $row['title'] . '</strong> 
            </a>
             last edited: ' . $row['dateEdited'] . ' by ' . $row['author'] . ' total hours: ' . $row['hoursW'] . '</div>
          </div> <div class="col-12 col-lg-6 text-end">
            <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#edit_' . $row['id'] . '"><i class="fa-regular fa-edit"></i> Edit</a>
                <a  target="_blank" href="invoice.php?id=' . $row['id'] . '" class="btn"><i class="fa-solid fa-file-invoice"></i> Invoice</a>
                    <a  target="_blank" href="kanban.php?id=' . $row['id'] . '" class="btn"><i class="fa-solid fa-list-check"></i> Kanban</a>
            <a  target="_blank" href="doc.php?id=' . $row['id'] . '" class="btn"><i class="fa-solid fa-download"></i> Doc</a>
            <a  target="_blank" href="changelog.php?id=' . $row['id'] . '" class="btn"><i class="fa-solid fa-download"></i> Log</a>
               <a  target="_blank" href="notes.php?id=' . $row['id'] . '" class="btn"><i class="fa-solid fa-download"></i> Notes</a>
                      <a  target="_blank" href="credentials.php?id=' . $row['id'] . '" class="btn"><i class="fa-solid fa-download"></i> Credentials</a>
                    
            <a href="#"  data-bs-toggle="modal" data-bs-target="#delete_' . $row['id'] . '" class="btn"><i class="fa-solid fa-trash"></i></a>
             
            </div>
             </div>
               </div>
               <div class="modal fade " id="delete_' . $row['id'] . '" tabindex="-1" aria-labelledby="ep" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="ep">delete <strong>' . $row['title'] . '</strong> </h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
   <form class="" action="index.php" method="post">
                       <input type="hidden" name="deleteProject" value="true">
                          <input type="hidden" name="idchange" value="' . $row['id'] . '">
            
                    <div class="d-grid mt-2">
               <button type="submit" class="btn  btn-indigo">Delete <i class="fa-solid fa-trash"></i></button>
              </div>
                   </form>
               </div>

           </div>
       </div>
   </div>
             <div class="modal fade " id="edit_' . $row['id'] . '" tabindex="-1" aria-labelledby="ep" aria-hidden="true">
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
               <button type="submit" class="btn  btn-indigo">Save <i class="fa-regular fa-save"></i></button>
              </div>
                   </form>
               </div>

           </div>
       </div>
   </div>
            
            ';
        }
    }
    return $data;
}
