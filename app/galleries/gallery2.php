<?php

    require __DIR__ . '/../models/photo.php';

    function gallery2()
    {
        $directory = __DIR__ . '/../images/';
        $mongoClient = get_db();
        $collection = $mongoClient->photos;

        $selectedPhotos = isset($_SESSION['selectedPhotos']) ? array_values($_SESSION['selectedPhotos']) : [];
        $count = count($selectedPhotos);
        $photoId = array();

        //STRONICOWANIE
        $imagesPerPage = 5;
        $totalPages = ceil($count / $imagesPerPage);
        $page = isset($_GET['page']) ? max(1, min($totalPages, (int)$_GET['page'])) : 1;
        $startIndex = ($page - 1) * $imagesPerPage;

        echo '<div class="images-container">';
        for ($i = $startIndex; $i < min($count, $startIndex + $imagesPerPage); $i++)
        {
            $photoIndex = $selectedPhotos[$i];
            $photoDocument = $collection->findOne(['id' => $photoIndex]);
            $photoPath = $photoDocument['path'];
            $lastElement = basename($photoPath);
            $thumbnailPath = str_replace($lastElement, 'thumbnail_' . $lastElement, $photoPath);
            $watermarkedPath = str_replace($lastElement, 'watermarked_' . $lastElement, $photoPath);
            echo '<div class="image-container">';
                echo '<img src="'. $thumbnailPath . '" alt="' . $photoDocument['title'] . '" class="thumbnail" onclick="openLightbox(\'' . $watermarkedPath . '\')"/>';
                echo '<div class="image-details">';
                    echo '<p>Tytuł: ' . $photoDocument['title'] . '</p>';
                    echo '<p>Autor: ' . $photoDocument['author'] . '</p>';
                echo '</div>';
                $photoId[] = $photoDocument['id'];
            echo '</div>';
        }
        echo '</div>';
        
        echo '<div class="checkboxs-container">';
        echo '<form action="/mvc/public/remember/forget" method="post">';
        for ($i = $startIndex; $i < min($count, $startIndex + $imagesPerPage); $i++)
        {
            echo '<div class="checkbox-container">';
            if (isset($selectedPhotos[$i])) 
            {
                echo '<input type="checkbox" value="' . $selectedPhotos[$i] . '" name="photos[]">';
                echo '</div>';
            } 
            else 
            {
                continue;
            }
        } 
        echo '</div>';

        if($count != 0)
        {
            echo '<br><button type="submit" class="button1">USUŃ ZAZNACZONE Z ZAPAMIĘTANYCH</button><br>';
        }
        echo '</form>';

         //DODAJE PAGINACJE
        if ($totalPages > 1) {
            echo '<div class="pagination">';
            for ($i = 1; $i <= $totalPages; $i++) {
                $class = ($i == $page) ? 'active' : '';
                echo '<a href="?page=' . $i . '" class="' . $class . '">' . $i . '</a>';
            }
            echo '</div>';
        }
    }
        
        