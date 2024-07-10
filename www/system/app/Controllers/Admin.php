<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\DataTables;

class Admin extends BaseController
{
    protected $AuthModel;
    protected $DataTables;
    public function __construct()
    {
        $this->AuthModel = new AuthModel();
        $this->DataTables = new DataTables();
    }

    public function index()
    {
        $admin = $this->AuthModel->findAll();
        $data = [
            'admin' => $admin,
            'title' => 'Admin',
            'agent' => $this->request->getUserAgent()
        ];
        if (session()->get('role') == "Master Admin") {
            return view('dashboard/admin/index', $data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function adminlist()
    {
        $request = \Config\Services::request();
        $list_data = new $this->DataTables;
        $where = ['id_user !=' => session()->get('id_user')];
        //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
        //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
        $column_order = array('id_user', NULL, 'fullname');
        $column_search = array('fullname', 'username', 'role');
        $order = array('id_user' => 'DESC');
        $lists = $list_data->get_datatables('user', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $row = array();
            $row[] = '<span class="date">' . ++$no . '</span>';
            $row[] = '<div class="btn-group" role="group">
                            <a class="btn btn-secondary text-nowrap bg-gradient rounded-start-3" style="--bs-btn-padding-y: 0.15rem; --bs-btn-padding-x: 0.5rem; --bs-btn-font-size: 9pt;" href="' . base_url('/admin/edit/' . $list->id_user) . '" role="button"><i class="fa-solid fa-pen-to-square"></i><span class="fw-bold"> Edit</span></a>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#modal-delete-' . $list->id_user . '" class="btn btn-danger text-nowrap bg-gradient rounded-end-3" style="--bs-btn-padding-y: 0.15rem; --bs-btn-padding-x: 0.5rem; --bs-btn-font-size: 9pt;"><i class="fa-solid fa-trash"></i><span class="fw-bold"> Hapus</span></button>
                        </div>
                        <div class="modal modal-sheet p-4 py-md-5 fade" id="modal-delete-' . $list->id_user . '" tabindex="-1" aria-labelledby="modal-delete-' . $list->id_user . '" aria-hidden="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content bg-body rounded-4 shadow-lg transparent-blur">
                                <div class="modal-body p-4 text-center">
                                    <h5 class="mb-0">Hapus admin "' . $list->fullname . '" (@' . $list->username . ')?</h5>
                                </div>
                                <form class="modal-footer flex-nowrap p-0" style="border-top: 1px solid var(--bs-border-color-translucent);" id="delete-' . $list->id_user . '" action="' . base_url('/admin/delete/' . $list->id_user) . '" method="post">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end" style="border-right: 1px solid var(--bs-border-color-translucent)!important;" data-bs-dismiss="modal">Tidak</button>
                                    <button class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0">Ya</button>
                                </form>
                            </div>
                        </div>
                    </div>
                        ';
            $row[] = '<strong>' . $list->fullname . '</strong><br>@' . $list->username . '<br>' . $list->role;
            $data[] = $row;
        }

        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $list_data->count_all('user', $where),
            "recordsFiltered" => $list_data->count_filtered('user', $column_order, $column_search, $order, $where),
            "data" => $data,
        );

        return json_encode($output);
    }

    public function add()
    {
        $data = [
            'title' => 'Tambah Admin',
            'agent' => $this->request->getUserAgent()
        ];
        if (session()->get('role') == "Master Admin") {
            return view('dashboard/admin/add', $data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function create()
    {
        if (!$this->validate([
            'fullname' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required',
            ],
            'username' => [
                'label' => 'Nama Pengguna',
                'rules' => 'required|is_unique[user.username]|alpha_numeric_punct',
            ],
            'role' => [
                'label' => 'Jenis Pengguna',
                'rules' => 'required',
            ],
        ])) {
            return redirect()->back()->withInput();
        }
        $password = password_hash($this->request->getVar('username'), PASSWORD_DEFAULT);
        $this->AuthModel->save([
            'fullname' => $this->request->getVar('fullname'),
            'username' => $this->request->getVar('username'),
            'password' => $password,
            'profilephoto' => NULL,
            'role' => $this->request->getVar('role'),
        ]);
        $db = db_connect();
        $agent = $this->request->getUserAgent();
        if ($agent->isRobot() == FALSE) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            if ($agent->isMobile()) {
                $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Menambahkan admin @' . $this->request->getVar('username') . '", "' . $useragent . '", UTC_TIMESTAMP())');
            } else {
                $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Menambahkan admin @' . $this->request->getVar('username') . '", "' . $useragent . '", UTC_TIMESTAMP())');
            }
        }
        session()->setFlashdata('msg', '@' . $this->request->getVar('username') . ' berhasil ditambahkan!');
        return redirect()->to(base_url('/admin'));
    }

    public function edit($id)
    {
        $admin = $this->AuthModel->getUsers($id);
        if (empty($admin)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        } else {
            if ($admin['id_user'] == session()->get('id_user')) {
                return redirect()->to(base_url('/settings/edit'));
            } else {
                $data = [
                    'admin' => $admin,
                    'title' => 'Edit @' . $admin['username'],
                    'agent' => $this->request->getUserAgent()
                ];
                if (session()->get('role') == "Master Admin") {
                    return view('dashboard/admin/edit', $data);
                } else {
                    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
                }
            }
        }
    }

    public function update($id)
    {
        $admin = $this->AuthModel->getUsers($id);
        $password = $admin['password'];
        $profilephoto = $admin['profilephoto'];
        if ($admin['username'] == $this->request->getVar('username')) {
            $adminrules = 'required|alpha_numeric_punct';
        } else {
            $adminrules = 'required|is_unique[menu.nama_menu]|alpha_numeric_punct';
        }
        if (!$this->validate([
            'fullname' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required',
            ],
            'username' => [
                'label' => 'Nama Pengguna',
                'rules' => $adminrules,
            ],
            'role' => [
                'label' => 'Jenis Pengguna',
                'rules' => 'required',
            ],
        ])) {
            return redirect()->back()->withInput();
        }
        $db = db_connect();
        $agent = $this->request->getUserAgent();
        if ($admin['fullname'] == $this->request->getVar('fullname') && $admin['username'] == $this->request->getVar('username') && $admin['role'] == $this->request->getVar('role')) {
            session()->setFlashdata('info', 'Tidak ada perubahan apa-apa dalam formulir ini!');
            return redirect()->back();
        } else {
            $this->AuthModel->save([
                'id_user' => $id,
                'fullname' => $this->request->getVar('fullname'),
                'username' => $this->request->getVar('username'),
                'password' => $password,
                'profilephoto' => $profilephoto,
                'role' => $this->request->getVar('role'),
            ]);
            if ($admin['username'] == $this->request->getVar('username')) {
                if ($agent->isRobot() == FALSE) {
                    $ipaddress = $_SERVER['REMOTE_ADDR'];
                    $useragent = $_SERVER['HTTP_USER_AGENT'];
                    if ($agent->isMobile()) {
                        $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Mengubah informasi pengguna @' . $this->request->getVar('username') . '", "' . $useragent . '", UTC_TIMESTAMP())');
                    } else {
                        $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Mengubah informasi pengguna @' . $this->request->getVar('username') . '", "' . $useragent . '", UTC_TIMESTAMP())');
                    }
                }
                session()->setFlashdata('msg', '@' . $this->request->getVar('username') . ' berhasil diubah!');
            } else {
                if ($agent->isRobot() == FALSE) {
                    $ipaddress = $_SERVER['REMOTE_ADDR'];
                    $useragent = $_SERVER['HTTP_USER_AGENT'];
                    if ($agent->isMobile()) {
                        $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Mengedit informasi pengguna dengan mengubah nama pengguna dari @' . $admin['username'] . ' menjadi @' . $this->request->getVar('username') . '", "' . $useragent . '", UTC_TIMESTAMP())');
                    } else {
                        $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Mengedit informasi pengguna dengan mengubah nama pengguna dari @' . $admin['username'] . ' menjadi @' . $this->request->getVar('username') . '", "' . $useragent . '", UTC_TIMESTAMP())');
                    }
                }
                session()->setFlashdata('msg', '@' . $admin['username'] . ' berhasil diganti dengan nama baru @' . $this->request->getVar('username') . '!');
            }
            return redirect()->to(base_url('/admin'));
        }
    }

    public function delete($id)
    {
        $agent = $this->request->getUserAgent();
        $admin = $this->AuthModel->getUsers($id);
        if ($admin['id_user'] == session()->get('id_user')) {
            session()->setFlashdata('error', 'Anda tidak dapat menghapus admin yang sedang masuk!');
            return redirect()->back();
        } else {
            $this->AuthModel->delete($id);
            $db = db_connect();
            $db->query('ALTER TABLE `user` auto_increment = 1');
            if ($agent->isRobot() == FALSE) {
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $useragent = $_SERVER['HTTP_USER_AGENT'];
                if ($agent->isMobile()) {
                    $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Menghapus admin @' . $admin['username'] . '", "' . $useragent . '", UTC_TIMESTAMP())');
                } else {
                    $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Menghapus admin @' . $admin['username'] . '", "' . $useragent . '", UTC_TIMESTAMP())');
                }
            }
            session()->setFlashdata('msg', '@' . $admin['username'] . ' berhasil dihapus!');
            return redirect()->to(base_url('/admin'));
        }
    }
}
