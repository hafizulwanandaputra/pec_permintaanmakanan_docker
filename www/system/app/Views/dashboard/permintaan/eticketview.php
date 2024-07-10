<?php

use CodeIgniter\I18n\Time;

$tanggal = Time::parse($permintaan['tanggal']);
$tanggal_lahir = Time::parse($permintaan['tanggal_lahir']);
?>
<?= $this->extend('dashboard/templates/eticket'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid my-3">
    <footer style="font-family: sans-serif; font-size: 9pt;">
        Gizi PEC
    </footer>
    <div style="font-family: sans-serif;">
        <h4 style=" margin: 0;">E-tiket Makanan Pasien Rawat Inap</h4>
        <hr style="margin-top: 3px; margin-bottom: 3px;">
        <div style="font-size: 7pt;">
            <table class="table table-borderless" style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="padding: 0; width: 30%; font-weight: bold;" scope="row">Tanggal</td>
                        <td style="padding: 0; width: 70%;" class="date"><?= $tanggal->toLocalizedString('d MMMM yyyy'); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 0; width: 30%; font-weight: bold;" scope="row">Nama Menu</td>
                        <td style="padding: 0; width: 70%;" class="date"><?= $permintaan['nama_menu']; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 0; width: 30%; font-weight: bold;" scope="row">Protein Hewani</td>
                        <td style="padding: 0; width: 70%;"><?= $permintaan['protein_hewani']; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 0; width: 30%; font-weight: bold;" scope="row">Protein Nabati</td>
                        <td style="padding: 0; width: 70%;"><?= $permintaan['protein_nabati']; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 0; width: 30%; font-weight: bold;" scope="row">Sayur</td>
                        <td style="padding: 0; width: 70%;"><?= $permintaan['sayur']; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 0; width: 30%; font-weight: bold;" scope="row">Buah</td>
                        <td style="padding: 0; width: 70%;"><?= $permintaan['buah']; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 0; width: 30%; font-weight: bold;" scope="row">Jadwal Makan</td>
                        <td style="padding: 0; width: 70%;"><?= $permintaan['jadwal_makan']; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 0; width: 30%; font-weight: bold;" scope="row">Petugas</td>
                        <td style="padding: 0; width: 70%;"><?= $permintaan['nama_petugas']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr style="margin-top: 3px; margin-bottom: 3px;">
        <div style="font-size: 7pt;">
            <table class="table table-borderless" style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="padding: 0; width: 30%; font-weight: bold;" scope="row">Nama Pasien</td>
                        <td style="padding: 0; width: 70%;" class="date"><?= $permintaan['nama_pasien']; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 0; width: 30%; font-weight: bold;" scope="row">Tanggal Lahir dan Umur</td>
                        <td style="padding: 0; width: 70%;"><?= $tanggal_lahir->toLocalizedString('d MMMM yyyy') . ' (' . $tanggal_lahir->getAge() . ' tahun)'; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 0; width: 30%; font-weight: bold;" scope="row">Jenis Kelamin</td>
                        <td style="padding: 0; width: 70%;"><?= $permintaan['jenis_kelamin']; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 0; width: 30%; font-weight: bold;" scope="row">Kamar</td>
                        <td style="padding: 0; width: 70%;"><?= $permintaan['kamar']; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 0; width: 30%; font-weight: bold;" scope="row">Jenis Tindakan</td>
                        <td style="padding: 0; width: 70%;"><?= $permintaan['jenis_tindakan']; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 0; width: 30%; font-weight: bold;" scope="row">Diet</td>
                        <td style="padding: 0; width: 70%;"><?= $permintaan['diet']; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 0; width: 30%; font-weight: bold;" scope="row">Keterangan</td>
                        <td style="padding: 0; width: 70%;"><?= $permintaan['keterangan']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>