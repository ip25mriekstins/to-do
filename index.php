<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YourToDo's</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.png">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
        include("functions.php");
    ?>  
    <div class="container">
        <div class="auth-container" <?php print($_SESSION['loginDisplay']) ?>>
            <div class="auth-box">
                <div class="auth-logo" >
                    LogIn
                </div>
                <form action="" method="POST" class="auth-form">
                    <p class="inputError" <?php print($_SESSION['loginNameError']) ?>> invalid username or email</p>
                    <input class="auth-input" type="text" placeholder="username or e-mail" name="loginName" value="">
                    <input class="auth-input" type="password" placeholder="password" name="loginPassword">
                    <button class="auth-input-btn" name="loginUser">LogIn</button>
                    <div class="auth-option-box" >
                        <p>Dont have account:</p>
                        <button name="registerBtn">Register</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="auth-container" <?php echo $registerDisplayStatus?>>
            <div class="auth-box">
                <div class="auth-logo">
                    Register
                </div>
                <form action="" method="POST" class="auth-form">
                    <input class="auth-input" type="email" placeholder="E-mail" name="email">
                    <p class="inputError" <?php print($_SESSION['emailError']) ?>> email already used</p>
                    <input class="auth-input" placeholder="username" name="name">
                    <input class="auth-input" type="password" placeholder="password" name="registerPass">
                    <button class="auth-input-btn" name="registerUserBtn">Register</button>
                </form>
                <form action="" method="POST" class="auth-option-box">
                    <p>Already have an account:</p>
                        <button name="login-btn">LogIn</button>
                </form>
            </div>
        </div>
        <div class="nav-bar">
            <div class="logo-box">
                <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#1f1f1f"><path d="M348.5-291.5Q360-303 360-320t-11.5-28.5Q337-360 320-360t-28.5 11.5Q280-337 280-320t11.5 28.5Q303-280 320-280t28.5-11.5Zm0-160Q360-463 360-480t-11.5-28.5Q337-520 320-520t-28.5 11.5Q280-497 280-480t11.5 28.5Q303-440 320-440t28.5-11.5Zm0-160Q360-623 360-640t-11.5-28.5Q337-680 320-680t-28.5 11.5Q280-657 280-640t11.5 28.5Q303-600 320-600t28.5-11.5ZM440-280h240v-80H440v80Zm0-160h240v-80H440v80Zm0-160h240v-80H440v80ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>
                YourToDo's
            </div>
            <div class="nav-options">
                <div class="nav-history">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M480-120q-138 0-240.5-91.5T122-440h82q14 104 92.5 172T480-200q117 0 198.5-81.5T760-480q0-117-81.5-198.5T480-760q-69 0-129 32t-101 88h110v80H120v-240h80v94q51-64 124.5-99T480-840q75 0 140.5 28.5t114 77q48.5 48.5 77 114T840-480q0 75-28.5 140.5t-77 114q-48.5 48.5-114 77T480-120Zm112-192L440-464v-216h80v184l128 128-56 56Z"/></svg>
                    History
                </div>
                <button type="button" data-theme-toggle aria-label="Change to light theme">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M565-395q35-35 35-85t-35-85q-35-35-85-35t-85 35q-35 35-35 85t35 85q35 35 85 35t85-35Zm-226.5 56.5Q280-397 280-480t58.5-141.5Q397-680 480-680t141.5 58.5Q680-563 680-480t-58.5 141.5Q563-280 480-280t-141.5-58.5ZM200-440H40v-80h160v80Zm720 0H760v-80h160v80ZM440-760v-160h80v160h-80Zm0 720v-160h80v160h-80ZM256-650l-101-97 57-59 96 100-52 56Zm492 496-97-101 53-55 101 97-57 59Zm-98-550 97-101 59 57-100 96-56-52ZM154-212l101-97 55 53-97 101-59-57Zm326-268Z"/></svg>
                </button>
                <form action="" class="option-loginBtn" method="POST" <?php print($_SESSION['loginBtnDisplay'])?>>
                    <button name="option-login-btn">LogIn</button>
                </form>
            </div>
        </div>
        <div class="content">
            <div class="tasks-box">
                <div class="task-option-box">
                    <div class="filters">
                        <select class="filter-select-style" name="" id="">
                            <option>All</option>
                            <option>Completed</option>
                            <option>Active</option>
                        </select>
                    </div>
                    <div class="tasks-options">
                        <form action="" method="POST">
                            <button name="addTaskBtn" <?php print($_SESSION['addTaskBtn']) ?>>Add Task</button>
                        </form>
                    </div>
                </div>
                <div class="tasks-display-container">
                    <div class="tasks-display">
                        <?php 
                        if(isset($_SESSION['loginStatus'])){
                            if($_SESSION['loginStatus'] == "true"){
                               displayTasks(); 
                            }else{
                                $_SESSION['loginStatus'] = "false";
                            }
                        }else{
                            print('<p class="guestTaskBox"> Log in to see Tasks </p>');
                        }
                        ?>
                    </div>
                    <div class="add-task-display" <?php print($_SESSION['addTaskDisplay']) ?>>
                        <form class="add-task-form" action="" method="post">
                            <input type="text" placeholder="Enter your task" value="" name="taskInput">
                            <button id="myBtn" name="addToTasks" type="submit">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
