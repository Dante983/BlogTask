<?php
$username = "";
$email    = "";
$errors = array();

// REGISTER USER
if (isset($_POST['reg_user'])) {
    $username = esc($_POST['username']);
    $email = esc($_POST['email']);
    $password_1 = esc($_POST['password_1']);
    $password_2 = esc($_POST['password_2']);

    // form validation
    if (empty($username)) {  array_push($errors, "Gib your username"); }
    if (empty($email)) { array_push($errors, "Email is missing"); }
    if (empty($password_1)) { array_push($errors, "Forgot the password"); }
    if ($password_1 != $password_2) { array_push($errors, "The two passwords do not match");}

    // provjera da nema dupli.
    $user_check_query = "SELECT * FROM users WHERE username='$username' 
								OR email='$email' LIMIT 1";

    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }
        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    if (count($errors) == 0) {
        $password = md5($password_1);//encrypt the password before saving in db

        $query = "INSERT INTO users (username, email, password, created_at, updated_at) 
					  VALUES('$username', '$email', '$password', now(), now())";
        mysqli_query($conn, $query);

        // get id of created user
        $reg_user_id = mysqli_insert_id($conn);
        $_SESSION['user'] = getUserById($reg_user_id);


        // nedje odje lezi probleeeeeem
        // if user is admin, redirect to admin area
        if ( in_array($_SESSION['user']['role'], ["admin", "Admin"])) {
            $_SESSION['message'] = "You are now logged in";
            // redirect to admin area
            header('location: ' . BASE_URL . 'admin/dashboard.php');
            exit(0);
        } else {
            $_SESSION['message'] = "You are now logged in";
            // redirect to public area
            header('location: index.php');
            exit(0);
        }
    }
}

// LOG USER IN
if (isset($_POST['login_btn'])) {
    $username = esc($_POST['username']);
    $password = esc($_POST['password']);

    if (empty($username)) { array_push($errors, "Username required"); }
    if (empty($password)) { array_push($errors, "Password required"); }
    if (empty($errors)) {
        $password = md5($password); // encrypt password
        $sql = "SELECT * FROM users WHERE username='$username' and password='$password' LIMIT 1";

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $reg_user_id = mysqli_fetch_assoc($result)['id'];
            $_SESSION['user'] = getUserById($reg_user_id);

            // ili ovdje
            // if user is admin, redirect to admin area
            if ( in_array($_SESSION['user']['role'], ["admin", "Author"])) {
                $_SESSION['message'] = "You are now logged in";
                // redirect to admin area
                header('location: ' . BASE_URL . '/admin/dashboard.php');
                exit(0);
            } else {
                $_SESSION['message'] = "You are now logged in";
                // redirect to public area
                header('location: index.php');
                exit(0);
            }
        } else {
            array_push($errors, 'Wrong credentials');
        }
    }
}
// escape value from form
function esc(String $value)
{
    // bring the global db connect object into function
    global $conn;

    $val = trim($value);
    $val = mysqli_real_escape_string($conn, $value);

    return $val;
}
// Get user info from user id
function getUserById($id)
{
    global $conn;
    $sql = "SELECT * FROM users WHERE id=$id LIMIT 1";

    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    return $user;
}
?>