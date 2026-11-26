<?php

/**
 * elFinder connector.
 *
 * @author Robert Korulczyk <robert@korulczyk.pl>
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
	/**
	 * Commands which may be sent by GET - the ones which only read files. Any other command must be sent by POST,
	 * so it is covered by the CSRF validation of Yii, which does not check GET requests. Without this a link opened by
	 * a logged-in user could delete or overwrite files.
	 *
	 * Some of these commands are sent by GET by the client regardless of its `requestType` (a link to a file,
	 * the download of an archive).
	 *
	 * @var string[]
	 * @since 1.1.10
	 */
	public $getCommands = ['open', 'tree', 'parents', 'ls', 'tmb', 'size', 'dim', 'file', 'get', 'info', 'search', 'zipdl'];

	public function run() {
		$command = isset($_GET['cmd']) ? $_GET['cmd'] : null;
		if (!Yii::app()->getRequest()->getIsPostRequest() && !in_array($command, $this->getCommands, true)) {
			throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));
		}

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
