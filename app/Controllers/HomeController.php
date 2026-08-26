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

    public function dashboard(): string {
        return '<h1>VEDAIRO Dashboard</h1><p>Authenticated successfully.</p><p><a href="/users">Users CRUD</a></p><form method="post" action="/logout"><input type="hidden" name="_token" value="'.e(csrf_token()).'"><button>Logout</button></form>';
    }
}
