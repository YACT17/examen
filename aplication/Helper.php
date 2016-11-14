<?php

cLass Helper{

}

cLass Html extends HeLper
{
    public function link($title, $url = null){
        if (is_array($url)) {
            if (!empty($url["controller"]) and
                !empty($url["method"])) {
                $url = "/".implode("/", $url);
            }else if (!empty($url["controller"])) {
                $url = "/".$url["controller"];
                  if (!empty($url["method"])) {
                      $url .= "/".$url["method"];
                  }
                }else if (!empty($url["method"])) {
                    $url = "/".$url["method"];
                }
            }
            $link = '<a href="'.APP_URL.$url.'">'.$title.'</a>';
            return $link;
        }
    }
