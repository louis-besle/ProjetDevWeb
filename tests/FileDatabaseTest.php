<?php
use App\Models\FileDatabase;
use PHPUnit\Framework\TestCase;

class FileDatabaseTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        $this->db = new FileDatabase('172.201.220.97','stageup','azureuser','#Cesi2024');
    }

    public function testGetAllRecords()
    {
        $result = $this->db->getAllRecords('utilisateur');
        $this->assertContains($result[0], $this->db->getAllRecords('utilisateur'));
    }

    public function testInsertRecord()
    {
        // Test avec une transaction pour ne pas modifier la DB réelle
        $this->db->getPDO()->beginTransaction();
        
        try {
            $result = $this->db->InsertRecordIntoUtilisateur(
                'Test', 
                'User', 
                'test@example.com', 
                'hashedpass', 
                1
            );
            $this->assertTrue($result);
        } finally {
            $this->db->getPDO()->rollBack();
        }
    }
}
?>