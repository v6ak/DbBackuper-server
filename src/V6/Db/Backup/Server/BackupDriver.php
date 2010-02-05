<?php

interface V6_Db_Backup_Server_BackupProvidingApplication_BackupDriver{

	public function listTables();
	
	public function quote($value);
	
	public function getTableData($name);
	
	public function getTableDefinition($name);
	
};
