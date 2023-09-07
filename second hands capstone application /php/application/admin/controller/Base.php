<?php

namespace app\admin\controller;

use app\common\controller\Common;
use think\Request;
use think\Db;
use think\Cache;


class Base extends Common
{


    public function sendEmail(){
        $param = $this->checkParam('email');
        $count = db('home_user')->where('email', $param['email'])->count();
        if($count>0){
            return error('Mailbox has been registered');
        }
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        $config = db('admin_email')->column('name,value');
        $code = rand(100000, 999999);
        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = $config['host'];
            $mail->Port = 465;
            $mail->CharSet = "utf8";
            $mail->Username = $config['username'];
            $mail->Password = $config['password'];
            $mail->setFrom($mail->Username,$config['subject']);

            $mail->addAddress($param['email']);

            $mail->Subject =$config['subject'];
            $mail->Body = 'Your verification code is 【'.$code.'】';
            $res = $mail->send();
            if($res){
                Cache::set($param['email'],$code,60*60*5);
                return success('', 'Verification code sent successfully');
            }else{
                return error('Verification code sending error');
            }
        } catch (Exception $e) {
            return error('Verification code sending error');
        }

    }


    /**
     * 用户登录
     * @return \think\response\Json
     */
    public function login()
    {
        //验证码
        if (model('admin/Setting')->where('name','verification')->value("value") == 1) {
            $captcha = new \com\verify\HonrayVerify(config('captcha'));
            if (!$captcha->check($this->param['verify'])) {
                return error("Verification code error");
            }
        }
        //字段验证
        $validate = validate("User");
        $result = $validate->scene('login')->check($this->param);
        if (!$result) {
            return error($validate->getError());
        }
        $userModel = model('admin/User');
        $data = $userModel->login($this->param);

        if ($data) {
            return success($data, 'Login successful');
        } else {
            return error($userModel->getError());
        }
    }

    /**
     * 获取系统配置:是否需要验证码
     * @return \think\response\Json
     */
    public function getConfigs()
    {

        $info = model('admin/Setting')->where('name','not in',['token_expire','super_user'])->column('name,value');
        $info['verifyUrl'] = $info['verification'] == 1 ? url('admin/Base/getVerify', '', '', true) : "";

        return success($info);
    }
    /**
     * 验证码
     * @return \think\Response
     */
    public function getVerify()
    {
        ob_clean();
        $captcha = new \com\verify\HonrayVerify(config('captcha'));
        return $captcha->entry();
    }

    /**
     * miss路由
     * @return string
     */
    public function miss()
    {
        if (Request::instance()->isOptions()) {
            return '';
        } else {
            echo 'VUE接口';
        }
    }
}
