<?php

    require __DIR__ . '/../../../../../vendor/autoload.php';

    require __DIR__ . '/../getdb.php';

    class Photo {
        private $id;
        private $path;
        private $title;
        private $author;

        public function __construct($id, $path, $title, $author) {
            $this->id = $id;
            $this->path = $path;
            $this->title = $title;
            $this->author = $author;
        }

        public function getId() {
            return $this->id;
        }
    
        public function getPath() {
            return $this->path;
        }
    
        public function getTitle() {
            return $this->title;
        }
    
        public function getAuthor() {
            return $this->author;
        }

        public function saveToMongoDB() {
            $mongoClient = get_db();
            $collection = $mongoClient->photos;
        
            $data = [
                'id' => $this->getId(),
                'path' => $this->getPath(),
                'title' => $this->getTitle(),
                'author' => $this->getAuthor(),
            ];
        
            if (!$collection instanceof \MongoDB\Collection) {
                throw new \Exception("Błąd podczas uzyskiwania dostępu do kolekcji 'photos'");
            }
        
            $result = $collection->insertOne($data);
    
            return $result->getInsertedId();
        }

    }
