<?php

/**
 * Class ElFinderPopupAction.
 *
 * @since 1.1.4
 *
 * @author Robert Korulczyk <robert@korulczyk.pl>
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
abstract class ElFinderPopupAction extends CAction {

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

	protected function beforeRun() {
		require_once __DIR__ . '/ElFinderHelper.php';
		ElFinderHelper::registerAlias();
		ElFinderHelper::registerAssets();

		// set required options
		if (empty($this->connectorRoute)) {
			throw new CException('$connectorRoute must be set!');
		}
		$this->settings['url'] = $this->controller->createUrl($this->connectorRoute, $this->connectorParams);
		$this->settings['lang'] = ElFinderHelper::getLanguage();
		$this->settings['baseUrl'] = ElFinderHelper::getAssetsDir() . '/';
		$this->settings['soundPath'] = ElFinderHelper::getAssetsDir() . '/sounds/';

		if (Yii::app()->getRequest()->enableCsrfValidation) {
			$this->settings['customData'] = [
				Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
			];
		}
	}
}
