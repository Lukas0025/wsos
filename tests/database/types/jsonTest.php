<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class jsonTest extends TestCase
{
    public function testCreation(): void
    {
        $val = new \wsos\database\types\json(["array", "1"]);
        $this->assertFalse(is_null($val->value));
    }

    public function testEQ(): void
    {
        $idA = new \wsos\database\types\json(["array", "1"]);
        $idB = new \wsos\database\types\json(["array" => [10,20,30], "1" => [100,500]]);
        $idC = new \wsos\database\types\json(["array" => [10,20,30], "1" => [100,500]]);

        $this->assertFalse($idA == $idB);
        $this->assertTrue ($idA == $idA);
        $this->assertTrue ($idB == $idB);
        $this->assertFalse($idB == $idA);

        $this->assertTrue ($idB == $idC);
        $this->assertTrue ($idC == $idB);
    }

    public function testNEQ(): void
    {
        $idA = new \wsos\database\types\json(["array", "1"]);
        $idB = new \wsos\database\types\json(["array" => [10,20,30], "1" => [100,500]]);
        $idC = new \wsos\database\types\json(["array" => [10,20,30], "1" => [100,500]]);

        $this->assertTrue ($idA <> $idB);
        $this->assertFalse($idA <> $idA);
        $this->assertFalse($idB <> $idB);
        $this->assertTrue ($idB <> $idA);

        $this->assertFalse($idB <> $idC);
        $this->assertFalse($idC <> $idB);
    }

    public function testSet(): void
    {
        $a = new \wsos\database\types\json(["array", "1"]);

        $this->assertTrue ($a->value == "[\"array\",\"1\"]");

        $a->set([]);

        $this->assertTrue ($a->value == "[]");
    }

    public function testGet(): void
    {
        $a1 = [10,30,40];
        $a2 = ["a" => [10.20]];

        $a = new \wsos\database\types\json($a1);

        $this->assertTrue ($a->get()[1] == 30);

        $a->set($a2);

        $this->assertTrue ($a->get()["a"][0] == 10.20);
    }
}
?>