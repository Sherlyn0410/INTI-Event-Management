<?php
class Purchase {
    private $conn;
    private $table_name = "purchase";

    public $id;
    public $user_id;
    public $ticket_id;
    public $purchaseDateTime;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fetch purchases by user ID
    public function readByUser($user_id) {
        $query = "SELECT p.id, p.user_id, p.ticket_id, p.purchaseDateTime, p.status, t.event_id, e.name as event_name, e.image as event_image, e.startdatetime, e.endtime, e.campus_id, c.name as campus_name, e.status as event_status
                  FROM " . $this->table_name . " p
                  LEFT JOIN ticket t ON p.ticket_id = t.id
                  LEFT JOIN event e ON t.event_id = e.id
                  LEFT JOIN campus c ON e.campus_id = c.id
                  WHERE p.user_id = ?
                  AND NOT (p.status = 'pending' AND e.status = 'completed')
                  ORDER BY e.startdatetime ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();

        return $stmt;
    }
}
?>