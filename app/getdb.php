<?php
    function get_db()
    {   
     $mongo = new MongoDB\Client(
            "mongodb://localhost:27017/SECRET",
            [
                'username' => 'SECRET',
                'password' => 'SECRET',
            ]);

        $db = $mongo->SECRET;

        //CZYSZCZENIE BAZY
        /*$collection = $db->photos;
        $result = $collection->drop();
        $collection = $db->users;
        $result = $collection->drop();*/

        return $db;
    }