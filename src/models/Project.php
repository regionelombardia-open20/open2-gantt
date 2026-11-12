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

namespace lispa\amos\gantt\models;

use yii\base\Event;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class Projects
 * @package lispa\amos\gantt\models
 *
 * @var integer $id
 * @var string $text
 * @var datetime $start_date
 * @var integer $order
 * @var float $progress
 * @var boolean $open
 * @var integer $parent
 * @var array $custom
 * @var array $links
 *
 */
class Project extends Model
{
    public static $TYPE_PROJECT = 'gantt.config.types.project';
    public static $PREFIX_ID = 'p-';

    public $id;
    public $text;
    public $order;
    public $open = true;
    public $parent;
    public $color = "#666666";
    public $textColor = "#FFFFFF";
    public $custom = [];
    public $links = [];

    public $asGanttValue = '{}';

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'text',
                    'custom',
                    'links'
                ],
                'required'
            ],
            [
                [
                    'order',
                    'parent',
                ],
                'integer'
            ],
        ];

    }

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_AFTER_VALIDATE, function (Event $event) {
            $event->sender->asGanttValue = Json::encode(
                ArrayHelper::merge(
                    $event->sender->toArray(),
                    [
                        'id' => self::$PREFIX_ID . $event->sender->id,
                        'text' => $event->sender->text,
                        'type' => self::$TYPE_PROJECT,
                        'readonly' => true
                    ]));
        });

    }

    /**
     * @param int $option
     * @return mixed
     */
    public function toJson($option = 302)
    {
        return Json::encode($this, $option);
    }

}