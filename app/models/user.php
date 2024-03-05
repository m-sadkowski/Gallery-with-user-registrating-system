<?php

    require __DIR__ . '/../../../../../vendor/autoload.php';

    require __DIR__ . '/../getdb.php';

    class User 
    {
        private $userid;
        private $login;
        private $email;
        private $password;

        public function __construct($userid, $login, $email, $password) {
            $this->userid = $userid;
            $this->login = $login;
            $this->email = $email;
            $this->password = $password;
        }

        public function userId() {
            return $this->userid;
        }
    
        public function getLogin() {
            return $this->login;
        }
    
        public function getEmail() {
            return $this->email;
        }
    
        public function getPassword() {
            return $this->password;
        }

        public function createUserInMongoDB() {
            $mongoClient = get_db();
            $collection = $mongoClient->users;
        
            $data = [
                'userid' => $this->userId(),
                'login' => $this->getLogin(),
                'email' => $this->getEmail(),
                'password' => $this->getPassword(),
            ];
        
            if (!$collection instanceof \MongoDB\Collection) {
                throw new \Exception("Błąd podczas uzyskiwania dostępu do kolekcji 'users'");
            }
        
            $result = $collection->insertOne($data);
    
            return $result->getInsertedId();
        }

        public static function getUserByLogin($login)
        {
            $mongoClient = get_db();
            $collection = $mongoClient->users;
            $userData = $collection->findOne(['login' => $login]);

            if ($userData !== null) {
                return new User(
                    $userData['userid'],
                    $userData['login'],
                    $userData['email'],
                    $userData['password']
                );
            }
            return null;
        }       
    }
