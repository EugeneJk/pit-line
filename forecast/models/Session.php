<?php
namespace forecast;

class Session {

    private $user = null;
    private $mongo_connection = null;

    public function __construct() {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['forecast'])) {
//            $this->mongo_connection = new \MongoClient("mongodb://localhost");
            $this->save();
        } else {
            $this->read();
        }
    }

    private function read($param = null) {
        switch ($param) {
            case 'user':
                $this->user = $_SESSION['forecast']['user'];
                break;
//            case 'mongo_connection':
//                $this->mongo_connection = $_SESSION['forecast']['mongo_connection'];
//                break;
            default:
                $this->user = $_SESSION['forecast']['user'];
//                $this->mongo_connection = $_SESSION['forecast']['mongo_connection'];
                break;
        }
    }

    public function save() {
        $_SESSION['forecast'] = array(
            'user' => $this->user,
//            'mongo_connection' => $this->mongo_connection,
        );
    }

    public function isLogged() {
        $this->read('user');
        return $this->user === null ? false : true;
    }

//    public function getMongoConnection() {
//        $this->read('mongo_connection');
//        return $this->mongo_connection;
//    }

    public function getUser() {
        $this->read('user');
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
        $this->save();
    }

}
