<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PackageModel;

class PackageController extends BaseController
{
    protected $packageModel;

    public function __construct()
    {
        $this->packageModel = new PackageModel();
    }

    public function index()
    {
        $categoryModel = new \App\Models\CategoryModel();
        $categories = $categoryModel->findAll();
        
        $categoryMap = [];
        foreach ($categories as $cat) {
            $categoryMap[$cat->id] = $cat->name;
        }

        $packages = $this->packageModel->findAll();
        foreach ($packages as &$pkg) {
            $pkg->category_name = $categoryMap[$pkg->category_id ?? 0] ?? 'Sem Categoria';
        }
        unset($pkg);

        $data = [
            'title'    => 'Pacotes',
            'packages' => $packages
        ];
        return view('admin/packages/index', $data);
    }

    public function new()
    {
        $categoryModel = new \App\Models\CategoryModel();
        $categories = $categoryModel->where('is_active', 1)->orderBy('name', 'asc')->findAll();

        return view('admin/packages/form', [
            'title'      => 'Novo Pacote',
            'categories' => $categories
        ]);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $data['is_active']    = isset($data['is_active']) ? 1 : 0;
        $data['is_preferred'] = isset($data['is_preferred']) ? 1 : 0;
        
        // Trata category_id se vazio
        if (empty($data['category_id'])) {
            $data['category_id'] = null;
        }
        
        if ($this->packageModel->save($data)) {
            return redirect()->to('/admin/packages')->with('message', 'Pacote criado com sucesso.');
        }

        return redirect()->back()->withInput()->with('errors', $this->packageModel->errors());
    }

    public function edit($id = null)
    {
        $package = $this->packageModel->find($id);
        if (!$package) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $categoryModel = new \App\Models\CategoryModel();
        $categories = $categoryModel->where('is_active', 1)->orderBy('name', 'asc')->findAll();

        return view('admin/packages/form', [
            'title'      => 'Editar Pacote',
            'package'    => $package,
            'categories' => $categories
        ]);
    }

    public function update($id = null)
    {
        $data = $this->request->getPost();
        $data['id'] = $id;
        $data['is_active']    = isset($data['is_active']) ? 1 : 0;
        $data['is_preferred'] = isset($data['is_preferred']) ? 1 : 0;

        // Trata category_id se vazio
        if (empty($data['category_id'])) {
            $data['category_id'] = null;
        }

        if ($this->packageModel->save($data)) {
            return redirect()->to('/admin/packages')->with('message', 'Pacote atualizado com sucesso.');
        }

        return redirect()->back()->withInput()->with('errors', $this->packageModel->errors());
    }

    public function delete($id = null)
    {
        $this->packageModel->delete($id);
        return redirect()->to('/admin/packages')->with('message', 'Pacote removido com sucesso.');
    }
}
