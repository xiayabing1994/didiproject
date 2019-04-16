<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/29
 * Time: 16:21
 */
namespace datamodel;

class BaseDataModel extends \think\Model
{
    //增加插入数据，返回影响的记录数
    public function addEntity(array $insertData)
    {
       return $this->data($insertData)->save();
    }
    //增加插入数据，返回增加的主键
    public function addEntityReturnID(array $insertData)
    {
        return $this->insertGetId($insertData);
    }
    //批量增加，返回新增的数据集（包含自增主键）

    /**
     * 根据条件增加记录
     * @access public
     * @param array $insertData
     * @return array|false
     * @throws \Exception
     */
    public function addMultiEntity(array $insertData)
    {
       return $this->saveAll($insertData);
    }
     //根据条件，更新记录，可更新多条，返回修改的记录数量，模型方法
    public function updateEntity(array $where,array $data)
    {
       return $this->save($data,$where);
    }
    //根据条件，更新记录，可更新多条，返回修改的记录数量，DB方法，可不考虑使用
    public function updateMultiEntity(array $where,array $data)
    {
       return $this->where($where)->update($data);
    }

    /**
     * 根据条件增加记录
     * @access public
     * @param int|array id
     * @return int
     * @throws \think\Exception
     */
    public function updateSetInc(array $where,$field,$num)
    {
        if(empty($where) || !is_array($where))
        {
            die('危险操作');
        }else
        {
            return $this->where($where)->setInc($field,$num);
        }
    }

    /**
     * 根据条件减少记录
     * @access public
     * @param int|array $id
     * @throws \think\Exception
     * @return int
     */

    public function updateSetDec(array $where,$field,$num)
    {
        if(empty($where) || !is_array($where))
        {
            die('危险操作');
        }else
        {
            return $this->where($where)->setDec($field,$num);
        }

    }

    /**
     * 删除记录，返回删除的记录数量
     * @access public
     * @param int|array $id
     * @return int
     */
    public function deleteEntity($id)
    {
        return $this->destroy($id);
    }
    /*
     * 根据条件删除记录，返回影响的记录数量
     */
    public function deleteByWhere(array $where)
    {
        return $this->where($where)->delete();
        
    }

    /**
     * 获取单个记录，根据主键ID
     * @param $id
     * @return null|static
     * @throws \think\Exception
     */
    public function getSingle($id)
    {
        return $this::get($id);
    }

    /**
     * 根据多个主键获取记录
     * @param array $ids 主键ID数组
     * @return false|static[]
     * @throws \think\Exception
     */
    public function getAllSingle(array $ids)
    {
        return $this::all($ids);
    }

    /**
     * 单表查询
     * @param array $where 查询条件
     * @param array $fields 查询字段
     * @param null|string $groupField 分组字段
     * @param array|null $orderule 排序规则的数组表达式
     * @param int $pageindex 当前页码
     * @param int $pagesize 页码量
     * @throws \think\Exception
     * @return false|\PDOStatement|string|\think\Collection|array
     */
    public function queryEntity(array $where,array $fields,$groupField=null,array $orderule=null,$pageindex=0,$pagesize=10,array $whereOr=null)
    {

         if($pageindex===0)
         {
             return $this->where($where)->whereOr($whereOr)->field($fields)->group($groupField)->order($orderule)->select()->toArray();

         }
        else
        {
            return $this->where($where)->whereOr($whereOr)->field($fields)->group($groupField)->order($orderule)->page($pageindex,$pagesize)->select()->toArray();

        }
    }

    /**
     * 多表查询
     * @param array $join 多表连接的条件数组
     * @param array $where  查询条件
     * @param array $field 查询字段
     * @param null|string $groupField 分组字段
     * @param array|null $orderule 排序规则的数组表达式
     * @param int $pageindex 当前页码
     * @param int $pagesize 页码量
     * @throws \think\Exception
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function queryRelation(array $join,array $where,array $field,$groupField=null,array $orderule=null,$pageindex=0,$pagesize=10)
    {
          if($pageindex===0)
          {
              return $this->alias('a')->join($join)->where($where)->field($field)->group($groupField)->order($orderule)->select()->toArray();
          }
        else
        {
            return $this->alias('a')->join($join)->where($where)->field($field)->group($groupField)->order($orderule)->page($pageindex,$pagesize)->select()->toArray();

        }
    }

    public function queryRelationor(array $join,array $where,$whereor,array $field,$groupField=null,array $orderule=null,$pageindex=0,$pagesize=10)
    {
        if($pageindex===0)
        {
            return $this->alias('a')->join($join)->where($where)->whereOr($whereor)->field($field)->group($groupField)->order($orderule)->select();
        }
        else
        {
            return $this->alias('a')->join($join)->where($where)->whereOr($whereor)->field($field)->group($groupField)->order($orderule)->page($pageindex,$pagesize)->select();

        }
    }

    public function queryRelationwhereor(array $join,$whereor,array $field,$groupField=null,array $orderule=null,$pageindex=0,$pagesize=10)
    {
        if($pageindex===0)
        {
            return $this->alias('a')->join($join)->whereOr($whereor)->field($field)->group($groupField)->order($orderule)->select();
        }
        else
        {
            return $this->alias('a')->join($join)->whereOr($whereor)->field($field)->group($groupField)->order($orderule)->page($pageindex,$pagesize)->select();

        }
    }

    /** 单表查询数量
     * @param array $where 查询条件
     * @param string $field 查询的字段
     * @return int|string
     */
    public function getCount(array $where,$field)
    {
       return $this->where($where)->count($field);
    }
    public function getMax(array $where,$field)
    {
       return $this->where($where)->max($field);
    }
    public function getMin(array $where,$field)
    {
        return $this->where($where)->min($field);
    }
    public function getSum(array $where,$field)
    {
        return $this->where($where)->sum($field);
        
    }
    public function queryorfind($where,$field,$whereor)
    {
        return $this->field($field)->where($where)->whereOr($whereor)->find();
    }
    public function queryfind($where,$field)
    {
        return $this->field($field)->where($where)->find() ? $this->field($field)->where($where)->find()->toArray() : null ;
    }
    public function querycount(array $where,$field='id')
    {
        return $this->where($where)->count($field);
    }

    public function queryorcount(array $where,$whereor,$field='id')
    {
        return $this->where($where)->whereOr($whereor)->count($field);
    }


}