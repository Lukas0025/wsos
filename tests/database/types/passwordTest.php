<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class passwordTest extends TestCase
{
    public function testCreation(): void
    {
        $val = new \wsos\database\types\password("hello", true);
        $this->assertFalse(is_null($val->value));
    }

    public function testVerify(): void
    {
        $pass = new \wsos\database\types\password("passw0rd", true);

        $this->assertFalse($pass->verify("password"));
        $this->assertTrue ($pass->verify("passw0rd"));
        $this->assertFalse($pass->verify(""));
    }


    public function testSet(): void
    {
        $a = new \wsos\database\types\password("hello", true);

        $this->assertTrue ($a->verify("hello"));

        $a->set("help");

        $this->assertTrue ($a->verify("help"));
    }

    public function testGet(): void
    {
        $a = new \wsos\database\types\password("hello", true);

        $this->assertTrue ($a->get() == "***");
    }

    public function testPlain(): void
    {
        $a = new \wsos\database\types\password("hello", true);

        $this->assertTrue ($a->value <> "hello");
    }
}
?>