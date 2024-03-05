<?php

require_once __DIR__ . '/../models/user.php';

class Login extends Controller
{
    
    public function index()
    {
        $this->view('login/index');
    }

    public function login_process()
    {
        $db = get_db();

        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $login = $_POST['login'];
            $password = $_POST['password'];
            
            //ZNAJDZ UZYTKOWNIKA Z TAKIM LOGINEM
            $user = User::getUserByLogin($login);

            //CZY ISTNIEJE TAKI UZYTKOWNIK
            if ($user !== null) 
            {
                //CZY POPRAWNE HASLO
                if (password_verify($password, $user->getPassword())) 
                {
                    setcookie("cookie", $user->userId(), time() + 600, "/");
                    echo "Logowanie udane. Witaj, " . $user->getLogin() . "!";
                    $_SESSION['user_id'] = $user->userId();
                    $_SESSION['user_login'] = $user->getLogin();
                } 
                else 
                {
                echo "Błędne hasło. Spróbuj ponownie.";
                }
            } 
            else 
            {
            echo "Użytkownik o podanym loginie nie istnieje.";
            }
        }
        else
        {
            echo "Błąd logowania. Formularz został nieprawidłowo przesłany.";
        }

        $this->view('login/login_process');
    }
}