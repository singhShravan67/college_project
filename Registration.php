<?php
require_once 'database.php';
require_once 'User.php';
require_once 'Event.php';

class Registration {
    private $conn;
    private $userModel;
    private $eventModel;
    
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
        $this->userModel = new User();
        $this->eventModel = new Event();
    }

    public function registerForEvent($event_id, $user_id, $semester, $branch, $iu_number, $special_requirements) {
        // Check if already registered
        if ($this->isUserRegistered($event_id, $user_id)) {
            return ['success' => false, 'message' => 'You are already registered for this event!'];
        }

        // Get user and event details
        $user_data = $this->userModel->getUserById($user_id);
        $event_data = $this->eventModel->getEventById($event_id);

        if (!$user_data || !$event_data) {
            return ['success' => false, 'message' => 'Invalid user or event data!'];
        }

        // Sanitize input
        $semester = mysqli_real_escape_string($this->conn, $semester);
        $branch = mysqli_real_escape_string($this->conn, $branch);
        $iu_number = mysqli_real_escape_string($this->conn, $iu_number);
        $special_requirements = mysqli_real_escape_string($this->conn, $special_requirements);

        // Insert registration data
        $reg_sql = "INSERT INTO registrations 
                   (event_id, user_id, user_name, user_email, user_phone, semester, branch, iu_number, event_name, special_requirements) 
                   VALUES 
                   ($event_id, $user_id, '{$user_data['name']}', '{$user_data['email']}', '{$user_data['phone']}', '$semester', '$branch', '$iu_number', '{$event_data['title']}', '$special_requirements')";

        if ($this->conn->query($reg_sql)) {
            // Update participant count
            $this->eventModel->updateParticipantCount($event_id);
            return ['success' => true, 'message' => 'Registration successful!'];
        } else {
            return ['success' => false, 'message' => 'Registration failed!'];
        }
    }

    public function isUserRegistered($event_id, $user_id) {
        $event_id = (int)$event_id;
        $user_id = (int)$user_id;
        $sql = "SELECT * FROM registrations WHERE event_id = $event_id AND user_id = $user_id";
        $result = $this->conn->query($sql);
        return $result->num_rows > 0;
    }

    public function getUserRegistrations($user_id) {
        $user_id = (int)$user_id;
        $sql = "SELECT event_id FROM registrations WHERE user_id = $user_id";
        $result = $this->conn->query($sql);
        
        $registrations = array();
        while ($row = $result->fetch_assoc()) {
            $registrations[] = $row['event_id'];
        }
        
        return $registrations;
    }
}
?>