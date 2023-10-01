<?php
    namespace wsos\database\query;

    class DBLParser {

        private $table = [
            [],
            [],
            [],

        ];

        function __construct() {

        }

        public function tokenizer($text) {
            preg_match_all("([^()=!><|&\s]+|==|!=|\(|\)|&&|\|\||<=|>=|<|>)", $text, $tokens, PREG_PATTERN_ORDER);
            return $tokens[0];
        }

        public function parser($tokens) {
            $op     = [
                "op" => null,
                "p1" => null,
                "p2" => null
            ];

            $emptyOp = $op;

            $stack = new \wsos\structs\vector();
            $ops   = new \wsos\structs\vector();
            foreach ($tokens as $token) {

                if ($token == "(") {
                    $stack->push($op);
                    $op   = $emptyOp; 
                
                } else if ($token == ")") {
                    $op = $stack->pop();

                    if      (is_null($op["p1"])) $op["p1"] = "";
                    else if (is_null($op["p2"])) $op["p2"] = "";

                } else if (in_array($token, ["==", "!=", "<=", ">=", ">", "<", "||", "&&"])) {
                    $op["op"] = $token;
                } else {
                    if      (is_null($op["p1"])) $op["p1"] = $token;
                    else if (is_null($op["p2"])) $op["p2"] = $token;
                }

                if (!is_null($op["p1"]) && !is_null($op["p2"])) {
                    $ops->push($op);
                    $op = $emptyOp;

                    $op["p1"] = "";
                }
            }

            return $ops;
        }

        public function parse($text) {
            return $this->parser($this->tokenizer($text));
        }

    }