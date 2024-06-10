
<?php //PHP code
include '../config.php';
include 'sidebar.php';


if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    
    if ($stmt->execute()) {
        echo "User was deleted successfully.";
    } else {
        echo "Error while deleting user: " . $conn->error;
    }

   
    header("Location: display_accounts.php");
    exit;
} else {
    echo "User ID invalid.";
}
?>
