<?php
session_start();
unset($_SESSION['loginStatus']);
$taskOutput = "";
$registerDisplayStatus = 'style = "display:none"'; 
$_SESSION['loginDisplay'] = 'style = "display:none"'; 
$_SESSION['userFinderStatus'] = 'guest';
$_SESSION['loginBtnDisplay'] = 'style = "inherit"';
$_SESSION['emailError'] = 'style = "display:none"';
$_SESSION['loginNameError'] = 'style = "display:none"';
$_SESSION['addTaskDisplay'] = 'style = "display:none"';
$_SESSION['addTaskBtn'] = 'style = "display: none"';


if(isset($_POST['option-login-btn'])){
    $_SESSION['loginDisplay'] = 'style = "display:inherit"';
    $_SESSION['loginStatus'] = "false"; 
}

if (isset($_POST['login-btn'])){   
    $_SESSION['loginDisplay'] = 'style = "display:inherit"';
    $registerDisplayStatus = 'style = "display:none"'; 
}

if (isset($_POST['registerBtn'])){   
    $registerDisplayStatus = 'style = "display:inherit"';
}

if (isset($_POST['registerUserBtn'])) {
    $_SESSION['loginStatus'] = "false";
    if($_POST['email'] == ''){
        echo "!";
        $registerDisplayStatus = 'style = "display:inherit"';
    }elseif($_POST['name'] == ''){
        echo "!";
        $registerDisplayStatus = 'style = "display:inherit"';
    }elseif($_POST['registerPass'] == ''){
        echo "!";
        $registerDisplayStatus = 'style = "display:inherit"';
    }else{
        if($_SESSION['loginStatus'] == "false"){
            registerUser();
            $registerDisplayStatus = 'style = "display:inherit"';    
        }
        if($_SESSION['loginStatus'] == "true"){
            $registerDisplayStatus = 'style = "display:none"'; 
            $_SESSION['loginBtnDisplay'] = 'style = "display:none"';
        }
    $_SESSION['userFinderStatus'] = 'guest';
    }  
}

if (isset($_POST['loginUser'])){  
        loginUser();
}

function registerUser(){
    $_SESSION['loginStatus'] = "true";
    $userDataArray = file_get_contents('dataArray.json');
    $users = json_decode($userDataArray,true);
    $inputEmail = $_POST['email'];
    $inputUsername = $_POST['name'];
    $inputPass = $_POST['registerPass'];
    $n=0;
    
    foreach($users as $Value){
        if ($users[$n]['email'] == $inputEmail){
            $_SESSION['userFinderStatus'] = 'found';
            }
        $n++;
    }

    if($_SESSION['userFinderStatus'] == "found"){
            $_SESSION['loginStatus'] = "false";
            $_SESSION['emailError'] = 'style = "display:inherit"';
    }else{
        $users[] = [

            "email" => $inputEmail,
            "name" => $inputUsername,
            "password" => password_hash($inputPass, PASSWORD_DEFAULT),
            "type" => "user",
            "tasks" => [],
        
        ];
        $_SESSION['user'] = $inputEmail;
        $_SESSION['addTaskBtn'] = 'style = "display: inherit"';
        $_SESSION['user'] = $n;
        $_SESSION['userIs'] = $users[$n]['name'];

        $dataSaveFile = 'dataArray.json';
        file_put_contents($dataSaveFile , json_encode($users, JSON_PRETTY_PRINT));
        }
        
}

function loginUser(){
    $_SESSION['loginStatus'] = "true";
    $userDataArray = file_get_contents('dataArray.json');
    $users = json_decode($userDataArray,true);
    $inputname = $_POST['loginName'];
    $inputPass = $_POST['loginPassword'];
    $n = 0;
    $_SESSION['userIs'] = '';
    foreach($users as $Value){
        if ($users[$n]['name'] == $inputname || $users[$n]['email'] == $inputname){
            if(password_verify($inputPass, $users[$n]['password'])){
                $_SESSION['user'] = $n;
                $_SESSION['userFinderStatus'] = "found";
                // print_r($_SESSION['user']); 
            }
        }
        $n++;
    }
    if($_SESSION['userFinderStatus'] == "found"){
        $_SESSION['loginDisplay'] = 'style = "display:none"';
        $_SESSION['loginStatus'] = "true";
        $_SESSION['loginBtnDisplay'] =  'style = "display:none"';
        $_SESSION['addTaskBtn'] = 'style = "display: inherit"';
    }else{
        $_SESSION['loginStatus'] = "false";
        $_SESSION['loginDisplay'] = 'style = "display:inherit"';
        $_SESSION['loginNameError'] = 'style = "display:inherit"';
    }
}

if(isset($_POST['addTaskBtn'])){
    addTask();
 
}

if(isset($_POST['addToTasks'])){
    addToTasks();
}

function addTask(){
    $_SESSION['addTaskDisplay'] = 'style = "display:inherit"';
    $_SESSION['loginBtnDisplay'] =  'style = "display:none"';
    $_SESSION['loginStatus'] = "true";    
}

function addToTasks(){
    $_SESSION['loginStatus'] = "true";
    $userDataArray = file_get_contents('dataArray.json');
    $users = json_decode($userDataArray,true);

    $_SESSION['loginBtnDisplay'] =  'style = "display:none"'; 
    $_SESSION['addTaskBtn'] = 'style = "display:inherit"';


    $taskCount = count($users[$_SESSION['user']]['tasks']);
    $i = 0;
    $taskFound = "false";
    if($_POST['taskInput'] != ""){
        foreach($users[$_SESSION['user']]["tasks"] as $value){
            $task = $users[$_SESSION['user']]["tasks"][$i];
            if($task == $_POST['taskInput']){
                $taskFound = "true";
            }else{
                $taskFound = "false";
            }
            $i++;
        } 
        if($taskFound == "false"){
        $taskInput = $_POST['taskInput'];
        $users[$_SESSION['user']]['tasks'][$taskCount] = $taskInput;
    }
    }
    
    $dataSaveFile = 'dataArray.json';
    file_put_contents($dataSaveFile , json_encode($users, JSON_PRETTY_PRINT));
}

function displayTasks(){
    $i=0;
    $userDataArray = file_get_contents('dataArray.json');
    $users = json_decode($userDataArray,true);
    foreach($users[$_SESSION['user']]["tasks"] as $value){
        $task = $users[$_SESSION['user']]["tasks"][$i];
        $tasks = "<div class='task'>
                    <p>
                    $task
                    </p>
                    <form method='POST'>
                        <button id='complete$i' name='completeBtn'>Complete</button>
                        <button id='edit$i' name='editBtn'>Edit</button>
                        <button id='delete$i' value='0' name='deleteBtn0'>Delete</button>
                    </form>    
                </div>";
        echo $tasks;
        $i++;
    }
    $tasks = "";
}

if(isset($_POST['deleteBtn0'])){
    // returnTaskN();
    $_SESSION['loginStatus'] = "true";
    $_SESSION['loginBtnDisplay'] =  'style = "display:none"'; 
    echo 1;
}



?>