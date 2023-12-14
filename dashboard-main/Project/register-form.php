<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="output.css">
</head>

<body class="flex justify-center items-center bg-neutral-700">
    <img class="bg-cover" src="img/pexels-mohamed-almari-1485894.jpg" alt="picture">

    <div class="flex absolute  ">
        <div class="max-w-3xl">
            <img class="rounded-tl-lg rounded-bl-lg" src="img/pexels-pixabay-416320.jpg" alt="picture">
        </div>
        <div class="bg-neutral-800 p-8 rounded-tr-lg  rounded-br-lg    ">

            <div class="flex justify-center">
                <svg class="sm:w-10 lg:w-20 text-white" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z">
                    </path>
                </svg>
            </div>
            <form method="post" action="register.php" class="sm:p-0 grid">
                <input class="sm:p-0 md:p-2 mb-5 bg-neutral-600 rounded" type="text" name="username"
                    placeholder="Username" required>
                <input class="sm:p-0 md:p-2 mb-5 bg-neutral-600 rounded" type="password" name="password"
                    placeholder="Password (6+ characters).." required>
                <input class="sm:p-0 md:p-2 mb-5 bg-neutral-600 rounded" type="password" name="confirm_password"
                    placeholder="Confirm Password" required>

                <div class="sm:mt-3 md:mt-10 md:mb-5 flex justify-center">
                    <input type="submit" name="register" value="Register"
                        class="hover:bg-orange-400 rounded transition ease-out duration-500 sm:text-text-sm md:text-4xl lg:py-2 lg:px-3 text-white">
                </div>
            </form>


            <span class="sm:text-xs md:text-lg text-white">Already have an account? <a href="login-form.php"
                    class="text-orange-400 font-semibold sm:text-xs md:text-lg">Login</a> <span
                    class="sm:hidden md:contents">here.</span></span>
        </div>
    </div>
</body>

</html>