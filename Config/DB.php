<?php
namespace Config;

include ("connection.php");

class DB
{
    private $website ;
    public $table;
    public $table_id = 'id';
    public $selects =  '*' ;
    public $select =  NULL ;
    public $wheres  = NULL ;
    public $orderBy = NULL ;
    public $groupBy = NULL ;
    public $join    = NULL ;

    public function __construct()
    {
        global $website;
        $this->website = $website;
    }

    /**
     * Set var table
     *
     *@param string $table
     *@return $this
     */
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Get var table
     *
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Set var table_id
     *
     *@param string $table_id
     *@return $this
     */
    public function setTableId($table_id)
    {
        $this->table_id = $table_id;
        return $this;
    }

    /**
     * Get var table_id
     *
     * @return mixed
     */
    public function getTableId()
    {
        return $this->table_id;
    }

    /**
     * Set the Selects
     *
     * @param mixed $binding
     * @return $this
     */
    public function selects(...$binding)
    {
        if (is_array($binding) && is_null($binding[1]))
            $this->selects = implode(',',$binding[0]);
        else
            $this->selects = implode(',',$binding);
        return $this;
    }

    /**
     * Set the Selects For given by modal
     *
     * @param mixed $select
     * @return $this
     */
    public function select($select = NULL)
    {
        if (!is_null($select))
            $this->selects($select);
        else
            $this->selects($this->select);
        return $this;
    }

    /**
     * Set the WHERE
     *
     * @param mixed $binding
     * @return $this
     */
    public function where(...$binding)
    {
        $this->wheres = ' WHERE ';
        if (is_array($binding) && is_null($binding[1])){
            if (!is_array($binding[0])){
                $this->wheres .= $this->table.'.'.$this->table_id.' = '.$binding[0];
            }else{
                foreach ($binding[0] as $key => $value)
                    $this->wheres .= $key.' = '.$value.' AND ';

                $this->wheres = rtrim($this->wheres,'AND ');
            }
        }else{
            if (count($binding) == 2)
                $binding = array_merge(array_slice($binding, 0, 1), ['='], array_slice($binding, 1));
            $this->wheres .= implode(' ',$binding);
        }
        return $this;
    }

    /**
     * Set the ORDER BY
     *
     * @param string $column
     * @param string $order
     * @return $this
     */
    public function orderBy($column, $order = 'ASC')
    {
        $this->orderBy = " ORDER BY $column $order ";
        return $this;
    }

    /**
     * Set the GROUP BY
     *
     * @param string $column
     * @return $this
     */
    public function groupBy($column)
    {
        $this->orderBy = " GROUP BY $column ";
        return $this;
    }

    /**
     * Set the GROUP BY
     *
     * @param mixed $binding
     * @return $this
     */
    public function join(...$binding)
    {
        $this->join = " ".$binding[0]['join']." JOIN " . $binding[0]['table'] ." ON ".$binding[0]['on'];
        return $this;
    }

    /**
     * Set the query that will be executed
     *
     *@return string
     */
    private function query()
    {
        return "SELECT ".$this->selects." FROM ".$this->getTable().$this->join.$this->wheres.$this->groupBy.$this->orderBy;
    }

    /**
     * Executed the query
     *
     *@param string $query
     *@return mixed
     */
    public function executed($query = NULL)
    {
        if (!is_null($query))
            return mysqli_query( $this->website, $query );
         return mysqli_query( $this->website, $this->query() );
    }

    /**
     * Fetch assoc
     *
     *@return mixed
     */
    public function get()
    {
        $result = mysqli_fetch_assoc( $this->executed() );
        $this->reset();
        return $result;
    }
    
    /**
     * Fetch all
     *
     *@return mixed
     */
    public function getAll()
    {
        $result = mysqli_fetch_all( $this->executed(), MYSQLI_ASSOC );
        $this->reset();
        return $result;
    }

    /**
     * Insert
     *
     * @param mixed $binding
     * @return $this
     */
    public function insert(...$binding)
    {
        $query = "INSERT INTO ".$this->getTable()." SET ";

        foreach ($binding[0] as $key => $value)
            $query .= $key." = '".$value."' , ";

        $query = rtrim($query,', ');
        $this->executed($query);
        $this->reset();
        return $this;
    }

    /**
     * Update
     *
     * @param mixed $binding
     */
    public function update(...$binding)
    {
        $query = "UPDATE ".$this->getTable()." SET ";

        foreach ($binding[0] as $key => $value)
            $query .= $key." = '".$value."' , ";

        $query = rtrim($query,', ');
        $query .= $this->wheres;

        $this->executed($query);
        $this->reset();
    }

    /**
     * Delete
     *
     */
    public function remove()
    {
        $query = "DELETE FROM " . $this->getTable() . $this->wheres;

        $this->executed($query);
        $this->reset();
    }

    /**
     * Get number of rows
     *
     * @return int
     */
    public function rowCount()
    {
        $result = mysqli_num_rows( $this->executed() );
        $this->reset();
        return $result;
    }

    /**
     * Get last insert id
     *
     * @return int
     */
    public function lastID()
    {
        return mysqli_insert_id($this->website);
    }

    /**
     * Reset all variables
     */
    private function reset()
    {
        $this->table    = NULL ;
        $this->selects  = '*'  ;
        $this->table_id = 'id' ;
        $this->select   = NULL ;
        $this->wheres   = NULL ;
        $this->orderBy  = NULL ;
        $this->groupBy  = NULL ;
        $this->join     = NULL ;
    }
}
