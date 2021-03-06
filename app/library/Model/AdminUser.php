<?php
/**
 * 管理员用户表
 *
 * @author: xieyong <qxieyongp@163.com>
 * @Date: 2017/8/28
 * @Time: 20:40
 */

namespace Oranger\Library\Model;

use Oranger\Library\Database\DBBase;
use Oranger\Library\Exception\DBException;
use Oranger\Library\Tools\StringHelper;

/**
 * Class AdminUser
 * @package App\Library\Model
 */
class AdminUser extends DBBase
{
    /**
     * @var string 数据库配置名
     */
    protected $config_name = 'db';
    /**
     * @var string 表名
     */
    protected $table = 'admin_user';
    /**
     * @var array 配置
     */
    protected $option = [
        'salt_length' => 6, // 密码加密随机串长度
        'admin_user_info' => [
            'id',
            'username',
            'realname',
            'group',
            'tel',
            'create_time',
            'update_time',
            'status',
        ],
    ];

    /**
     * AdminUser constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 判断用户是否存在
     * @author: xieyong <qxieyongp@163.com>
     * @param string $username username
     *
     * @return bool
     * @throws DBException
     */
    public function isUsernameExist(string $username)
    {
        if (empty($username)) {
            return false;
        }

        $where = [
            'username' => $username,
        ];

        try {
            return $this->isExist($where);
        } catch (\PDOException $e) {
            $this->logger->logException($e);

            throw new DBException('DB_ERROR');
        }
    }

    /**
     * 创建密码加密随机字符串
     * @author: xieyong <qxieyongp@163.com>
     * @return string
     */
    public function createSalt()
    {
        return StringHelper::getRandomString($this->option['salt_length']);
    }

    /**
     * 添加管理员用户
     * @author: xieyong <qxieyongp@163.com>
     * @param array $data
     */
    public function addAdminUser(array $data)
    {
        $user['username'] = $data['username'];
        $user['realname'] = '';
        $user['password'] = $data['password'];
        $user['salt'] = $data['salt'];
        $user['group'] = $data['group'];
        $use['tel'] = $data['tel'];

        $this->insert($user);
    }

    /**
     * 根据uid获取用户信息
     * @author: xieyong <qxieyongp@163.com>
     * @param int $uid uid
     *
     * @return array
     */
    public function getAdminUserById(int $uid)
    {
        return $this->getOne($this->option['admin_user_info'], ['id' => $uid]);
    }

    /**
     * 根据用户名获取用户信息
     * @author: xieyong <qxieyongp@163.com>
     * @param string $username 用户名
     *
     * @return array
     */
    public function getAdminUserByUsername(string $username)
    {
        return $this->getOne($this->option['admin_user_info'], ['username' => $username]);
    }

    /**
     * 分页获取所有管理员用户
     * @author: xieyong <qxieyongp@163.com>
     * @param int $offset
     * @param     $limit
     *
     * @return array
     */
    public function getAllByLimit(int $offset, $limit)
    {
        $where = [
            'ORDER' => [
                'group' => 'ASC',
                'update_time' => 'DESC',
            ],
            'LIMIT' => [$offset, $limit],
        ];

        return $this->getData($this->option['admin_user_info'], $where);
    }

    /**
     * 根据uid删除用户
     * @author: xieyong <qxieyongp@163.com>
     * @param int $uid uid
     *
     * @return \PDOStatement
     */
    public function deleteAdminUserById(int $uid)
    {
        return $this->delete(['id' => $uid]);
    }
}
