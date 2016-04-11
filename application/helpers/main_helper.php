<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(!function_exists('my_money_format'))
{
    function my_money_format($val)
    {
        if($val)
        {
            return number_format($val,0,'',' ');
        }
        else
        {
            return 'Договорная';
        }
        
    }
}


if(!function_exists('my_cost_format'))
{
    function my_cost_format($per_hour,$per_project)
    {
        $ret_val = '';
        if($per_hour)
        {
            $ret_val = '/ час';
        }
        elseif($per_project)
        {
            $ret_val = '/ проект';
        }
        else
        {
            $ret_val = '';
        }
        
        return $ret_val;
    }
}


if(!function_exists('get_rating'))
{
    function get_rating($rating)
    {
        $ret_val = '';
        if($rating > 0)
        {
            $ret_val = '+ '.$rating;
        }
        elseif( $rating < 0)
        {
            $ret_val = $rating;
        }
        else
        {
            $ret_val = 0;
        }
        return $ret_val;
    }
}


if(!function_exists('get_rating_color'))
{
    function get_rating_color($rating)
    {
        $ret_val ='';
        if($rating >= 0)
        {
            $ret_val = 'green';
        }
        else
        {
            $ret_val = 'red';
        }
        return $ret_val;
    }
}


if(!function_exists('get_photo_count'))
{
    function get_photo_count($numbers)
    {
        $number = $numbers ? $numbers : 0;
        $cases = array (2, 0, 1, 1, 1, 2);
        $titles = array('фотография','фотографии','фотографий');
        return $titles[ ($number%100 > 4 && $number %100 < 20) ? 2 : $cases[min($number%10, 5)] ];
    }
}


if(!function_exists('get_album_count'))
{
    function get_album_count($numbers)
    {
        $number = $numbers ? $numbers : 0;
        $cases = array (2, 0, 1, 1, 1, 2);
        $titles = array('дополнительного альбома','дополнительных альбомов','дополнительных альбомов');
        return $titles[ ($number%100 > 4 && $number %100 < 20) ? 2 : $cases[min($number%10, 5)] ];
    }
}