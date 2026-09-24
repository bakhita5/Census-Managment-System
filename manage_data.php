<?php
session_start();
include 'connect.php';

$user_id = $_SESSION['user_id'];
$household_id = $_GET['id'] ?? null;

if (!$household_id) {
    header('Location: censusofficerdashboard.php');
    exit();
}

// Handle delete action
if (isset($_POST['delete'])) {
    $delete_sql = "DELETE FROM HOUSEHOLD WHERE household_id = '$household_id'";

    if (mysqli_query($conn, $delete_sql)) {
        $_SESSION['message'] = "Household deleted successfully!";
        header('Location: censusofficerdashboard.php');
        exit();
    } 
    else {
        $error = "Error deleting household: " . mysqli_error($conn);
    }
}

// Handle update action
if (isset($_POST['update'])) {
    $censusofficer_id = $_POST['censusofficer_id'];
    $family_size = $_POST['family_size'];
    $electricity = $_POST['access_to_electricity'];
    $water = $_POST['access_to_water'];
    $assets = $_POST['assets'];
    $residential_status = $_POST['residential_status'];
    
    $update_sql = "UPDATE HOUSEHOLD SET 
                   censusofficer_id = '$censusofficer_id',
                   family_size = '$family_size',
                   access_to_electricity = '$electricity',
                   access_to_water = '$water',
                   assets = '$assets',
                   residential_status = '$residential_status'
                   WHERE household_id = '$household_id'";
    
    if (mysqli_query($conn, $update_sql)) {
        $_SESSION['message'] = "Household updated successfully!";
        header('Location: censusofficerdashboard.php');
        exit();
    } else {
        $error = "Error updating household: " . mysqli_error($conn);
    }
}

// Fetch the household data
$sql = "SELECT * FROM HOUSEHOLD WHERE household_id = '$household_id'";
$result = mysqli_query($conn, $sql);
$household = mysqli_fetch_assoc($result);

if (!$household) {
    header('Location: censusofficerdashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Household</title>
    <link rel="stylesheet" href="commissionerdashboard.css">
</head>
<body>
    <div class="main">
        <div class="header">
            <h1>Manage Household #<?= $household_id ?></h1>
        </div>

        <?php if (isset($error)): ?>
            <div class="error-message" style="color: red; padding: 10px; margin: 10px 0; border: 1px solid red;">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <h2>Edit Household</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Census Officer ID:</label>
                    <input type="text" name="censusofficer_id" value="<?= $household['censusofficer_id'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Family Size:</label>
                    <input type="number" name="family_size" value="<?= $household['family_size'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Access to Electricity:</label>
                    <select name="access_to_electricity">
                        <option value="Yes" <?= $household['access_to_electricity'] == 'Yes' ? 'selected' : '' ?>>Yes</option>
                        <option value="No" <?= $household['access_to_electricity'] == 'No' ? 'selected' : '' ?>>No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Access to Water:</label>
                    <select name="access_to_water">
                        <option value="Yes" <?= $household['access_to_water'] == 'Yes' ? 'selected' : '' ?>>Yes</option>
                        <option value="No" <?= $household['access_to_water'] == 'No' ? 'selected' : '' ?>>No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Assets:</label>
                    <input type="text" name="assets" value="<?= $household['assets'] ?>">
                </div>
                <div class="form-group">
                    <label>Residential Status:</label>
                    <select name="residential_status">
                        <option value="Owned" <?= $household['residential_status'] == 'Owned' ? 'selected' : '' ?>>Owned</option>
                        <option value="Rented" <?= $household['residential_status'] == 'Rented' ? 'selected' : '' ?>>Rented</option>
                        <option value="Other" <?= $household['residential_status'] == 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                
                <div class="button-group">
                    <button type="submit" name="update" class="btn-update">Update Household</button>
                    <button type="submit" name="delete" class="btn-delete" onclick="return confirm('Are you sure you want to delete this household? This action cannot be undone!')">Delete Household</button>
                    <a href="censusofficerdashboard.php" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <style>
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        .button-group button, .button-group a {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-update {
            background: #4CAF50;
            color: white;
        }
        .btn-delete {
            background: #f44336;
            color: white;
        }
        .btn-cancel {
            background: #666;
            color: white;
        }
    </style>
</body>
</html>