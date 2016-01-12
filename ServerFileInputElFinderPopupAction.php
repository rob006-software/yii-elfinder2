<?php

/**
 * Action creates content for file browse popup window with elFinder widget
 *
 * @author Robert Korulczyk <robert@korulczyk.pl>
 * @link http://rob006.net/
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
class ServerFileInputElFinderPopupAction extends CAction {

	/**
	 * @var string
	 */
	public $connectorRoute = false;

	/**
	 * @var array
	 */
	public $connectorParams = array();

	/**
	 * Popup title
	 * @var string
	 */
	public $title = 'Files';

	/**
	 * Client settings.
	 * @see https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
	 * @var array
	 */
	public $settings = array();

	public function run() {
		Yii::import('ext.elFinder.ElFinderHelper');
		ElFinderHelper::registerAssets();

		if(empty($_GET['fieldId']) || !preg_match('/[a-z0-9\-_]/i', $_GET['fieldId'])) {
			throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));
		}

		// set required options
		if (empty($this->connectorRoute)) {
			throw new CException('$connectorRoute must be set!');
		}
		$this->settings['url'] = $this->controller->createUrl($this->connectorRoute, $this->connectorParams);
		$this->settings['lang'] = Yii::app()->language;

		$this->controller->layout = false;
		$this->controller->render('ext.elFinder.views.ServerFileInputElFinderPopupAction', array(
			'title' => $this->title, 'settings' => $this->settings, 'fieldId' => $_GET['fieldId']));
	}

}
