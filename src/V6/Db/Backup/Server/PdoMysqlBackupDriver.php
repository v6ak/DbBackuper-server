<?php

require_once dirname(__FILE__).'/BackupDriver.php';

final class V6_Db_Backup_Server_PdoMysqlBackupDriver implements V6_Db_Backup_Server_BackupDriver{
	
	private $pdb;
	
	public function __construct($dbh){
		if(! ($dbh instanceof PDO) ){
			throw new InvalidArgumentException('$dbh has to be a PDO');
		}
		$this->dbh = $dbh;
	}
	
	public function listTables(){
		return $this->dbh->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
	}
	
	public function quote($value){
		return $this->dbh->quote($value);
	}
	
	public function getTableData($name){
		$stmt = $this->dbh->query('SELECT * FROM '.$name);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt;
	}
	
	public function getTableDefinition($name){
		return $this->dbh->query('SHOW CREATE TABLE '.$name)->fetchObject()->{'Create Table'};
	}
	
}