<?php

class HistoryBehavior extends CActiveRecordBehavior
{
	public $fieldName;
	
	//получение истории, если $d == null то всю, если нет то по дате
	public function getHist($d = null)
	{
		$sql = 'select field_val, record_time from behavior where model_name = :model and field_name = :field and item_id = :id';
		if ($d != null) {
			$sql .= ' and record_time like :date';
		}
		$result = Yii::app()->db->createCommand($sql)->
			bindParam(':model', get_class($this->getOwner()))->
			bindParam(':field', $this->fieldName)->
			bindParam(':id', $this->getOwner()->id);
		if ($d != null) {
			$result->bindParam(':date', $d.'%');
		}
		return $result->queryAll();
	}
	
	public function afterSave()
	{
		$item = Yii::app()->db->createCommand()->
			select('field_val')->
			from('behavior')->
			where('item_id = :id and model_name = :model and field_name = :field', array(
				':id' => $this->getOwner()->id,
				':model' => get_class($this->getOwner()),
				':field' => $this->fieldName
			))->
			order('id desc')->
			queryRow();
		
		if ($item['field_val'] != $this->getOwner()->{$this->fieldName}) {
			Yii::app()->db->createCommand()->insert('behavior', array(
				'item_id' => $this->getOwner()->id,
				'model_name' => get_class($this->getOwner()),
				'field_name' => $this->fieldName,
				'field_val' => $this->getOwner()->{$this->fieldName},
				'record_time' => date("Y-m-d H:i:s")
			));
		}
	}
}