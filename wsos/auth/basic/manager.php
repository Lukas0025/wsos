<?php
/**
 * Base databse table
 */

namespace wsos\auth\basic;

class manager {
    private $entity;
    private $nameCol;
    private $passCol;
    private $loginPage;

    function __construct($auth_entity, $nameCol, $passCol, $loginPage) {
        $this->entity    = $auth_entity;
        $this->nameCol   = $nameCol;
        $this->passCol   = $passCol;
        $this->loginPage = $loginPage;

        if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function requireLogin() {
        if (!isset($_SESSION["auth"])) {
            header("Location: {$this->loginPage}");
            die("Not logined.");
        }
    }

    public function login($username, $pass) {
        $user = new $this->entity();

        if (!$user->find($this->nameCol, $username)) {
            echo "cant find user";
            return false;
        }

        $vars = get_object_vars($user);

        if (!$vars[$this->passCol]->verify($pass)) return false;

        $_SESSION["auth"] = [
            "user" => $user,
            "time" => time()
        ];

        return true;
    }

    public function getActive() {
        if (!isset($_SESSION["auth"])) return false;

        return $_SESSION["auth"]["user"];
    }

    public function logout() {
        $_SESSION['auth'] = null;
        unset($_SESSION['auth']);
    }
}
