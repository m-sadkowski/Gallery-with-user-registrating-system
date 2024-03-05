<?php

require_once __DIR__ . '/../models/user.php';

class Register extends Controller
{
    public function index()
    {
        $this->view('register/index');
    }

    public function ifUserExists($login)
    {
        $mongoClient = get_db();
        $collection = $mongoClient->users;
        $existingUser = $collection->findOne(['login' => $login]);
        return ($existingUser !== null);
    }

    public function register_process()
    {
        $db = get_db();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {   
            if ($this->ifUserExists($_POST['login'])) {
                echo "Użytkownik o podanym loginie już istnieje. Wybierz inny login.";
            }
            else if (!($_POST['password'] === $_POST['confirm_password']))
            {
                echo "Podane hasła są różne. Spróbuj ponownie.";
            }
            else
            {
                $login = $_POST['login'];
                $email = $_POST['email'];
                $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $id = uniqid();
    
                //STWÓRZ UŻYTKOWNIKA
                $user = new User($id, $login, $email, $hashedPassword);
    
                //DODAJ UŻYTKOWNIAK DO BAZY
                $insertedId = $user->createUserInMongoDB();
    
                //CZY UDAŁO SIĘ ZAREJESTROWAĆ
                if ($insertedId) {
                    echo "Rejestracja udana. Użytkownik dodany do bazy danych z ID: $insertedId";
                } else {
                    echo "Błąd podczas rejestracji. Nie udało się dodać użytkownika do bazy danych.";
                }
            }
        }
        else
        {
            echo "Błąd rejestracji. Formularz został nieprawidłowo przesłany.";
        }
        $this->view('register/register_process');
    }
}