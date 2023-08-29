<?php declare(strict_types=1);

class user extends \wsos\database\core\row {

    public \wsos\database\types\text      $name;
    public \wsos\database\types\password  $password;
    public \wsos\database\types\reference $city;

    function __construct($id = null, $name = "", $password = "", $city = null) {
        parent::__construct($id);
        $this->name      = new \wsos\database\types\text($name);
        $this->password  = new \wsos\database\types\password($password);
        $this->city      = new \wsos\database\types\reference($city, city::class);
    }
}

class city extends \wsos\database\core\row {

    public \wsos\database\types\integer $population;
    public \wsos\database\types\text    $name;

    function __construct($id = null, $population = 0, $name = "") {
        parent::__construct($id);
        $this->population = new \wsos\database\types\integer($population);
        $this->name       = new \wsos\database\types\text($name);
    }
}

use PHPUnit\Framework\TestCase;

final class rowTest extends TestCase
{
    protected function setUp(): void
    {
        // register DB
        $container = new \wsos\structs\container();
        $db        = new \wsos\database\drivers\inAppArray();

        $container->register("DBDriver", $db);
    }

    public function testCrateSomeData(): void
    {
        $brno  = new city(null, 500000, "Brno");
        $brno->commit();

        $pepa  = new user();
        $pepa->name    ->set("Pepa");
        $pepa->password->set("ahoj");
        $pepa->city    ->set($brno);

        $jarda = new user();
        $jarda->name    ->set("Jarda");
        $jarda->password->set("help");
        $jarda->city    ->set($brno);

        $this->assertTrue($pepa->name->get() == "Pepa");
        $this->assertTrue($pepa->city->get() == $brno);
        $this->assertTrue($jarda->name->get() == "Jarda");
        $this->assertTrue($pepa->city->get() == $jarda->city->get());
    }

    public function testCommit(): void
    {
        $jarda = new user();
        $jarda->name    ->set("Jarda");
        $jarda->password->set("help");

        $jarda->commit();

        $jardaDB = (new user())->find("name", "Jarda");
        
        $this->assertTrue($jardaDB == $jarda);
    }

    public function testFetch(): void
    {
        $jarda = new user();
        $jarda->name    ->set("Jarda");
        $jarda->password->set("help");

        $jarda->commit();

        $jardaDB = new user($jarda->id);

        $jardaDB->fetch();

        $this->assertTrue($jardaDB->name->get() == $jarda->name->get());
    }

    public function testFind(): void
    {
        $jarda = new user();
        $jarda->name    ->set("Jarda");
        $jarda->password->set("help");
        $jarda->commit();

        $jarda1 = new user();
        $jarda1->name    ->set("Pepa");
        $jarda1->password->set("help");
        $jarda1->commit();

        $jarda2 = new user();
        $jarda2->name    ->set("Lukas");
        $jarda2->password->set("help");
        $jarda2->commit();

        $DBuser = new user();

        $this->assertTrue($DBuser->find("name", "Jarda"));
        $this->assertTrue($DBuser->name->get() == "Jarda");

        $this->assertTrue($DBuser->find("name", "Pepa"));
        $this->assertTrue($DBuser->name->get() == "Pepa");

        $this->assertTrue($DBuser->find("name", "Lukas"));
        $this->assertTrue($DBuser->name->get() == "Lukas");

        $this->assertFalse($DBuser->find("name", "Tomas"));
    }
}
?>