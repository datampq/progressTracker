<?php
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
$generatedPass = generateRandomString(12);
if (is_file('_db.php')) {
    echo 'Database already installed!';
    // header('Location:login.php');
    // exit;
} else {
}
if (!empty($_POST['install'])) {
    $dbName = $_POST['dbName'];
    $pass = $_POST['dbPass'];
    $user = $_POST['dbUser'];
    $servername = "localhost";
    $conn = new mysqli($servername, $user, $pass);
    // Check connection
    if ($conn->connect_error) {
        echo 'Connection failed 16: ' . $conn->connect_error . '';
        exit;
    }
    echo 'Connected to MySQL!';
    if (!mysqli_select_db($conn, $dbName)) {
        $sql = "CREATE DATABASE " . $dbName;
        if ($conn->query($sql) === TRUE) {
            echo 'Created Database!';
        } else {
            echo 'Database creation failed 25: ' . $conn->error . '';
            exit;
        }
    } else {
        echo 'db exists, continue...';
    }
    $dbUser =  $user;
    $dbPass =    $pass;
    $file = "_db.php";
    $conn = new mysqli($servername, $user, $pass, $dbName);
    if ($conn->connect_error) {
        die("Connection failed 61: " . $conn->connect_error);
        exit;
    }


    $sql = "CREATE TABLE admin (
    id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user VARCHAR(255),
    pass VARCHAR(255),
    email VARCHAR(64),
    phone VARCHAR(64),
    lastLogin VARCHAR(64),
    dateUpdated VARCHAR(64),
    name VARCHAR(64)
  ) ";
    if ($conn->query($sql) === TRUE) {
        echo 'Admin table created!';
    } else {
        echo 'Error occured when creating table 80: ' . $conn->error . '';
        exit;
    }
    $sql = "CREATE TABLE task (
    id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    dateEdited VARCHAR(32),
    title VARCHAR(255),
    description TEXT,
    author VARCHAR(255),
    hoursW VARCHAR(255),
     validated VARCHAR(255),
      prioritytask VARCHAR(255),
      stat VARCHAR(255),
        projectId VARCHAR(255),
        note TEXT
  ) ";

    if ($conn->query($sql) === TRUE) {
        echo 'project created!';
    } else {
        echo 'Error occured when creating table 82: ' . $conn->error . '';
        exit;
    }

    $sql = "CREATE TABLE project (
    id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    dateEdited VARCHAR(32),
    title VARCHAR(255),
    description TEXT,
    author VARCHAR(255),
    hoursW VARCHAR(255),
     startd VARCHAR(255),
      endd VARCHAR(255)
  ) ";

    if ($conn->query($sql) === TRUE) {
        echo 'project created!';
    } else {
        echo 'Error occured when creating table 82: ' . $conn->error . '';
        exit;
    }


    $sql =
        "CREATE TABLE page (
    id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    dateEdited VARCHAR(32),
    title VARCHAR(255),
    description TEXT,
    note TEXT,
    author VARCHAR(255),
    projectId VARCHAR(255),
    controller VARCHAR(255),
    databaseObject VARCHAR(255),
    repository VARCHAR(255),
    stat VARCHAR(255),
    versi VARCHAR(255),
admi VARCHAR(255),
moda VARCHAR(255),
logic VARCHAR(255),
client VARCHAR(255)
  ) ";

    if ($conn->query($sql) === TRUE) {
        echo 'page created!';
    } else {
        echo 'Error occured when creating table 108: ' . $conn->error . '';
        exit;
    }


    $sql = "CREATE TABLE todos (
    id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    dateEdited VARCHAR(32),
     	content TEXT,
    projectid VARCHAR(255)
  ) ";

    if ($conn->query($sql) === TRUE) {
        echo 'todos created!';
    } else {
        echo 'Error occured when creating table 82: ' . $conn->error . '';
        exit;
    }

    $sql = "CREATE TABLE credentials (
    id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    dateEdited VARCHAR(32),
     	note TEXT,
    projectid VARCHAR(255),
     title VARCHAR(255),
    username VARCHAR(255),
    pass VARCHAR(255)
  ) ";

    if ($conn->query($sql) === TRUE) {
        echo 'credentials created!';
    } else {
        echo 'Error occured when creating table credentials 140: ' . $conn->error . '';
        exit;
    }

    $sql = "CREATE TABLE changet (
    id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    dateEdited VARCHAR(32),
    note TEXT,
    author VARCHAR(255),
    pageId VARCHAR(255),
    projectId VARCHAR(255),
      startd VARCHAR(255),
      endd VARCHAR(255)

  ) ";

    if ($conn->query($sql) === TRUE) {
        echo 'project created!';
    } else {
        echo 'Error occured when creating table 82: ' . $conn->error . '';
        exit;
    }




    $admin = $_POST['admin'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $name = $_POST['name'];
    //  user VARCHAR(255),
    //  pass VARCHAR(255),
    //  email VARCHAR(64),
    //  phone VARCHAR(64),
    //  lastLogin VARCHAR(64),
    //  dateUpdated VARCHAR(64),
    //  name VARCHAR(64)
    $passh = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO admin (user, pass, email, phone, lastLogin, dateUpdated, name) VALUES ('" . $admin . "', '" . $passh . "', '" . $email . "', '" . $phone . "', '', '', '" . $name . "')";
    if ($conn->query($sql) === TRUE) {
        echo 'Admin acc created';
        $FileHandle = fopen($file, 'w');
        fwrite($FileHandle, "");
        fclose($FileHandle);
        $FileHandle = fopen($file, 'w');
        $written = '<?php
    Header("Cache-Control: no-cache, no-store, must-revalidate");
    class Database
    {
      private static $init = FALSE;
      public static $conn;
      public static function initialize()
      {
        if (self::$init === TRUE)
        return;
        self::$init = TRUE;
        self::$conn = new mysqli("localhost", "' . $user . '", "' . $dbPass . '", "' . $dbName . '");
      }
    }
    Database::initialize();
    ?>';
        $fwrite =  fwrite($FileHandle, $written);
        fclose($FileHandle);

        if ($fwrite === FALSE) {
            echo 'Writing database config failed: check file permissions 53';
            exit;
        } else {
            echo 'Database: ' . $user . ';' . $pass . '';
        }
    } else {
        echo 'Error occured when creating table 266: ' . $conn->error . '';
        exit;
    }
    header('Location:login.php?msg=User:' . $admin . ', pass:' . $pass);
    exit;
}


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>drow progress tracker</title>
    <link href="bootstrap.min.css" rel="stylesheet">

    <link href="style.css" rel="stylesheet">
</head>
<div class="container mt-4 p-4 fancy">
    <div class="row">
        <div class="col-md-12">
            <h1>drow progress tracker</h1>
            <p>
                This is a simple progress tracker for drow.
            </p>
        </div>

    </div>

</div>
<div class="container top-50">
    <div class="row">
        <div class="col-3">
        </div>
        <div class="col-6 text-center pad-25 shadow top-50 wow animate__backInDown">
            <form class="" action="install.php" method="post">
                <input type="hidden" name="install" value="true">
                <h5 class="text-primary">Existing data</h5>
                <div class="form-group">
                    <label for="">database user</label>
                    <input type="text" name="dbUser" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">database pass</label>
                    <input type="text" name="dbPass" class="form-control" required>
                </div>
                <h5 class="text-primary">New data</h5>
                <div class="form-group">
                    <label for="">database name</label>
                    <input type="text" name="dbName" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">admin user</label>
                    <input type="text" name="admin" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">admin pass</label>
                    <input type="text" name="pass" class="form-control" value="<?php echo $generatedPass; ?>" required>
                </div>
                <div class="form-group">
                    <label for="">admin mail</label>
                    <input type="text" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">admin phone</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">admin name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="button">Install</button>
            </form>
        </div>
    </div>
</div>



<script src="bootstrap.bundle.min.js"></script>
<script src="jquery-3.6.0.min.js"></script>

<script>
</script>

</body>

</html>