<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ClientProjectModel;
use App\Models\PackageModel;
use App\Models\ProjectPhotoModel;
use App\Libraries\AwsS3Service;

class ClientProjectController extends BaseController
{
    protected $projectModel;
    protected $packageModel;

    public function __construct()
    {
        $this->projectModel = new ClientProjectModel();
        $this->packageModel = new PackageModel();
    }

    public function index()
    {
        // For simplicity, we just fetch all projects. In a real scenario, we'd join with users and packages to get names.
        // Let's do a raw query or loop to inject names to avoid complex joins for now.
        $projects = $this->projectModel->findAll();
        $packages = $this->packageModel->findAll();
        
        $packageMap = [];
        foreach($packages as $p) {
            $packageMap[$p->id] = $p->name;
        }

        $users = auth()->getProvider()->findAll();
        $userMap = [];
        foreach($users as $u) {
            $userMap[$u->id] = $u->username ?? $u->email ?? 'User ' . $u->id;
        }

        foreach($projects as &$proj) {
            $proj->user_name = $userMap[$proj->user_id] ?? 'Desconhecido';
            $proj->package_name = $packageMap[$proj->package_id] ?? 'Desconhecido';
        }

        $data = [
            'title'    => 'Projetos de Clientes',
            'projects' => $projects
        ];
        return view('admin/client_projects/index', $data);
    }

    public function new()
    {
        $data = [
            'title'    => 'Novo Projeto',
            'users'    => auth()->getProvider()->findAll(),
            'packages' => $this->packageModel->findAll()
        ];
        return view('admin/client_projects/form', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();
        
        if ($this->projectModel->save($data)) {
            return redirect()->to('/admin/client-projects')->with('message', 'Projeto criado com sucesso.');
        }

        return redirect()->back()->withInput()->with('errors', $this->projectModel->errors());
    }

    public function edit($id = null)
    {
        $project = $this->projectModel->find($id);
        if (!$project) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data = [
            'title'    => 'Editar Projeto',
            'project'  => $project,
            'users'    => auth()->getProvider()->findAll(),
            'packages' => $this->packageModel->findAll()
        ];
        return view('admin/client_projects/form', $data);
    }

    public function update($id = null)
    {
        $data = $this->request->getPost();
        $data['id'] = $id;

        if ($this->projectModel->save($data)) {
            return redirect()->to('/admin/client-projects')->with('message', 'Projeto atualizado com sucesso.');
        }

        return redirect()->back()->withInput()->with('errors', $this->projectModel->errors());
    }

    public function delete($id = null)
    {
        $this->projectModel->delete($id);
        return redirect()->to('/admin/client-projects')->with('message', 'Projeto removido com sucesso.');
    }

    public function photos($id)
    {
        $project = $this->projectModel->find($id);
        if (!$project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $package    = $this->packageModel->find($project->package_id);
        $photoModel = new ProjectPhotoModel();

        $selectedPhotos = $photoModel->where('project_id', $id)
                                     ->where('status', 'selected')
                                     ->findAll();

        // Gera presigned URLs para exibição no admin
        $s3 = new AwsS3Service();
        foreach ($selectedPhotos as &$photo) {
            $photo->presigned_url = $s3->getPresignedUrl($photo->proxy_url);
        }
        unset($photo);

        return view('admin/client_projects/photos', [
            'title'          => 'Fotos Selecionadas — Projeto #' . $id,
            'project'        => $project,
            'package'        => $package,
            'selectedPhotos' => $selectedPhotos,
        ]);
    }

    /**
     * Sincronização manual S3 → banco (POST /admin/client-projects/{id}/sync-s3)
     * Útil para o fotógrafo forçar a listagem das fotos de um projeto.
     */
    public function syncS3($id)
    {
        $project = $this->projectModel->find($id);
        if (!$project) {
            return $this->response->setJSON(['success' => false, 'message' => 'Projeto não encontrado.']);
        }

        try {
            $photoModel = new ProjectPhotoModel();
            $s3         = new AwsS3Service();
            $photos     = $s3->syncProjectPhotos((int)$id, $photoModel);

            return $this->response->setJSON([
                'success' => true,
                'message' => count($photos) . ' foto(s) sincronizadas com sucesso.',
                'count'   => count($photos),
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Admin S3 Sync Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erro ao sincronizar: ' . $e->getMessage(),
            ]);
        }
    }
}
