<?php

/**
 * Action creates content for TinyMCE popup window with elFinder widget.
 *
 * @author Robert Korulczyk <robert@korulczyk.pl>
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
class TinyMceElFinderPopupAction extends ElFinderPopupAction {

	public function run() {
		$this->beforeRun();

		$this->controller->layout = false;
		$this->controller->render('elFinder.views.TinyMceElFinderPopupAction', [
			'title' => $this->title,
			'settings' => $this->settings,
		]);
	}
}
