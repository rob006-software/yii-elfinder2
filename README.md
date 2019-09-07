elFinder 2.1 integration for Yii 1.1
====================================

Based on https://bitbucket.org/z_bodya/yii-elfinder with updated [elFinder](https://github.com/Studio-42/elFinder) and some code improvements.

How to use
----------

1. Checkout source code to your project to ext.elFinder.
   You can use custom elFinder code, just set `elFindervendor` alias to point your elFinder code directory.

   ```php
   'aliases' => [
       'elFindervendor' => 'vendor.myCystomElFinder',
   ],
   ```

   You can get elFinder from https://github.com/Studio-42/elFinder/releases - remember to move `css`, `img`, `js`
   and `sounds` directories to `assets` directory, so elFinder source will look like:

   ![](http://f.rob006.net/p/2016/5acc96076751b96d9d94cc3f65de.png)

2. Create controller for connector action, and configure it params

   ```php
   class ElfinderController extends Controller {
   
       // don't forget configure access rules
   
       public function actions() {
           return [
               // main action for elFinder connector
               'connector' => [
                   'class' => 'ext.elFinder.ElFinderConnectorAction',
                   // elFinder connector configuration
                   // https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options
                   'settings' => [
                       'roots' => [
                           [
                               'driver' => 'LocalFileSystem',
                               'path' => Yii::getPathOfAlias('webroot') . '/files/',
                               'URL' => Yii::app()->baseUrl . '/files/',
                               'alias' => 'Root Alias',
                               'acceptedName' => '/^[^\.].*$/', // disable creating dotfiles
                               'attributes' => [
                                   [
                                       'pattern' => '/\/[.].*$/', // hide dotfiles
                                       'read' => false,
                                       'write' => false,
                                       'hidden' => true,
                                   ],
                               ],
                           ],
                       ],
                   ],
               ],
               // action for TinyMCE popup with elFinder widget
               'elfinderTinyMce' => [
                   'class' => 'ext.elFinder.TinyMceElFinderPopupAction',
                   'connectorRoute' => 'connector', // main connector action id
               ],
               // action for file input popup with elFinder widget
               'elfinderFileInput' => [
                   'class' => 'ext.elFinder.ServerFileInputElFinderPopupAction',
                   'connectorRoute' => 'connector', // main connector action id
               ],
           ];
       }
   }
   ```

3. ServerFileInput - use this widget to choose file on server using elFinder pop-up

   ```php
   $this->widget('ext.elFinder.ServerFileInput', [
       'model' => $model,
       'attribute' => 'field_name',
       'popupConnectorRoute' => 'elfinder/elfinderFileInput', // relative route for file input action
       // ability to customize "Browse" button
   //	'customButton' => CHtml::button('Browse images', [
   //		'id' => CHtml::getIdByName(CHtml::activeName($model, 'field_name')) . 'browse',
   //		'class' => 'btn', 'style' => 'margin-left:10px',
   //	]),
       // title for popup window (optional)
       'popupTitle' => 'Files',
   ]);
   ```

4. ElFinderWidget - use this widget to manage files

   ```php
   $this->widget('ext.elFinder.ElFinderWidget', [
       'connectorRoute' => 'elfinder/connector', // relative route for elFinder connector action
   ]);
   ```

5. TinyMceElFinder - use this widget to integrate elFinder with [yii-tinymce](https://github.com/rob006/yii-tinymce)

   ```php
   $this->widget('ext.tinymce.TinyMce', [
       'model' => $model,
       'attribute' => 'content',
       'fileManager' => [
           'class' => 'ext.elFinder.TinyMceElFinder',
           'popupConnectorRoute' => 'elfinder/elfinderTinyMce', // relative route for TinyMCE popup action
           // title for popup window (optional)
           'popupTitle' => 'Files',
       ],
   ]);
   ```
