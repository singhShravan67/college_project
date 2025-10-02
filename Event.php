<?php
require_once 'database.php';

class Event {
    private $conn;
    
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAllEvents($search = '', $category_filter = '', $status_filter = '') {
        $where_conditions = array();
        
        if (!empty($search)) {
            $search = mysqli_real_escape_string($this->conn, $search);
            $where_conditions[] = "(title LIKE '%$search%' OR description LIKE '%$search%')";
        }
        
        if (!empty($category_filter)) {
            $category_filter = mysqli_real_escape_string($this->conn, $category_filter);
            $where_conditions[] = "category = '$category_filter'";
        }
        
        if (!empty($status_filter)) {
            $status_filter = mysqli_real_escape_string($this->conn, $status_filter);
            $where_conditions[] = "status = '$status_filter'";
        }
        
        $where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";
        $sql = "SELECT * FROM events $where_clause ORDER BY event_date ASC";
        
        return $this->conn->query($sql);
    }

    public function getCategories() {
        $sql = "SELECT DISTINCT category FROM events ORDER BY category";
        return $this->conn->query($sql);
    }

    public function getStats() {
        $sql = "SELECT 
                    COUNT(*) as total_events,
                    SUM(CASE WHEN status = 'upcoming' THEN 1 ELSE 0 END) as upcoming_events,
                    SUM(current_participants) as total_participants,
                    COUNT(DISTINCT category) as total_categories
                FROM events";
        
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    public function getEventById($id) {
        $id = (int)$id;
        $sql = "SELECT title FROM events WHERE id = $id";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    public function updateParticipantCount($event_id) {
        $event_id = (int)$event_id;
        $sql = "UPDATE events SET current_participants = current_participants + 1 WHERE id = $event_id";
        return $this->conn->query($sql);
    }
}
?>