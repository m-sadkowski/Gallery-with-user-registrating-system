<?php session_start();

class Remember extends Controller
{
    
    public function index()
    {
        $this->view('remember/remembered');
    }

    public function remember() 
    {
        if (isset($_POST['photos']) && is_array($_POST['photos'])) 
        {
            if (!isset($_SESSION['selectedPhotos'])) 
            {
                $_SESSION['selectedPhotos'] = array();
            }

            //DODAJ NOWE ZDJĘCIA DO SESJI
            foreach ($_POST['photos'] as $newPhoto) 
            {
                //JEŚLI NIE ISTNIEJE TAKIE W TABLICY TO JE DODAJ
                if (!in_array($newPhoto, $_SESSION['selectedPhotos'])) 
                {
                    $_SESSION['selectedPhotos'][] = $newPhoto;
                }
            }
            //SELECTED PHOTOS ZAWIERA W SESJI WSZYSTKIE ZAPISANE ZDJĘCIA (po id)
        }
    }
    public function forget() 
    {
        if (isset($_POST['photos']) && is_array($_POST['photos'])) {
            // USUŃ WYBRANE ZDJĘCIA Z SESJI
            foreach ($_POST['photos'] as $photoToRemove) {
                $indexToRemove = array_search($photoToRemove, $_SESSION['selectedPhotos']);
                if ($indexToRemove !== false) {
                    unset($_SESSION['selectedPhotos'][$indexToRemove]);
                }
            }
        }

        $this->view('upload/index');
    }
}