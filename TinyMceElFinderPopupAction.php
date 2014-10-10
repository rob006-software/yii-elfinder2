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
		$alias = 'ext.elFinder';
		if (is_file(Yii::getPathOfAlias('ext.elFinder.ElFinderHelper'))) {
			Yii::import('ext.elFinder.ElFinderHelper');
		} else {
			Yii::import('elFinder.ElFinderHelper');
			$alias = 'elFinder';
		}
		ElFinderHelper::registerAssets();

		// set required options
		if (empty($this->connectorRoute))
			throw new CException('$connectorRoute must be set!');
		$settings = array(
			'url' => $this->controller->createUrl($this->connectorRoute),
			'lang' => Yii::app()->language,
		);

		$this->controller->layout = false;
		$this->controller->render($alias.'.views.TinyMceElFinderPopupAction', array('title' => $this->title,
			'settings' => CJavaScript::encode($settings)));
	}

}
