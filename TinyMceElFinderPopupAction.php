<?php

/**
 * Action creates content for TinyMCE popup window with elFinder widget
 *
 * @author Robert Korulczyk <robert@korulczyk.pl>
 * @link http://rob006.net/
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
class TinyMceElFinderPopupAction extends CAction {

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
		require_once dirname(__FILE__) . '/ElFinderHelper.php';
		ElFinderHelper::registerAlias();
		ElFinderHelper::registerAssets();

		// set required options
		if (empty($this->connectorRoute)) {
			throw new CException('$connectorRoute must be set!');
		}
		$this->settings['url'] = $this->controller->createUrl($this->connectorRoute, $this->connectorParams);
		$this->settings['lang'] = Yii::app()->language;

		if (Yii::app()->getRequest()->enableCsrfValidation) {
			$this->settings['customData'] = array(
				Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
			);
		}

		$this->controller->layout = false;
		$this->controller->render('elFinder.views.TinyMceElFinderPopupAction', array(
			'title' => $this->title, 'settings' => $this->settings));
	}

}
