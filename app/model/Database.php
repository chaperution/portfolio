<?php

namespace CP\portfolio\model;

Abstract class Database {
	protected $db;
	private $_dbName = 'portfolio';
	private $_dbUser = 'root';
	private $_dbPass = '';
	private $_dbHost = 'localhost';

	public function __construct() {
		$db = new \PDO('mysql:host='. $this->_dbHost . ';dbname='. $this->_dbName .';charset=utf8', $this->_dbUser, $this->_dbPass);
		$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

		$this->db = $db;
	}
}