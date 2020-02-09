<?php

/**
 * elFinder connector
 *
 * @author Robert Korulczyk <robert@korulczyk.pl>
 * @link http://rob006.net/
 * @author Bogdan Savluk <Savluk.Bogdan@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
class ElFinderConnectorAction extends CAction {

	/**
	 * Connector configuration.
	 *
	 * @see https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options
	 * @var array
	 */
	public $settings = [];

	public function run() {
		require_once __DIR__ . '/ElFinderHelper.php';
		ElFinderHelper::registerAssets();

		Yii::import('elFindervendor.php.elFinderSession');
		Yii::import('elFindervendor.php.elFinderSessionInterface');

		$phpPath = Yii::getPathOfAlias('elFindervendor.php');
		/* @noinspection PhpIncludeInspection */
		require_once $phpPath . '/autoload.php';

		header('Content-Type: application/json');
		$fm = new elFinderConnector(new elFinder($this->settings));
		$fm->run();
	}
}
