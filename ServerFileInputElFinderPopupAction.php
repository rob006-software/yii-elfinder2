<?php

/**
 * Action creates content for file browse popup window with elFinder widget
 *
 * @author Robert Korulczyk <robert@korulczyk.pl>
 * @link http://rob006.net/
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
class ServerFileInputElFinderPopupAction extends ElFinderPopupAction {

	public function run() {
		if (empty($_GET['fieldId']) || !preg_match('/[a-z0-9\-_]/i', $_GET['fieldId'])) {
			throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));
		}

		$this->beforeRun();

		$this->controller->layout = false;
		$this->controller->render('elFinder.views.ServerFileInputElFinderPopupAction', [
			'title' => $this->title,
			'settings' => $this->settings,
			'fieldId' => $_GET['fieldId'],
		]);
	}
}
