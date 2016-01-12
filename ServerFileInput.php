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
	 * @var array
	 */
	public $popupConnectorParams = array();

	/**
	 * @var string
	 */
	public $popupTitle = 'Files';

	/**
	 * HTML options for rendered input field
	 * @var array
	 */
	public $inputHtmlOptions = array();

	/**
	 * Custom "Browse" button html code
	 * Button id must be according with the pattern [INPUT_FIELD_ID]browse, for exaple:
	 * CHtml::button('Browse', array('id' => TbHtml::getIdByName(TbHtml::activeName($model, 'header_box_image')) . 'browse'));
	 * @var string
	 */
	public $customButton = '';

	public function run() {
		require_once dirname(__FILE__) . '/ElFinderHelper.php';
		ElFinderHelper::registerAssets();

		if (empty($this->popupConnectorRoute)) {
			throw new CException('$popupConnectorRoute must be set!');
		}

		list($name, $id) = $this->resolveNameID();

		if (isset($this->htmlOptions['id'])) {
			$id = $this->htmlOptions['id'];
		} else {
			$this->htmlOptions['id'] = $id;
		}

		if (isset($this->htmlOptions['name'])) {
			$name = $this->htmlOptions['name'];
		} else {
			$this->htmlOptions['name'] = $name;
		}

		// open container
		$contHtmlOptions = $this->htmlOptions;
		$contHtmlOptions['id'] = $id . 'container';
		echo CHtml::openTag('div', $contHtmlOptions);

		// render input
		$inputOptions = array_merge(array('style' => 'float:left;'), $this->inputHtmlOptions, array('id' => $id));
		if ($this->hasModel()) {
			echo CHtml::activeTextField($this->model, $this->attribute, $inputOptions);
		} else {
			echo CHtml::textField($name, $this->value, $inputOptions);
		}

		// append button to input
		if (!empty($this->customButton)) {
			echo $this->customButton;
		} else {
			echo CHtml::button('Browse', array('id' => $id . 'browse', 'class' => 'btn'));
		}

		// close container
		echo CHtml::closeTag('div');

		$url = Yii::app()->controller->createUrl($this->popupConnectorRoute, array_merge(array('fieldId' => $id), $this->popupConnectorParams));
		$iframe = CHtml::tag('iframe', array(
					'frameborder' => 0,
					'width' => '100%',
					'height' => '100%',
					'src' => $url,
						), '');
		echo CHtml::tag('div', array(
			'id' => $id . '-dialog',
			'style' => 'display:none;',
			'title' => $this->popupTitle,
				), $iframe);

		$js = '
$("#' . $id . 'browse").click(function(){ $(function() {
	$("#' . $id . '-dialog" ).dialog({
		title: ' . CJSON::encode($this->popupTitle) . ',
		width: 900,
		height: 550,
	});
});});';

		Yii::app()->getClientScript()->registerScript('ServerFileInput#' . $id, $js);
	}

}
