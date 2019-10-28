<?php

class Database
{
    private $host = "localhost";
    private $user = "root";
    //private $user = "bsdbvrhh_work_management_user";
   // private $db = "bsdbvrhh_work_management_user";
    //private $pass = "^j6FWqDqs#EZ";
    private $db = "db_work_management";
    private $pass = "";
    public  $con = "";
    private $permission;

    public function __construct()
    {
        $this->con = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->pass);
    }

    public function Insert_data($table_name, $form_data)
    {
        $fields = array_keys($form_data);

        $sql = "INSERT INTO " . $table_name . " (`" . implode('`,`', $fields) . "`) VALUES(:" . implode(",:", $fields) . ")";

        $prepare = array();
        foreach ($fields as $field){
            $prepare[':'.$field] = $form_data[$field];
        }
        $q = $this->con->prepare($sql);
        $q->execute($form_data) or die(print_r($q->errorInfo()));

        return $this->con->lastInsertId();
    }

    // View All Data Function
    public function view_all($table_name)
    {
        $data = array();
        $sql = "SELECT * FROM $table_name";
        $q = $this->con->prepare($sql);
        $q->execute();

        while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    // View All Ordered By  Data Function
    public function view_all_ordered_by($table_name, $order)
    {
        $data = array();
        $sql = "SELECT * FROM $table_name ORDER BY $order";
        $q = $this->con->prepare($sql);
        $q->execute();
        while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

// View All Data Condition wise Function
    public function view_all_by_cond($table_name, $where_cond)
    {
        $data = array();
        $sql = "SELECT * FROM $table_name WHERE $where_cond";
        $q = $this->con->prepare($sql);
        $q->execute();

        while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    // Details Data View Condition Wise Function
    public function details_by_cond($table_name, $where_cond)
    {
        $sql = "SELECT * FROM $table_name WHERE $where_cond";
        $q = $this->con->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data;
    }


// Update Data Function

    function Update_data($table_name, $form_data, $where_clause = '')
    {
        $whereSQL = '';
        if (!empty($where_clause)) {
            if (substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
                $whereSQL = " WHERE " . $where_clause;
            } else {
                $whereSQL = " " . trim($where_clause);
            }
        }

        $sql = "UPDATE " . $table_name . " SET ";

        $sets = array();
        foreach ($form_data as $column => $value) {
            $sets[] = "`" . $column . "` = :" . $column . "";
        }

        $sql .= implode(', ', $sets);
        $sql .= $whereSQL;

        $fields = array_keys($form_data);
        $prepare = array();
        foreach ($fields as $field){
            $prepare[':'.$field] = $form_data[$field];
        }

        $q = $this->con->prepare($sql);

        return $q->execute($prepare) or die(print_r($q->errorInfo()));
    }

    //only get total qty of a column.
    public function get_sum_data($table_name, $sum_of_field, $where_cond)
    {
        $sql = "SELECT SUM($sum_of_field) as total FROM $table_name WHERE $where_cond";
        $q = $this->con->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));
        $data = $q->fetch(PDO::FETCH_ASSOC);

        return isset($data['total']) ? $data['total'] : 0;
    }
//    only get total qty a column without condition
    public function get_sum_data_without_condition($table_name, $sum_of_field)
    {
        $sql = "SELECT SUM($sum_of_field) as total FROM $table_name";
        $q = $this->con->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));
        $data = $q->fetch(PDO::FETCH_ASSOC);

        return isset($data['total']) ? $data['total'] : 0;
    }

// Delete Data Function
    function Delete_data($table_name, $where_cond)
    {
        $sql = "DELETE FROM $table_name WHERE $where_cond";
        $q = $this->con->prepare($sql);

        return $q->execute();
    }

    public function Total_Count($table_name, $where_cond)
    {
        $sql_login = "SELECT * FROM " . $table_name . " WHERE $where_cond";
        $login = $this->con->prepare($sql_login);
        $login->execute();
        $total = $login->rowCount();

        return $total;

    }

    public function get_avg_data($table_name, $avg_of_field, $where_cond)
    {
        $sql = "SELECT AVG($avg_of_field) as total FROM $table_name WHERE $where_cond";
        $q = $this->con->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return isset($data['total']) ? $data['total'] : 0;
    }

    public function details_selected_field_by_cond($table_name, $selected_field, $where_cond)
    {
        $sql = "SELECT $selected_field FROM $table_name WHERE $where_cond";
        $q = $this->con->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function raw_sql($raw_sql)
    {
        $data = array();
        $sql = "SELECT $raw_sql";
        $q = $this->con->prepare($sql);
        $q->execute();

        while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function raw_sql_single($raw_sql)
    {
        $sql = "SELECT $raw_sql";
        $q = $this->con->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    
    // View All Data Condition wise Function with left join table
    public function view_selected_field_by_cond_left_join($table_name1, $table_name2, $table1_col_matched, $table2_col_matched, $table1_col, $table2_col, $where_cond = null)
    {
        $data = array();
        if (!empty($where_cond)) {
            $sql = "SELECT $table1_col, $table_name2.$table2_col FROM $table_name1 LEFT JOIN $table_name2 ON $table_name1.$table1_col_matched = $table_name2.$table2_col_matched WHERE $where_cond";
        } else {
            $sql = "SELECT $table1_col, $table_name2.$table2_col FROM $table_name1 LEFT JOIN $table_name2 ON $table_name1.$table1_col_matched = $table_name2.$table2_col_matched";
        }
        $q = $this->con->prepare($sql);
        $q->execute();

        while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function view_selected_field_by_cond($table_name, $selected_field, $where_cond)
    {
        $data = array();
        $sql = "SELECT $selected_field FROM $table_name WHERE $where_cond";
        $q = $this->con->prepare($sql);
        $q->execute();

        while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }


}
