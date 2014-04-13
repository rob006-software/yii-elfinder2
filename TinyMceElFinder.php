<?php

Yii::import('ext.tinymce.TinyMceFileManager');

/**
 * elFnder file manager for TinyMCE
 *
 * @author Robert Korulczyk <robert@korulczyk.pl>
 * @link http://rob006.net/
 * @author Bogdan Savluk <Savluk.Bogdan@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
class TinyMceElFinder extends TinyMceFileManager {

	/**
	 * @var string
	 */
	public $popupConnectorRoute = false;

	/**
	 * @var string
	 */
	public $popupTitle = 'Files';

	public function getFileBrowserCallback() {
		if (empty($this->popupConnectorRoute))
			throw new CException('$popupConnectorRoute must be set!');
		$connectorUrl = Yii::app()->controller->createUrl($this->popupConnectorRoute);

		$script = <<<JS
function (field_name, url, type, win) {
	tinymce.activeEditor.windowManager.open({
		file: '$connectorUrl',
		title: '{$this->popupTitle}',
		width: 900,
		height: 450,
		resizable: "yes"
	}, {
		setUrl: function(url) {
			win.document.getElementById(field_name).value = url;
		}
	});
	return false;
}
JS;
		return 'js:' . $script;
	}

}
