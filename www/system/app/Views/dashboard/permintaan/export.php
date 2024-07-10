<?= $this->extend('dashboard/templates/dashboard'); ?>
<?= $this->section('title'); ?>
<div class="d-flex justify-content-start align-items-center">
    <a class="fs-5 me-3 link-body-emphasis" href="<?= base_url('/permintaan'); ?>"><i class="fa-solid fa-arrow-left"></i></a>
    <span class="fw-medium fs-5 flex-fill text-truncate"><?= $title; ?></span>
</div>
<div style="min-width: 1px; max-width: 1px;"></div>
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
    <form action="<?= base_url('/permintaan/export'); ?>" method="get" role="search">
        <fieldset class="border rounded-3 px-2 py-0 mb-3">
            <legend class="float-none w-auto mb-0 px-1 fs-6 fw-bold">Menu dan Petugas</legend>
            <div class="form-floating mb-2">
                <select class="form-select rounded-3 <?= (validation_show_error('menu')) ? 'is-invalid' : ''; ?>" id="keyword" name="keyword" aria-label="keyword">
                    <option value="">-- Pilih Menu dan Petugas --</option>
                    <?php foreach ($menu as $selectmenu) : ?>
                        <?php if ($selectmenu['jumlah'] != 0) : ?>
                            <option value="<?= $selectmenu['id_menu']; ?>" <?= ($keyword == $selectmenu['id_menu']) ? 'selected' : ''; ?>><?= $selectmenu['tanggal'] . ' - ' . $selectmenu['nama_menu'] . ' - ' . $selectmenu['nama_petugas'] . ' (' . $selectmenu['jumlah'] . ')'; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <label for="keyword">Menu dan Petugas</label>
            </div>
            <?php
            $request = \Config\Services::request();
            $keyword = $request->getGet('keyword');
            if ($keyword != '') {
                $param = "?keyword=" . $keyword;
            } else {
                $param = '';
            }
            ?>
        </fieldset>
        <hr>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
            <?php if ($keyword && !empty($permintaaninit)) : ?>
                <a class="btn btn-success rounded-3 bg-gradient" href="<?= base_url('/permintaan/exportexcel' . $param); ?>" role="button"><i class="fa-solid fa-file-excel"></i> Expor Excel</a>
            <?php endif; ?>
            <button class="btn btn-primary rounded-3 bg-gradient" type="submit" id="submit"><i class="fa-solid fa-magnifying-glass"></i> Cari data</button>
        </div>
    </form>
    <?php if ($keyword) : ?>
        <?php if (empty($permintaaninit)) : ?>
            <div class="alert alert-danger bg-gradient rounded-3" role="alert">
                <div class="d-flex align-items-start">
                    <div style="width: 12px; text-align: center;">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                    <div class="w-100 ms-3">
                        Tidak ada permintaan pada menu ini! Silakan cari menu yang lain!
                    </div>
                </div>
            </div>
        <?php else : ?>
            <hr>
            <fieldset class="border rounded-3 px-2 py-0 mb-3">
                <legend class="float-none w-auto mb-0 px-1 fs-6 fw-bold">Hasil</legend>
                <div style="font-size: 9pt;">
                    <div class="mb-2 row">
                        <div class="col-lg-3 fw-medium">Tanggal</div>
                        <div class="col-lg">
                            <div class="date"><?= $permintaaninit['tanggal']; ?></div>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-lg-3 fw-medium">Nama Menu</div>
                        <div class="col-lg">
                            <div>
                                <div class="mb-1 date fw-bold"><?= $permintaaninit['nama_menu']; ?></div>
                                <div class="mb-1 row">
                                    <div class="col-5 fw-medium">Protein Hewani</div>
                                    <div class="col">
                                        <div><?= $permintaaninit['protein_hewani']; ?></div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-5 fw-medium">Protein Nabati</div>
                                    <div class="col">
                                        <div><?= $permintaaninit['protein_nabati']; ?></div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-5 fw-medium">Sayur</div>
                                    <div class="col">
                                        <div><?= $permintaaninit['sayur']; ?></div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-5 fw-medium">Buah</div>
                                    <div class="col">
                                        <div><?= $permintaaninit['buah']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-lg-3 fw-medium">Jadwal Makan</div>
                        <div class="col-lg">
                            <div class="date"><?= $permintaaninit['jadwal_makan']; ?></div>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-lg-3 fw-medium">Petugas Gizi</div>
                        <div class="col-lg">
                            <div class="date"><?= $permintaaninit['nama_petugas']; ?></div>
                        </div>
                    </div>
                </div>
                <div class="mb-2 table-responsive">
                    <table id=" tabel" class="table table-sm table-hover style=" style="width:100%; font-size: 9pt;">
                        <thead>
                            <tr class="align-middle">
                                <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">No</th>
                                <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">Nama Pasien</th>
                                <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">Tanggal Lahir</th>
                                <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">Jenis Kelamin</th>
                                <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">Kamar</th>
                                <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">Jenis Tindakan</th>
                                <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">Diet</th>
                                <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="align-top">
                            <?php foreach ($permintaan as $listpermintaan) : ?>
                                <tr>
                                    <td><?= $nomor++; ?></td>
                                    <td><?= $listpermintaan['nama_pasien']; ?></td>
                                    <td class="date"><?= $listpermintaan['tanggal_lahir']; ?></td>
                                    <td><?= $listpermintaan['jenis_kelamin']; ?></td>
                                    <td><?= $listpermintaan['kamar']; ?></td>
                                    <td><?= $listpermintaan['jenis_tindakan']; ?></td>
                                    <td><?= $listpermintaan['diet']; ?></td>
                                    <td><?= $listpermintaan['keterangan']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
        <?php endif; ?>
    <?php endif; ?>
</main>
</div>
</div>
<?= $this->endSection(); ?>