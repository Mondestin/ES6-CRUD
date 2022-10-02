<?php
namespace CRUD;
require_once('config.php');

class User extends Config
{
   private $fname;
   private $lname;
   private $email;
   private $phone;

    // FirstName access and mutator
    public function setFname($fname)
    {
          $this->fname = $fname;
    }
    public function getFname()
    {
          return $this->fname;
    }

    // LastName access and mutator
    public function setLname($lname)
    {
          $this->lname = $lname;
    }
    public function getLname()
    {
          return $this->lname;
    }

   // Email access and mutator
    public function setEmail($email)
    {
          $this->email = $email;
    }
    public function getEmail()
    {
          return $this->email;
    }
    
    // Phone access and mutator
    public function setPhone($phone)
    {
          $this->phone = $phone;
    }
    public function getPhone()
    {
          return $this->phone;
    }

    // Fetch all users from the database
    public function all() 
    {
      $sql = 'SELECT * FROM users ORDER BY id DESC';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll();
      return $result;
    }

    // Save new user into the database
    public function save() 
    {
      $sql = 'INSERT INTO users (first_name, last_name, email, phone) VALUES (:fname, :lname, :email, :phone)';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([
        'fname' => $this->fname,
        'lname' => $this->lname,
        'email' => $this->email,
        'phone' => $this->phone
      ]);
      return true;
    }

    // Fetch s single user from the database
    public function get($id) 
    {
      $sql = 'SELECT * FROM users WHERE id = :id';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute(['id' => $id]);
      $result = $stmt->fetch();
      return $result;
    }
    // Update Single User
    public function update($id) 
    {
      $sql = 'UPDATE users SET first_name = :fname, last_name = :lname, email = :email, phone = :phone WHERE id = :id';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([
        'fname' => $this->fname,
        'lname' => $this->lname,
        'email' => $this->email,
        'phone' => $this->phone,
        'id' => $id
      ]);
      return true;
    }

    // Delete User From Database
    public function destroy($id) 
    {
      $sql = 'DELETE FROM users WHERE id = :id';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute(['id' => $id]);
      return true;
    }
  }

?>