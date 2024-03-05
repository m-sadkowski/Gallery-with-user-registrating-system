<?php

class Upload extends Controller
{
    
    public function index()
    {
        $this->view('upload/index');
    }

    public function process() 
    {
        require_once __DIR__ . '/../models/photo.php';
        $db = get_db();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES['photo']['name'])) 
        {
            $uploadOk = 0;
            $photo = $_FILES['photo'];
            $fileSize = $photo['size'];
            $allowedFormats = ['jpeg', 'jpg', 'png'];
            $maxFileSize = 1 * 1024 * 1024; //1 MB
            $fileExtension = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));

            if (!in_array($fileExtension, $allowedFormats)) 
            {
                echo "Niepoprawny format pliku. Dozwolone formaty to: " . implode(', ', $allowedFormats) . ".";
            }
            elseif ($fileSize > $maxFileSize) 
            {
                echo "Zdjęcie przekracza maksymalny rozmiar (1 MB).";
            }
            else
            {
                $uploadDir = '/var/www/prod/src/web/mvc/app/images/';
                if (!empty($photo['name'])) 
                {
                    $author = $_POST['author'];
                    $title = $_POST['title'];
                    $tmpName = $photo['tmp_name'];
                    $targetPath = $uploadDir . $photo['name'];
                    $id = uniqid();

                    $pathInfo = pathinfo($targetPath);
                    $newFileName = 'photo_' . $id . '.' . $pathInfo['extension'];
                    $newFilePath = $uploadDir . $newFileName;
                    $pathToSave =  '/mvc/app/images/' . 'photo_' . $id . '.' . $pathInfo['extension'];
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    if (move_uploaded_file($tmpName, $newFilePath)) 
                    {
                        echo "Zdjęcie zostało pomyślnie przesłane.<br>";
                        $watermarkText = $_POST['watermark'];
                        $this->createWatermarkedImage($newFilePath, $uploadDir, $watermarkText);
                        $this->createThumbnail($newFilePath, $uploadDir);
                        $image = new Photo($id, $pathToSave, $title, $author);
                        $insertedId = $image->saveToMongoDB();
                        $uploadOk = 1;
                    } 
                    else 
                    {
                        echo "Błąd podczas przesyłania zdjęcia.<br>";
                    }
                }
            }
        }
        else 
        {
            echo "Nie wybrano żadnych zdjęć.";
        }
        
        $this->view('upload/process');
    }

    public function createWatermarkedImage($originalImagePath, $outputDir, $watermarkText) 
    {
        $imageType = exif_imagetype($originalImagePath);
    
        switch ($imageType) 
        {
            case IMAGETYPE_JPEG:
                $originalImage = imagecreatefromjpeg($originalImagePath);
                break;
            case IMAGETYPE_PNG:
                $originalImage = imagecreatefrompng($originalImagePath);
                break;
            default:
                return false;
        }

        $watermarkColor = imagecolorallocate($originalImage, 255, 255, 255); //BIAŁY TEKST
        $fontPath = __DIR__ . '/../../public/Arial Bold.ttf';
        $fontSize = 50;

        $imageWidth = imagesx($originalImage) / 2 - $fontSize; //POZYCJA TEKSTU
        $imageHeight = imagesy($originalImage) / 2 - $fontSize;

        imagettftext($originalImage, $fontSize, 0, $imageWidth, $imageHeight, $watermarkColor, $fontPath, $watermarkText);

        $watermarkedImagePath = $outputDir . 'watermarked_' . basename($originalImagePath);

        switch ($imageType) 
        {
            case IMAGETYPE_JPEG:
                imagejpeg($originalImage, $watermarkedImagePath);
                break;
            case IMAGETYPE_PNG:
                imagepng($originalImage, $watermarkedImagePath);
                break;
        }

        imagedestroy($originalImage);

        return true;
    }

    public function createThumbnail($originalImagePath, $outputDir) 
    {
        //JAKI PLIK
        $imageType = exif_imagetype($originalImagePath);

        switch ($imageType) 
        {
            case IMAGETYPE_JPEG:
                $originalImage = imagecreatefromjpeg($originalImagePath);
                break;
            case IMAGETYPE_PNG:
                $originalImage = imagecreatefrompng($originalImagePath);
                break;
        }
        $thumbnail = imagecreatetruecolor(200, 125);
        imagecopyresampled($thumbnail, $originalImage, 0, 0, 0, 0, 200, 125, imagesx($originalImage), imagesy($originalImage));
        //ZAPISZ MINIATURKE
        $thumbnailImagePath = $outputDir . 'thumbnail_' . basename($originalImagePath);
        imagejpeg($thumbnail, $thumbnailImagePath);
        //POZBADZ SIE TMP
        imagedestroy($thumbnail);
        imagedestroy($originalImage);
    }

}
?>
