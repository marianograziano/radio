<?php
ob_start(); 
ini_set('display_errors', 1);
error_reporting(E_ALL);
include('includes/config.php');
include('includes/db.php');
include('includes/functions.php');
secure();
include('includes/headadmin.php');
?>

<div class="container">
    <div class="row justify-content-center">
        <h1 class="display-1">Dashboard</h1>
        <div class="col-md-6">
<a href="users.php">Users managment</a> |

<a href="posts.php">Post Managment</a>


        </div>
    </div>

</div>

<?php
include('includes/footer.php');
?>