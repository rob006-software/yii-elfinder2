<?php

require_once __DIR__ . '/ElFinderHelper.php';
ElFinderHelper::importTinyMceFileManager();

/**
 * elFinder file manager for TinyMCE.
 *
 * @author Robert Korulczyk <robert@korulczyk.pl>
 * @author Bogdan Savluk <Savluk.Bogdan@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
class TinyMceElFinder extends TinyMceFileManager {

	/** @var string */
	public $popupConnectorRoute = false;
	/** @var array */
	public $popupConnectorParams = [];

	/** @var string */
	public $popupTitle = 'Files';

	public function getFileBrowserCallback() {
		if (empty($this->popupConnectorRoute)) {
			throw new CException('$popupConnectorRoute must be set!');
		}
		$connectorUrl = CJSON::encode(Yii::app()->controller->createUrl($this->popupConnectorRoute, $this->popupConnectorParams));
		$title = CJSON::encode($this->popupTitle);

		$tinymceVersion = 4;
		if (method_exists($this, 'getTinymceVersion')) {
			$tinymceVersion = $this->getTinymceVersion();
		}
		if ($tinymceVersion === 6) {
			/* @noinspection ALL */
			$script = <<<JS
function (callback, value, meta) {
	window.tinymceImageUploadCallback = callback;
	tinymce.activeEditor.windowManager.openUrl({
		url: $connectorUrl,
		title: $title,
		width: 900,
		height: 450,
		resizable: "yes"
	});
	return false;
}
JS;
		} else {
			/* @noinspection ALL */
			$script = <<<JS
function (field_name, url, type, win) {
	tinymce.activeEditor.windowManager.open(
		{
			file: $connectorUrl,
			title: $title,
			width: 900,
			height: 450,
			resizable: "yes"
		}, 
		{
			setUrl: function(url) {
				win.document.getElementById(field_name).value = url;
			}
		}
	);
	window.tinymceImageUploadCallback = tinymce.activeEditor.windowManager.getParams().setUrl;
}
JS;
		}
		return 'js:' . $script;
	}
}
