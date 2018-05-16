<?php 

namespace app\admin\controller;

class Income extends Base{

	// 收入报表
	public function incomelist(){
		return $this->fetch();
	}

	function returnDate($len){
        $dateArray = array();
        for($i=1; $i<=$len; $i++){
            $end_time = date('Y-m-d', strtotime('-'.$i.' day'));
            $strtime = strtotime($end_time);
            $inArr = ($strtime).','.($strtime+86400);
            $dateArray[] = $inArr;
        }
        return array_reverse($dateArray);
    }

	public function incomeData(){
		$where['pay_status'] = 1;
		$field = 'id, count, all_price, addtime';
		$orderList = model('Order')->getIncome($where, $field);

		$date = $this->returnDate(7);
		$countAll = [];
		foreach ($orderList as $key => $value) {
			for($i=0; $i<7; $i++){
				$dateArr = explode(',', $date[$i]);
				if(($value['addtime']>=intval($dateArr[0])) && ($value['addtime']<=intval($dateArr[1]))){
					$countAll[$i][] = $value['all_price'];
				}
			}
		}
		$money = '';
        foreach ($countAll as $key => $value) {
            $temp = 0;
            foreach ($value as $k => $v) {
                $temp+=$v;
            }
            $money[$key] = $temp;
        }
        for($i = 0; $i<7; $i++){
            if(!isset($money[$i])){
                $money[$i] = 0;
            }
        }
        ksort($money);
        echo json_encode($money);
	}
}


 ?>