<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use App\Models\PermintaanModel;
use App\Models\MenuModel;
use App\Models\PetugasModel;
use App\Models\DataTablesPermintaan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class Permintaan extends BaseController
{
    protected $PermintaanModel;
    protected $MenuModel;
    protected $PetugasModel;
    protected $DataTablesPermintaan;
    public function __construct()
    {
        $this->PermintaanModel = new PermintaanModel();
        $this->MenuModel = new MenuModel();
        $this->PetugasModel = new PetugasModel();
        $this->DataTablesPermintaan = new DataTablesPermintaan();
    }

    public function index()
    {
        $data = [
            'title' => 'Permintaan',
            'agent' => $this->request->getUserAgent()
        ];
        return view('dashboard/permintaan/index', $data);
    }

    public function menulist()
    {
        $request = \Config\Services::request();
        $list_data = new $this->DataTablesPermintaan;
        $where = ['id !=' => 0];
        //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
        //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
        $column_order = array('id', NULL, 'tanggal', 'nama_menu', 'nama_petugas', 'nama_pasien', 'tanggal_lahir', 'jenis_kelamin', 'kamar', 'jenis_tindakan', 'diet', 'keterangan');
        $column_search = array('tanggal', 'nama_menu', 'nama_petugas', 'nama_pasien');
        $order = array('id' => 'DESC');
        $lists = $list_data->get_datatables('permintaan', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $row = array();
            $row[] = '<span class="date">' . ++$no . '</span>';
            $row[] = '<div class="btn-group" role="group">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#modal-details-' . $list->id . '" class="btn btn-info text-nowrap bg-gradient rounded-start-3" style="--bs-btn-padding-y: 0.15rem; --bs-btn-padding-x: 0.5rem; --bs-btn-font-size: 9pt;"><i class="fa-solid fa-circle-info"></i></button>
                            <a class="btn btn-secondary text-nowrap bg-gradient" style="--bs-btn-padding-y: 0.15rem; --bs-btn-padding-x: 0.5rem; --bs-btn-font-size: 9pt;" href="' . base_url('/permintaan/edit/' . $list->id) . '" role="button"><i class="fa-solid fa-pen-to-square"></i></a>
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
            $row[] = '<span class="date text-nowrap">' . $list->tanggal . '</span>';
            $row[] = '<strong>' . $list->nama_menu . '</strong><div class="text-nowrap">Jadwal: ' . $list->jadwal_makan . '<br>Protein Hewani: ' . $list->protein_hewani . '<br>Protein Nabati: ' . $list->protein_nabati . '<br>Sayur: ' . $list->sayur . '<br>Buah: ' . $list->buah . '</div>';
            $row[] = $list->nama_petugas;
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

    public function eticketprint($id)
    {
        $permintaan = $this->PermintaanModel->join('menu', 'permintaan.id_menu = menu.id_menu', 'inner')->join('petugas', 'menu.id_petugas = petugas.id_petugas', 'inner')->getPermintaan($id);
        if (empty($permintaan)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        } else {
            $data = [
                'permintaan' => $permintaan,
                'title' => 'E-tiket untuk Permintaan "' . $permintaan['nama_pasien'] . '"',
                'agent' => $this->request->getUserAgent()
            ];
            $db = db_connect();
            $agent = $this->request->getUserAgent();
            if ($agent->isRobot() == FALSE) {
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $useragent = $_SERVER['HTTP_USER_AGENT'];
                if ($agent->isMobile()) {
                    $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Mencetak E-tiket permintaan pasien \"' . $permintaan['nama_pasien'] . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
                } else {
                    $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Mencetak E-tiket permintaan pasien \"' . $permintaan['nama_pasien'] . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
                }
            }
            $dompdf = new Dompdf();
            $html = view('dashboard/permintaan/eticketview', $data);
            $dompdf->loadHtml($html);
            $dompdf->render();
            $dompdf->stream('eticket-id-' . $permintaan['id'] . '-' . $permintaan['tanggal'] . '-' . urlencode($permintaan['nama_pasien']) . '.pdf', array(
                'Attachment' => FALSE
            ));
        }
    }

    public function export()
    {
        $keyword = $this->request->getVar('keyword');
        $db = \Config\Database::connect();
        $menuq = $db->table('menu');
        $menuq->select('*');
        $menuq->join('petugas', 'menu.id_petugas = petugas.id_petugas', 'inner');
        $menu = $menuq->get()->getResult('array');
        $nomor = 1;
        $permintaan = $this->PermintaanModel->join('menu', 'menu.id_menu = permintaan.id_menu', 'inner')->join('petugas', 'petugas.id_petugas = menu.id_petugas', 'inner')->search($keyword)->findAll();
        $permintaaninit = $this->PermintaanModel->join('menu', 'menu.id_menu = permintaan.id_menu', 'inner')->join('petugas', 'petugas.id_petugas = menu.id_petugas', 'inner')->where('permintaan.id_menu', $keyword)->search($keyword)->get()->getRowArray();
        $data = [
            'nomor' => $nomor,
            'menu' => $menu,
            'permintaan' => $permintaan,
            'permintaaninit' => $permintaaninit,
            'keyword' => $keyword,
            'title' => 'Ekspor Permintaan',
            'agent' => $this->request->getUserAgent()
        ];
        return view('dashboard/permintaan/export', $data);
    }

    public function exportexcel()
    {
        $keyword = $this->request->getGet('keyword');
        if ($keyword != '') {
            $db = \Config\Database::connect();
            $permintaanq = $db->table('permintaan');
            $permintaanq->select('*');
            $permintaanq->join('menu', 'menu.id_menu = permintaan.id_menu')->join('petugas', 'petugas.id_petugas = menu.id_petugas');
            $permintaanq->where('permintaan.id_menu', $keyword);
            $countpermintaan = $permintaanq->countAllResults(false);
            $permintaan = $permintaanq->get()->getResult('array');
            $permintaaninitq = $db->table('permintaan');
            $permintaaninitq->select('*');
            $permintaaninitq->join('menu', 'menu.id_menu = permintaan.id_menu')->join('petugas', 'petugas.id_petugas = menu.id_petugas');
            $permintaaninitq->where('permintaan.id_menu', $keyword);
            $permintaaninit = $permintaaninitq->get()->getRowArray();

            if (empty($permintaaninit)) {
                session()->setFlashdata('error', 'Tidak ada permintaan pada menu ini! Ekspor gagal!');
                return redirect()->back();
            } else {
                $agent = $this->request->getUserAgent();
                if ($agent->isRobot() == FALSE) {
                    $ipaddress = $_SERVER['REMOTE_ADDR'];
                    $useragent = $_SERVER['HTTP_USER_AGENT'];
                    if ($agent->isMobile()) {
                        $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Mengekspor daftar permintaan pada menu \"' . $permintaaninit['nama_menu'] . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
                    } else {
                        $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Mengekspor daftar permintaan pada menu \"' . $permintaaninit['nama_menu'] . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
                    }
                }
                $filename = $permintaaninit['tanggal'] . '-permintaan-makanan-pasien-rawat-inap';
                $tanggal = Time::parse($permintaaninit['tanggal']);
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                $sheet->setCellValue('A1', 'DAFTAR PERMINTAAN MAKANAN PASIEN RAWAT INAP');
                $sheet->setCellValue('A2', 'Hari/Tanggal:');
                $sheet->setCellValue('C2', $tanggal->toLocalizedString('d MMMM yyyy'));
                $sheet->setCellValue('A3', 'Jadwal Makan:');
                $sheet->setCellValue('C3', $permintaaninit['jadwal_makan']);
                $sheet->setCellValue('A4', 'Nama Menu:');
                $sheet->setCellValue('C4', $permintaaninit['nama_menu']);
                $sheet->setCellValue('C5', 'Protein Hewani:');
                $sheet->setCellValue('D5', $permintaaninit['protein_hewani']);
                $sheet->setCellValue('C6', 'Protein Nabati:');
                $sheet->setCellValue('D6', $permintaaninit['protein_nabati']);
                $sheet->setCellValue('C7', 'Protein Sayur:');
                $sheet->setCellValue('D7', $permintaaninit['sayur']);
                $sheet->setCellValue('C8', 'Protein Buah:');
                $sheet->setCellValue('D8', $permintaaninit['buah']);
                $sheet->setCellValue('A9', 'Petugas Gizi:');
                $sheet->setCellValue('C9', $permintaaninit['nama_petugas']);

                $sheet->setCellValue('A10', 'No');
                $sheet->setCellValue('B10', 'Nama Pasien');
                $sheet->setCellValue('C10', 'Tanggal Lahir');
                $sheet->setCellValue('D10', 'Jenis Kelamin');
                $sheet->setCellValue('E10', 'Kamar');
                $sheet->setCellValue('F10', 'Jenis Tindakan');
                $sheet->setCellValue('G10', 'Diet');
                $sheet->setCellValue('H10', 'Keterangan');

                $spreadsheet->getActiveSheet()->mergeCells('A1:H1');
                $spreadsheet->getActiveSheet()->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $spreadsheet->getActiveSheet()->getPageSetup()
                    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
                $spreadsheet->getDefaultStyle()->getFont()->setSize(8);

                $column = 11;
                foreach ($permintaan as $listpermintaan) {
                    $tanggal_lahir = Time::parse($listpermintaan['tanggal_lahir']);
                    $sheet->setCellValue('A' . $column, ($column - 10));
                    $sheet->setCellValue('B' . $column, $listpermintaan['nama_pasien']);
                    $sheet->setCellValue('C' . $column, $tanggal_lahir->toLocalizedString('d MMMM yyyy'));
                    $sheet->setCellValue('D' . $column, $listpermintaan['jenis_kelamin']);
                    $sheet->setCellValue('E' . $column, $listpermintaan['kamar']);
                    $sheet->setCellValue('F' . $column, $listpermintaan['jenis_tindakan']);
                    $sheet->setCellValue('G' . $column, $listpermintaan['diet']);
                    $sheet->setCellValue('H' . $column, $listpermintaan['keterangan']);
                    $sheet->getStyle('B' . $column . ':H' . $column)->getAlignment()->setWrapText(true);
                    $column++;
                }
                $sheet->setCellValue('B' . $column, 'Jumlah Pasien: ' . $countpermintaan . ' orang');
                $sheet->setCellValue('H' . ($column + 1), 'Padang,');
                $sheet->setCellValue('F' . ($column + 2), 'Petugas Gizi');
                $sheet->setCellValue('G' . ($column + 2), 'Ahli Gizi');
                $sheet->setCellValue('H' . ($column + 2), 'Perawat Rawat Inap');
                $sheet->setCellValue('F' . ($column + 6), '(                                    )');
                $sheet->setCellValue('G' . ($column + 6), '(                                    )');
                $sheet->setCellValue('H' . ($column + 6), '(                                    )');

                $sheet->getStyle('A1')->getFont()->setBold(TRUE);
                $sheet->getStyle('A2:A9')->getFont()->setBold(TRUE);
                $sheet->getStyle('C5:C8')->getFont()->setBold(TRUE);
                $sheet->getStyle('A10:H10')->getFont()->setBold(TRUE);

                $sheet->getStyle('B' . $column)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A10:H10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A11:A' . ($column + 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F' . ($column + 2) . ':H' . ($column + 2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F' . ($column + 6) . ':H' . ($column + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000']
                        ]
                    ]
                ];
                $sheet->getStyle('A10:H' . ($column - 1))->applyFromArray($styleArray);

                $sheet->getColumnDimension('A')->setWidth(35, 'px');
                $sheet->getColumnDimension('B')->setWidth(210, 'px');
                $sheet->getColumnDimension('C')->setWidth(120, 'px');
                $sheet->getColumnDimension('D')->setWidth(120, 'px');
                $sheet->getColumnDimension('E')->setWidth(120, 'px');
                $sheet->getColumnDimension('F')->setWidth(180, 'px');
                $sheet->getColumnDimension('G')->setWidth(180, 'px');
                $sheet->getColumnDimension('H')->setWidth(180, 'px');

                $writer = new Xlsx($spreadsheet);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheet.sheet');
                header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                exit();
            }
        } else {
            session()->setFlashdata('info', 'Tidak ada menu dan petugas yang dipilih. Silakan pilih menu dan petugas!');
            return redirect()->to(base_url('/permintaan/export'));
        }
    }

    public function add()
    {
        $db = \Config\Database::connect();
        $menuq = $db->table('menu');
        $menuq->select('*');
        $menuq->join('petugas', 'menu.id_petugas = petugas.id_petugas', 'inner');
        $menu = $menuq->get()->getResult('array');
        $data = [
            'menu' => $menu,
            'title' => 'Tambah Permintaan pada',
            'agent' => $this->request->getUserAgent()
        ];
        return view('dashboard/permintaan/add', $data);
    }

    public function create()
    {
        if (!$this->validate([
            'menu' => [
                'label' => 'Menu',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!'
                ]
            ],
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
            'id_menu' => $this->request->getVar('menu'),
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
        $permintaan = $db->table('permintaan')->where('id_menu', $this->request->getVar('menu'));
        $totalpermintaan = $permintaan->countAllResults();
        $db->query('UPDATE menu SET jumlah = ' . $totalpermintaan . ' WHERE id_menu = ' . $this->request->getVar('menu'));
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
        return redirect()->to(base_url('/permintaan'));
    }

    public function edit($id)
    {
        $permintaan = $this->PermintaanModel->getPermintaan($id);
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
            echo view('dashboard/permintaan/edit', $data);
        }
    }

    public function update($id)
    {
        $permintaan = $this->PermintaanModel->getPermintaan($id);
        if (!$this->validate([
            'menu' => [
                'label' => 'Menu',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!'
                ]
            ],
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
        if ($permintaan['id_menu'] == $this->request->getVar('menu') && $permintaan['nama_pasien'] == $this->request->getVar('nama_pasien') && $permintaan['tanggal_lahir'] == $this->request->getVar('tanggal_lahir') && $permintaan['jenis_kelamin'] == $this->request->getVar('jenis_kelamin') && $permintaan['kamar'] == $this->request->getVar('kamar') && $permintaan['jenis_tindakan'] == $this->request->getVar('jenis_tindakan') && $permintaan['diet'] == $this->request->getVar('diet') && $permintaan['keterangan'] == $this->request->getVar('keterangan')) {
            session()->setFlashdata('info', 'Tidak ada perubahan apa-apa dalam formulir ini!');
            return redirect()->back();
        } else {
            $this->PermintaanModel->save([
                'id' => $id,
                'id_menu' => $this->request->getVar('menu'),
                'nama_pasien' => $this->request->getVar('nama_pasien'),
                'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
                'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
                'kamar' => $this->request->getVar('kamar'),
                'jenis_tindakan' => $this->request->getVar('jenis_tindakan'),
                'diet' => $this->request->getVar('diet'),
                'keterangan' => $this->request->getVar('keterangan'),
            ]);
            if ($permintaan['id_menu'] != $this->request->getVar('menu')) {
                $menu1 = $db->table('permintaan')->where('id_menu', $permintaan['id_menu']);
                $menu2 = $db->table('permintaan')->where('id_menu', $this->request->getVar('menu'));
                $totalpermintaan1 = $menu1->countAllResults();
                $totalpermintaan2 = $menu2->countAllResults();
                $db->query('UPDATE menu SET jumlah = ' . $totalpermintaan1 . ' WHERE id_menu = ' . $permintaan['id_menu']);
                $db->query('UPDATE menu SET jumlah = ' . $totalpermintaan2 . ' WHERE id_menu = ' . $this->request->getVar('menu'));
            }
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
            return redirect()->to(base_url('/permintaan'));
        }
    }

    public function delete($id)
    {
        $agent = $this->request->getUserAgent();
        $permintaan = $this->PermintaanModel->getPermintaan($id);
        $this->PermintaanModel->delete($id);
        $db = db_connect();
        $permintaan1 = $db->table('permintaan')->where('id_menu', $permintaan['id_menu']);
        $totalpermintaan = $permintaan1->countAllResults();
        $db->query('UPDATE menu SET jumlah = ' . $totalpermintaan . ' WHERE id_menu = ' . $permintaan['id_menu']);
        $db->query('ALTER TABLE `permintaan` auto_increment = 1');
        if ($agent->isRobot() == FALSE) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            if ($agent->isMobile()) {
                $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Menghapus permintaan pasien \"' . $permintaan['nama_pasien'] . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
            } else {
                $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Menghapus permintaan pasien \"' . $permintaan['nama_pasien'] . '\"", "' . $useragent . '", UTC_TIMESTAMP())');
            }
        }
        session()->setFlashdata('msg', 'Permintaan pasien "' . $permintaan['nama_pasien'] . '" berhasil dihapus!');
        return redirect()->back();
    }
}