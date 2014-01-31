<?php namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\SQL\ValuesSQL;

/**
 * @group sql.values
 */
class ValuesSQLTest extends AbstractTestCase {


    /**
     * @covers CL\Atlas\SQL\ValuesSQL::__construct
     */
    public function testConstruct()
    {
        $values = array(10, 20);
        $sql = new ValuesSQL($values);

        $this->assertEquals(null, $sql->content());
        $this->assertEquals($values, $sql->parameters());
    }
}
