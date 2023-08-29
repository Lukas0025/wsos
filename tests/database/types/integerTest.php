<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class integerTest extends TestCase
{
    public function testCreation(): void
    {
        $val = new \wsos\database\types\integer(10);
        $this->assertFalse(is_null($val->value));
    }

    public function testEQ(): void
    {
        $idA = new \wsos\database\types\integer(10);
        $idB = new \wsos\database\types\integer(20);
        $idC = new \wsos\database\types\integer(20);

        $this->assertFalse($idA == $idB);
        $this->assertTrue ($idA == $idA);
        $this->assertTrue ($idB == $idB);
        $this->assertFalse($idB == $idA);

        $this->assertTrue ($idB == $idC);
        $this->assertTrue ($idC == $idB);
    }

    public function testNEQ(): void
    {
        $idA = new \wsos\database\types\base(5);
        $idB = new \wsos\database\types\base(10);
        $idC = new \wsos\database\types\base(10);

        $this->assertTrue ($idA <> $idB);
        $this->assertFalse($idA <> $idA);
        $this->assertFalse($idB <> $idB);
        $this->assertTrue ($idB <> $idA);

        $this->assertFalse($idB <> $idC);
        $this->assertFalse($idC <> $idB);
    }

    public function testSet(): void
    {
        $a = new \wsos\database\types\base(20);

        $this->assertTrue ($a->value == 20);

        $a->set(10);

        $this->assertTrue ($a->value == 10);
    }

    public function testGet(): void
    {
        $a = new \wsos\database\types\base(10);

        $this->assertTrue ($a->get() == 10);

        $a->set(50);

        $this->assertTrue ($a->get() == 50);
    }
}
?>