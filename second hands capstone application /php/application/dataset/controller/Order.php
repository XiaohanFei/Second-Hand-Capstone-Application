<?php

namespace app\dataset\controller;

use app\common\controller\ApiCommon;

class Order extends ApiCommon
{
    public function index(){

        $param = $this->checkParam('page,limit');
        $order = 'id desc';
        $where = [];
        if(isset($param['name']) && strlen($param['name'])){
            $name = trim($param['name']);
            $where['name'] = array("LIKE", "%$name%");
        }
        $list = db('home_order')->where($where)->page($param['page'], $param['limit'])
            ->order($order)
            ->select()->toArray();

        foreach ($list as &$item){
            $item['user'] = db('home_user')->where('id', $item['user_id'])->field('mobile,nickname')->find();
            $item['owner'] = db('home_user')->where('id', $item['owern_user_id'])->field('mobile,nickname')->find();
            $item['info'] = db('home_goods')->field('id,name,price,status')->find($item['goods_id']);
        }
        $res['list'] = $list;
        $res["total"] = db('home_order')->where($where)->count();
        return success($res);
    }

    public function delete(){
        $param = $this->param;
        if(db('home_goods')->where('id',$param['id'])->update(['status'=>2])){
            return success("", "Edit succeeded");
        }else{
            return error("数据库错误");
        }
    }

    public function getClassify(){
        $list = model("dataset/Classify")->index();
        return success($list);
    }
    public function getGoodsDetail(){
        $param = $this->checkParam('id');
        db('home_goods')->where('id', $param['id'])->setInc('view');
        $info = db('home_goods')->find($param['id']);
        $info['picture'] = explode(",", $info['picture']);
        $temp = db('home_classify')->where('id', $info['classify_id'])->field('pid,title')->find();
        $info['classify_name'] = db('home_classify')->where('id', $temp['pid'])->value('title') . " >> " . $temp['title'];
        return success($info);
    }

    public function edit(){
        $param = $this->checkParam('name,id');
        unset($param['classify_name']);
        $param['update_time'] = format_date(time());
        if(db('home_goods')->where('id',$param['id'])->update($param)){
            return success("", "Edit succeeded");
        }else{
            return error("System error");
        }
    }

    public function statistics()
    {
        $start_time = date('Y-m-d H:i:s',strtotime('-7 day'));
        $end_time = date('Y-m-d H:i:s');
        $sales = db('home_order')->whereTime('create_time','>=',$start_time)
            ->whereTime('create_time','<=',$end_time)
            ->select();
        $lend = $this->getLend($start_time,$end_time);
        $data = [
            "lend"=>[],
            "sales_analysis" => [],
            "money_analysis" => []
        ];
        if(!empty($lend)){
            foreach ($lend as $v){
                $num = 0;
                $money = 0;
                $end = $v." 23:59:59";
                $info = db('home_order')
                    ->alias('o')
                    ->join('home_goods g','o.goods_id = g.id')
                    ->whereTime('o.create_time','>=',$v)
                    ->whereTime('o.create_time','<=',$end)
                    ->field('o.id,o.goods_id,o.order_id,g.price')
                    ->select();
                if(!empty($info)){
                    foreach ($info as $val){
                        $num += 1;
                        $money += $val['price'];
                    }
                }
                $data['lend'][] = $v;
                $data['sales_analysis'][] = $num;
                $data['money_analysis'][] = round($money/100,2);
            }
        }
        return success($data);

    }

    public function getLend($start_time,$end_time)
    {
        $lend = [];
        $start_time = strtotime(date('Y-m-d',strtotime($start_time)));
        $end_time = strtotime(date('Y-m-d',strtotime($end_time)));
        while ($start_time <= $end_time){
            $lend[] =  date('Y-m-d',$start_time);
            $start_time  += 86400;
        }
        return $lend;
    }

}
