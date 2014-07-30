<?php
/**
 * BaseController.php
 * 
 * @author: rose1988c
 * @email: rose1988.c@gmail.com
 * @created: 2014-7-2 下午4:55:51
 * @logs: 
 *       
 */
class BaseController extends Controller
{
    protected function setupLayout() {
        if( ! is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    /**
     * 返回方法
     *
     * @param String $msg
     * @param int $code
     */
    protected function toJson($msg, $code, $data = false) {
        return Response::json(array (
            'code' => $code,
            'message' => $msg,
            'data' => $data
        ));
    }
}