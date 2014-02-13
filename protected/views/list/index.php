<?php
$urls = '"'.$dataUrl.'","'.$saveUrl.'","'.$removeUrl.'","'.$updateUrl.'"';
Yii::app()->clientScript->registerScript('list', 'init('.$urls.');', CClientScript::POS_READY);
?>

<h3>Список дел</h3>

<form id="form" style="margin-bottom:20px;">
	<input type="text" name="text" id="text"value="" size="103"/>
	<a href="javascript:void(0);" class="button" id="submit" onclick="save();">Сохранить</a>
	<input type="hidden" name="id" id="item-id" value=""/>
</form>

<p>
<a href="javascript:void(0);" class="button" id="backward">Назад</a>
<a href="javascript:void(0);" class="button" id="forward">Вперед</a>
<a href="<?php echo CHtml::normalizeUrl(array('list/index')); ?>" class="button" id="index">Список дел</a>
</p>

<div id="errors" style="color:red;"></div>

<ul id="list" style="list-style:none;list-style-position: inside;padding:0;">

</ul>