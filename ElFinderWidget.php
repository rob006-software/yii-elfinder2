<?php

/**
 * elFinder widget.
 *
 * @author Robert Korulczyk <robert@korulczyk.pl>
 * @author Bogdan Savluk <Savluk.Bogdan@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
class ElFinderWidget extends CWidget {

	/**
	 * Client settings.
	 *
	 * @see https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
	 * @var array
	 */
	public $settings = [];
	/** @var string */
	public $connectorRoute = false;
	/** @var array */
	public $connectorParams = [];

	public function run() {
		require_once __DIR__ . '/ElFinderHelper.php';
		ElFinderHelper::registerAssets();

		// set required options
		if (empty($this->connectorRoute)) {
			throw new CException('$connectorRoute must be set!');
		}
		$this->settings['url'] = $this->controller->createUrl($this->connectorRoute, $this->connectorParams);
		$this->settings['lang'] = Yii::app()->language;

		if (Yii::app()->getRequest()->enableCsrfValidation) {
			$this->settings['customData'] = [
				Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
			];
		}

		$id = $this->getId();
		$settings = CJavaScript::encode($this->settings);
		$cs = Yii::app()->getClientScript();
		$cs->registerScript("elFinder#$id", "$('#$id').elfinder($settings);");
		echo CHtml::tag('div', ['id' => $id], '');
	}
}
