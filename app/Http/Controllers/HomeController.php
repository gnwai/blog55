<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Product\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'index';
        return view('home');

    }


    /**
     * 聊天房间列表
     */
    public function room()
    {

        $res = [2,3,5];
        return view('room', $res);
    }


    public function workerman()
    {
        return view('workerman');
    }

    public function test(Request $req)
    {
        return $req->session()->all();
        return 'home/test';
    }


    /**
     * 商品标签 多对多关联
     */
    public function productMark()
    {


        $pro =  Product::with('mark')->find(1);

        #更新关联 参数 mark_id 数组
        $pro->markLink([1,2,3]);

        return $pro;
    }


    /**
     * 审核qc  (sd 系统)
     * @param $step boolean 审核是否通过
     * @param $step_remark string 最终审核备注说明
     * @developer Kane
     */
    public function checkQc(Request $req)
    {
        $qc = QC::find($req->id);

        if (!$qc) {
            return $this->resFail('QC报告不存在。');
        }

        if (!$qc->isStepCheckAble()) {
            return $this->resFail($qc->getDebug());
        }

//		if ($qc->isQtyOverload()) {
//			return $this->resFail($qc->getDebug());
//		}

        $step = $req->step;
        $remark = $req->step_remark;

        \DB::transaction(function() use (&$step, &$remark, &$qc) {
            $step ? $qc->checkDone($remark) : $qc->checkDoneButError($remark);
            $qc->save();
            $step || $qc->purchaseItem()->decrement('qc_qty' , $qc->qty);
        });

        return $this->statusResponse('success', 'QC报告审核完毕。');

    }
}
