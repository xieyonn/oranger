<?php
/**
 * @brief 键值对工具
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2019-03-14 14:47
 */

namespace Oranger\Library\Service;

use Oranger\Library\Model\KeyValConfig;

class KeyValService
{
    const CACHE_KEY_PREFIX = 'KEY_VAL_SERVICE#';

    private $group;

    private $table;

    private $di;

    private $expire_time;

    private $use_cache;

    private $db;

    public function __construct($group = 'system', $use_cache = false, $expire_time = 60)
    {
        $this->group = $group;
        $this->use_cache = $use_cache;
        $this->expire_time = $expire_time;
        $this->table = KeyValConfig::tableName();
        $this->di = DI::getInstance();
    }

    /**
     * 设置key val键值对
     *
     * @param  string $key key
     * @param  string $val val
     * @return void
     */
    public function set($key, $val)
    {
        if (empty($key)) {
            throw new KeyValServiceException('EMPTY_KEY');
        }

        $data = $this->getFromMysql($key);
        if ($data === false) {
            $this->insert($key, $val);
        } else {
            $this->update($key, $val);
        }

        if ($this->use_cache) {
            $this->setCache($key, $val);
        }
    }

    /**
     * 获取值
     *
     * @param  string       $key key
     * @return array|string
     */
    public function get($key)
    {
        if ($this->use_cache) {
            $cache = $this->getCache($key);

            if ($cache !== null) {
                return $cache;
            }

            $data = $this->getFromMysql($key);
            if ($data === false) {
                throw new KeyValServiceException('CONFIG_NOT_SET', ['k' => $key]);
            }
            $this->setCache($key, $data);
            return $data;
        }

        $data = $this->getFromMysql($key);
        if ($data === false) {
            throw new KeyValServiceException('CONFIG_NOT_SET', ['k' => $key]);
        }

        return $data;
    }

    /**
     * 获取一组下的全部键值对
     *
     * @return array
     */
    public function getGroup()
    {
        if ($this->use_cache) {
            $cache = $this->getCache();

            if ($cache !== null) {
                return $cache;
            }

            $data = $this->getAllFromMysql();
            if (! empty($data)) {
                $this->setCache('', \json_encode($data));
            }
            return $data;
        }

        return $this->getAllFromMysql();
    }

    /**
     * 删除
     *
     * @param  string $key key 为空时删除一组配置
     * @return void
     */
    public function del($key = '')
    {
        if ($key === '') {
            $sql = <<<EOL
delete from {$this->table}
where `group` = :group
EOL;
            $this->db->createCommand($sql, [':group' => $this->group])->execute();
            if ($this->use_cache) {
                $this->di->redis->del(self::CACHE_KEY_PREFIX . $this->group);
            }
        } else {
            $sql = <<<EOL
delete from {$this->table}
where `group` = :group
and `k` = :k
EOL;
            $this->db->createCommand($sql, [
                ':group' => $this->group,
                ':k' => $key,
            ])->execute();
            if ($this->use_cache) {
                $this->di->redis->del(self::CACHE_KEY_PREFIX . $this->group . '#' . $key);
            }
        }
    }

    private function getFromMysql($key)
    {
        $sql = <<<EOL
select `v`
from {$this->table}
where `group` = :group
and `k` = :k
EOL;
        $data = $this->db->createCommand($sql, [
            ':group' => $this->group,
            ':k' => $key,
        ])->queryOne();

        if (isset($data['v'])) {
            return $data['v'];
        }
        return false;
    }

    private function getAllFromMysql()
    {
        $sql = <<<EOL
select `k`, `v`
from {$this->table}
where `group` = :group
EOL;
        $data = $this->db->createCommand($sql, [
            ':group' => $this->group,
        ])->queryAll();

        $rtv = [];
        foreach ($data as $entry) {
            $rtv[$entry['k']] = $entry['v'];
        }

        return $rtv;
    }

    private function insert($key, $val)
    {
        $now = time();

        $sql = <<<EOL
insert into {$this->table}
(`group`, `k`, `v`, `create_time`, `update_time`)
values
(:group, :k, :v, {$now}, {$now})
EOL;
        $this->db->createCommand($sql, [
            ':group' => $this->group,
            ':k' => $key,
            ':v' => $val,
        ])->execute();
    }

    private function update($key, $val)
    {
        $now = time();
        $sql = <<<EOL
update {$this->table}
set `v` = :v, `update_time` = {$now}
where `group` = :group
and `k` = :k
EOL;
        $this->db->createCommand($sql, [
            ':group' => $this->group,
            ':k' => $key,
            ':v' => $val,
        ])->execute();
    }

    private function setCache($key, $val)
    {
        if ($key === '') {
            // group
            $cache_key = self::CACHE_KEY_PREFIX . $this->group;
        } else {
            $cache_key = self::CACHE_KEY_PREFIX . $this->group . '#' . $key;
        }

        try {
            $this->di->redis->setex($cache_key, $this->expire_time, $val);
        } catch (\Exception $e) {
            throw new KeyValServiceException('SET_REDIS_ERROR', [], $e);
        }
    }

    private function getCache($key = '')
    {
        if ($key === '') {
            // 取group
            $cache_key = self::CACHE_KEY_PREFIX . $this->group;
            $cache = $this->di->redis->get($cache_key);
            if ($cache === null) {
                return;
            }
            return \json_decode($cache, true);
        }
        $cache_key = self::CACHE_KEY_PREFIX . $this->group . '#' . $key;
        return $this->di->redis->get($cache_key);
    }
}
