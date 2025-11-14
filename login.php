<?php
session_start();
$connect = new mysqli("localhost", "root", "", "classA");

if (isset($_POST['login'])) {
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);
    
    if (empty($email) || empty($password)) {
        $error = "All fields are required!";
    }
    else {
        $stmt = $connect->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                
                session_regenerate_id(true);
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['logged_in'] = true;
                
                if ($remember) {
                    setcookie("user_id", $user['id'], time() + (30 * 24 * 60 * 60), "/");
                    setcookie("username", $user['username'], time() + (30 * 24 * 60 * 60), "/");
                }
                
                header("Location: index.php");
                exit();
            } else {
                $error = "Incorrect password!";
            }
        } else {
            $error = "User not found!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .form-container {
            background: white;
            max-width: 450px;
            width: 100%;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        h2 {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }
        
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .message {
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .error {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }
        
        label {
            display: block;
            color: #333;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #1e3c72;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .remember-me input[type="checkbox"] {
            margin-right: 8px;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        
        .remember-me label {
            margin: 0;
            font-weight: normal;
            cursor: pointer;
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
        
        .signup-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }
        
        .signup-link a {
            color: #1e3c72;
            text-decoration: none;
            font-weight: bold;
        }
        
        .signup-link a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .form-container {
                padding: 30px 20px;
            }
            
            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Welcome Back</h2>
        <p class="subtitle">Login to access your account</p>
        
        <?php if (isset($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="post">
            <label>Email</label>
            <input type="email" name="email" placeholder="Enter your email" required>
            
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
            
            <div class="remember-me">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me for 30 days</label>
            </div>
            
            <button name="login">Login</button>
        </form>
        
        <p class="signup-link">Don't have an account? <a href="signup.php">Sign up here</a></p>
    </div>
</body>
</html>