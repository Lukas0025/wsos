<?php
/**
 * Base databse table
 */

namespace wsos\router\basic;

class manager {
    private $p404;
    private $sites = [];
    private $args  = [];

    function __construct($sites = []) {
        $this->sites = $sites;
    }

    public function getArgs() {
        return $this->args;
    }

    public function route($path) {
        $Spath          = explode("/", explode("?", $path)[0]);
        array_shift($Spath);

        $sites          = $this->sites;
        $lastController = null;

        do {
            // have controller?
            if (array_key_exists("controller", $sites)) {
                $lastController = $sites["controller"];
            }

            // work with subdirs
            if ((count($Spath) > 0) && array_key_exists("sites", $sites) && array_key_exists($Spath[0], $sites["sites"])) {
                $sites = $sites["sites"][$Spath[0]];
                array_shift($Spath);
            } else {
                //route to last controller
                if (is_null($lastController)) die("No controller for {$path}");

                $this->args = $Spath;
                
                include_once($lastController);

                break;
            }

        } while (TRUE);
    }

    public function getMenu($url = "/", $sites = null) {
        $menu  = new \wsos\structs\vector();

        if (is_null($sites)) $sites = ["" => $this->sites];

        foreach ($sites as $site => $content){
            if (array_key_exists("menu", $content) && $content["menu"] == true) {
                $menuItem        = $content;
                $menuItem["url"] = $url . $site;

                if (array_key_exists("sites", $menuItem)) {
                    //go in subdir

                    if (substr($menuItem["url"], -1) == "/") {
                        $menuItem["sites"] = $this->getMenu($menuItem["url"], $menuItem["sites"]);
                    } else {
                        $menuItem["sites"] = $this->getMenu($menuItem["url"] . "/", $menuItem["sites"]);
                    }
                }

                $menu->append($menuItem);
            }
        }

        return $menu;
    }

    public function getFlatMenu($url = "/", $sites = null) {
        $menu = $this->getMenu($url, $sites);

        return $this->preorder($menu);
    }

    private function preorder($menu) {
        $flat = new \wsos\structs\vector();

        foreach ($menu->values as $site) {
            $submenu = false;

            if (array_key_exists("sites", $site)) {
                $submenu = $this->preorder($site["sites"]);
                unset($site["sites"]);
            }
            
            $flat->append($site); 
            
            if ($submenu <> false) $flat->concat($submenu);  
        }

        return $flat;
    }
}
