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

	/**
	 * Commands which may be sent by GET - the ones which only read files. Any other command must be sent by POST,
	 * so it is covered by the CSRF validation of Yii, which does not check GET requests. Without this a link opened by
	 * a logged-in user could delete or overwrite files.
	 *
	 * Some of these commands are sent by GET by the client regardless of its `requestType` (a link to a file).
	 *
	 * @var string[]
	 * @since 1.0.5
	 */
	public $getCommands = array('open', 'tree', 'parents', 'ls', 'tmb', 'size', 'dim', 'file', 'get', 'info', 'search');

	public function run() {
		$command = isset($_GET['cmd']) ? $_GET['cmd'] : null;
		if (!Yii::app()->getRequest()->getIsPostRequest() && !in_array($command, $this->getCommands, true)) {
			throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));
		}

		require_once dirname(__FILE__) . '/ElFinderHelper.php';
		$assetsDir = ElFinderHelper::getAssetsDir();
		define('ELFINDER_IMG_PARENT_URL', $assetsDir);

		$php_path = Yii::getPathOfAlias('elFindervendor.php');
		require_once($php_path . '/elFinder.class.php');
		require_once($php_path . '/elFinderConnector.class.php');
		require_once($php_path . '/elFinderVolumeDriver.class.php');
		require_once($php_path . '/elFinderVolumeLocalFileSystem.class.php');
		require_once($php_path . '/elFinderVolumeMySQL.class.php');
		require_once($php_path . '/elFinderVolumeFTP.class.php');

		header("Content-Type: application/json");
		$fm = new elFinderConnector(new elFinder($this->settings));
		$fm->run();
	}

}
