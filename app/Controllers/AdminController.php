<?php
namespace App\Controllers;
use Vedairo\Http\Request;
use Vedairo\Application;
final class AdminController {
 public function dashboard(Request $r):string{$db=Application::$container->get('db');$data=['users'=>(int)$db->query('SELECT COUNT(*) FROM users')->fetchColumn(),'products'=>(int)$db->query('SELECT COUNT(*) FROM products')->fetchColumn(),'orders'=>(int)$db->query('SELECT COUNT(*) FROM orders')->fetchColumn(),'tenants'=>0];try{$data['tenants']=(int)$db->query('SELECT COUNT(*) FROM tenants')->fetchColumn();}catch(\Throwable $e){}ob_start();require base_path('resources/views/admin/dashboard.php');return (string) ob_get_clean();}
}
