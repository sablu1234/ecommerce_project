<?php include 'header.php'; ?>
<?php include 'top.php'; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM admins WHERE id=? ");
$statement->execute([$_REQUEST['id']]);
$total = $statement->rowCount();
if(!$total){
    header("location: ".$ADMIN_URL."admin-users.php");
    exit;
}
$result = $statement->fetch(PDO::FETCH_ASSOC);
if($result['role'] == 'Super Admin'){
    header("location: ".$ADMIN_URL."admin-users.php");
    exit;
}

// admin can not edit any admin data
if($_SESSION['admin']['role'] == 'Admin'){
    if($result['role']== 'Admin'){
    header("location: ".$ADMIN_URL."admin-users.php");
    exit;
    }
}

// Moderator can not edit any admin or moderator data here.
if($_SESSION['admin']['role'] == 'Moderator'){
    header("location: ".$ADMIN_URL."admin-users.php");
    exit;
}

// Now you can delete admin user
$statement = $pdo->prepare("DELETE FROM admins WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$_SESSION["success_message"] = 'Admin user has been deleted successfully.'; 
header("location: ".ADMIN_URL."admin-users.php");
exit;

?>

