<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class textTest extends TestCase
{
    public function testCreation(): void
    {
        $val = new \wsos\database\types\text("hello");
        $this->assertFalse(is_null($val->value));
    }

    public function testEQ(): void
    {
        $idA = new \wsos\database\types\text("2c95396c-60d6-43eb-b40f-9cdf8ff9b1fc");
        $idB = new \wsos\database\types\text("72fdd228-e996-490c-8649-f252cedac1fd");
        $idC = new \wsos\database\types\text("72fdd228-e996-490c-8649-f252cedac1fd");

        $this->assertFalse($idA == $idB);
        $this->assertTrue ($idA == $idA);
        $this->assertTrue ($idB == $idB);
        $this->assertFalse($idB == $idA);

        $this->assertTrue ($idB == $idC);
        $this->assertTrue ($idC == $idB);
    }

    public function testNEQ(): void
    {
        $idA = new \wsos\database\types\text("2c95396c-60d6-43eb-b40f-9cdf8ff9b1fc");
        $idB = new \wsos\database\types\text("72fdd228-e996-490c-8649-f252cedac1fd");
        $idC = new \wsos\database\types\text("72fdd228-e996-490c-8649-f252cedac1fd");

        $this->assertTrue ($idA <> $idB);
        $this->assertFalse($idA <> $idA);
        $this->assertFalse($idB <> $idB);
        $this->assertTrue ($idB <> $idA);

        $this->assertFalse($idB <> $idC);
        $this->assertFalse($idC <> $idB);
    }

    public function testSet(): void
    {
        $a = new \wsos\database\types\text("2c95396c-60d6-43eb-b40f-9cdf8ff9b1fc");

        $this->assertTrue ($a->value == "2c95396c-60d6-43eb-b40f-9cdf8ff9b1fc");

        $a->set("hello");

        $this->assertTrue ($a->value == "hello");
    }

    public function testGet(): void
    {
        $a = new \wsos\database\types\text("2c95396c-60d6-43eb-b40f-9cdf8ff9b1fc");

        $this->assertTrue ($a->get() == "2c95396c-60d6-43eb-b40f-9cdf8ff9b1fc");

        $a->set("hello");

        $this->assertTrue ($a->get() == "hello");
    }
}
?>