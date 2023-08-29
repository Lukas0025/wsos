<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class enumTest extends TestCase
{
    public function testCreation(): void
    {
        //                                   init value  dict                      default for null and other
        $val = new \wsos\database\types\enum("hello",    ["hello", "word", "now"], "word");
        $this->assertFalse(is_null($val->value));
    }

    public function testEQ(): void
    {
        $enum = new \wsos\database\types\enum("hello",    ["hello", "word", "now"], "word");

        $e1   = clone $enum;
        $e2   = clone $enum;
        $e3   = clone $enum;

        $e1->set("hello");
        $e2->set("now");
        $e3->set("hello");

        $this->assertFalse($e1 == $e2);
        $this->assertFalse($e2 == $e1);
        $this->assertTrue ($e1 == $e3);
        $this->assertTrue ($e3 == $e1);
    }

    public function testNEQ(): void
    {
        $enum = new \wsos\database\types\enum("hello",    ["hello", "word", "now"], "word");

        $e1   = clone $enum;
        $e2   = clone $enum;
        $e3   = clone $enum;

        $e1->set("hello");
        $e2->set("now");
        $e3->set("hello");

        $this->assertTrue ($e1 <> $e2);
        $this->assertTrue ($e2 <> $e1);
        $this->assertFalse($e1 <> $e3);
        $this->assertFalse($e3 <> $e1);
    }

    public function testValue(): void
    {
        $enum = new \wsos\database\types\enum("hello",    ["hello", "word", "now"], "word");

        $e1   = clone $enum;
        $e2   = clone $enum;
        $e3   = clone $enum;
        $e4   = clone $enum;

        $e1->set("hello");
        $e2->set("word");
        $e3->set("now");

        $this->assertTrue ($e1->value < $e2->value);
        $this->assertTrue ($e2->value < $e3->value);
        $this->assertTrue ($e1->value < $e3->value);
        $this->assertTrue ($e4->value == $e1->value);
    }

    public function testSet(): void
    {
        $enum = new \wsos\database\types\enum("hello",    ["hello", "word", "now"], "word");

        $enum->set("word");

        $this->assertTrue ($enum->value == 1);
    }

    public function testGet(): void
    {
        $enum = new \wsos\database\types\enum("hello",    ["hello", "word", "now"], "word");

        $enum->value = 2;

        $this->assertTrue ($enum->get() == "now");
    }

    public function testGetAndSet(): void
    {
        $enum = new \wsos\database\types\enum("hello",    ["hello", "word", "now"], "word");

        $enum->set("now");

        $this->assertTrue ($enum->get() == "now");
    }

    public function testNullDefault(): void
    {
        $enum = new \wsos\database\types\enum("hello",    ["hello", "word", "now"], "word");

        $enum->set(null);

        $this->assertTrue ($enum->get() == "word");
    }


    public function testNullInList(): void
    {
        $enum = new \wsos\database\types\enum("hello",    ["hello", null, "now"], "hello");

        $enum->set(null);

        $this->assertTrue ($enum->value == 1);
    }


    public function testDefault(): void
    {
        $enum = new \wsos\database\types\enum("hello",    ["hello", "word", "now"], "word");

        $enum->set("help");

        $this->assertTrue ($enum->get() == "word");
    }

}
?>