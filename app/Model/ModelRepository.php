<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Security\AuthenticationException;


class ModelRepository
{
	use Nette\SmartObject;

    /** @var Nette\Database\Context */
	private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function getAllUsers() {
        $result = $this->database->query('SELECT * FROM USERS')->fetchAll();
        return $result;
        

    }

    public function insertUser($email, $username, $password, $role) {
        $result = $this->database->query('INSERT INTO USERS', [
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'role' => $role
        ]);
        return $result;  
    }

    public function isDuplicate($email) {
        $duplicateEmail = $this->database->table('users')->where('email = ?', $email)->count('*');

        if ($duplicateEmail < 1) {
            return 1;
        }
        else {
            return 0;
        }
    }
     

}