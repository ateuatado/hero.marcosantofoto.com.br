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
        $data = [
            'title'    => 'Pacotes',
            'packages' => $this->packageModel->findAll()
        ];
        return view('admin/packages/index', $data);
    }

    public function new()
    {
        return view('admin/packages/form', ['title' => 'Novo Pacote']);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $data['is_active']    = isset($data['is_active']) ? 1 : 0;
        $data['is_preferred'] = isset($data['is_preferred']) ? 1 : 0;
        
        if ($this->packageModel->save($data)) {
            return redirect()->to('/admin/packages')->with('message', 'Pacote criado com sucesso.');
        }

        return redirect()->back()->withInput()->with('errors', $this->packageModel->errors());
    }

    public function edit($id = null)
    {
        $package = $this->packageModel->find($id);
        if (!$package) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        return view('admin/packages/form', [
            'title'   => 'Editar Pacote',
            'package' => $package
        ]);
    }

    public function update($id = null)
    {
        $data = $this->request->getPost();
        $data['id'] = $id;
        $data['is_active']    = isset($data['is_active']) ? 1 : 0;
        $data['is_preferred'] = isset($data['is_preferred']) ? 1 : 0;

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
