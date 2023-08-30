<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class booleanTest extends TestCase
{
    public function testCreation(): void
    {
        $val = new \wsos\database\types\boolean(true);
        $this->assertFalse(is_null($val->value));
    }

    public function testEQ(): void
    {
        $idA = new \wsos\database\types\boolean(false);
        $idB = new \wsos\database\types\boolean(true);
        $idC = new \wsos\database\types\boolean(true);

        $this->assertFalse($idA == $idB);
        $this->assertTrue ($idA == $idA);
        $this->assertTrue ($idB == $idB);
        $this->assertFalse($idB == $idA);

        $this->assertTrue ($idB == $idC);
        $this->assertTrue ($idC == $idB);
    }

    public function testNEQ(): void
    {
        $idA = new \wsos\database\types\boolean(false);
        $idB = new \wsos\database\types\boolean(true);
        $idC = new \wsos\database\types\boolean(true);

        $this->assertTrue ($idA <> $idB);
        $this->assertFalse($idA <> $idA);
        $this->assertFalse($idB <> $idB);
        $this->assertTrue ($idB <> $idA);

        $this->assertFalse($idB <> $idC);
        $this->assertFalse($idC <> $idB);
    }

    public function testSet(): void
    {
        $a = new \wsos\database\types\boolean(false);

        $this->assertTrue ($a->value == 0);

        $a->set(true);

        $this->assertTrue ($a->value == 1);
    }

    public function testGet(): void
    {
        $a = new \wsos\database\types\boolean(false);

        $this->assertTrue ($a->get() == false);

        $a->set(true);

        $this->assertTrue ($a->get() == true);
    }
}
?>