<?php

namespace mdm\admin\controllers;

use mdm\admin\components\ItemController as Item1Controller;
use yii\rbac\Item;

/**
 * PermissionController implements the CRUD actions for AuthItem model.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class PermissionController extends Item1Controller
{

    /**
     * @inheritdoc
     */
    public function labels()
    {
        return[
            'Item' => 'Permission',
            'Items' => 'Permissions',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return Item::TYPE_PERMISSION;
    }
}
