<?php
$connect=new mysqli("localhost","root","","classA");
if(isset($_POST["submit"])){
$phone_number=$_POST['number'];
$firstname=$_POST['fn'];
$lastname=$_POST['ln'];
$gender=$_POST['gender'];
$province=$_POST['province'];
$insert=$connect->query("INSERT INTO information SET phone_number='$phone_number',firstname ='$firstname',lastname='$lastname',gender='$gender',province='$province'");
}

?>
<html>
    <head>
        <title>
            registration
        </title>
        <style>
            /* Reset and base styles */
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
            
            /* Main container to hold form and table side by side */
            .container {
                display: flex;
                gap: 20px;
                max-width: 1400px;
                margin: 0 auto;
                align-items: flex-start;
            }
            
            /* Container for the form */
            form {
                background: white;
                flex: 0 0 350px;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            }
            
            /* Form title */
            form::before {
                content: "Registration Form";
                display: block;
                font-size: 24px;
                font-weight: bold;
                color: #333;
                margin-bottom: 20px;
                text-align: center;
            }
            
            /* Input fields */
            input[type="number"],
            input[type="text"] {
                width: 100%;
                padding: 12px;
                margin: 8px 0 15px 0;
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
            
            /* Labels - displayed before each input */
            input[type="number"]::before,
            input[type="text"]::before {
                content: attr(placeholder);
                display: block;
                margin-bottom: 5px;
            }
            
            /* Submit button */
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
            
            /* Table wrapper */
            .table-wrapper {
                flex: 1;
                background: white;
                border-radius: 10px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                overflow: hidden;
            }
            
            /* Table container */
            table {
                width: 100%;
                border-collapse: collapse;
            }
            
            /* Table header */
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
            
            /* Table cells */
            td {
                padding: 15px;
                border-bottom: 1px solid #f0f0f0;
                color: #333;
            }
            
            /* Alternating row colors */
            tr:nth-child(even) {
                background: #f9f9f9;
            }
            
            tr:hover {
                background: #f0f0ff;
            }
            
            /* Links in table */
            a {
                color: #1e3c72;
                text-decoration: none;
                font-weight: bold;
                padding: 5px 10px;
                border-radius: 3px;
                transition: background 0.3s;
            }
            
            a:hover {
                background: #1e3c72;
                color: white;
            }
            
            /* Responsive design */
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
        <div class="container">
            <form action="" method="post">
                phone-number:<input type="number" name="number"><br>
                firstname:<input type="text" name="fn"><br>
                lastname:<input type="text" name="ln"><br>
                gender:<input type="text" name="gender"><br>
                province:<input type="text" name="province"><br>
                <button name="submit">submit</button>
            </form>
            
            <div class="table-wrapper">
                <table border=2>
        <tr>
            <th>phone number</th>
            <th>firstname</th>
            <th>lastname</th>
            <th>gender</th>
            <th>province</th>
            <th>update</th>
            <th>delete</th>
        </tr>
        <?php
        

        $sele=$connect->query("select * from information");
        while($row=mysqli_fetch_array($sele)){
            $phone_number=$row['phone_number'];
            $firstname=$row['firstname'];
            $lastname=$row['lastname'];
            $gender=$row['gender'];
            $province=$row['province'];
       
        ?>
        <tr>
            <td><?php echo $phone_number?></td>
            <td><?php echo $firstname?></td>
            <td><?php echo $lastname?></td>
            <td><?php echo $gender?></td>
            <td><?php echo $province?></td>
            
            <td><a href="update.php?phone_number=<?php echo $phone_number?>">update</a></td>
            <td><a href="delete.php?phone_number=<?php echo $phone_number?>">delete</a></td>
     
        </tr>
        <?php
         }
        
        ?>

    </table>
            </div>
        </div>

    </body>
</html>