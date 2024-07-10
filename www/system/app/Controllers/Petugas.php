<?php

namespace App\Controllers;

use App\Models\PetugasModel;
use App\Models\DataTables;

class Petugas extends BaseController
{
    protected $PetugasModel;
    protected $DataTables;
    public function __construct()
    {
        $this->PetugasModel = new PetugasModel();
        $this->DataTables = new DataTables();
    }

    public function index()
    {
        $petugas = $this->PetugasModel->findAll();
        $data = [
            'petugas' => $petugas,
            'title' => 'Petugas Gizi',
            'agent' => $this->request->getUserAgent()
        ];
        return view('dashboard/petugas/index', $data);
    }

    public function petugaslist()
    {
        $request = \Config\Services::request();
        $list_data = new $this->DataTables;
        $where = ['id_petugas !=' => 0];
        //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
        //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
        $column_order = array('id_petugas', NULL, 'nama_petugas', 'jumlah_menu');
        $column_search = array('nama_petugas');
        $order = array('id_petugas' => 'DESC');
        $lists = $list_data->get_datatables('petugas', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $row = array();
            $row[] = '<span class="date">' . ++$no . '</span>';
            $row[] = '<div class="btn-group" role="group">
                            <a class="btn btn-secondary text-nowrap bg-gradient rounded-start-3" style="--bs-btn-padding-y: 0.15rem; --bs-btn-padding-x: 0.5rem; --bs-btn-font-size: 9pt;" href="' . base_url('/petugas/edit/' . $list->id_petugas) . '" role="button"><i class="fa-solid fa-pen-to-square"></i><span class="fw-bold"> Ganti Nama</span></a>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#modal-delete-' . $list->id_petugas . '" class="btn btn-danger text-nowrap bg-gradient rounded-end-3" style="--bs-btn-padding-y: 0.15rem; --bs-btn-padding-x: 0.5rem; --bs-btn-font-size: 9pt;"><i class="fa-solid fa-trash"></i><span class="fw-bold"> Hapus</span></button>
                        </div>
                        <div class="modal modal-sheet p-4 py-md-5 fade" id="modal-delete-' . $list->id_petugas . '" tabindex="-1" aria-labelledby="modal-delete-' . $list->id_petugas . '" aria-hidden="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content bg-body rounded-4 shadow-lg transparent-blur">
                                <div class="modal-body p-4 text-center">
                                    <h5>Hapus petugas "' . $list->nama_petugas . '"?</h5>
                                    <h6 class="mb-0 fw-normal">Mengapus petugas gizi juga akan menghapus menu yang digunakan petugas gizi ini dan permintaan yang menggunakan menu ini</h6>
                                </div>
                                <form class="modal-footer flex-nowrap p-0" style="border-top: 1px solid var(--bs-border-color-translucent);" id="delete-' . $list->id_petugas . '" action="' . base_url('/petugas/delete/' . $list->id_petugas) . '" method="post">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end" style="border-right: 1px solid var(--bs-border-color-translucent)!important;" data-bs-dismiss="modal">Tidak</button>
                                    <button class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0">Ya</button>
                                </form>
                            </div>
                        </div>
                    </div>
                        ';
            $row[] = $list->nama_petugas;
            $row[] = '<span class="date text-nowrap">' . number_format($list->jumlah_menu, 0, ',', '.') . '</span>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $list_data->count_all('petugas', $where),
            "recordsFiltered" => $list_data->count_filtered('petugas', $column_order, $column_search, $order, $where),
            "data" => $data,
        );

        return json_encode($output);
    }

    public function add()
    {
        $data = [
            'title' => 'Tambah Petugas Gizi',
            'agent' => $this->request->getUserAgent()
        ];
        return view('dashboard/petugas/add', $data);
    }

    public function create()
    {
        if (!$this->validate([
            'nama_petugas' => [
                'label' => 'Nama Petugas',
                'rules' => 'required|is_unique[petugas.nama_petugas]',
                'errors' => [
                    'required' => '{field} wajib diisi!',
                    'is_unique' => '{field} dilarang sama dengan petugas lainnya'
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }
        $this->PetugasModel->save([
            'nama_petugas' => $this->request->getVar('nama_petugas'),
            'jumlah_menu' => 0
        ]);
        $db = db_connect();
        $agent = $this->request->getUserAgent();
        if ($agent->isRobot() == FALSE) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            if ($agent->isMobile()) {
                $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Menambahkan petugas \"' . $this->request->getVar('nama_petugas') . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
            } else {
                $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Menambahkan petugas \"' . $this->request->getVar('nama_petugas') . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
            }
        }
        session()->setFlashdata('msg', 'Petugas gizi "' . $this->request->getVar('nama_petugas') . '" berhasil ditambahkan!');
        return redirect()->to(base_url('/petugas'));
    }

    public function edit($id)
    {
        $petugas = $this->PetugasModel->getPetugas($id);
        if (empty($petugas)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        } else {
            $data = [
                'petugas' => $petugas,
                'title' => 'Ganti Nama "' . $petugas['nama_petugas'] . '"',
                'agent' => $this->request->getUserAgent()
            ];
            echo view('dashboard/petugas/edit', $data);
        }
    }

    public function update($id)
    {
        $petugas = $this->PetugasModel->getPetugas($id);
        if ($petugas['nama_petugas'] == $this->request->getVar('nama_petugas')) {
            $petugasrules = 'required';
        } else {
            $petugasrules = 'required|is_unique[petugas.nama_petugas]';
        }
        if (!$this->validate([
            'nama_petugas' => [
                'label' => 'Nama Petugas',
                'rules' => $petugasrules,
                'errors' => [
                    'required' => '{field} wajib diisi!',
                    'is_unique' => '{field} dilarang sama dengan petugas lainnya'
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }
        $db = db_connect();
        $menu = $db->table('menu')->where('id_petugas', $id);
        $totalmenu = $menu->countAllResults();
        $agent = $this->request->getUserAgent();
        if ($petugas['nama_petugas'] == $this->request->getVar('nama_petugas')) {
            session()->setFlashdata('info', 'Tidak ada perubahan apa-apa dalam formulir ini!');
            return redirect()->back();
        } else {
            $this->PetugasModel->save([
                'id_petugas' => $id,
                'nama_petugas' => $this->request->getVar('nama_petugas'),
                'jumlah_menu' => $totalmenu
            ]);
            if ($agent->isRobot() == FALSE) {
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $useragent = $_SERVER['HTTP_USER_AGENT'];
                if ($agent->isMobile()) {
                    $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Mengganti nama petugas gizi dari \"' . $petugas['nama_petugas'] . '\" menjadi \"' . $this->request->getVar('nama_petugas') . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
                } else {
                    $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Mengganti nama petugas gizi dari \"' . $petugas['nama_petugas'] . '\" menjadi \"' . $this->request->getVar('nama_petugas') . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
                }
            }
            session()->setFlashdata('msg', 'Petugas gizi "' . $petugas['nama_petugas'] . '" berhasil diganti dengan nama baru "' . $this->request->getVar('nama_petugas') . '"!');
            return redirect()->to(base_url('/petugas'));
        }
    }

    public function delete($id)
    {
        $agent = $this->request->getUserAgent();
        $petugas = $this->PetugasModel->getPetugas($id);
        $db = db_connect();
        $menu = $db->table('menu')->join('petugas', 'petugas.id_petugas = menu.id_petugas', 'inner')->where('petugas.id_petugas', $id)->get()->getRowArray();
        if ($petugas['jumlah_menu'] != 0) {
            $db->query('DELETE FROM `permintaan` WHERE id_menu = ' . $menu['id_menu']);
        }
        $db->query('DELETE FROM `menu` WHERE id_petugas = ' . $id);
        $this->PetugasModel->delete($id);
        $db->query('ALTER TABLE `menu` auto_increment = 1');
        $db->query('ALTER TABLE `permintaan` auto_increment = 1');
        $db->query('ALTER TABLE `petugas` auto_increment = 1');
        if ($agent->isRobot() == FALSE) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            if ($agent->isMobile()) {
                $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Menghapus petugas \"' . $petugas['nama_petugas'] . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
            } else {
                $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Menghapus petugas \"' . $petugas['nama_petugas'] . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
            }
        }
        session()->setFlashdata('msg', 'Petugas gizi "' . $petugas['nama_petugas'] . '" berhasil dihapus!');
        return redirect()->to(base_url('/petugas'));
    }
}
