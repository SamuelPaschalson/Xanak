<?php

namespace Xanak\Table;

use Xanak\Database\Connection;

class Table
{
    public $currentTable;

    function __construct($currentTable)
    {
        $this->currentTable = $currentTable;
    }

    function saveInDatabase($credentials, $primary = '')
    {
        try {
            $this->insertInDatabase($credentials);
        } catch (\Exception $err) {
            $this->updateInDatabase($credentials, $primary);
        }
    }

    function insertInDatabase($credentials)
    {
        $pdo = Connection::getInstance()->getPdo();
        $pieces = array_keys($credentials);
        $rowValues = implode(',', $pieces); 
        $rowValuesWithColon = implode(', :', $pieces);
        $databaseQuery = 'INSERT INTO ' . $this->currentTable . '(' . $rowValues . ') VALUES(:' . $rowValuesWithColon . ')';
        $selectprpstmt = $pdo->prepare($databaseQuery);
        $selectprpstmt->execute($credentials);
    }

    function updateInDatabase($credentials, $primary)
    {
        $pdo = Connection::getInstance()->getPdo();
        $pieces = [];
        foreach ($credentials as $key => $value) {
            $pieces[] = $key . '= :' . $key; 
        }
        $piecesWithComma = implode(', ', $pieces);
        $databaseQuery = "UPDATE $this->currentTable SET $piecesWithComma WHERE $primary=:primary";
        $credentials['primary'] = $credentials[$primary];
        $selectprpstmt = $pdo->prepare($databaseQuery);
        $selectprpstmt->execute($credentials); 
    }

    function findInDatabase($column, $value)
    {
        $pdo = Connection::getInstance()->getPdo();
        $selectprpstmt = $pdo->prepare('SELECT * FROM ' . $this->currentTable . ' WHERE ' . $column . '=:value');
        $credentials = [
            'value' => $value
        ];
        $selectprpstmt->execute($credentials);
        return $selectprpstmt;
    }

    function findAllInDatabase()
    {
        $pdo = Connection::getInstance()->getPdo();
        $selectprpstmt = $pdo->prepare("SELECT * FROM " . $this->currentTable);
        $selectprpstmt->execute();
        return $selectprpstmt;
    }

    function deleteFromDatabase($column, $value)
    {
        $pdo = Connection::getInstance()->getPdo();
        $selectprpstmt = $pdo->prepare("DELETE FROM $this->currentTable WHERE $column = :value");
        $credentials = [
            'value' => $value
        ];
        $selectprpstmt->execute($credentials);
        return $selectprpstmt;
    }

    function getLastInsertId()
    {
        $pdo = Connection::getInstance()->getPdo();
        $lastInsertId = $pdo->lastInsertId();
        return $lastInsertId;
    }
}
