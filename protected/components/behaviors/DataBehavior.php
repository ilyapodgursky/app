<?php

class DataBehavior extends CActiveRecordBehavior
{
	public function afterSave($event) {
		$hist = new Hist();
		$hist->item_id = $this->getOwner()->id;
		$hist->text = $this->getOwner()->text;
		$hist->priority = $this->getOwner()->priority;
		$hist->status = $this->getOwner()->status;
		$hist->step = $this->getNextStep();
		$hist->save();
	}
	
	protected function getNextStep()
	{
		$sql = 'select max(step) as m from hist where status = 1';
		$res = Yii::app()->db->createCommand($sql)->queryRow();
		return $res['m'] + 1;
	}
	
}

