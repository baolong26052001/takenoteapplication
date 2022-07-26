<?php
include 'fileManager.php';
class Connection
{
    public $pdo = null;

    public function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:server=localhost;dbname=notes', 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "ERROR: " . $exception->getMessage();
        }

    }

    public function getNotes()
    {
        $statement = $this->pdo->prepare("SELECT * FROM notes ORDER BY create_date DESC");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addNote($note)
    {
       
        $statement = $this->pdo->prepare("INSERT INTO notes (title, description, image, create_date)
                                    VALUES (:title, :description, :image, :date)");
        $statement->bindValue('title', $note['title']);
        $statement->bindValue('description', $note['description']);
        $statement->bindValue('image', $note['image']);
        $statement->bindValue('date', date('Y-m-d H:i:s'));
        return $statement->execute();

    }

    public function updateNote($id, $note)
    {
        $statement = $this->pdo->prepare("UPDATE notes 
        SET title = :title, description = :description, image = :image
        WHERE id = :id");
        $statement->bindValue('id', $id);
        $statement->bindValue('title', $note['title']);
        $statement->bindValue('description', $note['description']);
        $statement->bindValue('image', $note['image']);
        return $statement->execute();
    }

    public function removeNote($id)
    {
        $statement = $this->pdo->prepare("DELETE FROM notes WHERE id = :id");
        $statement->bindValue('id', $id);
        return $statement->execute();
    }

    public function getNoteById($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM notes WHERE id = :id");
        $statement->bindValue('id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}

return new Connection();