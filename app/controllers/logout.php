<?php session_start();

class Logout extends Controller
{
    public function index()
    {
        $this->view('logout/logout_process');
    }

    public function logout()
    {
        //JEŻELI SESJA ISTNIEJE, POZBĄDŹ SIĘ JEJ
        if(session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
            setcookie("cookie", "", time() - 3600, "/");
            unset($_COOKIE['cookie']);
            echo 'Wylogowano.';
        }
        $this->view('logout/logout_process');
    }
}