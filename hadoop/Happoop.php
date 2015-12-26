<?php

/**
 * Content: 处理文章的单词数
 * Created by PhpStorm.
 * User: acer
 * Date: 2015/12/26
 * Time: 20:47
 */
class Happoop
{
    /**
     * 消息队列，将消息传递到不同机器上处理
     * 作业的输入，将作业分类，交由不同的mapper处理
     * 如果是文件的话，按照文件的大小进行块划分
     */

    /**
     * Mapper函数，将输入处理成Reduce需要的格式
     */
    public function mapper($array)
    {
        $middleResult = array();
        foreach ($array as $value) {
            $middleResult[$value]++;
        }
        return $middleResult;
    }

    /**
     * 为了减少数据通信开销，mapping出的键值对数据在进入真正的reduce前，进行重复键合并。
     * 它负责对中间过程的输出进行本地的聚集，这会有助于降低从Mapper到 Reducer数据传输量。
     * 这样做默认将所有的mapper结果进行了一次处理。
     */
    public function combine($array)
    {
        $combineResult = array();
        foreach ($array as $value) {
            foreach ($value as $word => $count) {
                $combineResult[$word] += $count;
            }
        }
        return $combineResult;
    }

    
}