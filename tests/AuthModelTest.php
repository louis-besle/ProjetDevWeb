<?php
use App\Models\AuthModel;
use App\Models\FileDatabase;
use PHPUnit\Framework\TestCase;

class AuthModelTest extends TestCase
{
    private $authModel;
    private $mockDb;

    protected function setUp(): void
    {
        $this->mockDb = $this->createMock(FileDatabase::class);
        $this->authModel = new AuthModel($this->mockDb);
    }

    public function testConnexionSuccess()
    {
        // Mock des données utilisateur
        $mockUser = [
            'id_utilisateur' => 1,
            'email' => 'test@example.com',
            'mot_de_passe' => password_hash('Password123', PASSWORD_DEFAULT),
            'nom_utilisateur' => 'Test',
            'prenom_utilisateur' => 'User',
            'id_role' => 1
        ];

        // Configuration du mock
        $this->mockDb->method('getAllRecords')->willReturn([$mockUser]);

        $this->mockDb->method('getRecordById')->willReturn(['nom_role' => 'Admin']);

        $this->assertTrue($this->authModel->connexion('test@example.com', 'Password123'));
        $this->assertArrayHasKey('user', $_SESSION);
    }

    public function testConnexionFailure()
    {
        $this->mockDb->method('getAllRecords')->willReturn([]);

        $this->assertFalse($this->authModel->connexion('wrong@example.com', 'wrongpass'));
    }

    protected function deconnexion(): void
    {
        unset($_SESSION['user']);
    }
}
?>