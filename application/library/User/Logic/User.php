<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2016/9/19
 * Time: 15:09
 */
//用户逻辑层
class User_Logic_User{
    //用户登录界面
    public function userLogin($email,$password){
        $userModel = new UserModel();
        //密码md5加密
        $inputParam['email']    = $email;
        $inputParam['password'] = md5($password);
        $info = $userModel->getUserAccount($inputParam);
        if(!empty($info)){
            Yaf_Session::getInstance()->set(User_Keys::getLoginUserKey(),$info['id']);
            User_Api::checkLogin();
            return true;
        }
        return false;
    }
    public function checkEmail($email = ''){
        try{
            $userObj = new UserModel();
            $info = $userObj->checkEmail($email);
            $result = array(
                "CODE"    => Base_Error::MODEL_RETURN_SUCCESS,
                "MESSAGE" => '成功!',
                "RES"     => $info
            );
            return $result;
        }catch (Exception $e){
            $log = new Base_Log();
            $log->ERROR($e->getMessage());
            $result = array(
                "CODE"    => Base_Error::MYSQL_EXECUTE_ERROR,
                "MESSAGE" => $e->getMessage(),
            );
            return $result;
        }
    }
}