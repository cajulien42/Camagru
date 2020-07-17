<?php
session_name("user");
session_start();
$current_file = __FILE__;
define('__ROOT__', dirname(dirname(__FILE__)));


class FilterManager
{
    public function get_cats($pdo)
    {
      $req = $pdo->query("SELECT `cat_name` FROM `f_categories`;");
      $req = $req->fetchAll();
      return($req);
    }

    public function get_filters($pdo, $cat_name)
    {
      $req = $pdo->query("SELECT `filter_id`, `filter_name`, `filter_cat`, `filter_url` FROM `filters` WHERE `filter_cat` = '$cat_name';");
      $req = $req->fetchAll();
      return($req);
    }

    public function get_filter($pdo, $filter_id)
    {
      $req = $pdo->query("SELECT `filter_name`, `filter_cat`, `filter_url` FROM `filters` WHERE `filter_id`='$filter_id';");
      $req = $req->fetchAll();
      return($req);
    }


}