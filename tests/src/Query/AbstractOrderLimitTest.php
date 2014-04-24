<?php

namespace CL\Atlas\Test\Query;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\SQL;

/**
 * @group query
 */
class AbstractOrderLimitTest extends AbstractTestCase
{
    /**
     * @covers CL\Atlas\Query\AbstractOrderLimit::order
     * @covers CL\Atlas\Query\AbstractOrderLimit::getOrder
     */
    public function testOrder()
    {
        $query = $this->getMock('CL\Atlas\Query\AbstractOrderLimit', array('sql', 'getParameters'));

        $query
            ->order('col1')
            ->order('col2', 'dir2');

        $expected = array(
            new SQL\Direction('col1'),
            new SQL\Direction('col2', 'dir2'),
        );

        $this->assertEquals($expected, $query->getOrder());
    }


    /**
     * @covers CL\Atlas\Query\AbstractOrderLimit::limit
     * @covers CL\Atlas\Query\AbstractOrderLimit::getLimit
     */
    public function testLimit()
    {
        $query = $this->getMock('CL\Atlas\Query\AbstractOrderLimit', array('sql', 'getParameters'));

        $query->limit(20);

        $expected = new SQL\IntValue(20);

        $this->assertEquals($expected, $query->getLimit());
    }
}
