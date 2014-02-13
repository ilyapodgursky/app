<?php

/**
 * Модель списка дел (таблица data)
 *
 * @property integer $id - идентификатор записи
 * @property string $text - текст задания
 * @property integer $priority - приоритет (порядок) записи
 * @property integer $status - статус, если 0, то запись считается удаленной
 */
class Data extends CActiveRecord
{
	/**
	 * @return string - название таблицы
	 */
	public function tableName()
	{
		return 'data';
	}
	
	/**
	 * подключаем поведения для ведения всей истории и истории изменения поля priority
	 */
	public function behaviors(){
		return array(
			'DataBehavior' => array(
				'class' => 'application.components.behaviors.DataBehavior',
			),
			'HistoryBehavior' => array(
				'class' => 'application.components.behaviors.HistoryBehavior',
				'fieldName' => 'priority'
			)
		);
	}

	/**
	 * @return array - правила валидации
	 */
	public function rules()
	{
		return array(
			array('text, priority', 'required'),
			array('priority, status', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array связи между таблицами
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array названия полей
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'text' => 'Text',
			'priority' => 'Priority',
			'status' => 'Status',
		);
	}

	/**
	 * Возвращает статичный класс модели
	 * @param string $className - класс записи AR
	 * @return Data - статический класс модели
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
