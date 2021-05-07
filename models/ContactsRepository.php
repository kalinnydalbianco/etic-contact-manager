<?php

require_once '../core/Database.php';

class ContactsRepository extends Database {

    public function all() {
        return $this->select('contacts');
    }

    public function id($id) {
        return $this->byId('contacts', $id);
    }

    public function create($name, $email, $phone = null) {
        $result = $this->insert('contacts', [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ]);

        if ($result['stmt']->rowCount() < 1) {
            throw new Exception('Error creating contact');
        }
    }

    public function edit($id, $name, $email, $phone = null) {
        $stmt = $this->update('contacts', [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ], ['id' => $id]);

        if ($stmt->rowCount() < 1) {
            throw new Exception('Error updating contact');
        }
    }

    public function remove($id) {
        $stmt = $this->delete('contacts', ['id' => $id]);
        
        if ($stmt->rowCount() < 1) {
            throw new Exception('Error updating contact');
        }
    }

    public function export() {

    }

    public function upload($file) {

    }

    public function sendMessage($id, $message) {

    }
}