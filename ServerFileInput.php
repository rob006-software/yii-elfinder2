<?php

/**
 * File input field with elFinder widget
 *
 * @author Robert Korulczyk <robert@korulczyk.pl>
 * @link http://rob006.net/
 * @author Bogdan Savluk <Savluk.Bogdan@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
class ServerFileInput extends CInputWidget {

	/**
	 * @var string
	 */
	public $popupConnectorRoute = false;

	/**
	 * @var string
	 */
	public $popupTitle = 'Files';

	/**
	 * Custom "Browse" button html code
	 * Button id must be according with the pattern [INPUT_FIELD_ID]browse, for exaple:
	 * CHtml::button('Browse', array('id' => TbHtml::getIdByName(TbHtml::activeName($model, 'header_box_image')) . 'browse'));
	 * @var string
	 */
	public $customButton = '';

	public function run() {
		Yii::import('ext.elFinder.ElFinderHelper');
		ElFinderHelper::registerAssets();

		list($name, $id) = $this->resolveNameID();

		if (isset($this->htmlOptions['id']))
			$id = $this->htmlOptions['id'];
		else
			$this->htmlOptions['id'] = $id;
		if (isset($this->htmlOptions['name']))
			$name = $this->htmlOptions['name'];
		else
			$this->htmlOptions['name'] = $name;

		$contHtmlOptions = $this->htmlOptions;
		$contHtmlOptions['id'] = $id . 'container';
		echo CHtml::openTag('div', $contHtmlOptions);
		$inputOptions = array('id' => $id, 'style' => 'float:left;' /* , 'readonly' => 'readonly' */);
		if ($this->hasModel())
			echo CHtml::activeTextField($this->model, $this->attribute, $inputOptions);
		else
			echo CHtml::textField($name, $this->value, $inputOptions);

		if (!empty($this->customButton)) {
			echo $this->customButton;
		} else {
			echo CHtml::button('Browse', array('id' => $id . 'browse', 'class' => 'btn'));
		}
		echo CHtml::closeTag('div');

		// set required options
		if (empty($this->popupConnectorRoute))
			throw new CException('$popupConnectorRoute must be set!');
		$url = Yii::app()->controller->createUrl($this->popupConnectorRoute, array('fieldId' => $id));

		echo '<div id="' . $id . '-dialog" style="display:none;" title="' . $this->popupTitle . '">'
		. '<iframe frameborder="0" width="100%" height="100%" src="' . $url . '">'
		. '</iframe>'
		. '</div>';
		$js = '
$("#' . $id . 'browse").click(function(){ $(function() {
	$("#' . $id . '-dialog" ).dialog({
		autoOpen: false,
		position: "center",
		title: "' . $this->popupTitle . '",
		width: 900,
		height: 550,
		resizable : true,
		modal : true,
	}).dialog( "open" );
});});';

		Yii::app()->getClientScript()->registerScript('ServerFileInput#' . $id, $js);
	}

}
