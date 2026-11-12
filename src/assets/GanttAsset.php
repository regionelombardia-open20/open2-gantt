<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   lispa\amos-gantt
 * @author    Aria S.p.A. <protocollo@pec.ariaspa.it>
 * @license   GNU General Public License v3.0 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @link      https://www.ariaspa.it/
 *
 * This file is part of OPEN 2.0.
 *
 * OPEN 2.0 is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OPEN 2.0 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OPEN 2.0. If not, see <https://www.gnu.org/licenses/>.
 */

namespace lispa\amos\gantt\assets;

use yii\helpers\StringHelper;
use yii\web\AssetBundle;

/**
 * Class GanttAsset
 * @package lispa\amos\core\views\assets
 *
 */
class GanttAsset extends AssetBundle
{

    /**
     * @var string the language.
     *
     * It is recommended that you use [IETF language tags](http://en.wikipedia.org/wiki/IETF_language_tag).
     * For example, `en` stands for English, while `en-US` stands for English (United States).
     *
     * If [[language]] is not set, it will be set as language application
     *
     */
    public $language = null;

    public $sourcePath = '@bower/gantt';

    public $js = [
        'codebase/dhtmlxgantt.js',
        'codebase/ext/dhtmlxgantt_tooltip.js',
        'codebase/ext/dhtmlxgantt_fullscreen.js',
    ];

    public $css = [
        'codebase/dhtmlxgantt.css',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    /**
     * @inheritdoc
     */
    public function registerAssetFiles($view)
    {
        $language = $this->language ? $this->language : \Yii::$app->language;
        if (isset($language)) {
            $language = StringHelper::byteSubstr($language, 0, 2);
        }
        if (isset($language) && $language != 'en') {
            $this->js[] = "codebase/locale/locale_{$language}.js";
        } else {
            $this->js[] = "codebase/locale/locale.js";
        }

        parent::registerAssetFiles($view);
    }

}