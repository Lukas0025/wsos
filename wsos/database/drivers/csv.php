<?php
    /**
     * This file contains help functions for work with database IDs
     */

    namespace wsos\database\drivers;
    
    class csv {
        
        public $dir;
        public $tables;

        function __construct($dir, $separator = ";") {
            $this->dir = $dir;
            $this->tables = [];
            $this->separator = $separator;
        }

        public function table($name) {
            return new table($name, $this);
        }

        public function &getTable($name) {
            if (array_key_exists($name, $this->tables)) return $this->tables[$name];

            $content     = "";

            if (file_exists($this->dir . "/{$name}.csv")) {
                $content = file_get_contents($this->dir . "/{$name}.csv");
            }

            $this->tables[$name] = $this->parseCSV($content);

            return $this->tables[$name];
        }

        public function update($name) {
            $file = fopen($this->dir . "/{$name}.csv", "w");
            fwrite($file, $this->getCSV($this->tables[$name]));
            fclose($file);
        }

        public function getCSV($table) {
            $csv = "";

            $ids = array_keys($table);

            if (count($ids) == 0) return $csv;
            if (count(array_keys($table[$ids[0]])) == 0) return $csv;

            // get header
            $header = [];
            foreach ($table[$ids[0]] as $key => $value) {
                $header[] = $key;
                $csv     .= "{$key}{$this->separator}";                
            }

            $csv = substr_replace($csv, "\n", -1); 

            //get content
            foreach ($table as $row) {
                foreach ($header as $col) {
                    $csv .= "{$row[$col]}{$this->separator}";   
                }   
                
                $csv = substr_replace($csv, "\n", -1); 
            }

            return  substr_replace($csv, "", -1);

        }

        public function parseCSV($content) {
            $table = [];
            $rows  = explode("\n", $content);

            if (count($rows) == 0) return $table;

            //get header
            $header = explode($this->separator, array_shift($rows));

            foreach ($rows as $row) {
                $cols = explode($this->separator, $row);
                $array = [];

                foreach ($cols as $index => $col) {
                    $array[$header[$index]] = $col;
                }

                $table[$array['id']] = $array;

            }

            return $table;
        }
    }

    class table {
        private $name;
        private $driver;
        private $table;

        function __construct($name, $driver) {
            $this->driver = $driver;
            $this->name   = $name;
            $this->table  = &$this->driver->getTable($name);
        }

        public function createUpdate($obj) {
            $array = [];

            foreach ($obj as $name => $values) {
                $array[$name] = $values['value'];
            }

            $this->table[$obj['id']['value']] = $array;

            $this->driver->update($this->name);
        }

        public function find($col, $value) {

            foreach ($this->table as $row) {
                if ($row[$col] == $value) {
                    return $row;
                }
            }

            return null;

        }

        public function count($cmd, $binding, $abstractLayer, $order = null, $limit = null) {
            return count($this->query($cmd, $binding, $abstractLayer, $order, $limit));
        }

        public function getBindings($col, $row, $abstractLayer) {
            if ($col === true || $col == false) return $col;
            
            $col   = str_replace(["\"", "'"], "", $col); //string escape
            $parts = explode(".", $col);
            
            // init abstract layer
            $vol = new $abstractLayer();
            $vol->id->set($row["id"]);
            $vol->fetch();

            //transmitter.station.id == ?
            foreach ($parts as $part) {
                $context = get_object_vars($vol);

                if (array_key_exists($part, $context)) {
                    if (!($context[$part] instanceof \wsos\database\types\reference)) { //not reference
                        $vol = $context[$part]->value;
                    } else {
                        $vol = $context[$part]->get();
                    }
                }
            }

            return is_object($vol) ? $col : $vol;
        }

        public function query($cmd, $binding, $abstractLayer, $order = null, $limit = null) {
            $keys = [];

            //add bindings
            foreach ($binding as $value) {
                $pos = strpos($cmd, "?");

                if ($pos !== false) {
                    $cmd = substr_replace($cmd, $value, $pos, 1);
                }

            }

            $parser = new \wsos\database\query\DBLParser();
            $ops    = $parser->parse($cmd)->values;

            foreach ($this->table as $key => $row) {
                $stack  = new \wsos\structs\vector();
                $stack->push(true); // empty is valid                

                foreach($ops as $op) {

                    if ($op["p1"] == "") $op["p1"] = $stack->pop();
                    if ($op["p2"] == "") $op["p2"] = $stack->pop();

                    //do bindings
                    $op["p1"] = $this->getBindings($op["p1"], $row, $abstractLayer);
                    $op["p2"] = $this->getBindings($op["p2"], $row, $abstractLayer);

                    if ($op["op"] == "==") $stack->push($op["p1"] == $op["p2"]);
                    if ($op["op"] == "!=") $stack->push($op["p1"] <> $op["p2"]);
                    if ($op["op"] == ">" ) $stack->push($op["p1"] >  $op["p2"]);
                    if ($op["op"] == "<" ) $stack->push($op["p1"] <  $op["p2"]);
                    if ($op["op"] == ">=") $stack->push($op["p1"] >= $op["p2"]);
                    if ($op["op"] == "<=") $stack->push($op["p1"] <= $op["p2"]);
                    if ($op["op"] == "&&") $stack->push($op["p1"] && $op["p2"]);
                    if ($op["op"] == "||") $stack->push($op["p1"] || $op["p2"]);

                }

                if ($stack->pop()) {
                    $keys[] = $key;
                }
            }

            // order array
            if (!is_null($order)) {
                //parse ASC  {col}
                //      DESC {col}

                $order = explode(" ", $order);

                $GLOBALS["db_csv_col"]   = $order[1];
                $GLOBALS["db_csv_table"] = &$this->table;

                if ($order[0] == "ASC") {
                    usort($keys, function ($a, $b) {
                        return $GLOBALS["db_csv_table"][$a][$GLOBALS["db_csv_col"]] - $GLOBALS["db_csv_table"][$b][$GLOBALS["db_csv_col"]];
                    });
                } elseif ($order[0] == "DESC") {
                    usort($keys, function ($a, $b) {
                        return $GLOBALS["db_csv_table"][$b][$GLOBALS["db_csv_col"]] - $GLOBALS["db_csv_table"][$a][$GLOBALS["db_csv_col"]];
                    });
                }

                $GLOBALS["db_csv_col"]   = null;
            }

            //limit array
            if (!is_null($limit)) {
                $keys = array_slice($keys, 0, $limit);
            }

            return $keys;
        }

        public function get($id) {
            return $this->table[$id];
        }
    }