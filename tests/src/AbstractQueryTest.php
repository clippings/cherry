<?php

namespace Harp\Query\Test;

use Harp\Query\SQL;
use Harp\Query\DB;

/**
 * @group query
 * @coversDefaultClass Harp\Query\AbstractQuery
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class AbstractQueryTest extends AbstractTestCase
{
    /**
     * @covers ::type
     * @covers ::getType
     * @covers ::setType
     * @covers ::clearType
     */
    public function testType()
    {
        $query = $this->getMock(
            'Harp\Query\AbstractQuery',
            array('sql', 'getParameters'),
            array(self::getDb())
        );

        $query->type('IGNORE');

        $expected = new SQL\SQL('IGNORE');

        $this->assertEquals($expected, $query->getType());

        $expected = new SQL\SQL('IGNORE TEST');

        $query->type($expected);

        $this->assertSame($expected, $query->getType());

        $query->type('IGNORE QUICK');

        $expected = new SQL\SQL('IGNORE QUICK');

        $this->assertEquals($expected, $query->getType());

        $query->setType($expected);

        $this->assertEquals($expected, $query->getType());

        $query->clearType();

        $this->assertNull($query->getType());
    }

    /**
     * @covers ::getDb
     * @covers ::__construct
     */
    public function testDb()
    {
        $query = $this->getMock(
            'Harp\Query\AbstractQuery',
            array('sql', 'getParameters'),
            array(self::getDb())
        );

        $this->assertSame(self::getDb(), $query->getDb());
    }

    /**
     * @covers ::execute
     */
    public function testExecute()
    {
        $query = $this->getMock(
            'Harp\Query\AbstractQuery',
            array('sql', 'getParameters'),
            array(self::getDb())
        );

        $query
            ->expects($this->once())
            ->method('sql')
            ->will($this->returnValue('SELECT * FROM users WHERE name = ?'));

        $query
            ->expects($this->once())
            ->method('getParameters')
            ->will($this->returnValue(array('User 1')));

        $expected = array(
            array('id' => 1, 'name' => 'User 1'),
        );

        $this->assertEquals($expected, $query->execute()->fetchAll());
    }

    /**
     * @covers ::humanize
     */
    public function testHumanize()
    {
        $query = $this->getMock(
            'Harp\Query\AbstractQuery',
            array('sql', 'getParameters'),
            array(self::getDb())
        );

        $query
            ->expects($this->once())
            ->method('sql')
            ->will($this->returnValue('SELECT * FROM users WHERE name = ?'));

        $query
            ->expects($this->once())
            ->method('getParameters')
            ->will($this->returnValue(array('User 1')));

        $this->assertEquals('SELECT * FROM users WHERE name = "User 1"', $query->humanize());
    }
}
