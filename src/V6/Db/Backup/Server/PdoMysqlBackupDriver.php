<?php

require_once dirname(__FILE__).'/BackupDriver.php';

final class V6_Db_Backup_Server_PdoMysqlBackupDriver implements V6_Db_Backup_Server_BackupDriver{
	
	public function listTables(){
		return $dbh->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
	}
	
	// FIXME: implement
	public function quote($value){}
	
	public function getTableData($name){}
	
	public function getTableDefinition($name){}
	
}