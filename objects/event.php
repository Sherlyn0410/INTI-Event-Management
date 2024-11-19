<?php
class Event{
  
    // database connection and table name
    private $conn;
    private $table_name = "event";
  
    // object properties
    public $id;
    public $name;
    public $image;
    public $description;
    public $startdatetime;
    public $endtime;
    public $campus_id;
    public $campus_name;
    public $capacity;
    public $status;
    public $user_id;
    public $user_name;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read events
    function read(){
    
        // select all query
        $query = "SELECT
                    c.name as campus_name, u.name as user_name, e.id, e.name, e.image, e.description, e.startdatetime, e.endtime, e.campus_id, e.capacity, e.status, e.user_id
                FROM
                    " . $this->table_name . " e
                    LEFT JOIN
                        campus c
                            ON e.campus_id = c.id
                    LEFT JOIN
                        user u
                            ON e.user_id = u.id
                ORDER BY
                    e.startdatetime ASC";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // create event
    function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name, image=:image, description=:description, startdatetime=:startdatetime, endtime=:endtime, campus_id=:campus_id, capacity=:capacity, status=:status, user_id=:user_id";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->image=htmlspecialchars(strip_tags($this->image));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->startdatetime=htmlspecialchars(strip_tags($this->startdatetime));
        $this->endtime=htmlspecialchars(strip_tags($this->endtime));
        $this->campus_id=htmlspecialchars(strip_tags($this->campus_id));
        $this->capacity=htmlspecialchars(strip_tags($this->capacity));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
    
        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":startdatetime", $this->startdatetime);
        $stmt->bindParam(":endtime", $this->endtime);
        $stmt->bindParam(":campus_id", $this->campus_id);
        $stmt->bindParam(":capacity", $this->capacity);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":user_id", $this->user_id);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // used when filling up the update event form
    function readOne(){
    
        // query to read single record
        $query = "SELECT
                    c.name as campus_name, e.id, e.name, e.image, e.description, e.startdatetime, e.endtime, e.campus_id, e.capacity, e.status, e.user_id, u.name as user_name
                FROM
                    " . $this->table_name . " e
                    LEFT JOIN
                        campus c
                            ON e.campus_id = c.id
                    LEFT JOIN
                        user u
                            ON e.user_id = u.id
                WHERE
                    e.id = ?
                LIMIT
                    0,1";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // bind id of event to be updated
        $stmt->bindParam(1, $this->id);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->name = $row['name'];
        $this->image = $row['image'];
        $this->description = $row['description'];
        $this->startdatetime = $row['startdatetime'];
        $this->endtime = $row['endtime'];
        $this->campus_id = $row['campus_id'];
        $this->campus_name = $row['campus_name'];
        $this->capacity = $row['capacity'];
        $this->status = $row['status'];
        $this->user_id = $row['user_id'];
        $this->user_name = $row['user_name'];
    }

    // update the event
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name = :name,
                    image = :image,
                    description = :description,
                    startdatetime = :startdatetime,
                    endtime = :endtime,
                    campus_id = :campus_id,
                    capacity = :capacity,
                    status = :status,
                    user_id = :user_id
                WHERE
                    id = :id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->image=htmlspecialchars(strip_tags($this->image));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->startdatetime=htmlspecialchars(strip_tags($this->startdatetime));
        $this->endtime=htmlspecialchars(strip_tags($this->endtime));
        $this->campus_id=htmlspecialchars(strip_tags($this->campus_id));
        $this->capacity=htmlspecialchars(strip_tags($this->capacity));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));

        // explicitly set status to "Published"
        $this->status = "Published";
    
        // bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':startdatetime', $this->startdatetime);
        $stmt->bindParam(':endtime', $this->endtime);
        $stmt->bindParam(':campus_id', $this->campus_id);
        $stmt->bindParam(':capacity', $this->capacity);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':user_id', $this->user_id);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete the event
    function delete(){
    
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind id of record to delete
        $stmt->bindParam(1, $this->id);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    
    // search events
    function search($name, $campus){
        // select all query with search condition
        $query = "SELECT
                    c.name as campus_name, u.name as user_name, e.id, e.name, e.image, e.description, e.startdatetime, e.endtime, e.campus_id, e.capacity, e.status, e.user_id
                FROM
                    " . $this->table_name . " e
                    LEFT JOIN
                        campus c
                            ON e.campus_id = c.id
                    LEFT JOIN
                        user u
                            ON e.user_id = u.id
                WHERE
                    e.name LIKE ?";

        // add campus condition if campus is specified
        if ($campus != '0' && $campus != '') {
            $query .= " AND e.campus_id = ?";
        }

        $query .= " ORDER BY e.startdatetime ASC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $name = htmlspecialchars(strip_tags($name));
        $name = "%{$name}%";

        // bind parameters
        $stmt->bindParam(1, $name);
        if ($campus != '0' && $campus != '') {
            $stmt->bindParam(2, $campus);
        }

        // execute query
        $stmt->execute();
        return $stmt;
    }

    // read event with pagination
    public function readPaging($from_record_num, $records_per_page){
    
        // select query
        $query = "SELECT
                    c.name as campus_name, u.name as user_name, e.id, e.name, e.image, e.description, e.startdatetime, e.endtime, e.campus_id, e.capacity, e.status, e.user_id
                FROM
                    " . $this->table_name . " e
                    LEFT JOIN
                        campus c
                            ON e.campus_id = c.id
                    LEFT JOIN
                        user u
                            ON e.user_id = u.id
                ORDER BY e.startdatetime ASC
                LIMIT ?, ?";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind variable values
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
    
        // execute query
        $stmt->execute();
    
        // return values from database
        return $stmt;
    }

    // read latest events
    function readLatest($limit) {
        // select query to get the latest events
        $query = "SELECT
                    c.name as campus_name, u.name as user_name, e.id, e.name, e.image, e.description, e.startdatetime, e.endtime, e.campus_id, e.capacity, e.status, e.user_id
                FROM
                    " . $this->table_name . " e
                    LEFT JOIN
                        campus c
                            ON e.campus_id = c.id
                    LEFT JOIN
                        user u
                            ON e.user_id = u.id
                ORDER BY
                    e.id DESC
                LIMIT ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind limit parameter
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);

        // execute query
        $stmt->execute();
        return $stmt;
    }

    // read random events
    function readRandom($limit) {
        // select query to get random events
        $query = "SELECT
                    c.name as campus_name, u.name as user_name, e.id, e.name, e.image, e.description, e.startdatetime, e.endtime, e.campus_id, e.capacity, e.status, e.user_id
                FROM
                    " . $this->table_name . " e
                    LEFT JOIN
                        campus c
                            ON e.campus_id = c.id
                    LEFT JOIN
                        user u
                            ON e.user_id = u.id
                ORDER BY
                    RAND()
                LIMIT ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind limit parameter
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);

        // execute query
        $stmt->execute();
        return $stmt;
    }

    // read events by user
    public function readByUser($user_id) {
        $query = "SELECT
                    c.name as campus_name, u.name as user_name, e.id, e.name, e.image, e.description, e.startdatetime, e.endtime, e.campus_id, e.capacity, e.status, e.user_id
                FROM
                    " . $this->table_name . " e
                    LEFT JOIN
                        campus c
                            ON e.campus_id = c.id
                    LEFT JOIN
                        user u
                            ON e.user_id = u.id
                WHERE
                    e.user_id = ?
                ORDER BY
                    e.startdatetime DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();

        return $stmt;
    }

    // used for paging event
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row['total_rows'];
    }
}
?>