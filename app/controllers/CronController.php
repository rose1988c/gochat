<?php
/**
 * CronController.php
 * 
 * @author rose1988.c@gmail.com
 * @version 1.0
 * @date 2014-10-16 下午9:51:06
 */
class CronController extends BaseController
{

    public function qq()
    {
        $url = 'http://pt5.3g.qq.com/s?aid=nLogin3gqqbysid&3gqqsid=';
        $sids = array (
            'AWiP5FxLdVjzP6ImzMXfiWlH', // 510043188
            'AZbKLLLcVpLxqg4lvrLgSaVK', // 996058288
            'ATOUf-RgZXcLWmpPdluS9xhK', // 492732544
            'ARHTGAh_iLi8YJI_niZ9dDlK', // 390416409
            'AW92hRVaVd76K8IL_OuiMAZN', // 134
            'AZelDu4FqziolXkh02GRHD5N'  //1058287803
        );
        foreach((array)$sids as $sid) {
            curl_setopt_check($url . $sid);
        }
        echo date('Y-m-d H:i:s') . ' ok~';
        exit();
    }
}