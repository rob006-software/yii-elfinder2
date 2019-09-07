<?php

/**
 * Action creates content for file browse popup window with elFinder widget
 *
 * @author Robert Korulczyk <robert@korulczyk.pl>
 * @link http://rob006.net/
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
class ServerFileInputElFinderPopupAction extends CAction {

	/** @var string */
	public $connectorRoute = false;
	/** @var array */
	public $connectorParams = [];
	/**
	 * Popup title.
	 *
	 * @var string
	 */
	public $title = 'Files';
	/**
	 * Client settings.
	 *
	 * @see https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
	 * @var array
	 */
	public $settings = [];

	public function run() {
		require_once __DIR__ . '/ElFinderHelper.php';
		ElFinderHelper::registerAlias();
		ElFinderHelper::registerAssets();

		if (empty($_GET['fieldId']) || !preg_match('/[a-z0-9\-_]/i', $_GET['fieldId'])) {
			throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));
		}

		// set required options
		if (empty($this->connectorRoute)) {
			throw new CException('$connectorRoute must be set!');
		}
		$this->settings['url'] = $this->controller->createUrl($this->connectorRoute, $this->connectorParams);
		$this->settings['lang'] = Yii::app()->language;
		$this->settings['soundPath'] = ElFinderHelper::getAssetsDir() . '/sounds/';

		if (Yii::app()->getRequest()->enableCsrfValidation) {
			$this->settings['customData'] = [
				Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
			];
		}

		$this->controller->layout = false;
		$this->controller->render('elFinder.views.ServerFileInputElFinderPopupAction', [
			'title' => $this->title, 'settings' => $this->settings, 'fieldId' => $_GET['fieldId'],
		]);
	}
}
