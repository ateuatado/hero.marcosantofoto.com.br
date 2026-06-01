<?php

namespace App\Controllers;

use App\Models\Hero;

class Home extends BaseController
{
    public function index()
    {
        // Redirecionamento inteligente pós-login
        if (auth()->loggedIn()) {
            $user = auth()->user();
            if ($user->inGroup('admin', 'superadmin', 'developer')) {
                return redirect()->to('/admin');
            }
            return redirect()->to('/client/galeria');
        }

        $heroModel = new Hero();
        $data['heroes'] = $heroModel->orderBy('created_at', 'DESC')->findAll();
        
        return view('home', $data);
    }
}
