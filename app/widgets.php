<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 7/7/14
 * Time: 4:34 PM
 */


Widget::register('loginform',function(){
    return View::make('widgets.loginform');
});

Widget::register('hello',function(){
   return View::make('widgets.hello');
});

Widget::register('slider',function(){
    return View::make('widgets.slider');
});

use Gregwar\Captcha\CaptchaBuilder;
Widget::register('captcha',function(){
    $builder = new CaptchaBuilder;
	$builder->setIgnoreAllEffects(true);
    $builder->build();
    $captcha = $builder->inline();
    Session::put('captchaPhrase', $builder->getPhrase());
    return View::make('widgets.captcha',array(
        'captcha' => $captcha
    ));
});