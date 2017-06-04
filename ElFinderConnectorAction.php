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
	 * Connector configuration
	 * @see https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options
	 * @var array
	 */
	public $settings = array();

	public function run() {
		require_once dirname(__FILE__) . '/ElFinderHelper.php';
		$assetsDir = ElFinderHelper::getAssetsDir();
		define('ELFINDER_IMG_PARENT_URL', $assetsDir);

		Yii::import('elFindervendor.php.elFinderSession');
		Yii::import('elFindervendor.php.elFinderSessionInterface');

		$php_path = Yii::getPathOfAlias('elFindervendor.php');
		require_once($php_path . '/autoload.php');

		header("Content-Type: application/json");
		$fm = new elFinderConnector(new elFinder($this->settings));
		$fm->run();
	}

}
