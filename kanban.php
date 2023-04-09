   <?php
    include '_main.php';

    $title = 'Kanban';
    $description = 'Kanban';
    if (!empty($_GET['id'])) {
        $id =  Database::$conn->real_escape_string($_GET['id']);
    } else {
        if (!empty($_POST['id'])) {
            $id =  Database::$conn->real_escape_string($_POST['id']);
        } else {
            header('Location:index.php');
            exit;
        }
    }

    if (!empty($_POST['editTask'])) {
        $taskId =  Database::$conn->real_escape_string($_POST['taskid']);
        $title =  Database::$conn->real_escape_string($_POST['title']);
        $description =  Database::$conn->real_escape_string($_POST['description']);
        $author =  Database::$conn->real_escape_string($_POST['author']);
        $dateEdited =  $dateTimeCurrentCHHeure;
        $request = "UPDATE task SET title = '" . $title . "', description = '" . $description . "', author = '" . $author . "', dateEdited = '" . $dateEdited . "' WHERE id = '" . $taskId . "'";
        if (mysqli_query(Database::$conn, $request)) {
            echo 'ok';
        } else {
            echo "ERROR: Could not able to execute $request. " . mysqli_error(Database::$conn);
        }
        exit;
    }


    if (!empty($_POST['removeTask'])) {
        $taskId =  Database::$conn->real_escape_string($_POST['taskid']);

        $request = "DELETE FROM task WHERE id = '" . $taskId . "'";
        if (mysqli_query(Database::$conn, $request)) {
            echo 'ok';
        } else {
            echo "ERROR: Could not able to execute $request. " . mysqli_error(Database::$conn);
        }
        exit;
    }
    if (!empty($_POST['setStatus'])) {
        $taskId =  Database::$conn->real_escape_string($_POST['taskid']);
        $stat =  Database::$conn->real_escape_string($_POST['stat']);
        $dateEdited =  $dateTimeCurrentCHHeure;
        $request = "UPDATE task SET stat = '" . $stat . "', dateEdited = '" . $dateEdited . "' WHERE id = '" . $taskId . "'";
        if (mysqli_query(Database::$conn, $request)) {
            echo 'ok';
        } else {
            echo "ERROR: Could not able to execute $request. " . mysqli_error(Database::$conn);
        }
        exit;
    }

    $modals  = '';
    if (!empty($_POST['setHours'])) {
        $taskId =  Database::$conn->real_escape_string($_POST['taskId']);
        $hoursW =  Database::$conn->real_escape_string($_POST['hoursW']);
        $dateEdited =  $dateTimeCurrentCHHeure;
        $request = "UPDATE task SET hoursW = '" . $hoursW . "', dateEdited = '" . $dateEdited . "' WHERE id = '" . $taskId . "'";
        if (mysqli_query(Database::$conn, $request)) {
            echo 'ok';
        } else {
            echo "ERROR: Could not able to execute $request. " . mysqli_error(Database::$conn);
        }
        exit;
    }
    if (!empty($_POST['setPriority'])) {
        $taskId =  Database::$conn->real_escape_string($_POST['taskid']);
        $validated =  Database::$conn->real_escape_string($_POST['prioritytask']);
        $request = "UPDATE task SET prioritytask = '" . $validated . "' WHERE id = '" . $taskId . "'";
        if (mysqli_query(Database::$conn, $request)) {
            echo 'ok';
        } else {
            echo "ERROR: Could not able to execute $request. " . mysqli_error(Database::$conn);
        }
        exit;
    }

    if (!empty($_POST['setValidate'])) {
        $taskId =  Database::$conn->real_escape_string($_POST['taskid']);
        $validated =  Database::$conn->real_escape_string($_POST['validated']);
        $dateEdited =  $dateTimeCurrentCHHeure;
        $request = "UPDATE task SET validated = '" . $validated . "', dateEdited = '" . $dateEdited . "'  WHERE id = '" . $taskId . "'";
        if (mysqli_query(Database::$conn, $request)) {
            echo 'ok';
        } else {
            echo "ERROR: Could not able to execute $request. " . mysqli_error(Database::$conn);
        }
        exit;
    }
    if (!empty($_POST['setNote'])) {
        $taskid =  Database::$conn->real_escape_string($_POST['taskid']);
        $note =  Database::$conn->real_escape_string($_POST['comment']);
        $request = "UPDATE task SET note = '" . $note . "' WHERE id = '" . $taskid . "'";
        if (mysqli_query(Database::$conn, $request)) {
            echo 'ok';
        } else {
            echo "ERROR: Could not able to execute $request. " . mysqli_error(Database::$conn);
        }
    }
    if (!empty($_POST['insert'])) {
        $projkectId =  Database::$conn->real_escape_string($_POST['id']);
        $title =  Database::$conn->real_escape_string($_POST['title']);
        $description =  Database::$conn->real_escape_string($_POST['description']);
        $author =  Database::$conn->real_escape_string($_POST['author']);
        $hoursW =  Database::$conn->real_escape_string($_POST['hoursW']);
        //current date :
        $dateEdited =  $dateTimeCurrentCHHeure;
        $stat =  'pending';
        $prioritytask =  Database::$conn->real_escape_string($_POST['prioritytask']);
        $validated =  Database::$conn->real_escape_string($_POST['validated']);
        $note =  Database::$conn->real_escape_string($_POST['note']);
        $request = "INSERT INTO task (projectId, title, description, author, hoursW, dateEdited, stat, prioritytask, validated, note) VALUES ('" . $projkectId . "', '" . $title . "', '" . $description . "', '" . $author . "', '" . $hoursW . "', '" . $dateEdited . "', '" . $stat . "', '" . $prioritytask . "', '" . $validated . "', '" . $note . "')";
        if (mysqli_query(Database::$conn, $request)) {
            header('Location:kanban.php?id=' . $projkectId);
            exit;
        } else {
            echo "ERROR: Could not able to execute $request. " . mysqli_error(Database::$conn);
        }
    }


    //get project :
    $request = "SELECT * FROM project WHERE id = '" . $id . "'";
    $results = mysqli_query(Database::$conn, $request);
    if (mysqli_num_rows($results) > 0) {
        while ($row = mysqli_fetch_array($results)) {
            $title = $row['title'];
            $dateEdited = $row['dateEdited'];
            $description = $row['description'];
            $author = $row['author'];
        }
    } else {
        header('Location:index.php');
        exit;
    }


    //get tasks:
    $request = "SELECT * FROM task WHERE projectId = '" . $id . "'";
    $results = mysqli_query(Database::$conn, $request);
    $pending = '';
    $inProgress = '';
    $done = '';

    if (mysqli_num_rows($results) > 0) {
        $info = mysqli_num_rows($results) . ' tasks found';
        while ($row = mysqli_fetch_array($results)) {
            $flag = '';
            if ($row['prioritytask'] == 'true') {
                $flag = '<a class="btn setPriority true"><i class="fa-regular fa-flag pi text-primary"></i></a>';
            } else {
                $flag = '<a class="btn setPriority "><i class="fa-regular fa-flag pi"></i></a>';
            }
            $validated = '';
            if ($row['validated'] == 'true') {
                $validated = '<a class="btn setValidate true"><i class="fa-regular vi fa-check-circle "></i></a>';
            } else {
                $validated = '<a class="btn setValidate "><i class="fa-regular vi fa-times-circle"></i></a>';
            }
            $attrs = 'data-id="' . $row['id'] . '" data-project="' . $id . '" data-hours="' . $row['hoursW'] . '" draggable="true" ondragstart="dragstart(event)" id="' . $row['id'] . '"';
            $style = 'bg-pending';
            if ($row['stat'] == 'inProgress') {
                $style = 'bg-progress';
            } else if ($row['stat'] == 'done') {
                $style = 'bg-done';
            }
            $item = '<div class="task py-1 px-4 ' . $style . '" ' . $attrs . '>
 <div class="row ">
  <div class="col timer">
   ' . $row['hoursW'] . '
  </div>
    <div class="col status-indicator text-end">
    ' . $flag . ' ' . $validated . '
    </div>
</div>
                <h3 class=" mt-2 ttitle">' . $row['title'] . '</h3>
                <small><i class="fa-regular fa-calendar-day"></i> ' . $row['dateEdited'] . ' by ' . $row['author'] . '</small>
                       <p class="ttext">' . $row['description'] . '</p>
            <div class="row  border-top">
            <div class="col d-grid p-2"><a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#edit_' . $row['id'] .
                '"><i class="fa-regular fa-edit"></i></a></div>
            <div class="col d-grid p-2"><a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#comment_' . $row['id'] .
                '"><i class="fa-regular fa-comment"></i></a></div>
<div class="col d-grid p-2"><a href="#" class="btn timera" ><i class="fa-solid fa-stopwatch"></i></a></div>
<div class="col d-grid p-2"><a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#remove_' . $row['id'] . '"><i class="fa-solid fa-trash"></i></a></div>
            </div>
            </div>';


            if ($row['stat'] == 'pending') {
                $pending .= $item;
            } else if ($row['stat'] == 'inProgress') {
                $inProgress .= $item;
            } else if ($row['stat'] == 'done') {
                $done .= $item;
            }
            $modals .= '            
               <div class="modal fade" id="edit_' . $row['id'] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel">Edit task</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body editTask">
                   <form>
                       <input type="hidden" name="id" value="' . $row['projectId'] . '">
  <input type="hidden" name="idedit" value="' . $row['id'] . '">
               
                       <div class="form-group ">
                           <input type="text" class="form-control" name="title" value="' . $row['title'] . '" placeholder="Title">
                       </div>
                       <div class=" form-group ">
                           <textarea placeholder="description" class="form-control" name="description" id="" cols="4" rows="4">' . $row['description'] . '</textarea>
                       </div>
                       <div class="form-group ">
                           <input type="text" class="form-control" name="author" placeholder="author" value="' . $row['author'] . '">
                       </div>
            
                       <div class="d-grid mt-2">
                           <button type="submit" class="btn  btn-indigo">Save <i class="fa-regular fa-save"></i></button>
                       </div>
                   </form>

               </div>

           </div>
       </div>
   </div>
            


               <div class="modal fade" id="comment_' . $row['id'] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-xl">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel">Note task</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body comment">
                   <form>
                       <input type="hidden" name="id" value="' . $row['projectId'] . '">
  <input type="hidden" name="taskid" value="' . $row['id'] . '">
                    
                     <div class=" form-group ">
                           <textarea placeholder="Note" class="form-control sc" name="comment" id="" cols="8" rows="8">' . $row['note'] . '</textarea>
                       </div>
                       <div class="d-grid mt-2">
                           <button type="submit" class="btn  btn-indigo">Save <i class="fa-regular fa-save"></i></button>
                       </div>
                   </form>

               </div>

           </div>
       </div>
   </div>
            



               <div class="modal fade" id="remove_' . $row['id'] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel">Note task</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body removeTask">
                   <form class="" >
                <input type="hidden" value="' . $row['id'] . '" name="taskid" class="taskid">
                       <div class="d-grid mt-2">
                           <button type="submit" class="btn  btn-indigo">Remove <i class="fa-solid fa-trash"></i></button>
                       </div>
                   </form>

               </div>

           </div>
       </div>
   </div>';
        }
    } else {
        $info = 'No tasks yet';
    }

    ?>
   <!doctype html>
   <html lang="en">

   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <title>drow progress tracker | kanban</title>
       <link href="bootstrap.min.css" rel="stylesheet">
       <link href="fa/css/all.min.css" rel="stylesheet" />
       <link href="style.css" rel="stylesheet">

       <style>
           .active {
               background-color: #000;
               border: 2px solid var(--hover);

           }

           .task {
               box-shadow: 0px 4px 16px rgba(0, 0, 0, .3);
               margin-top: 20px;
               /* linear gradient: */

               background-color: rgba(14, 19, 22, 0.938);
           }

           .bg-pending {
               border: 1px solid var(--hover);
           }

           .bg-progress {
               border: 1px solid var(--hover);
           }

           .bg-done {
               border: 1px solid transparent;
           }

           .border-left {
               border-left: 1px solid var(--hover);

           }

           .border-right {
               border-right: 1px solid var(--hover);

           }

           .tasks {
               min-height: 90vh;
               max-height: 90vh;
               overflow: scroll;
           }

           .sc {
               font-size: medium;
           }
       </style>
   </head>
   <div class="container-fluid  ">
       <div class="row fancy p-4">
           <div class="col-1 align-self-center">
               <div class="d-grid">
                   <a href="index.php" class="btn "><i class="fa-solid fa-home"></i> </a>
               </div>

           </div>



           <div class="col-9 text-center">

               <h1><?php echo $title; ?> | <?php echo $info; ?> | <?php echo $dateEdited; ?></h1>
               <small>
                   <?php echo $description; ?>
               </small>

           </div>

           <div class="col-1 align-self-center">
               <div class="d-grid">
                   <a href="#" class="addProject btn btn-indigo" data-bs-toggle="modal" data-bs-target="#addTask"><i class="fa-regular fa-plus"></i></a>
               </div>

           </div>

           <div class="col-1 align-self-center">
               <div class="d-grid">
                   <a href="printban.php?id=<?php echo $id; ?>" class="btn" target="_blank"><i class="fa-solid fa-download"></i> </a>
               </div>

           </div>

       </div>
       <div class="row ">


           <div class="col-4 tasks border-right" ondrop="drop(event)" ondragover="dragover(event)" id="pending">
               <h2>Pending</h2>
               <?php echo $pending; ?>
           </div>
           <div class="col-4 tasks bg-transparent" ondrop="drop(event)" ondragover="dragover(event)" id="inProgress">
               <h2>In progress</h2>
               <?php echo $inProgress; ?>
           </div>
           <div class="col-4 tasks border-left" ondrop="drop(event)" ondragover="dragover(event)" id="done">
               <h2>Done</h2>
               <?php echo $done; ?>
           </div>
       </div>

       <?php echo $modals; ?>


   </div>

   </div>

   <div class="modal fade" id="addTask" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel">Add task</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <form class="" action="kanban.php" method="post">
                       <input type="hidden" name="id" value="<?php echo $id; ?>">

                       <input type="hidden" name="insert" value="true">

                       <div class="form-group ">
                           <input type="text" class="form-control" name="title" placeholder="Title">
                       </div>
                       <div class=" form-group ">
                           <textarea placeholder="description" class="form-control" name="description" id="" cols="4" rows="4"></textarea>
                       </div>
                       <div class="form-group ">
                           <input type="text" class="form-control" name="author" placeholder="author" value="<?php echo $author; ?>">
                       </div>

                       <div class="form-group ">
                           <input type="text" class="form-control" name="hoursW" placeholder="hoursW" value="0">
                       </div>

                       <div class="form-group ">
                           <input type="text" class="form-control" name="validated" placeholder="false" value="false">
                       </div>

                       <div class="form-group ">
                           <input type="text" class="form-control" name="prioritytask" placeholder="false" value="false">
                       </div>
                       <div class=" form-group ">
                           <textarea placeholder="Note" class="form-control" name="note" id="" cols="4" rows="4"></textarea>
                       </div>

                       <div class="d-grid mt-2">
                           <button type="submit" class="btn  btn-indigo">Save <i class="fa-regular fa-save"></i></button>
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
   <script>
       let timers = [];
       var timer = null;
       $('.removeTask').on('click', '.btn-indigo', function(e) {
           e.preventDefault();
           var id = $(this).closest('form').find('input[name="taskid"]').val();
           var form_data = new FormData();
           form_data.append('removeTask', 'true');
           form_data.append('taskid', id);
           form_data.append('id', <?php echo $id; ?>);

           $.ajax({
               url: 'kanban.php',
               type: 'POST',
               data: form_data,
               contentType: false,
               cache: false,
               processData: false,
               success: function(data) {
                   $('.tasks').find('.task[data-id="' + id + '"]').remove();
               }
           });

       });
       $('.editTask').on('click', '.btn-indigo', function(e) {
           e.preventDefault();
           var id = $(this).closest('form').find('input[name="idedit"]').val();
           var title = $(this).closest('form').find('input[name="title"]').val();
           var description = $(this).closest('form').find('textarea[name="description"]').val();
           var author = $(this).closest('form').find('input[name="author"]').val();

           var form_data = new FormData();
           form_data.append('editTask', 'true');
           form_data.append('taskid', id);
           form_data.append('id', <?php echo $id; ?>);
           form_data.append('title', title);
           form_data.append('description', description);
           form_data.append('author', author);

           $.ajax({
               url: 'kanban.php',
               type: 'POST',
               data: form_data,
               contentType: false,
               cache: false,
               processData: false,
               success: function(data) {
                   $('.tasks').find('.task[data-id="' + id + '"]').find('.ttitle').text(title);
                   $('.tasks').find('.task[data-id="' + id + '"]').find('.ttext').text(description);

               }
           });

       });


       $('.comment').on('click', '.btn-indigo', function(e) {
           e.preventDefault();
           var id = $(this).closest('form').find('input[name="taskid"]').val();
           var comment = $(this).closest('form').find('textarea[name="comment"]').val();
           var form_data = new FormData();
           form_data.append('setNote', 'true');
           form_data.append('taskid', id);
           form_data.append('comment', comment);
           form_data.append('id', <?php echo $id; ?>);

           $.ajax({
               url: 'kanban.php',
               type: 'POST',
               data: form_data,
               contentType: false,
               cache: false,
               processData: false,
               success: function(data) {

               }
           });

       });
       $('.tasks').on('click', '.setPriority', function(e) {
           e.preventDefault();
           var task = $(this).closest('.task');
           var id = task.attr('data-id');
           if (task.hasClass('true')) {
               task.removeClass('true');
               task.find('.pi').removeClass('text-primary')
               var form_data = new FormData();
               form_data.append('setPriority', 'true');
               form_data.append('taskid', id);
               form_data.append('id', <?php echo $id; ?>);
               form_data.append('prioritytask', 'false');
               $.ajax({
                   url: 'kanban.php',
                   type: 'POST',
                   data: form_data,
                   contentType: false,
                   cache: false,
                   processData: false,
                   success: function(data) {}
               });
           } else {
               task.addClass('true');
               task.find('.pi').addClass('text-primary')
               var form_data = new FormData();
               form_data.append('setPriority', 'true');
               form_data.append('taskid', id);
               form_data.append('id', <?php echo $id; ?>);
               form_data.append('prioritytask', 'true');
               $.ajax({
                   url: 'kanban.php',
                   type: 'POST',
                   data: form_data,
                   contentType: false,
                   cache: false,
                   processData: false,
                   success: function(data) {}
               });
           }
       });
       $('.tasks').on('click', '.setValidate', function(e) {
           e.preventDefault();
           var task = $(this).closest('.task');
           var id = task.attr('data-id');
           if (task.hasClass('true')) {
               task.removeClass('true');
               task.find('.vi').removeClass('fa-check-circle').addClass('fa-times-circle');
               var form_data = new FormData();
               form_data.append('setValidate', 'true');
               form_data.append('taskid', id);
               form_data.append('id', <?php echo $id; ?>);
               form_data.append('validated', 'false');
               $.ajax({
                   url: 'kanban.php',
                   type: 'POST',
                   data: form_data,
                   contentType: false,
                   cache: false,
                   processData: false,
                   success: function(data) {}
               });
           } else {
               task.addClass('true');
               task.find('.vi').removeClass('fa-times-circle').addClass('fa-check-circle');
               var form_data = new FormData();
               form_data.append('setValidate', 'true');
               form_data.append('taskid', id);
               form_data.append('id', <?php echo $id; ?>);
               form_data.append('validated', 'true');
               $.ajax({
                   url: 'kanban.php',
                   type: 'POST',
                   data: form_data,
                   contentType: false,
                   cache: false,
                   processData: false,
                   success: function(data) {}
               });
           }
       });
       $('.tasks').on('click', '.timera', function(e) {
           e.preventDefault();
           var task = $(this).closest('.task');
           var id = task.attr('data-id');
           var hours = task.attr('data-hours');
           //hours int reprsenting menutes elapsed

           if (task.hasClass('active')) {
               task.removeClass('active');
               $(this).html('<i class="fa-solid fa-stopwatch"></i>');
               //get elapsed time:
               var elapsed = timers[id];
               //get total minutes elapsed:
               var total = elapsed;
               //to minutes:
               total = total / 1000 / 60;
               alert(Math.floor(total));
               task.attr('data-hours', total);
               clearInterval(timer);
               timer = null;
               timers[id] = 0;

               var form_data = new FormData();
               form_data.append('setHours', 'true');
               form_data.append('taskId', id);
               form_data.append('id', <?php echo $id; ?>);
               form_data.append('hoursW', total);
               $.ajax({
                   url: 'kanban.php',
                   type: 'POST',
                   data: form_data,
                   contentType: false,
                   cache: false,
                   processData: false,
                   success: function(data) {
                       console.log(data);

                   }
               });



           } else {
               task.addClass('active');
               $(this).html('<i class="fa-regular fa-pause"></i>');
               //start timer
               var start = new Date().getTime();
               //set start time from hours
               start = start - (hours * 1000 * 60);
               timer = setInterval(function() {
                   var now = new Date().getTime();
                   var elapsed = now - start;
                   timers[id] = elapsed;
                   var s = elapsed / 1000;
                   var m = s / 60;
                   var h = m / 60;
                   var d = h / 24;
                   var total = Math.floor(d) + 'd ' + Math.floor(h) + 'h ' + Math.floor(m) + 'm ' + Math.floor(s) + 's';
                   $(task).find('.timer').html(total);
               }, 1000);
           }
       });

       function updateStatus(id, status) {
           var form_data = new FormData();
           form_data.append('setStatus', 'true');
           form_data.append('taskid', id);
           form_data.append('id', <?php echo $id; ?>);
           form_data.append('stat', status);
           $.ajax({
               url: 'kanban.php',
               type: 'POST',
               data: form_data,
               contentType: false,
               cache: false,
               processData: false,
               success: function(data) {

               }
           });
       }


       function dragover(evt) {
           evt.preventDefault();
           evt.dataTransfer.dropEffect = "move";
       }

       function dragLeave(evt) {} // available if required
       function dragEnd(evt) {} // available if required

       function dragstart(evt) {
           evt.dataTransfer.setData("text/plain", evt.target.id);
           evt.dataTransfer.effectAllowed = "move";
       }

       function drop(evt) {
           evt.preventDefault();
           var data = evt.dataTransfer.getData("text");
           evt.target.closest('.tasks').appendChild(document.getElementById(data));
           var task = document.getElementById(data);

           var id = task.getAttribute('data-id');

           var status = evt.target.closest('.tasks').getAttribute('id');

           if (status == 'pending') {
               //remove bg-* classes
               task.classList.remove('bg-pending');
               task.classList.remove('bg-progress');
               task.classList.remove('bg-done');

               //add bg-pending
               task.classList.add('bg-pending');
           } else if (status == 'inProgress') {
               //remove bg-* classes
               task.classList.remove('bg-pending');
               task.classList.remove('bg-progress');
               task.classList.remove('bg-done');

               //add bg-pending
               task.classList.add('bg-progress');

           } else if (status == 'done') {
               //remove bg-* classes
               task.classList.remove('bg-pending');
               task.classList.remove('bg-progress');
               task.classList.remove('bg-done');

               //add bg-pending
               task.classList.add('bg-done');
           }

           updateStatus(id, status);


       }
   </script>

   </html>