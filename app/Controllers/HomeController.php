<?php
namespace App\Controllers;

use Vedairo\View;

class HomeController {
    public function index(): string {
        return View::render('home');
    }

    public function docs(): string {
        return View::render('docs/manual');
    }

    public function manual(): string {
        return View::render('docs/manual');
    }

    public function pdf(): never {
        $pdfFile = base_path('VEDAIRO-Enterprise-Complete-User-Guide-v5.0.0.pdf');
        if (!is_file($pdfFile)) {
            $pdfFile = base_path('public/docs/VEDAIRO-Enterprise-Complete-User-Guide-v5.0.0.pdf');
        }
        if (is_file($pdfFile)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="VEDAIRO-Enterprise-Complete-User-Guide-v5.0.0.pdf"');
            header('Content-Length: ' . filesize($pdfFile));
            readfile($pdfFile);
            exit;
        }
        \Vedairo\Http\Response::json(['error' => 'PDF guide not found'], 404);
    }

    public function dashboard(): string {
        $user = \Vedairo\Auth\Auth::user() ?? ['name' => 'Administrator', 'email' => 'admin@vedairo.local', 'role' => 'admin'];
        $stats = [
            'users' => 0,
            'products' => 0,
            'orders' => 0,
        ];
        try {
            $db = \Vedairo\Application::$container->get('db');
            $stats['users'] = (int) $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
            $stats['products'] = (int) $db->query("SELECT COUNT(*) FROM products")->fetchColumn();
            $stats['orders'] = (int) $db->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        } catch (\Throwable) {}

        return View::render('dashboard', [
            'user' => $user,
            'stats' => $stats,
        ]);
    }
}
