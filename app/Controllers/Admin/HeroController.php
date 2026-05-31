<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Hero;

class HeroController extends BaseController
{
    protected $heroModel;

    public function __construct()
    {
        $this->heroModel = new Hero();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data['heroes'] = $this->heroModel->orderBy('created_at', 'desc')->findAll();
        return view('admin/heroes/index', $data);
    }

    public function new()
    {
        return view('admin/heroes/form');
    }

    public function create()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'sport' => 'required',
            'slug' => 'required|is_unique[heroes.slug]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->heroModel->save([
            'name' => $this->request->getPost('name'),
            'sport' => $this->request->getPost('sport'),
            'slug' => url_title($this->request->getPost('slug'), '-', true)
        ]);

        return redirect()->to(site_url('admin/heroes'))->with('message', 'Herói criado com sucesso.');
    }

    public function edit($id = null)
    {
        $data['hero'] = $this->heroModel->find($id);
        if (!$data['hero']) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        
        return view('admin/heroes/form', $data);
    }

    public function update($id = null)
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'sport' => 'required',
            'slug' => "required|is_unique[heroes.slug,id,{$id}]"
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->heroModel->update($id, [
            'name' => $this->request->getPost('name'),
            'sport' => $this->request->getPost('sport'),
            'slug' => url_title($this->request->getPost('slug'), '-', true)
        ]);

        return redirect()->to(site_url('admin/heroes'))->with('message', 'Herói atualizado com sucesso.');
    }

    public function delete($id = null)
    {
        $this->heroModel->delete($id);
        return redirect()->to(site_url('admin/heroes'))->with('message', 'Herói deletado.');
    }

    public function photos($heroId)
    {
        $hero = $this->heroModel->find($heroId);
        if (!$hero) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $photoModel = new \App\Models\Photo();
        $data['hero'] = $hero;
        $data['photos'] = $photoModel->where('hero_id', $heroId)->orderBy('display_order', 'asc')->findAll();

        return view('admin/heroes/photos', $data);
    }

    public function uploadPhoto($heroId)
    {
        $file = $this->request->getFile('photo');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/heroes/', $newName);
            
            $photoModel = new \App\Models\Photo();
            $photoModel->save([
                'hero_id' => $heroId,
                'image_path' => 'uploads/heroes/' . $newName,
                'caption' => $this->request->getPost('caption'),
                'display_order' => $this->request->getPost('display_order') ?? 0
            ]);
        }
        return redirect()->back()->with('message', 'Foto enviada!');
    }

    public function deletePhoto($photoId)
    {
        $photoModel = new \App\Models\Photo();
        $photo = $photoModel->find($photoId);
        if ($photo) {
            if (file_exists(FCPATH . $photo['image_path'])) {
                unlink(FCPATH . $photo['image_path']);
            }
            $photoModel->delete($photoId);
        }
        return redirect()->back()->with('message', 'Foto excluída.');
    }

    public function cta($heroId)
    {
        $hero = $this->heroModel->find($heroId);
        if (!$hero) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $ctaModel = new \App\Models\Cta();
        $data['hero'] = $hero;
        $data['cta'] = $ctaModel->where('hero_id', $heroId)->first();

        return view('admin/heroes/cta', $data);
    }

    public function updateCta($heroId)
    {
        $ctaModel = new \App\Models\Cta();
        $cta = $ctaModel->where('hero_id', $heroId)->first();

        $data = [
            'hero_id' => $heroId,
            'type' => $this->request->getPost('type'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'button_text' => $this->request->getPost('button_text'),
            'button_url' => $this->request->getPost('button_url')
        ];

        if ($cta) {
            $data['id'] = $cta['id'];
        }

        $ctaModel->save($data);
        return redirect()->to(site_url('admin/heroes'))->with('message', 'CTA atualizado com sucesso.');
    }
}
