<?php
/*
* Bismillah
* Dibuat Oleh Alifa Izzan 2015
* izzan@smalane.com
*/
class database
{

    protected $dbJob;

    public function __construct($DbName,$DbUser, $DbPass, $DbHost)
    {
        try
        {
            $this->dbJob = new PDO( "mysql:host={$DbHost};dbname={$DbName}",
                $DbUser,
                $DbPass);
            $this->dbJob->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            return ['0'=>"Connection Error"];
        }
    }

    public function add($table, $models, $data)
    {
        $template = $this->model($models);
        $stmt = $this->dbJob->prepare('INSERT INTO {$table} {$template[datamodel]} VALUES {$template[databinding]}');
        
        for ($i = 0, $c = count($data);$i<$c;$i++)
        {
            $stmt->bindParam($template['rawbinding'][$i], $data[$template['rawmodel'][$i]]);
        }

        $stmt->execute();
    }

    public function get($table)
    {
        $myarray = array();
        $stmt = $this->dbJob->prepare('SELECT * FROM {$table}');
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            array_push($myarray, $row);
        }
        return $myarray;
    }

    public function count($table)
    {
        $stmt = $this->dbJob->prepare('SELECT * FROM {$table}');
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function count($table, $keyname, $key)
    {
        $keybinding = ":".$keyname;
        $stmt = $this->dbJob->prepare('SELECT * FROM {$table} WHERE {$keyname} = {$keybinding}' );
        $stmt->bindParam($keybinding,$key);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function searchCount($table, $keyname, $key)
    {
        $keybinding = ":".$keyname;
        $stmt = $this->dbJob->prepare('SELECT * FROM {$table} WHERE {$keyname} LIKE {$keybinding}' );
        $stmt->bindParam($keybinding,$key);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function get($table, $keyname, $key)
    {
        $myarray = array();
        $keybinding = ":".$keyname;
        $stmt = $this->dbJob->prepare('SELECT * FROM {$table} WHERE {$keyname} = {$keybinding}' );
        $stmt->bindParam($keybinding,$key);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            array_push($myarray, $row);
        }
        return $myarray;
    }
    
    public function search($table, $keyname, $key)
    {
        $myarray = array();
        $keybinding = ":".$keyname;
        $stmt = $this->dbJob->prepare('SELECT * FROM {$table} WHERE {$keyname} LIKE {$keybinding}' );
        $stmt->bindParam($keybinding,$key);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            array_push($myarray, $row);
        }
        return $myarray;
    }

    public function update($table, $models, $data, $keyname, $key)
    {
        $template = $this->model($models);
        $keybinding = ":".$keyname;
        $newStr = array();
        
        for ($i = 0, $c = count($data);$i<$c;$i++)
        {
           $newStr[$i] = $template['datamodel'][$i]." = ".$template['databinding'][$i];

        }

        $stmt = $this->dbJob->prepare('UPDATE {$table} SET {implode(",", $newStr)} WHERE {$keyname} = {$keybinding}');
        for ($i = 0, $c = count($data);$i<$c;$i++)
        {
            $stmt->bindParam($template['rawbinding'][$i], $data[$template['rawmodel'][$i]]);
        }
        $stmt->bindParam($keybinding,$key);
        $stmt->execute();
    }

    public function delete($table, $keyname, $key)
    {
         $keybinding = ":".$keyname;
         $stmt = $this->dbJob->prepare('DELETE FROM {$table} WHERE {$keyname} = {$keybinding}');
         $stmt->bindParam($keybinding,$key);
         $stmt->execute();
    }

    private function model($models)
    {
        $myarray = array();
        $storage = explode(",", $models);
        
        array_push($myarray, 'datamodel' => "(".$models.")");
        array_push($myarray, 'rawmodel' => $storage);

        for ($i = 0, $c = count($storage); $i<$c; $i++)
        {
           $storage[i] = ":".$storage[i];
        }

        array_push($myarray, 'databinding' => "(".implode(",", $storage).")");
        array_push($myarray, 'rawbinding' => $storage);

        return $myarray;
    }
}
?>