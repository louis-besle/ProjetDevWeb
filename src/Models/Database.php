<?php
namespace App\Models;

interface Database {
    public function getAllRecords($table);
    public function getRecord($table,$id);
}
