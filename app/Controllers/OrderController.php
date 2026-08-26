<?php
namespace App\Controllers;
use Vedairo\Controller;use Vedairo\Http\Request;use Vedairo\Auth\Auth;use App\Services\OrderService;use Vedairo\API\Resource;
class OrderController extends Controller {
    /**
     * @return array<string,mixed>
     */
    public function checkout(Request $r): array {
        $items = $r->input('items', []);
        $id = (new OrderService)->checkout(Auth::id(), is_array($items) ? $items : [], $r->input('currency', 'INR'));
        return ['success' => true, 'order_id' => $id];
    }

    /**
     * @return array<string,mixed>
     */
    public function index(Request $r): array {
        $db = \Vedairo\Application::$container->get('db');
        return Resource::collection($db->table('orders')->whereEq('user_id', Auth::id())->orderBy('id', 'DESC')->get());
    }
}
