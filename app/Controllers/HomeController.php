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
        return '<h1>VEDAIRO Dashboard</h1><p>Authenticated successfully.</p><p><a href="/users">Users CRUD</a></p><form method="post" action="/logout"><input type="hidden" name="_token" value="'.e(csrf_token()).'"><button>Logout</button></form>';
    }
}
