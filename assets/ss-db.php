<?php

/**
 * SuperSeater Database Class
 * 
 */
class ssdb {

    var $latest_result;
    
    public $num_rows;
    
    public $result;
    
    /*
     * Users Table
     */
    public $users = 'users';
    
    public $restaurants = 'restaurants';
    
    public $media = 'media';
    
    public $schedule = 'schedule';

    /**
     * This connects to the database
     *
     * @param string $user MySQL database user
     * @param string $password MySQL database password
     * @param string $name MySQL database name
     * @param string $host MySQL database host
     */
    function __construct($user, $password, $name, $host) {


        /* Set up the variables, and initiallize the connection */
        $this->dbuser = $user;
        $this->dbpassword = $password;
        $this->dbname = $name;
        $this->dbhost = $host;
        $this->db_connect();
    }

    /**
     * destructor to make sure db object destructed correctly
     * @return boolean if properly destructs
     */
    function __destruct() {
        return true;
    }

    /**
     * Connect to and select database.
     *
     *
     * @return bool True with a successful connection, false on failure.
     */
    function db_connect() {

        $this->dbHandle = mysqli_init();

        $this->dbHandle->real_connect($this->dbhost, $this->dbuser, $this->dbpassword, $this->dbname);

        if ($this->dbHandle->connect_errno)
            $this->dbHandle = null;

        if ($this->dbHandle) {
            $this->isConnected = true;
            $this->isReady = true;
            return true;
        }

        return false;
    }

    public function query($query) {
        $this->latest_result = array();
        $this->_run_query($query);
        
        $num_rows = 0;
        while ($row = @mysqli_fetch_object($this->result)) {
            
            $this->latest_result[$num_rows] = $row;
            $num_rows++;
        }

        $this->num_rows = $num_rows;

        return $this->num_rows;
    }

    private function _run_query($query){
 
        $this->result = @mysqli_query(  $this->dbHandle, $query );
        
    }

    /**
     * Check that the connection to the database is still up.
     *
     * @return bool True if the connection is up.
     */
    function check_connection($reportErrors = false) {

        if ($this->dbHandle->ping()) {

            if ($reportErrors)
                echo "Database connection is working";

            return true;
        }else {
            if ($reportErrors)
                echo "Database connection is broken :(";
            return false;
        }
    }

    public function get_results($query = null ) {


        if ($query) {
            $this->query($query);
        } else {
            return null;
        }

        if($this->num_rows)
            return $this->latest_result;
        else 
            return false;
    
    }
    
    public function get_row($query = null) {
        
        if ($query) {
            
            $this->query($query);
            
        } else {
            
            return null;
            
        }
     
        if($this->num_rows == 0){
            return false;
        }else {
        return $this->latest_result[0];
        }
        
    }

    public function insert($table, $data) {
        return $this->_insert($table, $data);
    }

    function _insert($table, $data) {
       
 

        if (!$data) {
            return false;
        }

        $fields = '`' . implode('`, `', array_keys($data)) . '`';
        $formats = implode(', ', $data );

        $sql = "INSERT INTO `$table` ($fields) VALUES ($formats)";
      
        //updated version
        $this->result = @mysqli_query(  $this->dbHandle, $sql  );
        return $this->dbHandle->insert_id;
        
        //return $this->_run_query($sql);
    }
    
    
        public function update($table, $data , $ID , $keys) {
        return $this->_update($table, $data , $ID , $keys);
    }

    function _update($table, $data, $ID , $keys ) {
       
        
        $updates = array();
        foreach($data as $key => $item){
            $update = "`$key` = VALUES(`$key`)";
            array_push($updates, $update);
        }
        
        $data["ID"] = $ID; 
        if ($keys) {
            foreach ($keys as $key => $value) {
                $data[$key] = $value;
            }
        }


        if (!$data) {
            return false;
        }

        $fields = '`' . implode('`, `', array_keys($data)) . '`';
        //$formats = implode(', ', $data );
        $formats = implode(', ', $data );
        
        $update_comands = implode(', ' , $updates );
        
 
        

        
        $sql = "INSERT INTO `$table` ($fields) VALUES ($formats) ON DUPLICATE KEY UPDATE $update_comands";
        //var_dump($sql);
        return $this->_run_query($sql);
    }

}
