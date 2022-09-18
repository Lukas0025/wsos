<?php
        namespace wsos\templates;
    
        class multiLoader {
            private $staticsDir;
            private $loaders;

            function __construct($templatesDir = "", $staticsDir = "") {
                $this->loaders     = new \wsos\structs\vector();
                $this->loaders->append([
                    "file"   => null,
                    "loader" => new loader($templatesDir)
                ]);

                $this->staticsDir   = $staticsDir;
            }

            public function load($files) {
                foreach ($files as $file) {
                    $this->loaders->append([
                        "file"   => $file,
                        "loader" => $this->loaders->first()["loader"]->newInDir()
                    ]);
                    
                    $this->loaders->last()["loader"]->load($file);
                }
            }

            public function loadHtml($html, $file) {
                $this->loaders->append([
                    "file"   => $file,
                    "loader" => $this->loaders->first()["loader"]->newInDir()
                ]);

                $this->loaders->last()["loader"]->loadHtml($html);
            }

            public function render($binding = []) {
                foreach ($this->loaders->values as $loader) {
                    if (is_null($loader["file"])) {
                        continue;
                    }

                    $loader["loader"]->render($binding);
                }
            }

            public function getHtml() {
                $htmls = new \wsos\structs\vector();

                foreach ($this->loaders->values as $loader) {
                    if (is_null($loader["file"])) {
                        continue;
                    }

                    $htmls->append($loader["loader"]->getHtml());
                }

                return $htmls;
            }

            public function saveHtml() {
                foreach ($this->loaders->values as $loader) {
                    if (is_null($loader["file"])) {
                        continue;
                    }

                    $loader["loader"]->saveHtml("{$this->staticsDir}/{$loader["file"]}");
                }
            }
        }
?>