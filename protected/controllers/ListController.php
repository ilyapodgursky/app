<?php

class ListController extends Controller
{
	//отображает страницу списка дел
	public function actionIndex()
	{
		Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
		Yii::app()->getClientScript()->registerCssFile('/ui/css/cupertino/jquery-ui-1.10.4.custom.min.css');
		Yii::app()->getClientScript()->registerScriptFile('/ui/list.js');
		
		$this->render('index', array(
			'dataUrl' => CHtml::normalizeUrl(array('list/data')),
			'saveUrl' => CHtml::normalizeUrl(array('list/save')),
			'removeUrl' => CHtml::normalizeUrl(array('list/remove')),
			'updateUrl' => CHtml::normalizeUrl(array('list/update')),
		));
	}
	
	//данные для списка
	public function actionData()
	{
		if (Yii::app()->request->isPostRequest) {
			$hist = $_POST['hist'] > 0;
			$step = (int)$_POST['step'];
			
			$maxStep = $this->getMaxHistoryStep();
			
			$result = array(
				'data' => array(),
				'maxstep' => $maxStep,
				'minstep' => $this->getMinHistoryStep(),
				'step' => $maxStep
			);
			
			if ($hist) {
				$result['step'] = (int)$_POST['step'];
			}
			
			if ($hist) {
				$sql = 'select a.item_id as id, a.text from (select * from hist as h where h.status > 0 and step <= :step order by h.step desc) as a group by a.item_id order by a.priority asc';
				/*$result['data'] = Yii::app()->db->createCommand()->
					select('item_id as id, text')->
					from(Hist::model()->tableName())->
					where('step <= :step', array('step' => $step))->
					group('item_id')->
					order('id desc')->
					queryAll();*/
				$result['data'] = Yii::app()->db->createCommand($sql)->bindParam(':step', $step)->queryAll();
			} else {
				$result['data'] = Yii::app()->db->createCommand()->
					select('id, text')->
					from(Data::model()->tableName())->
					where('status = 1')->
					order('priority asc')->
					queryAll();
			}
			
			print_r(json_encode($result));
		} else {
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}
	
	//добавление или обновление дел
	public function actionSave()
	{
		if (Yii::app()->request->isPostRequest) {
			$id = (int) $_POST['id'];
			$text = htmlspecialchars($_POST['text']);
			$res = array(
				'result' => 'fail',
				'maxstep' => 0,
				'step' => 0
			);
			
			if ($id > 0) {
				//обновляем
				$item = Data::model()->findByPk($id);
				
				if ($item === null) {
					throw new CHttpException(404,'The requested page does not exist.');
				}
				$item->text = $text;
			} else {
				//создаем
				$item = new Data();
				$item->text = $text;
				$item->priority = $this->getNextPriority();
			}
			
			if ($item->save()) {
				$res['result'] = 'success';
				$maxStep = $this->getMaxHistoryStep();
				$res['maxstep'] = $maxStep;
				$res['step'] = $maxStep;
			}
			
			print_r(json_encode($res));
		} else {
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}
	
	//обновление порядка элементов
	public function actionUpdate()
	{
		if (Yii::app()->request->isPostRequest) {
			$arr = $_POST['data'];
			$res = array('result' => 'fail');
			$c = 0;
			
			if (is_array($arr)) {
				if (count($arr) > 0) {
					$i = 0;
					foreach ($arr as $id) {
						$i++;
						$item = Data::model()->findByPk($id);
						$item->priority = $i;
						$c += (int)$item->save();
						
						if ($c > 0) {
							$res['result'] = 'success';
							$maxStep = $this->getMaxHistoryStep();
							$res['maxstep'] = $maxStep;
							$res['step'] = $maxStep;
						}
					}
					print_r(json_encode($res));
				}
			}
		} else {
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}
	
	//удаление элемента
	public function actionRemove()
	{
		if (Yii::app()->request->isPostRequest) {
			$id = (int) $_POST['id'];
			$res = array('result' => 'fail');
			
			$item = Data::model()->findByPk($id);
			
			if ($item === null) {
				throw new CHttpException(404,'The requested page does not exist.');
			}
			
			$item->status = 0;
			
			if ($item->save()) {
				$res['result'] = 'success';
				$maxStep = $this->getMaxHistoryStep();
				$res['maxstep'] = $maxStep;
				$res['step'] = $maxStep;
			}
			
			print_r(json_encode($res));
		} else {
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}
	
	//возвращает следующий порядок элемента
	public function getNextPriority()
	{
		$sql = 'select max(priority) as m from data where status = 1';
		$res = Yii::app()->db->createCommand($sql)->queryRow();
		return $res['m'] + 1;
	}
	
	//возвращает максимальный шаг в истории
	public function getMaxHistoryStep()
	{
		$sql = 'select max(step) as m from hist where status = 1';
		$res = Yii::app()->db->createCommand($sql)->queryRow();
		return $res['m'];
	}
	
	//возвращает минимальный шаг в истории
	public function getMinHistoryStep()
	{
		$sql = 'select min(step) as m from hist where status = 1';
		$res = Yii::app()->db->createCommand($sql)->queryRow();
		return $res['m'];
	}
}