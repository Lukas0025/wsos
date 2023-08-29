<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class uuidTest extends TestCase
{
    public function testCreation(): void
    {
        $id = new \wsos\database\types\uuid();
        $this->assertFalse(is_null($id->value));
    }

    public function testOverwrap(): void
    {
        $ids = new \wsos\structs\vector();
        for ($i = 0; $i < 1000; $i++) {
            $id = new \wsos\database\types\uuid();
            
            foreach ($ids->values as $idV) {
                $this->assertFalse($idV == $id);          
            }

            $ids->append($id);
        }
    }

    public function testEQ(): void
    {
        $idA = new \wsos\database\types\uuid("2c95396c-60d6-43eb-b40f-9cdf8ff9b1fc");
        $idB = new \wsos\database\types\uuid("72fdd228-e996-490c-8649-f252cedac1fd");
        $idC = new \wsos\database\types\uuid("72fdd228-e996-490c-8649-f252cedac1fd");

        $this->assertFalse($idA == $idB);
        $this->assertTrue ($idA == $idA);
        $this->assertTrue ($idB == $idB);
        $this->assertFalse($idB == $idA);

        $this->assertTrue ($idB == $idC);
        $this->assertTrue ($idC == $idB);
    }

    public function testNEQ(): void
    {
        $idA = new \wsos\database\types\uuid("2c95396c-60d6-43eb-b40f-9cdf8ff9b1fc");
        $idB = new \wsos\database\types\uuid("72fdd228-e996-490c-8649-f252cedac1fd");
        $idC = new \wsos\database\types\uuid("72fdd228-e996-490c-8649-f252cedac1fd");

        $this->assertTrue ($idA <> $idB);
        $this->assertFalse($idA <> $idA);
        $this->assertFalse($idB <> $idB);
        $this->assertTrue ($idB <> $idA);

        $this->assertFalse($idB <> $idC);
        $this->assertFalse($idC <> $idB);
    }
}
?>