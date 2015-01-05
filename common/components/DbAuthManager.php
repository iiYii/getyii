<?php
namespace common\components;

use yii\db\Query;
use yii\rbac\Item;
use yii\rbac\DbManager;

class DbAuthManager extends DbManager
{
    protected function getChildrenListOfType($type)
    {
        $query = (new Query)->from($this->itemChildTable)
            ->join('INNER JOIN', $this->itemTable, implode(' AND ', [
                $this->itemTable . '.name=' . $this->itemChildTable . '.child',
                $this->itemTable . '.type = ' . $type
            ]));
        $parents = [];
        foreach ($query->all($this->db) as $row) {
            $parents[$row['parent']][] = $row['child'];
        }
        return $parents;
    }

    /**
     * @params bool $recursive 是否递归显示子角色权限
     * @inheritdoc
     */
    public function getPermissionsByRole($roleName, $recursive = true)
    {
        $childrenList = $recursive ? $this->getChildrenList() : $this->getChildrenListOfType(Item::TYPE_PERMISSION);
        $result = [];
        $this->getChildrenRecursive($roleName, $childrenList, $result);
        if (empty($result)) {
            return [];
        }
        $query = (new Query)->from($this->itemTable)->where([
            'type' => Item::TYPE_PERMISSION,
            'name' => array_keys($result),
        ]);
        $permissions = [];
        foreach ($query->all($this->db) as $row) {
            $permissions[$row['name']] = $this->populateItem($row);
        }
        return $permissions;
    }
}
