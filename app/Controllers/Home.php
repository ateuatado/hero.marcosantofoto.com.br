<?php

namespace App\Controllers;

use App\Models\Hero;

class Home extends BaseController
{
    public function index(): string
    {
        $heroModel = new Hero();
        $data['heroes'] = $heroModel->orderBy('created_at', 'DESC')->findAll();
        
        return view('home', $data);
    }
}
