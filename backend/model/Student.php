<?php
class Student{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = DB::getInstance()->getConnection();
    }

    public function getAll():array{
        $stmt = $this->connection->query("SELECT * FROM student");
        return $stmt->fetchAll();
    }
    
    public function getByID(int $id, array $cols = ['*']): array{
    
        $columns = implode(', ', $cols);
        $stmt = $this->connection->prepare("SELECT $columns FROM student WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create(array $data):bool{
        $sql = "INSERT INTO student (f_name, l_name, address, country, gender, department, username, password, skills, profile_image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            $data['f_name'],
            $data['l_name'],
            $data['address'],
            $data['country'],
            $data['gender'],
            $data['department'],
            $data['username'],
            $data['password'],     
            $data['skills'],       
            $data['profile_image'] 
        ]);
    }
    public function update (int $id, array $data): bool{
        $fields = implode(', ', array_map(fn($col) => "$col = ?", array_keys($data)));
        $sql    = "UPDATE student SET $fields WHERE id = ?";

        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([...array_values($data), $id]); 
    }
    public function delete (int $id): bool{
        $student = $this->getById($id);
        if (!$student) {
            die('Student not found.');
        }

        // 2. Delete
        $stmt = $this->connection->prepare("DELETE FROM student WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public function getByColumn(string $col, mixed $value): array|false
    {
        $stmt = $this->connection->prepare("SELECT * FROM student WHERE $col = ?");
        $stmt->execute([$value]);
        return $stmt->fetch();
    }
}

?>
