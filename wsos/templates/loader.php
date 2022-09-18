<?php
        namespace wsos\templates;
    
        class loader {
            private $dir;
            private $html;
            private $renderd;

            function __construct($dir = "") {
                $this->dir     = $dir;
                $this->renderd = false;
            }

            public function load($file) {
                $this->html    = file_get_contents("{$this->dir}/{$file}");
                $this->renderd = false;
            }

            public function loadHtml($html) {
                $this->html    = $html;
                $this->renderd = false;
            }

            public function render($binding = []) {
                preg_match_all('/{%\s[^{}%]*\s%}/', $this->html, $matches, PREG_PATTERN_ORDER);
                $commands = array_unique($matches[0]);

                $parser = new parser($this->newInDir()); 
                $parser->addBinding($binding);

                foreach ($commands as $command) {
                    $this->html = str_replace($command, $parser->exec($command), $this->html);
                }

                $this->html    = $this->html;
                $this->renderd = true;
            }

            public function newInDir() {
                return new loader($this->dir);
            }

            public function show() {
                if (!$this->renderd) {
                    return false;
                }

                echo $this->html;
                die();
            }

            public function getHtml() {
                return $this->html;
            }

            public function saveHtml($file) {
                file_put_contents($file, $this->html);
            }
        }
?>