<?php
namespace App\Http\Controllers\Admin;

use App\Model\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Home extends Controller {

    public function index()
    {
//        return 'Admin/Home/index';
        return view('admin/admin');
    }


    public function editUser(Request $req)
    {
        $user =  Admin::where('id', $req->id)->first();

        $user->address = (['aaa', 'bbb', 'sdd', 'aaa'=>'hhhhh']);
//        $user->active = 1;
        $user->active = true;

//        $user->save();
        $data = [
            'name' => 'test',
            'account' => 'test129',
            'pwd' => 'test123',
            'address' => ([
                'province'=>'fujian',
                'city'=>'ningde'
            ]),
//            'date' => self::toISO8601Time('2018-03-02 10:20:19'),
            'date' => self::toDatetime('2018-03-02T10:20:19Z')
        ];

//        return $data;

        return Admin::create(
            $data
        );

        return 'ok';
    }

    public function userList()
    {
        $users =  Admin::all();
        return $this->resSuccess('success', $users);
    }



    const ISO8601 = 'Y-m-d\TH:i:s\Z' ;

    /**
     * 将datetime转化成ISO8601时间格式（亚马逊时间）
     * @param $time
     * */
    static function toISO8601Time ($time)
    {
        return $time = str_replace(' ', 'T', $time).'Z';
//		return date(self::ISO8601, $time);
    }

    static function toAmazonTime (&$time)
    {
        return self::toISO8601Time($time);
    }


    static function toDatetime($time)
    {
        return $time = str_replace('T', ' ', str_replace('Z', '', $time));
    }


}