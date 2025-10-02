 <!-- ye ek controller hai jo events ka registrations handle karta hai -->

<?php
require_once 'Event.php';
require_once 'Registration.php';

class EventController {
    private $eventModel;
    private $registrationModel;
    
    public function __construct() {
        $this->eventModel = new Event();
        $this->registrationModel = new Registration();
    }

    public function getEvents($search = '', $category_filter = '', $status_filter = '') {
        return $this->eventModel->getAllEvents($search, $category_filter, $status_filter);
    }

    public function getCategories() {
        return $this->eventModel->getCategories();
    }

    public function getStats() {
        return $this->eventModel->getStats();
    }

    public function handleEventRegistration($user_id) {
        if (isset($_POST['event_register']) && $user_id) {
            $event_id = $_POST['event_id'];
            $semester = $_POST['semester'];
            $branch = $_POST['branch'];
            $iu_number = $_POST['iu_number'];
            $special_requirements = $_POST['special_requirements'];
            
            return $this->registrationModel->registerForEvent(
                $event_id, 
                $user_id, 
                $semester, 
                $branch, 
                $iu_number, 
                $special_requirements
            );
        }
        return null;
    }

    public function getUserRegistrations($user_id) {
        if ($user_id) {
            return $this->registrationModel->getUserRegistrations($user_id);
        }
        return array();
    }

    public function getCategoryIcon($category) {
        $category_icons = [
            'Technical' => 'fas fa-laptop-code',
            'Cultural' => 'fas fa-theater-masks',
            'Sports' => 'fas fa-football-ball',
            'Academic' => 'fas fa-book',
            'Workshop' => 'fas fa-tools',
            'Competition' => 'fas fa-trophy',
            'default' => 'fas fa-calendar'
        ];

        return isset($category_icons[$category]) ? 
               $category_icons[$category] : 
               $category_icons['default'];
    }
}
?>