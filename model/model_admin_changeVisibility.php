<?php if(!defined("DIR")){ exit(); }
class model_admin_changeVisibility extends connection{
	public $outMessage = 2;

	function __construct(){
		$files = glob(DIR.'_cache/*'); // get all file names
		foreach($files as $file){ // iterate files
			if(is_file($file))
			@unlink($file); // delete file
		}
	}

	public function change($c){
		$conn = $this->conn($c);
		if(isset($_GET['visibilitychnage']) && $_GET['visibilitychnage']=="true" && isset($_GET['sub']) && is_numeric($_GET['sub'])){
			$select_sql = 'SELECT `visibility` FROM `studio404_pages` WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:status';
			$select_prepare = $conn->prepare($select_sql);
			$select_prepare->execute(array(
				":idx"=>$_GET['sub'], 
				":lang"=>LANG_ID,
				":status"=>1
			));
			$select_fetch = $select_prepare->fetch(PDO::FETCH_ASSOC);
		
			if($select_fetch['visibility']==1){ $c_visibility = 2; }else{ $c_visibility = 1; }
			$sql = 'UPDATE `studio404_pages` SET `visibility`=:c_visibility WHERE `idx`=:idx AND `status`!=:status';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":c_visibility"=>$c_visibility, 
				":idx" => $_GET['sub'], 
				":status" => 1
			));

			$this->outMessage = 1;
		}
		return $this->outMessage;
	}

	public function change_news($c){
		$conn = $this->conn($c);
		if(isset($_GET['visibilitychnage']) && $_GET['visibilitychnage']=="true" && isset($_GET['id'])){
			$pagetype = $_GET['type'];
			
			$idx = (isset($_GET['newsidx'])) ? $_GET['newsidx'] : $_GET['catalogidx'];

			$select_sql = 'SELECT 
			`studio404_module_item`.`idx` AS smi_idx,
			`studio404_module`.`idx` AS sm_idx,
			`studio404_module_item`.`visibility` AS smi_visibility 
			FROM 
			`studio404_module_attachment`,`studio404_module`,`studio404_module_item` 
			WHERE 
			`studio404_module_attachment`.`connect_idx`=:connect_id AND 
			(
				`studio404_module_attachment`.`page_type`=:newspage OR 
				`studio404_module_attachment`.`page_type`=:eventpage OR 
				`studio404_module_attachment`.`page_type`=:catalogpage  
			) AND 
			`studio404_module_attachment`.`lang`=:lang AND 
			`studio404_module_attachment`.`status`!=:status AND 
			`studio404_module_attachment`.`idx`=`studio404_module`.`idx` AND 
			`studio404_module`.`lang`=:lang AND 
			`studio404_module`.`status`!=:status AND 
			`studio404_module`.`idx`=`studio404_module_item`.`module_idx` AND 
			`studio404_module_item`.`idx`=:newsidx AND 
			`studio404_module_item`.`lang`=:lang AND 
			`studio404_module_item`.`status`!=:status 
			';			
			$select_prepare = $conn->prepare($select_sql);
			$select_prepare->execute(array(
				":connect_id"=>$_GET['id'], 
				":newspage"=>'newspage', 
				":eventpage"=>'eventpage', 
				":catalogpage"=>'catalogpage', 
				":lang"=>LANG_ID,
				":status"=>1, 
				":newsidx"=>$idx
			));
			$select_fetch = $select_prepare->fetch(PDO::FETCH_ASSOC);
			if($select_fetch['smi_visibility']==1){ $c_visibility = 2; }else{ $c_visibility = 1; }

			$sql = 'UPDATE `studio404_module_item` SET `visibility`=:c_visibility WHERE `idx`=:idx AND `module_idx`=:module_idx AND `status`!=:status';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":c_visibility"=>$c_visibility, 
				":idx"=>$idx, 
				":module_idx"=>$select_fetch['sm_idx'], 
				":status"=>1
			));

			$this->outMessage = 1;
		}
		return $this->outMessage;
	}

	public function change_media($c){ 
		$conn = $this->conn($c);
		if(isset($_GET['visibilitychnage']) && $_GET['visibilitychnage']=="true" && isset($_GET['id'])){
			$pagetype = $_GET['type'];
			$idx = $_GET['mediaidx'];
			$select_sql = 'SELECT 
			`studio404_media_item`.`idx` AS smi_idx,
			`studio404_media`.`idx` AS sm_idx,
			`studio404_media_item`.`visibility` AS smi_visibility 
			FROM 
			`studio404_media_attachment`,`studio404_media`,`studio404_media_item` 
			WHERE 
			`studio404_media_attachment`.`connect_idx`=:connect_id AND 
			`studio404_media_attachment`.`page_type`=:page_type AND 
			`studio404_media_attachment`.`lang`=:lang AND 
			`studio404_media_attachment`.`status`!=:status AND 
			`studio404_media_attachment`.`idx`=`studio404_media`.`idx` AND 
			`studio404_media`.`lang`=:lang AND 
			`studio404_media`.`status`!=:status AND 
			`studio404_media`.`idx`=`studio404_media_item`.`media_idx` AND 
			`studio404_media_item`.`idx`=:mediaidx AND 
			`studio404_media_item`.`lang`=:lang AND 
			`studio404_media_item`.`status`!=:status 
			';			
			$select_prepare = $conn->prepare($select_sql);
			$select_prepare->execute(array(
				":connect_id"=>$_GET['id'], 
				":page_type"=>$pagetype, 
				":lang"=>LANG_ID,
				":status"=>1, 
				":mediaidx"=>$idx
			));
			$select_fetch = $select_prepare->fetch(PDO::FETCH_ASSOC);
			if($select_fetch['smi_visibility']==1){ $c_visibility = 2; }else{ $c_visibility = 1; }

			$sql = 'UPDATE `studio404_media_item` SET `visibility`=:c_visibility WHERE `idx`=:idx AND `media_idx`=:media_idx AND `status`!=:status';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":c_visibility"=>$c_visibility, 
				":idx"=>$idx, 
				":media_idx"=>$select_fetch['sm_idx'], 
				":status"=>1
			));

			$this->outMessage = 1;
		}
		return $this->outMessage;
	}

	public function changeUserAllowed($c){ 
		$conn = $this->conn($c);
		if(isset($_GET['visibilitychnage'],$_GET['wuserid']) && $_GET['visibilitychnage']=="true"){
			$select_sql = 'SELECT `allow` FROM `studio404_users` WHERE `id`=:id';
			$select_prepare = $conn->prepare($select_sql);
			$select_prepare->execute(array(
				":id"=>$_GET['wuserid']
			));
			$select_fetch = $select_prepare->fetch(PDO::FETCH_ASSOC);
		
			if($select_fetch['allow']==1){ $c_visibility = 2; }else{ $c_visibility = 1; }
			$sql = 'UPDATE `studio404_users` SET `allow`=:c_visibility WHERE `id`=:id';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":c_visibility"=>$c_visibility, 
				":id" => $_GET['wuserid']
			));

			$this->outMessage = 1;
		}
		return $this->outMessage;
	}
}
?>