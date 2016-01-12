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
		ElFinderHelper::registerAlias();
		$php_path = Yii::getPathOfAlias('elFindervendor.php');
		require_once($php_path . '/elFinder.class.php');
		require_once($php_path . '/elFinderConnector.class.php');
		require_once($php_path . '/elFinderVolumeDriver.class.php');
		require_once($php_path . '/elFinderVolumeLocalFileSystem.class.php');
		require_once($php_path . '/elFinderVolumeMySQL.class.php');
		require_once($php_path . '/elFinderVolumeFTP.class.php');

		// path for icons
		$dir = Yii::getPathOfAlias('elFindervendor.assets');
		$assetsDir = Yii::app()->getAssetManager()->publish($dir);
		define('ELFINDER_IMG_PARENT_URL', $assetsDir);

		header("Content-Type: application/json");
		$fm = new elFinderConnector(new elFinder($this->settings));
		$fm->run();
	}

}
