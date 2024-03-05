<?php
    function gallery1()
    {
        //ODCZYT ZDJEC Z PLIKU
        $directory = __DIR__ . '/../images/';
        require __DIR__ . '/../models/photo.php';
        $mongoClient = get_db();
        $collection = $mongoClient->photos;
        $cursor = $collection->find();

        $uniqueIds = $collection->distinct('id');
        $count = count($uniqueIds);
        $photoId = array();

        //STRONICOWANIE
        $imagesPerPage = 5;
        $totalPages = ceil($count / $imagesPerPage);
        $page = isset($_GET['page']) ? max(1, min($totalPages, (int)$_GET['page'])) : 1;
        $startIndex = ($page - 1) * $imagesPerPage;

        //WYPISUJE WSZYSTKIE ZDJĘCIA Z OPISAMI
        $numberOfImages = 0;
        echo '<div class="images-container">';
        $counter = 0;
        foreach ($cursor as $document) 
        {
            if ($counter >= $startIndex && $counter < $startIndex + $imagesPerPage) 
            {
                $photoPath = $document['path'];
                $lastElement = basename($photoPath);
                $thumbnailPath = str_replace($lastElement, 'thumbnail_' . $lastElement, $photoPath);
                $watermarkedPath = str_replace($lastElement, 'watermarked_' . $lastElement, $photoPath);
                echo '<div class="image-container">';
                    echo '<img src="'. $thumbnailPath . '" alt="' . $document['title'] . '" class="thumbnail" onclick="openLightbox(\'' . $watermarkedPath . '\')"/>';
                    echo '<div class="image-details">';
                        echo '<p>Tytuł: ' . $document['title'] . '</p>';
                        echo '<p>Autor: ' . $document['author'] . '</p>';
                    $photoId[] = $document['id'];
                    $numberOfImages++;
                    echo '</div>';
                echo '</div>';
            }
            $counter++;
        }
        echo '</div>';
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) 
        {
            echo '<div class="checkboxs-container">';
            echo '<form action="/mvc/public/remember/remembered" method="post">';
            for ($i = 0; $i < $numberOfImages; $i++) 
            {
                echo '<div class="checkbox-container">';
                    if(isset($_SESSION['selectedPhotos']))
                    {
                        $isChecked = in_array($photoId[$i], $_SESSION['selectedPhotos']);
                        echo '<input type="checkbox" value="' . $photoId[$i] . '" name="photos[]" ' . ($isChecked ? 'checked' : '') . '>';
                    }
                    else
                    {
                        echo '<input type="checkbox" value="' . $photoId[$i] . '" name="photos[]">';
                    }
                echo '</div>';
            } 
            echo '</div>';
        }

        //LOGOWANIE/WYLOGOWANIE ZALEZY OD SESJI
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            echo '<br><button type="submit" class="button1">ZAPAMIĘTAJ WYBRANE</button><br>';
            echo '</form>';
            echo '<br><a href = \'/./mvc/public/remember/remembered\'><button class="button1">ZAPAMIĘTANE</button></a><br>';
            echo '<br><a href = \'/./mvc/public/logout/logout\'><button class="button1">WYLOGUJ</button></a><br><br>';
        } 
        else 
        {
            echo '
            <br><a href = \'/./mvc/public/register/index\'><button class="button1">REJESTRACJA KONT</button></a><br><br>
            <a href = \'/./mvc/public/login/index\'><button class="button1">LOGOWANIE</button></a><br><br>';
        }

         //DODAJE PAGINACJE
         if ($totalPages > 1) 
         {
             echo '<div class="pagination">';
             for ($i = 1; $i <= $totalPages; $i++) 
             {
                 $class = ($i == $page) ? 'active' : '';
                 echo '<a href="?page=' . $i . '" class="' . $class . '">' . $i . '</a>';
             }
             echo '</div>';
         }
    }
        
        