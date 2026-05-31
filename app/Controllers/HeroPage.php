<?php

namespace App\Controllers;

use App\Models\Hero;
use App\Models\Photo;
use App\Models\Cta;

class HeroPage extends BaseController
{
    public function view($slug)
    {
        $heroModel = new Hero();
        $hero = $heroModel->where('slug', $slug)->first();

        if (!$hero) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $photoModel = new Photo();
        $ctaModel = new Cta();

        $data['hero'] = $hero;
        $data['photos'] = $photoModel->where('hero_id', $hero['id'])->orderBy('display_order', 'asc')->findAll();
        $data['cta'] = $ctaModel->where('hero_id', $hero['id'])->first();
        
        $data['title'] = $hero['name'] . ' | ' . $hero['sport'] . ' | Marco Santo';

        return view('hero_page', $data);
    }
}
