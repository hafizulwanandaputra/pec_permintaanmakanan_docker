<?php

namespace App\Controllers;

use App\Models\ActivitiesModel;
use App\Models\SettingsModel;
use App\Models\DataTables;

class Settings extends BaseController
{
    protected $ActivitiesModel;
    protected $SettingsModel;
    protected $DataTables;
    public function __construct()
    {
        $this->ActivitiesModel = new ActivitiesModel();
        $this->SettingsModel = new SettingsModel();
        $this->DataTables = new DataTables();
    }

    public function index()
    {
        $data = [
            'title' => 'Pengaturan',
            'agent' => $this->request->getUserAgent()
        ];
        return view('dashboard/settings/index', $data);
    }

    public function edit()
    {
        $data = [
            'title' => 'Ubah Informasi Pengguna',
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
            if ($agent->isRobot() == FALSE) {
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $useragent = $_SERVER['HTTP_USER_AGENT'];
                if ($agent->isMobile()) {
                    $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Mengubah informasi pengguna", "' . $useragent . '", UTC_TIMESTAMP())');
                } else {
                    $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Mengubah informasi pengguna", "' . $useragent . '", UTC_TIMESTAMP())');
                }
            }
            session()->remove('fullname');
            session()->remove('username');
            session()->set('fullname', $this->request->getVar('fullname'));
            session()->set('username', $this->request->getVar('username'));
            session()->setFlashdata('msg', 'Informasi Pengguna berhasil diubah!');
        }
        return redirect()->back();
    }

    public function activities()
    {
        $data = [
            'title' => 'Riwayat Aktivitas',
            'agent' => $this->request->getUserAgent()
        ];
        return view('dashboard/settings/activities', $data);
    }

    public function activitieslist()
    {
        $request = \Config\Services::request();
        $list_data = new $this->DataTables;
        $where = ['id !=' => 0];
        //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
        //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
        $column_order = array('id', 'datetime', 'username', 'ipaddress', 'activity', 'os', 'browser', 'mobile', 'useragent');
        $column_search = array('datetime', 'username', 'ipaddress', 'activity', 'os', 'browser', 'mobile', 'useragent');
        $order = array('datetime' => 'DESC');
        $lists = $list_data->get_datatables('session_history', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $row = array();
            $row[] = '<span class="date">' . ++$no . '</span>';
            $row[] = '<span class="date">' . $list->datetime . '</span>';
            $row[] = $list->username;
            $row[] = '<span class="date text-nowrap">' . $list->ipaddress . '</span>';
            $row[] = '<span class="text-break">' . $list->activity . '</span>';
            $row[] = $list->os;
            $row[] = $list->browser;
            if ($list->mobile != NULL) {
                $row[] = $list->mobile;
            } else {
                $row[] = '-';
            }
            $row[] = $list->useragent;
            $data[] = $row;
        }

        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $list_data->count_all('session_history', $where),
            "recordsFiltered" => $list_data->count_filtered('session_history', $column_order, $column_search, $order, $where),
            "data" => $data,
        );

        return json_encode($output);
    }

    public function about()
    {
        $agent = $this->request->getUserAgent();
        $data = [
            'agent' => $agent,
            'title' => 'Tentang Sistem',
            'agent' => $this->request->getUserAgent()
        ];
        return view('dashboard/settings/about', $data);
    }
}
