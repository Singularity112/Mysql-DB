<?php
    $mysqli = mysqli_connect('localhost','root','','myBD');
    $userList = array();

    if (mysqli_connect_errno()) {
        echo mysqli_connect_error();
        exit();
    }

    if ($result = mysqli_query($mysqli, 'SELECT * FROM users')) {
        while( $row = mysqli_fetch_assoc($result) )
        {
            $login = $row['login'];
            $password = $row['password'];
            $email = $row['Email'];
            $user = new User($login,$password,$email);
            $userList[] = $user;
        }
    }



    class User
    {
        public $login;
        public $password;
        public $email;

        public function User($login, $password ,$email)
        {
            $this->login = $login;
            $this->password = $password;
            $this->email = $email;
        }

        public function AddToBd($mysqli)
        {
            $mysqli->query("INSERT INTO users(login, password, email) VALUES ('$this->login','$this->password','$this->email')") or die(mysqli_error($mysqli));
        }
    }

    if (isset($_POST['submit']))
    {
        $user = new User($_POST['login'], $_POST['password'], $_POST['email']);

        foreach ($userList as $users)
        {
            if ($users->login == $user->login)
            {
                echo 'Login already register';
                return;
            }
            else if ($users->email == $user->email)
            {
                echo 'Email already register';
                return;
            }
        }

        $user->AddToBd($mysqli);
    }

    print ("<table border = '2'>");
    print ("<tr>");
    print ("<td>Login</td>");
    print ("<td>Password</td>");
    print ("<td>Email</td>");
    print ("</tr>");
    foreach ($userList as $users)
    {
        print ("<tr>");
        print ("<td>".$users->login."</td>");
        print ("<td>".$users->password."</td>");
        print ("<td>".$users->email."</td>");
        print ("</tr>");
    }
    print ("</table>");

?>

<form method = "post" action = " ">
    login<br>
    <input type = "text" name = "login" required /><br>
    password<br>
    <input type = "password" name = "password" required /><br>
    email<br>
    <input type = "email" name = "email" required /><br>
    <input type = "submit" value = "Sign up" name = "submit"/>
</form>


