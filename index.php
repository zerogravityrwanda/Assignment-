<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['logged_in']) && isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['logged_in'] = true;
}

$connect = new mysqli("localhost", "root", "", "classA");

if (isset($_POST["submit"])) {
    $phone_number = $_POST['number'];
    $firstname = $_POST['fn'];
    $lastname = $_POST['ln'];
    $gender = $_POST['gender'];
    $province = $_POST['province'];
    
    $phone_number = mysqli_real_escape_string($connect, $phone_number);
    $firstname = mysqli_real_escape_string($connect, $firstname);
    $lastname = mysqli_real_escape_string($connect, $lastname);
    $gender = mysqli_real_escape_string($connect, $gender);
    $province = mysqli_real_escape_string($connect, $province);
    
    $stmt = $connect->prepare("INSERT INTO information (phone_number, firstname, lastname, gender, province) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $phone_number, $firstname, $lastname, $gender, $province);
    
    if ($stmt->execute()) {
        $success = "Record added successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Information Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .header {
            background: white;
            max-width: 1400px;
            margin: 0 auto 20px;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            color: #1e3c72;
            font-size: 24px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-name {
            color: #333;
            font-weight: bold;
        }
        
        .logout-btn {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.2s;
        }
        
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        
        .container {
            display: flex;
            gap: 20px;
            max-width: 1400px;
            margin: 0 auto;
            align-items: flex-start;
        }
        
        form {
            background: white;
            flex: 0 0 350px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        form::before {
            content: "Add New Record";
            display: block;
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .message {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14px;
        }
        
        .error {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }
        
        .success {
            background: #efe;
            color: #3c3;
            border: 1px solid #cfc;
        }
        
        label {
            display: block;
            color: #333;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        input[type="number"],
        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        input[type="number"]:focus,
        input[type="text"]:focus {
            outline: none;
            border-color: #1e3c72;
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        
        .table-wrapper {
            flex: 1;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .table-header {
            padding: 20px 30px;
            background: #f8f9fa;
            border-bottom: 2px solid #e0e0e0;
        }
        
        .table-header h2 {
            color: #333;
            font-size: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            color: #333;
        }
        
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        tr:hover {
            background: #f0f0ff;
        }
        
        a {
            color: #1e3c72;
            text-decoration: none;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 3px;
            transition: background 0.3s;
            display: inline-block;
        }
        
        a:hover {
            background: #1e3c72;
            color: white;
        }
        
        @media (max-width: 1024px) {
            .container {
                flex-direction: column;
            }
            
            form {
                flex: 1;
                width: 100%;
                max-width: 500px;
                margin: 0 auto 20px;
            }
            
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }
        
        @media (max-width: 768px) {
            table {
                font-size: 12px;
            }
            
            th, td {
                padding: 10px 5px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Information Management System</h1>
        <div class="user-info">
            <span class="user-name">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="container">
        <form action="" method="post">
            <?php if (isset($error)): ?>
                <div class="message error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if (isset($success)): ?>
                <div class="message success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <label>Phone Number</label>
            <input type="number" name="number" placeholder="Enter phone number" required>
            
            <label>First Name</label>
            <input type="text" name="fn" placeholder="Enter first name" required>
            
            <label>Last Name</label>
            <input type="text" name="ln" placeholder="Enter last name" required>
            
            <label>Gender</label>
            <input type="text" name="gender" placeholder="Enter gender" required>
            
            <label>Province</label>
            <input type="text" name="province" placeholder="Enter province" required>
            
            <button name="submit">Add Record</button>
        </form>
        
        <div class="table-wrapper">
            <div class="table-header">
                <h2>All Records</h2>
            </div>
            <table>
                <tr>
                    <th>Phone Number</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Province</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
                <?php
                $sele = $connect->query("SELECT * FROM information");
                while($row = mysqli_fetch_array($sele)){
                    $phone_number = $row['phone_number'];
                    $firstname = $row['firstname'];
                    $lastname = $row['lastname'];
                    $gender = $row['gender'];
                    $province = $row['province'];
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($phone_number); ?></td>
                    <td><?php echo htmlspecialchars($firstname); ?></td>
                    <td><?php echo htmlspecialchars($lastname); ?></td>
                    <td><?php echo htmlspecialchars($gender); ?></td>
                    <td><?php echo htmlspecialchars($province); ?></td>
                    <td><a href="update.php?phone_number=<?php echo urlencode($phone_number); ?>">Update</a></td>
                    <td><a href="delete.php?phone_number=<?php echo urlencode($phone_number); ?>">Delete</a></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>