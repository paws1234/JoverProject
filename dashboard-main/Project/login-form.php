<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="output.css">
    <title>Login</title>
</head>
<body class="flex items-center justify-center h-screen"> 
    <img src="img/pexels-christina-morillo-1181304.jpg" alt="picture" >
    <div class="bg-neutral-800 p-10 flex flex-col items-center justify-center w-fit absolute rounded	">

        <svg class="w-20 mb-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
          </svg>
        <div class="flex">
            <h1 class="text-4xl text-white font-bold	">Log</h1>
            <h1 class="text-4xl text-neutral-800 bg-orange-400 rounded font-bold">In</h1>
        </div>
        <h1 class="text-4xl mt-5 mb-5 text-white">Employee Sign in</h1> 
        <span class="text-white">Access your Employee Account</span>
        
        <!-- Form -->
        <form method="post" action="login.php" class="mt-10 grid">
            <input class="p-2 mb-5 bg-neutral-600" type="text" name="username" placeholder="Employee name.." required>
            <input class="p-2 bg-neutral-600" type="password" name="password" placeholder="Password(6+ characters).." required>

            <div class="mt-5 flex justify-center">
                <input type="submit" name="login" value="Sign in" class="hover:bg-orange-400 rounded transition ease-out duration-500 text-white text-4xl py-2 px-3">
            </div>
        </form>

        <div class="mt-4">
            <span class="text-white">Don't have an account yet? <a href="register-form.php" class="text-orange-400">Sign up</a> here</span>
        </div>
    </div>

</body>
</html>
