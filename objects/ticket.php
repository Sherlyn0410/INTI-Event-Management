<?php
class Ticket {
    private $conn;
    private $table_name = "ticket";

    public $id;
    public $event_id;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getConnection() {
        return $this->conn;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (id, event_id, status) VALUES (:id, :event_id, :status)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':event_id', $this->event_id);
        $stmt->bindParam(':status', $this->status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function generateTickets($eventId, $newCapacity) {
        $prefix = 'A';
        $number = 1;
        $conn = $this->getConnection();

        // Get the current number of tickets
        $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE event_id = :event_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':event_id', $eventId);
        $stmt->execute();
        $currentCapacity = $stmt->fetchColumn();

        if ($newCapacity > $currentCapacity) {
            // Generate new tickets if the capacity is increased
            for ($i = $currentCapacity + 1; $i <= $newCapacity; $i++) {
                do {
                    if ($number > 99999) {
                        $prefix++;
                        $number = 0;
                    }
                    $ticketId = $prefix . str_pad($number, 5, '0', STR_PAD_LEFT);
                    $number++;

                    // Check if the ticket ID already exists
                    $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE id = :id";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':id', $ticketId);
                    $stmt->execute();
                    $count = $stmt->fetchColumn();
                } while ($count > 0);

                $this->event_id = $eventId;
                $this->id = $ticketId;
                $this->status = 'available';
                $this->create();
            }
        } elseif ($newCapacity < $currentCapacity) {
            // Delete excess tickets if the capacity is decreased
            $limit = $currentCapacity - $newCapacity;
            $query = "DELETE FROM " . $this->table_name . " WHERE event_id = :event_id AND status = 'available' ORDER BY id DESC LIMIT :limit";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':event_id', $eventId);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    public function countSoldTickets($eventId) {
        $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE event_id = :event_id AND status = 'sold'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':event_id', $eventId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>