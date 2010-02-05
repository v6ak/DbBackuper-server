<?php

class V6_Db_Backup_Server_BackupProvidingApplication{
	
	private $passwordVerifier;
	
	private $backupDriver;
	
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
	        echo $tbl[0]."\n";
	      };
	    	break;
			case 'create table':
	      $name = @ ((string)$_GET['table']);
	      echo $this->backupDriver->getTableDefinition($name);
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
	        echo $tbl;
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
	        echo ')';
	        echo "\n";
	      };
	    	break;
	    default:
      	throw new Exception('bad action');
    }
    echo "\n".'-- OK';
	}

};
