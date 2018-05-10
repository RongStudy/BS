<?php
namespace app\home\controller;
use think\Controller;

class Test extends Controller{
    public function test(){
        return 'Test控制器下的test方法';
    }

    public function think_encrypt($data, $key = '', $expire = 0) {
        $data = input('data');
        $key = config('url_key');
        $key = md5(empty($key) ? config('DATA_AUTH_KEY') : $key);
        dump('$key = '.$key);
        $data = base64_encode($data);
        dump('$data = '.$data);
        $x = 0;
        $len = strlen($data);
        dump('$len = '.$len);
        $l = strlen($key);
        dump('$l = '. $l);
        $char = '';
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
            echo $char.' ';
        }
        echo '<br/>';
        $str = sprintf('%010d', $expire ? $expire + time():0);
        for ($i = 0; $i < $len; $i++) {
            $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
        }
        return str_replace(array('+','/','='),array('-','_',''),base64_encode($str));
    }
    public function aa(){
        $str = 'MDAwMDAwMDAwMICNl3I';
        dump($str);
        $a = substr($str, 0, -4);
        dump($a);
    }
}
 ?>
