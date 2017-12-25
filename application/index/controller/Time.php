<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Time extends Controller
{
    public function index()
    {
    	$time = Db::table('time')->select();

    	$arr = $this->BubbleSort($time);

    	return $this->fetch('index', ['time'=>$arr]);
    }

	public function BubbleSort($arr) {
	    $len = count($arr);
	    //设置一个空数组 用来接收冒出来的泡
	    //该层循环控制 需要冒泡的轮数
	    for ($i = 1; $i < $len; $i++) {
	        $flag = false;    //本趟排序开始前，交换标志应为假
	        //该层循环用来控制每轮 冒出一个数 需要比较的次数
	        for ($k = 0; $k < $len - $i; $k++) {
	            //从小到大排序
	            if ($arr[$k]['time_time'] < $arr[$k + 1]['time_time']) {
	                $tmp = $arr[$k + 1];
	                $arr[$k + 1] = $arr[$k];
	                $arr[$k] = $tmp;
	                $flag = true;
	            }
	        }
	        if(!$flag) return $arr;
	    }
	}

}