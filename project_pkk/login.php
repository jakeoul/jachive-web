<?php
include 'config.php';
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    
    if (mysqli_num_rows($query) > 0) {
        $_SESSION['user'] = $username;
        header("Location: index.php");
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login - Skythrift</title>
</head>
<body class="bg-sky-50 flex items-center justify-center h-screen">
    <div class="bg-white p-10 rounded-[2rem] shadow-xl w-96 border border-sky-100">
        <h2 class="text-2xl font-bold text-slate-800 mb-6 text-center italic">SKYTHRIFT LOGIN</h2>
        
        <?php if(isset($error)) echo "<p class='text-red-500 text-xs mb-4'>$error</p>"; ?>

        <form action="" method="POST" class="space-y-4">
            <input type="text" name="username" placeholder="Username" class="w-full p-4 bg-sky-50 rounded-xl outline-none border border-transparent focus:border-sky-500 transition">
            <input type="password" name="password" placeholder="Password" class="w-full p-4 bg-sky-50 rounded-xl outline-none border border-transparent focus:border-sky-500 transition">
            <button type="submit" name="login" class="w-full bg-slate-900 text-white py-4 rounded-xl font-bold hover:bg-sky-600 transition">SIGN IN</button>
        </form>
    </div>
</body>
</html>