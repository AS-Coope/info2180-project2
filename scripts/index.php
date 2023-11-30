<?php
session_start();

require_once './phpmysqlconnect.php';
// Access the "email" variable from the POST request
$email = isset($_POST['email']) ? $_POST['email'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : false;

//echo nl2br("You will find the \n newlines in this string \r\n on the browser window.");
/* $salt_query = "SELECT SUBSTRING_INDEX(`password`, ';', 1) AS salt
FROM Users
WHERE email = '{$email}';"; */

$query = "SELECT password FROM Users
WHERE email = '{$email}';";

$stmt = $conn->query($query);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row){
    header("Location: ../pages/login.php?error=mnf");
}
echo "<br>";echo "<br>";
echo $row['password'];
//die("OVER");


//$stmt = $conn->query("SELECT * FROM users WHERE email = '{$email}' AND password = '{$password}'");

/* $students = $statement->fetchAll(PDO::FETCH_ASSOC);
echo nl2br("\n");
foreach ($students as $row){
    echo $row['email'];
};
*/

//$row = $stmt->fetch(PDO::FETCH_ASSOC);
//echo $recvEmail = $row['email'] ?? false;
$recvPassField = $row['password'] ?? false;
//echo nl2br("\nThe mail gotten is ".$recvEmail);
//echo nl2br("\nThe pass gotten is ".$recvPassField);

// Use strtok() to tokenize the string
$recv_salt = strtok($recvPassField, ";");
$recv_pass = strtok(";");

// Display the results
echo "<br>";echo "<br>";
echo "recv_salt: $recv_salt<br>";
echo "recv_pass: $recv_pass<br>";

echo $ri=$recv_salt.$password;
$salt = '4aa2d7b88da111ee84ad78e3b5519537';
//$password = hash('sha512', 'password123');
//4aa2d7b88da111ee84ad78e3b5519537;118466c43a72230da.       //bed
echo "<br>password before hashed {$password}<br>";
echo "<br>password just hashed<br>";
echo "<br>password thts hashed {$ri}<br>";
echo $hashed_password = hash('sha512', $recv_salt.$password);
echo "<br>";
$salted_hashed_password = $recv_salt.";".$hashed_password;
echo "<br>";echo "<br>";
echo "saltpass={$salted_hashed_password}";
echo "<br>";echo "<br>";

echo "<br>  lo<br>";
$answer = ($recvPassField===$salted_hashed_password) ? true : false;

echo ($answer) ? 'true' : 'false';
//die("lio");
/* if ($finalTotal==='admin@project2.com'){
    echo 'YES';
    echo $rodw['password'];
    echo '  salt: ',bin2hex($final);
    echo '  result: ',hash('sha512', 'password123'.bin2hex($final));
    echo '  result: ',hash('sha512', 'password123');
}
else {
    echo 'NO';
} */
switch ($answer) {
  case true:
    //echo "CORRECT";
    $_SESSION['user_email'] = $email;
    header("Location: ../pages/dashboard.php");
    break;
  case false:
    //die("falsue");
    header("Location: ../pages/login.php?error=ipe");
    break;
  }