<?php
namespace App\Models;

interface Database {
    public function getAllRecords($table);
    public function getRecordById($table,$id);
}
