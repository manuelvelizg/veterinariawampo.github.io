<?php
class Database{
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct(){
        $this->host = '127.0.0.1';
        $this->db = 'bdveterinaria_wampo';
        $this->user = 'root';
        $this->password = '';
        $this->charset = 'utf8mb4';
    }

    function connect(){
        try{
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $pdo = new PDO($connection, $this->user, $this->password, $options);
            return $pdo;
        }catch(PDOException $e){
            print_r('Error connection: ' . $e->getMessage());
        }
    }

    function insertUser($email, $password){
        $hashedPassword = hash('sha256', $password);

        try{
            $pdo = $this->connect();
            $query = $pdo->prepare('INSERT INTO user (Correo, Password) VALUES (:email, :password)');
            $query->execute([':email' => $email, ':password' => $hashedPassword]);
        }catch(PDOException $e){
            print_r('Error inserting user: ' . $e->getMessage());
        }
    }
}
?>
