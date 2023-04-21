<?php
namespace App\Model\User;
use PhalApi\Model\DataModel;

class User extends DataModel {

    protected function getTableName($id) {
        return 'userinfo';
    }

    public function getInfo($userId) {
        return $this->getORM()->select('*')->where('uid = ?', $userId)->fetch();
    }

    /**
     * 批量获取用户快照，并进行反转，以便外部查找
     */
    public function getSnapshotByUserIds(array $userIds)
    {
        $rs = array();
        if (empty($userIds)) {
            return $rs;
        }

        $rows =self::getORM()
            ->select('uid,nickname,portrait')
            ->where('uid', $userIds)
            ->fetchAll();

        foreach ($rows as $row) {
            $rs[$row['uid']] = $row;
        }

        return $rows;
    }
}