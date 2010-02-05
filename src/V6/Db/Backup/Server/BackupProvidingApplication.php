<?php

final class V6_Db_Backup_Server_BackupProvidingApplication{
	
	private $passwordVerifier;
	
	private $backupDriver;
	
	public function __construct($passwordVerifier, $backupDriver){
		if(!is_callable($passwordVerifier)){
			throw new InvalidArgumentException('$passwordVerifier has to be valid callback');
		}
		$this->passwordVerifier = $passwordVerifier;
		if(! ($backupDriver instanceof V6_Db_Backup_Server_BackupDriver) ){
			throw new InvalidArgumentException('$backupDriver has to be a V6_Db_Backup_Server_BackupDriver');
		}
		$this->backupDriver = $backupDriver;
	}
	
	public function run(){
		header('content-type: text/plain; charset=utf-8');
		$pwd = @((string)$_POST['password']);
		if( !call_user_func($this->passwordVerifier, $pwd) ){
		  echo ':pwd';
		  return;
		};
		switch(@$_GET['action']){
			case 'tables':
	      foreach ($this->backupDriver->listTables() as $tbl) {
	        echo $tbl."\n";
	      };
	    	break;
			case 'create table':
	      $name = @ ((string)$_GET['table']);
	      echo $this->backupDriver->getTableDefinition($name);
	      echo ';';
	    	break;
	    case 'data':
	      $name = @ ((string)$_GET['table']);
	      $data = $this->backupDriver->getTableData($name);
	      $scols = null;
	      foreach($data as $r) {
	        if(!$scols){
	          $scols = implode(',', array_keys($r));
	        };
	        $escvals = array();
	      	echo 'INSERT INTO ';
	        echo $name;
	        echo '(';
	        echo $scols;
	        echo ')';
	        echo 'VALUES(';
	        $count = count($r);
	        $i = 0;
	        foreach ($r as $value) {
	          $i++;
	        	echo $this->backupDriver->quote($value);
	        	if( $i != $count ){
	            echo ',';
	          };
	        };
	        echo ');';
	        echo "\n";
	      };
	    	break;
	    default:
      	echo '! bad action';
      	return;
    }
    echo "\n".'-- OK';
	}

};
