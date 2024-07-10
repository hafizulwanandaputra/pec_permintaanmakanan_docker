<?php

namespace App\Controllers;

use App\Models\PetugasModel;
use App\Models\PermintaanModel;
use App\Models\MenuModel;
use App\Models\DataTablesMenu;
use App\Models\DataTablesPermintaan;

class Menu extends BaseController
{
    protected $PetugasModel;
    protected $PermintaanModel;
    protected $MenuModel;
    protected $DataTablesMenu;
    protected $DataTablesPermintaan;
    public function __construct()
    {
        $this->PetugasModel = new PetugasModel();
        $this->PermintaanModel = new PermintaanModel();
        $this->MenuModel = new MenuModel();
        $this->DataTablesMenu = new DataTablesMenu();
        $this->DataTablesPermintaan = new DataTablesPermintaan();
    }

    public function index()
    {
        $menu = $this->MenuModel->findAll();
        $data = [
            'menu' => $menu,
            'title' => 'Menu Makanan',
            'agent' => $this->request->getUserAgent()
        ];
        return view('dashboard/menu/index', $data);
    }

    public function menulist()
    {
        $request = \Config\Services::request();
        $list_data = new $this->DataTablesMenu;
        $where = ['id_menu !=' => 0];
        //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
        //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
        $column_order = array('id_menu', NULL, 'tanggal', 'nama_menu', 'jadwal_makan', 'nama_petugas', 'jumlah');
        $column_search = array('tanggal', 'nama_menu');
        $order = array('id_menu' => 'DESC');
        $lists = $list_data->get_datatables('menu', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $row = array();
            $row[] = '<span class="date">' . ++$no . '</span>';
            $row[] = '<div class="btn-group" role="group">
                            <a class="btn btn-info text-nowrap bg-gradient rounded-start-3" style="--bs-btn-padding-y: 0.15rem; --bs-btn-padding-x: 0.5rem; --bs-btn-font-size: 9pt;" href="' . base_url('/menu/details/' . $list->id_menu) . '" role="button"><i class="fa-solid fa-circle-info"></i><span class="fw-bold"> Detail</span></a>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#modal-delete-' . $list->id_menu . '" class="btn btn-danger text-nowrap bg-gradient rounded-end-3" style="--bs-btn-padding-y: 0.15rem; --bs-btn-padding-x: 0.5rem; --bs-btn-font-size: 9pt;"><i class="fa-solid fa-trash"></i><span class="fw-bold"> Hapus</span></button>
                        </div>
                        <div class="modal modal-sheet p-4 py-md-5 fade" id="modal-delete-' . $list->id_menu . '" tabindex="-1" aria-labelledby="modal-delete-' . $list->id_menu . '" aria-hidden="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content bg-body rounded-4 shadow-lg transparent-blur">
                                <div class="modal-body p-4 text-center">
                                    <h5>Hapus menu "' . $list->nama_menu . '"?</h5>
                                    <h6 class="mb-0 fw-normal">Mengapus menu juga akan menghapus permintaan yang menggunakan menu ini</h6>
                                </div>
                                <form class="modal-footer flex-nowrap p-0" style="border-top: 1px solid var(--bs-border-color-translucent);" id="delete-' . $list->id_menu . '" action="' . base_url('/menu/delete/' . $list->id_menu) . '" method="post">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end" style="border-right: 1px solid var(--bs-border-color-translucent)!important;" data-bs-dismiss="modal">Tidak</button>
                                    <button class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0">Ya</button>
                                </form>
                            </div>
                        </div>
                    </div>
                        ';
            $row[] = '<span class="date text-nowrap">' . $list->tanggal . '</span>';
            $row[] = '<strong>' . $list->nama_menu . '</strong><div class="text-nowrap">Protein Hewani: ' . $list->protein_hewani . '<br>Protein Nabati: ' . $list->protein_nabati . '<br>Sayur: ' . $list->sayur . '<br>Buah: ' . $list->buah . '</div>';
            $row[] = $list->jadwal_makan;
            $row[] = $list->nama_petugas;
            $row[] = '<span class="date text-nowrap">' . number_format($list->jumlah, 0, ',', '.') . '</span>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $list_data->count_all('menu', $where),
            "recordsFiltered" => $list_data->count_filtered('menu', $column_order, $column_search, $order, $where),
            "data" => $data,
        );

        return json_encode($output);
    }

    public function add()
    {
        $petugas = $this->PetugasModel->orderBy('id_petugas', 'DESC')->findAll();
        $data = [
            'petugas' => $petugas,
            'title' => 'Tambah Menu Makanan',
            'agent' => $this->request->getUserAgent()
        ];
        return view('dashboard/menu/add', $data);
    }

    public function create()
    {
        if (!$this->validate([
            'tanggal' => [
                'label' => 'Tanggal',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!'
                ]
            ],
            'nama_menu' => [
                'label' => 'Nama Menu',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!'
                ]
            ],
            'jadwal_makan' => [
                'label' => 'Jadwal Makan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib dipilih!'
                ]
            ],
            'petugas' => [
                'label' => 'Petugas Gizi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib dipilih!'
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }
        $this->MenuModel->save([
            'id_petugas' => $this->request->getVar('petugas'),
            'tanggal' => $this->request->getVar('tanggal'),
            'nama_menu' => $this->request->getVar('nama_menu'),
            'jadwal_makan' => $this->request->getVar('jadwal_makan'),
            'protein_hewani' => $this->request->getVar('protein_hewani'),
            'protein_nabati' => $this->request->getVar('protein_nabati'),
            'sayur' => $this->request->getVar('sayur'),
            'buah' => $this->request->getVar('buah'),
            'jumlah' => 0,
        ]);
        $db = db_connect();
        $petugas = $db->table('menu')->where('id_petugas', $this->request->getVar('petugas'));
        $totalpetugas = $petugas->countAllResults();
        $db->query('UPDATE petugas SET jumlah_menu = ' . $totalpetugas . ' WHERE id_petugas = ' . $this->request->getVar('petugas'));
        $agent = $this->request->getUserAgent();
        if ($agent->isRobot() == FALSE) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            if ($agent->isMobile()) {
                $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Membuat menu \"' . $this->request->getVar('nama_menu') . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
            } else {
                $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Membuat menu \"' . $this->request->getVar('nama_menu') . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
            }
        }
        session()->setFlashdata('msg', 'Menu makanan ' . $this->request->getVar('nama_menu') . ' berhasil ditambahkan!');
        return redirect()->to(base_url('/menu/details/' . $this->MenuModel->getInsertID()));
    }

    public function edit($id)
    {
        $petugas = $this->PetugasModel->orderBy('id_petugas', 'DESC')->findAll();
        $menu = $this->MenuModel->getMenu($id);
        if (empty($menu)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        } else {
            $data = [
                'petugas' => $petugas,
                'menu' => $menu,
                'title' => 'Edit "' . $menu['nama_menu'] . '"',
                'agent' => $this->request->getUserAgent()
            ];
            echo view('dashboard/menu/edit', $data);
        }
    }

    public function update($id)
    {
        $menu = $this->MenuModel->getMenu($id);
        if (!$this->validate([
            'tanggal' => [
                'label' => 'Tanggal',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!'
                ]
            ],
            'nama_menu' => [
                'label' => 'Nama Menu',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!'
                ]
            ],
            'jadwal_makan' => [
                'label' => 'Jadwal Makan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib dipilih!'
                ]
            ],
            'petugas' => [
                'label' => 'Petugas Gizi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib dipilih!'
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }
        $db = db_connect();
        $permintaan = $db->table('permintaan')->where('id_menu', $id);
        $totalpermintaan = $permintaan->countAllResults();
        $agent = $this->request->getUserAgent();
        if ($menu['tanggal'] == $this->request->getVar('tanggal') && $menu['jadwal_makan'] == $this->request->getVar('jadwal_makan') && $menu['nama_menu'] == $this->request->getVar('nama_menu') && $menu['protein_hewani'] == $this->request->getVar('protein_hewani') && $menu['protein_nabati'] == $this->request->getVar('protein_nabati') && $menu['sayur'] == $this->request->getVar('sayur') && $menu['buah'] == $this->request->getVar('buah') && $menu['id_petugas'] == $this->request->getVar('petugas')) {
            session()->setFlashdata('info', 'Tidak ada perubahan apa-apa dalam formulir ini!');
            return redirect()->back();
        } else {
            $this->MenuModel->save([
                'id_menu' => $id,
                'id_petugas' => $this->request->getVar('petugas'),
                'tanggal' => $this->request->getVar('tanggal'),
                'jadwal_makan' => $this->request->getVar('jadwal_makan'),
                'nama_menu' => $this->request->getVar('nama_menu'),
                'protein_hewani' => $this->request->getVar('protein_hewani'),
                'protein_nabati' => $this->request->getVar('protein_nabati'),
                'sayur' => $this->request->getVar('sayur'),
                'buah' => $this->request->getVar('buah'),
                'jumlah' => $totalpermintaan,
            ]);
            if ($menu['id_petugas'] != $this->request->getVar('petugas')) {
                $petugas1 = $db->table('menu')->where('id_petugas', $menu['id_petugas'])->countAllResults();
                $petugas2 = $db->table('menu')->where('id_petugas', $this->request->getVar('petugas'))->countAllResults();
                $db->query('UPDATE petugas SET jumlah_menu = ' . $petugas1 . ' WHERE id_petugas = ' . $menu['id_petugas']);
                $db->query('UPDATE petugas SET jumlah_menu = ' . $petugas2 . ' WHERE id_petugas = ' . $this->request->getVar('petugas'));
            }
            if ($menu['nama_menu'] == $this->request->getVar('nama_menu')) {
                if ($agent->isRobot() == FALSE) {
                    $ipaddress = $_SERVER['REMOTE_ADDR'];
                    $useragent = $_SERVER['HTTP_USER_AGENT'];
                    if ($agent->isMobile()) {
                        $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Mengedit menu \"' . $this->request->getVar('nama_menu') . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
                    } else {
                        $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Mengedit menu \"' . $this->request->getVar('nama_menu') . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
                    }
                }
                session()->setFlashdata('msg', 'Menu "' . $this->request->getVar('nama_menu') . '" berhasil diedit!');
            } else {
                if ($agent->isRobot() == FALSE) {
                    $ipaddress = $_SERVER['REMOTE_ADDR'];
                    $useragent = $_SERVER['HTTP_USER_AGENT'];
                    if ($agent->isMobile()) {
                        $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Mengedit dan mengganti nama menu dari \"' . $menu['nama_menu'] . '\" menjadi \"' . $this->request->getVar('nama_menu') . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
                    } else {
                        $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Mengedit dan mengganti nama menu dari \"' . $menu['nama_menu'] . '\" menjadi \"' . $this->request->getVar('nama_menu') . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
                    }
                }
                session()->setFlashdata('msg', 'Menu "' . $menu['nama_menu'] . '" berhasil diedit dengan nama baru "' . $this->request->getVar('nama_menu') . '"!');
            }
            return redirect()->to(base_url('/menu/details/' . $id));
        }
    }

    public function details($id)
    {
        $menu = $this->MenuModel->getMenu($id);
        if (empty($menu)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        } else {
            $petugas = $this->PetugasModel->where('id_petugas', $menu['id_petugas'])->get()->getRowArray();
            $data = [
                'petugas' => $petugas,
                'menu' => $menu,
                'title' => 'Detail "' . $menu['nama_menu'] . '"',
                'agent' => $this->request->getUserAgent()
            ];
            echo view('dashboard/menu/details', $data);
        }
    }

    public function listpermintaanmenu($id)
    {
        $request = \Config\Services::request();
        $list_data = new $this->DataTablesPermintaan;
        $where = ['permintaan.id_menu' => $id];
        //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
        //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
        $column_order = array('id', NULL, 'nama_pasien', 'tanggal_lahir', 'jenis_kelamin', 'kamar', 'jenis_tindakan', 'diet', 'keterangan');
        $column_search = array('nama_pasien', 'tanggal_lahir');
        $order = array('id' => 'DESC');
        $lists = $list_data->get_datatables('permintaan', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $row = array();
            $row[] = '<span class="date">' . ++$no . '</span>';
            $row[] = '<div class="btn-group" role="group">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#modal-details-' . $list->id . '" class="btn btn-info text-nowrap bg-gradient rounded-start-3" style="--bs-btn-padding-y: 0.15rem; --bs-btn-padding-x: 0.5rem; --bs-btn-font-size: 9pt;"><i class="fa-solid fa-circle-info"></i></button>
                            <a class="btn btn-secondary text-nowrap bg-gradient" style="--bs-btn-padding-y: 0.15rem; --bs-btn-padding-x: 0.5rem; --bs-btn-font-size: 9pt;" href="' . base_url('/menu/editpermintaan/' . $list->id) . '" role="button"><i class="fa-solid fa-pen-to-square"></i></a>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#modal-delete-' . $list->id . '" class="btn btn-danger text-nowrap bg-gradient rounded-end-3" style="--bs-btn-padding-y: 0.15rem; --bs-btn-padding-x: 0.5rem; --bs-btn-font-size: 9pt;"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        <div class="modal" id="modal-details-' . $list->id . '" tabindex="-1" aria-labelledby="modal-details-' . $list->id . '-Label" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable rounded-3">
                <div class="modal-content bg-body shadow-lg transparent-blur">
                    <div class="modal-header justify-content-between pt-2 pb-2" style="border-bottom: 1px solid var(--bs-border-color-translucent);">
                        <h6 class="pe-2 modal-title fs-6 text-truncate" id="staticBackdropLabel" style="font-weight: bold;">Detail Permintaan Pasien</h6>
                        <button type="button" class="btn btn-danger btn-sm bg-gradient ps-0 pe-0 pt-0 pb-0 rounded-3" data-bs-dismiss="modal" aria-label="Close"><span data-feather="x" class="mb-0" style="width: 30px; height: 30px;"></span></button>
                    </div>
                    <div class="modal-body py-2">
                        <fieldset class="border rounded-3 px-2 py-0 h-100" style="border-color: var(--bs-border-color-translucent)!important;">
                            <legend class="float-none w-auto mb-0 px-1 fs-6 fw-bold">Menu</legend>
                            <div class="mb-2 row fs-6">
                                <div class="col-lg-3 fw-medium">Tanggal</div>
                                <div class="col-lg">
                                    <div class="date">' . $list->tanggal . '</div>
                                </div>
                            </div>
                            <div class="mb-2 row fs-6">
                                <div class="col-lg-3 fw-medium">Nama Menu</div>
                                <div class="col-lg">
                                    <div>
                                        <div class="mb-1 date fw-bold">' . $list->nama_menu . '</div>
                                        <div class="mb-1 row fs-6">
                                            <div class="col-5 fw-medium">Protein Hewani</div>
                                            <div class="col">
                                                <div>' . $list->protein_hewani . '</div>
                                            </div>
                                        </div>
                                        <div class="mb-1 row fs-6">
                                            <div class="col-5 fw-medium">Protein Nabati</div>
                                            <div class="col">
                                                <div>' . $list->protein_nabati . '</div>
                                            </div>
                                        </div>
                                        <div class="mb-1 row fs-6">
                                            <div class="col-5 fw-medium">Sayur</div>
                                            <div class="col">
                                                <div>' . $list->sayur . '</div>
                                            </div>
                                        </div>
                                        <div class="mb-1 row fs-6">
                                            <div class="col-5 fw-medium">Buah</div>
                                            <div class="col">
                                                <div>' . $list->buah . '</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2 row fs-6">
                                <div class="col-lg-3 fw-medium">Jadwal Makan</div>
                                <div class="col-lg">
                                    <div class="date">' . $list->jadwal_makan . '</div>
                                </div>
                            </div>
                            <div class="mb-2 row fs-6">
                                <div class="col-lg-3 fw-medium">Petugas Gizi</div>
                                <div class="col-lg">
                                    <div class="date">' . $list->nama_petugas . '</div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border rounded-3 px-2 py-0 h-100" style="border-color: var(--bs-border-color-translucent)!important;">
                            <legend class="float-none w-auto mb-0 px-1 fs-6 fw-bold">Identitas Pasien</legend>
                            <div class="mb-2 row fs-6">
                                <div class="col-lg-3 fw-medium">Nama Pasien</div>
                                <div class="col-lg">
                                    <div>' . $list->nama_pasien . '</div>
                                </div>
                            </div>
                            <div class="mb-2 row fs-6">
                                <div class="col-lg-3 fw-medium">Tanggal Lahir</div>
                                <div class="col-lg">
                                    <div class="date">' . $list->tanggal_lahir . '</div>
                                </div>
                            </div>
                            <div class="mb-2 row fs-6">
                                <div class="col-lg-3 fw-medium">Jenis Kelamin</div>
                                <div class="col-lg">
                                    <div class="date">' . $list->jenis_kelamin . '</div>
                                </div>
                            </div>
                            <div class="mb-2 row fs-6">
                                <div class="col-lg-3 fw-medium">Kamar</div>
                                <div class="col-lg">
                                    <div class="date">' . $list->kamar . '</div>
                                </div>
                            </div>
                            <div class="mb-2 row fs-6">
                                <div class="col-lg-3 fw-medium">Jenis Tindakan</div>
                                <div class="col-lg">
                                    <div class="date">' . $list->jenis_tindakan . '</div>
                                </div>
                            </div>
                            <div class="mb-2 row fs-6">
                                <div class="col-lg-3 fw-medium">Diet</div>
                                <div class="col-lg">
                                    <div class="date">' . $list->diet . '</div>
                                </div>
                            </div>
                            <div class="mb-2 row fs-6">
                                <div class="col-lg-3 fw-medium">Keterangan</div>
                                <div class="col-lg">
                                    <div class="date">' . $list->keterangan . '</div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer justify-content-end pt-2 pb-2" style="border-top: 1px solid var(--bs-border-color-translucent);">
                        <a class="btn btn-primary btn-sm bg-gradient rounded-3" href="' . base_url('/permintaan/eticketprint/' . $list->id) . '" role="button" target="_blank"><i class="fa-solid fa-print"></i> Cetak E-tiket</a>
                    </div>
                </div>
            </div>
        </div>
                        <div class="modal modal-sheet p-4 py-md-5 fade" id="modal-delete-' . $list->id . '" tabindex="-1" aria-labelledby="modal-delete-' . $list->id . '" aria-hidden="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content bg-body rounded-4 shadow-lg transparent-blur">
                                <div class="modal-body p-4 text-center">
                                    <h5 class="mb-0">Hapus "' . $list->nama_pasien . '"?</h5>
                                </div>
                                <form class="modal-footer flex-nowrap p-0" style="border-top: 1px solid var(--bs-border-color-translucent);" id="delete-' . $list->id . '" action="' . base_url('/permintaan/delete/' . $list->id) . '" method="post">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end" style="border-right: 1px solid var(--bs-border-color-translucent)!important;" data-bs-dismiss="modal">Tidak</button>
                                    <button class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0">Ya</button>
                                </form>
                            </div>
                        </div>
                    </div>
                        ';
            $row[] = $list->nama_pasien;
            $row[] = '<span class="date text-nowrap">' . $list->tanggal_lahir . '</span>';
            $row[] = $list->jenis_kelamin;
            $row[] = $list->kamar;
            $row[] = $list->jenis_tindakan;
            $row[] = $list->diet;
            $row[] = $list->keterangan;
            $data[] = $row;
        }

        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $list_data->count_all('permintaan', $where),
            "recordsFiltered" => $list_data->count_filtered('permintaan', $column_order, $column_search, $order, $where),
            "data" => $data,
        );

        return json_encode($output);
    }

    public function addpermintaan($id)
    {
        $menu = $this->MenuModel->join('petugas', 'menu.id_petugas = petugas.id_petugas', 'inner')->getMenu($id);
        $data = [
            'menu' => $menu,
            'title' => 'Tambah Permintaan',
            'agent' => $this->request->getUserAgent()
        ];
        return view('dashboard/menu/addpermintaan', $data);
    }

    public function createpermintaan($id)
    {
        if (!$this->validate([
            'nama_pasien' => [
                'label' => 'Nama Pasien',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!'
                ]
            ],
            'tanggal_lahir' => [
                'label' => 'Tanggal Lahir',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!'
                ]
            ],
            'jenis_kelamin' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib dipilih!'
                ]
            ],
            'kamar' => [
                'label' => 'Kamar',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!'
                ]
            ],
            'jenis_tindakan' => [
                'label' => 'Jenis Tindakan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!'
                ]
            ],
            'diet' => [
                'label' => 'Diet',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!'
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }
        $this->PermintaanModel->save([
            'id_menu' => $id,
            'nama_pasien' => $this->request->getVar('nama_pasien'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'kamar' => $this->request->getVar('kamar'),
            'jenis_tindakan' => $this->request->getVar('jenis_tindakan'),
            'diet' => $this->request->getVar('diet'),
            'keterangan' => $this->request->getVar('keterangan'),
        ]);
        $db = db_connect();
        $agent = $this->request->getUserAgent();
        $permintaan = $db->table('permintaan')->where('id_menu', $id);
        $totalpermintaan = $permintaan->countAllResults();
        $db->query('UPDATE menu SET jumlah = ' . $totalpermintaan . ' WHERE id_menu = ' . $id);
        if ($agent->isRobot() == FALSE) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            if ($agent->isMobile()) {
                $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Membuat permintaan pasien \"' . $this->request->getVar('nama_pasien') . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
            } else {
                $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Membuat permintaan pasien \"' . $this->request->getVar('nama_pasien') . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
            }
        }
        session()->setFlashdata('msg', 'Permintaan pasien "' . $this->request->getVar('nama_pasien') . '" berhasil ditambahkan!');
        return redirect()->to(base_url('/menu/details/' . $id));
    }

    public function editpermintaan($id)
    {
        $permintaan = $this->PermintaanModel->join('menu', 'permintaan.id_menu = menu.id_menu', 'inner')->join('petugas', 'menu.id_petugas = petugas.id_petugas', 'inner')->getPermintaan($id);
        if (empty($permintaan)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        } else {
            $db = \Config\Database::connect();
            $menuq = $db->table('menu');
            $menuq->select('*');
            $menuq->join('petugas', 'menu.id_petugas = petugas.id_petugas', 'inner');
            $menu = $menuq->get()->getResult('array');
            $data = [
                'permintaan' => $permintaan,
                'menu' => $menu,
                'title' => 'Edit "' . $permintaan['nama_pasien'] . '"',
                'agent' => $this->request->getUserAgent()
            ];
            echo view('dashboard/menu/editpermintaan', $data);
        }
    }

    public function updatepermintaan($id)
    {
        $permintaan = $this->PermintaanModel->getPermintaan($id);
        if (!$this->validate([
            'nama_pasien' => [
                'label' => 'Nama Pasien',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!'
                ]
            ],
            'tanggal_lahir' => [
                'label' => 'Tanggal Lahir',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!'
                ]
            ],
            'jenis_kelamin' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib dipilih!'
                ]
            ],
            'kamar' => [
                'label' => 'Kamar',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!'
                ]
            ],
            'jenis_tindakan' => [
                'label' => 'Jenis Tindakan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!'
                ]
            ],
            'diet' => [
                'label' => 'Diet',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!'
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }
        $db = db_connect();
        $agent = $this->request->getUserAgent();
        if ($permintaan['nama_pasien'] == $this->request->getVar('nama_pasien') && $permintaan['tanggal_lahir'] == $this->request->getVar('tanggal_lahir') && $permintaan['jenis_kelamin'] == $this->request->getVar('jenis_kelamin') && $permintaan['kamar'] == $this->request->getVar('kamar') && $permintaan['jenis_tindakan'] == $this->request->getVar('jenis_tindakan') && $permintaan['diet'] == $this->request->getVar('diet') && $permintaan['keterangan'] == $this->request->getVar('keterangan')) {
            session()->setFlashdata('info', 'Tidak ada perubahan apa-apa dalam formulir ini!');
            return redirect()->back();
        } else {
            $this->PermintaanModel->save([
                'id' => $id,
                'id_menu' => $permintaan['id_menu'],
                'nama_pasien' => $this->request->getVar('nama_pasien'),
                'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
                'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
                'kamar' => $this->request->getVar('kamar'),
                'jenis_tindakan' => $this->request->getVar('jenis_tindakan'),
                'diet' => $this->request->getVar('diet'),
                'keterangan' => $this->request->getVar('keterangan'),
            ]);
            $permintaan1 = $db->table('permintaan')->where('id_menu', $permintaan['id_menu']);
            $totalpermintaan = $permintaan1->countAllResults();
            $db->query('UPDATE menu SET jumlah = ' . $totalpermintaan . ' WHERE id_menu = ' . $permintaan['id_menu']);
            if ($permintaan['nama_pasien'] == $this->request->getVar('nama_pasien')) {
                if ($agent->isRobot() == FALSE) {
                    $ipaddress = $_SERVER['REMOTE_ADDR'];
                    $useragent = $_SERVER['HTTP_USER_AGENT'];
                    if ($agent->isMobile()) {
                        $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Mengedit permintaan pasien \"' . $this->request->getVar('nama_pasien') . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
                    } else {
                        $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Mengedit permintaan pasien \"' . $this->request->getVar('nama_pasien') . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
                    }
                }
                session()->setFlashdata('msg', 'Permintaan pasien "' . $this->request->getVar('nama_pasien') . '" berhasil diedit!');
            } else {
                if ($agent->isRobot() == FALSE) {
                    $ipaddress = $_SERVER['REMOTE_ADDR'];
                    $useragent = $_SERVER['HTTP_USER_AGENT'];
                    if ($agent->isMobile()) {
                        $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Mengedit permintaan dan mengganti nama pasien dari \"' . $permintaan['nama_pasien'] . '\" menjadi \"' . $this->request->getVar('nama_pasien') . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
                    } else {
                        $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Mengedit permintaan dan mengganti nama pasien dari \"' . $permintaan['nama_pasien'] . '\" menjadi \"' . $this->request->getVar('nama_pasien') . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
                    }
                }
                session()->setFlashdata('msg', 'Permintaan pasien "' . $permintaan['nama_pasien'] . '" berhasil diedit dengan nama baru "' . $this->request->getVar('nama_pasien') . '"!');
            }
            return redirect()->to(base_url('/menu/details/' . $permintaan['id_menu']));
        }
    }

    public function delete($id)
    {
        $agent = $this->request->getUserAgent();
        $menu = $this->MenuModel->getMenu($id);
        $this->MenuModel->delete($id);
        $db = db_connect();
        $petugas = $db->table('menu')->where('id_petugas', $menu['id_petugas']);
        $totalpetugas = $petugas->countAllResults();
        $db->query('UPDATE petugas SET jumlah_menu = ' . $totalpetugas . ' WHERE id_petugas = ' . $menu['id_petugas']);
        $db->query('DELETE FROM `permintaan` WHERE id_menu = ' . $id);
        $db->query('ALTER TABLE `menu` auto_increment = 1');
        $db->query('ALTER TABLE `permintaan` auto_increment = 1');
        if ($agent->isRobot() == FALSE) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            if ($agent->isMobile()) {
                $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Menghapus menu \"' . $menu['nama_menu'] . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
            } else {
                $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Menghapus menu \"' . $menu['nama_menu'] . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
            }
        }
        session()->setFlashdata('msg', 'Menu "' . $menu['nama_menu'] . '" berhasil dihapus!');
        return redirect()->to(base_url('/menu'));
    }
}
