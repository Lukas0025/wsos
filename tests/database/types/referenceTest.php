<?php declare(strict_types=1);

class tableA extends \wsos\database\core\row {

    public \wsos\database\types\integer $int;

    function __construct($id = null, $int = 0) {
        parent::__construct($id);
        $this->int = new \wsos\database\types\integer($int);
    }
}


use PHPUnit\Framework\TestCase;

final class referenceTest extends TestCase
{
    protected function setUp(): void
    {
        // register DB
        $container = new \wsos\structs\container();
        $db        = new \wsos\database\drivers\inAppArray();

        $container->register("DBDriver", $db);
    }

    public function testCreate(): void
    {
        $val = new \wsos\database\types\reference(null, tableA::class);
        $this->assertFalse(is_null($val->value));
    }

    public function testReferencing(): void
    {
        $a = new tableA(null, 100);
        $b = new tableA(null, 40);

        $val = new \wsos\database\types\reference($a, tableA::class);

        $this->assertTrue  ($val->value == $a->id->value);
        $this->assertFalse ($val->value == $b->id->value);
    }

    public function testSet(): void
    {
        $a = new tableA(null, 100);
        $b = new tableA(null, 40);

        $val = new \wsos\database\types\reference($a, tableA::class);

        $val->set($b);

        $this->assertFalse ($val->value == $a->id->value);
        $this->assertTrue  ($val->value == $b->id->value);
    }

    public function testGet(): void
    {
        $a = new tableA(null, 100);
        $b = new tableA(null, 40);

        $a->commit();
        $b->commit();

        $val = new \wsos\database\types\reference(null, tableA::class);
        $val->set($b);

        $this->assertTrue ($val->get() == $b);
        $this->assertTrue ($val->get()->int->get() == 40);
    }

    public function testNullReference(): void
    {
        $a = new tableA(null, 100);
        $a->commit();

        $val = new \wsos\database\types\reference(null, tableA::class);

        $this->assertTrue ($val->get() == false);
    }
}
?>