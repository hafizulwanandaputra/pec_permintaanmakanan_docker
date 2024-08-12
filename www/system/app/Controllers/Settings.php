<?php

namespace App\Controllers;

use App\Models\SettingsModel;
use App\Models\DataTables;

class Settings extends BaseController
{
    protected $SettingsModel;
    protected $DataTables;
    public function __construct()
    {
        $this->SettingsModel = new SettingsModel();
        $this->DataTables = new DataTables();
    }

    public function index()
    {
        $data = [
            'title' => 'Pengaturan - ' . $this->systemName,
            'headertitle' => 'Pengaturan',
            'agent' => $this->request->getUserAgent()
        ];
        return view('dashboard/settings/index', $data);
    }

    public function edit()
    {
        $data = [
            'title' => 'Ubah Informasi Pengguna - ' . $this->systemName,
            'headertitle' => 'Ubah Informasi Pengguna',
            'agent' => $this->request->getUserAgent(),
            'validation' => \Config\Services::validation()
        ];
        echo view('dashboard/settings/edit', $data);
    }

    public function update()
    {
        if (session()->get('username') == $this->request->getVar('username')) {
            $username = 'required|alpha_numeric_punct';
        } else {
            $username = 'required|is_unique[user.username]|alpha_numeric_punct';
        }
        if (!$this->validate([
            'fullname' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!',
                ]
            ],
            'username' => [
                'label' => 'Nama Pengguna',
                'rules' => $username,
                'errors' => [
                    'required' => '{field} wajib diisi!',
                    'is_unique' => '{field} harus berbeda dari pengguna lainnya!'
                ]
            ]
        ])) {
            return redirect()->back()->withInput();
        }
        $this->SettingsModel->save([
            'id_user' => session()->get('id_user'),
            'fullname' => $this->request->getVar('fullname'),
            'username' => $this->request->getVar('username'),
        ]);
        $db = db_connect();
        $agent = $this->request->getUserAgent();
        if ($this->request->getVar('fullname') == session()->get('fullname') && $this->request->getVar('username') == session()->get('username')) {
            session()->setFlashdata('info', 'Tidak ada perubahan apa-apa dalam formulir ini!');
        } else {
            session()->remove('fullname');
            session()->remove('username');
            session()->set('fullname', $this->request->getVar('fullname'));
            session()->set('username', $this->request->getVar('username'));
            session()->setFlashdata('msg', 'Informasi Pengguna berhasil diubah!');
        }
        return redirect()->back();
    }

    public function about()
    {
        $agent = $this->request->getUserAgent();
        $data = [
            'agent' => $agent,
            'title' => 'Tentang ' . $this->systemName,
            'headertitle' => 'Tentang Sistem',
            'agent' => $this->request->getUserAgent()
        ];
        return view('dashboard/settings/about', $data);
    }
}
