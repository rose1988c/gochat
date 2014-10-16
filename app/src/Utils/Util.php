<?php
namespace Utils;

class Util
{
    public static function ArrayColumn($input, $indexKey, $columnKey) {
        $columnKeyIsNumber = (is_numeric($columnKey)) ? true : false;
        $indexKeyIsNull = (is_null($indexKey)) ? true : false;
        $indexKeyIsNumber = (is_numeric($indexKey)) ? true : false;
        $result = array ();
        foreach((array)$input as $key => $row) {
            if($columnKeyIsNumber) {
                $tmp = array_slice($row, $columnKey, 1);
                $tmp = (is_array($tmp) &&  ! empty($tmp)) ? current($tmp) : null;
            } else {
                if(strstr($columnKey, ',')) {
                    $field = explode(',', $columnKey);
                    $c = array ();
                    foreach((array)$field as $fv) {
                        $c [$fv] = isset($row [$fv]) ? $row [$fv] : null;
                    }
                    $tmp = $c;
                } else {
                    $tmp = isset($row [$columnKey]) ? $row [$columnKey] : null;
                }
            }
            if( ! $indexKeyIsNull) {
                if($indexKeyIsNumber) {
                    $key = array_slice($row, $indexKey, 1);
                    $key = (is_array($key) &&  ! empty($key)) ? current($key) : null;
                    $key = is_null($key) ? 0 : $key;
                } else {
                    $key = isset($row [$indexKey]) ? $row [$indexKey] : 0;
                }
            }
            $result [$key] = $tmp;
        }
        return $result;
    }
    
    /**
     * 根据字段反压缩
     * 
     * @param array $array
     * @param unknown $key
     * @return multitype:
     */
    public static function arrayUnFlatten(array $array, $key) {
        $nmenu = array();
        foreach ($array as $k => $value) {
            if (is_array($value[$key]) && !empty($value[$key])){
                foreach ((array)$value[$key] as $v) {
                    $nmenu[] = $v;
                }
            }
            unset($value[$key]);
            $nmenu[] = $value;
        }
        return array_filter($nmenu);
    }

    /**
     * 树形
     * 
     * @param unknown $list
     * @param string $pk
     * @param string $pid
     * @param string $child
     * @param number $root
     * @return multitype:unknown
     */
    static function listToTree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0) {
        // 创建Tree
        $tree = array ();
        if(is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array ();
            foreach($list as $key => $data) {
                $refer [$data [$pk]] = & $list [$key];
            }
            foreach($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data [$pid];
                if($root == $parentId) {
                    $tree [] = & $list [$key];
                } else {
                    if(isset($refer [$parentId])) {
                        $parent = & $refer [$parentId];
                        $parent [$child] [] = & $list [$key];
                    }
                }
            }
        }
        return $tree;
    }

    /**
     * packRawCriteria
     *
     * @param array $criteria            
     * @return multitype:
     */
    public static function packRawCriteria(array $criteria) {
        $raw = array ();
        $data = array ();
        foreach((array)$criteria as $row => $value) {
            
            if($value == 0) {
                $raw [] = $row . ' = ?';
            }
            
            if ($value != false){
                if (strstr($row, '__'))
                {
                    $optmap = array (
                        'like' => ' like ',
                        'gte' => ' >= ',
                        'gt' => ' > ',
                        'lte' => ' <= ',
                        'lt' => ' < ',
                        'ne' => ' != '
                    );
                    list($row, $rule) = explode('__', $row);
                    $raw [] = $row . $optmap[$rule] . '?';
                } else {
                    $raw [] = $row . ' = ?';
                }
                $data[] = $value;
            }
        }
        
        if( ! empty($raw)) {
            $raw = implode(' and ', $raw);
        }
        return compact('raw', 'data');
    }
    

    //v4 框架图片地址 根据图片相对地址，取得觉得URL，也可以通过SRC_PRE
    public static function get_real_src($path) {
        return 'http://img1.qpdiy.com' . $path;
    }
    
    public static function mobile_shield($phone)
    {
        return  preg_replace('/(1[0-9]{1}[0-9])[0-9]{4}([0-9]{4})/i','$1****$2', $phone);
    }

}