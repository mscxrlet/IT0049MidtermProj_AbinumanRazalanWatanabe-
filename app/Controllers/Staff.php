<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Staff extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        return view('staff/index', [
            'staff' => $this->userModel->findAll()
        ]);
    }

    public function add()
    {
        return view('staff/form', [
            'title' => 'Add Staff',
            'staffMember' => null
        ]);
    }

    public function create()
    {
        $rules = [
            'username' => 'required|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|min_length[2]|max_length[100]',
            'password' => 'required|min_length[6]|max_length[255]',
            'avatar' => 'permit_empty|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]|max_size[avatar,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $avatar = $this->saveAvatar();

        if ($avatar === false) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Avatar upload failed.');
        }

        $this->userModel->insert([
            'username' => trim($this->request->getPost('username')),
            'full_name' => trim($this->request->getPost('full_name')),
            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'avatar' => $avatar,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/staff');
    }

    public function edit(int $id)
    {
        $staffMember = $this->userModel->find($id);

        if (!$staffMember) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('staff/form', [
            'title' => 'Edit Staff',
            'staffMember' => $staffMember
        ]);
    }

    public function update(int $id)
    {
        $staffMember = $this->userModel->find($id);

        if (!$staffMember) {
            throw PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'username' => "required|max_length[50]|is_unique[users.username,id,{$id}]",
            'full_name' => 'required|min_length[2]|max_length[100]',
            'password' => 'permit_empty|min_length[6]|max_length[255]',
            'avatar' => 'permit_empty|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]|max_size[avatar,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => trim($this->request->getPost('username')),
            'full_name' => trim($this->request->getPost('full_name'))
        ];

        $password = $this->request->getPost('password');

        if (!empty($password)) {
            $data['password'] = password_hash(
                $password,
                PASSWORD_DEFAULT
            );
        }

        $avatar = $this->saveAvatar();

        if ($avatar === false) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Avatar upload failed.');
        }

        if ($avatar !== null) {
            $data['avatar'] = $avatar;
        }

        $this->userModel->update($id, $data);

        return redirect()->to('/staff');
    }

    public function delete(int $id)
    {
        if ((int) session()->get('user_id') === $id) {
            return redirect()->to('/staff')
                ->with('error', 'You cannot delete your current account.');
        }

        $this->userModel->delete($id);

        return redirect()->to('/staff');
    }

    private function saveAvatar(): string|false|null
    {
        $file = $this->request->getFile('avatar');

        if (!$file || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (!$file->isValid() || $file->hasMoved()) {
            return false;
        }

        $uploadPath = FCPATH . 'uploads/avatars';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        $newName = $file->getRandomName();

        $file->move($uploadPath, $newName);

        service('image')
            ->withFile($uploadPath . DIRECTORY_SEPARATOR . $newName)
            ->fit(300, 300, 'center')
            ->save($uploadPath . DIRECTORY_SEPARATOR . $newName);

        return $newName;
    }
}