<?php

use Openbuildings\Cherry\DB;

/**
 * @group compiler
 */
class DBTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\DB::configuration
	 */
	public function testConfiguration()
	{
		$this->env->backup_and_set(array(
			'Openbuildings\Cherry\DB::$configurations' => array(),
		));

		$config = array('some', 'test');

		DB::configuration('test', $config);

		$this->assertSame($config, DB::configuration('test'));
	}

	/**
	 * @covers Openbuildings\Cherry\DB::defaultName
	 */
	public function testDefaultName()
	{
		$this->assertEquals('default', DB::defaultName());

		$this->env->backup_and_set(array(
			'Openbuildings\Cherry\DB::$default_name' => 'test',
		));

		$this->assertEquals('test', DB::defaultName());
		DB::defaultName('default_test');
		$this->assertEquals('default_test', DB::defaultName());
	}

	/**
	 * @covers Openbuildings\Cherry\DB::instance
	 * @covers Openbuildings\Cherry\DB::__construct
	 */
	public function testInstance()
	{
		DB::configuration('default', array(
			'dsn' => 'mysql:dbname=test-db;host=127.0.0.1',
			'username' => 'root',
		));

		DB::configuration('test', array(
			'dsn' => 'mysql:dbname=test-db;host=127.0.0.1',
			'username' => 'root',
		));

		$default = DB::instance();
		$test = DB::instance('test');

		$this->assertNotSame($default, $test);

		$this->assertSame($default, DB::instance());
		$this->assertSame($test, DB::instance('test'));
	}

	/**
	 * @covers Openbuildings\Cherry\DB::execute
	 */
	public function testExecute()
	{
		$sql = 'SELECT * FROM users WHERE name = ?';
		$parameters = array('User 1');

		$expected = array(
			array('id' => 1, 'name' => 'User 1'),
		);

		$this->assertEquals($expected, DB::instance()->execute($sql, $parameters)->fetchAll());
	}

	/**
	 * @covers Openbuildings\Cherry\DB::select
	 */
	public function testSelect()
	{
		$select = DB::instance()->select()->columns(array('test', 'test2'));

		$this->assertInstanceOf('Openbuildings\Cherry\Query_Select', $select);

		$this->assertSame(DB::instance(), $select->db());

		$this->assertEquals('SELECT test, test2', $select->sql());
	}

	/**
	 * @covers Openbuildings\Cherry\DB::update
	 */
	public function testUpdate()
	{
		$update = DB::instance()->update()->table(array('test', 'test2'));

		$this->assertInstanceOf('Openbuildings\Cherry\Query_Update', $update);

		$this->assertSame(DB::instance(), $update->db());

		$this->assertEquals('UPDATE test, test2', $update->sql());
	}

	/**
	 * @covers Openbuildings\Cherry\DB::delete
	 */
	public function testDelete()
	{
		$delete = DB::instance()->delete()->from(array('test', 'test2'));

		$this->assertInstanceOf('Openbuildings\Cherry\Query_Delete', $delete);

		$this->assertSame(DB::instance(), $delete->db());

		$this->assertEquals('DELETE FROM test, test2', $delete->sql());
	}

	/**
	 * @covers Openbuildings\Cherry\DB::insert
	 */
	public function testInsert()
	{
		$query = DB::instance()->insert()->into('table1')->set(array('name' => 'test2'));

		$this->assertInstanceOf('Openbuildings\Cherry\Query_Insert', $query);

		$this->assertSame(DB::instance(), $query->db());

		$this->assertEquals('INSERT INTO table1 SET name = ?', $query->sql());
		$this->assertEquals(array('test2'), $query->parameters());
	}
}
