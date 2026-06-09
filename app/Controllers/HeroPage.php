<?php

namespace App\Controllers;

use App\Models\Hero;
use App\Models\Photo;
use App\Models\Cta;
use App\Models\CtaBlock;

class HeroPage extends BaseController
{
    public function view($slug)
    {
        $heroModel = new Hero();
        $hero = $heroModel->where('slug', $slug)->first();

        if (!$hero) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $photoModel = new Photo();
        $ctaModel   = new Cta();
        $blockModel = new CtaBlock();

        $data['hero'] = $hero;

        // Busca todas as fotos ordenadas por display_order
        $allPhotos = $photoModel->where('hero_id', $hero['id'])->orderBy('display_order', 'asc')->findAll();

        // Garante que a foto de capa seja sempre a primeira do carrossel
        if (!empty($hero['cover_photo_id'])) {
            $coverFirst = [];
            $rest       = [];
            foreach ($allPhotos as $p) {
                if ($p['id'] == $hero['cover_photo_id']) {
                    $coverFirst[] = $p;
                } else {
                    $rest[] = $p;
                }
            }
            $allPhotos = array_merge($coverFirst, $rest);
        }

        $cta    = $ctaModel->where('hero_id', $hero['id'])->first();
        $blocks = $cta ? $blockModel->blocksForCta((int)$cta['id']) : [];

        $data['photos'] = $allPhotos;
        $data['cta']    = $cta;
        $data['blocks'] = $blocks;
        
        $data['title'] = $hero['name'] . ' | ' . $hero['sport'] . ' | Marco Santo';

        return view('hero_page', $data);
    }
}
