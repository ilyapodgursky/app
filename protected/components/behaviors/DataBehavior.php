<?php

/**
 * Поведение для ведения истории списка дел (модель Data)
 */
class DataBehavior extends CActiveRecordBehavior
{
	/**
	 * после сохранения записи, сохраняет ее копию в таблицу истории
	 */
	public function afterSave($event) {
		$hist = new Hist();
		$hist->item_id = $this->getOwner()->id;
		$hist->text = $this->getOwner()->text;
		$hist->priority = $this->getOwner()->priority;
		$hist->status = $this->getOwner()->status;
		$hist->step = $this->getNextStep();
		$hist->save();
	}
	
	/**
	 * возвращает максимальный шаг в истории + 1
	 */
	protected function getNextStep()
	{
		$sql = 'select max(step) as m from hist where status = 1';
		$res = Yii::app()->db->createCommand($sql)->queryRow();
		return $res['m'] + 1;
	}
	
}

