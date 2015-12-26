<?php

/**
 * Content: �������µĵ�����
 * Created by PhpStorm.
 * User: acer
 * Date: 2015/12/26
 * Time: 20:47
 */
class Happoop
{
    /**
     * ��Ϣ���У�����Ϣ���ݵ���ͬ�����ϴ���
     * ��ҵ�����룬����ҵ���࣬���ɲ�ͬ��mapper����
     * ������ļ��Ļ��������ļ��Ĵ�С���п黮��
     */

    /**
     * Mapper�����������봦���Reduce��Ҫ�ĸ�ʽ
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
     * Ϊ�˼�������ͨ�ſ�����mapping���ļ�ֵ�������ڽ���������reduceǰ�������ظ����ϲ���
     * ��������м���̵�������б��صľۼ�����������ڽ��ʹ�Mapper�� Reducer���ݴ�������
     * ������Ĭ�Ͻ����е�mapper���������һ�δ���
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