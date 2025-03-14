<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{
    protected $fpdf;

    public function __construct()
    {
        $this->fpdf = new Fpdf;
    }

    public function index(Request $request)
    {
        $id = $request->input('request_id');
        $req = \App\Models\Request::find($id);

        $username_peminjam = $req->nama_peminjam;
        $binusianid_peminjam = $req->binusian_id_peminjam;
        $email_peminjam = $req->email_peminjam;
        $nohp_peminjam = $req->nohp_peminjam;
        $division_peminjam = $req->prodi_peminjam;
        $division = $req->User->division;

        $purpose = $req->purpose;
        $lokasi = $req->lokasi;
        $isu = $req->return_notice;
        $book_date = date("d M Y H:i", strtotime($req->book_date));
        $return_date = date("d M Y H:i", strtotime($req->return_date));


        if ($req->status == 'on use'){
            $status = 'belum dikembalikan';
            $desc = '';
        }
        else{
            $status = 'sudah dikembalikan';
            $desc = $req->return_notes;
        }

        $booking = Booking::firstWhere('request_id', $req->id);

        $taken_date = date("d M Y H:i", strtotime($booking->taken_date));
        if($req->status == 'on use'){
            $realize_return_date = '';
        }
        else{
            $realize_return_date = date("d M Y H:i", strtotime($booking->realize_return_date));
        }

        $this->fpdf->AddPage();

        $this->fpdf->SetFont('Arial', 'B', 16);
        $this->fpdf->Cell(190, 7, 'Formulir Peminjaman Peralatan', 0, 1, 'C');

        $this->fpdf->Ln();

        $titikdua = ': ';

        $nama = $titikdua . $username_peminjam;
        $bid = $titikdua . $binusianid_peminjam;
        $prodiv = $titikdua . $division_peminjam;
        $email = $titikdua . $email_peminjam;
        $hp = $titikdua . $nohp_peminjam;
        $keperluan = $titikdua . $purpose;
        $book = $titikdua . $book_date;
        $return = $return_date;
        $lok = $titikdua . $lokasi;
        $div = $division;

        $this->fpdf->SetFont('Arial', '', 11);
        $this->fpdf->Cell(70, 6, 'Binusian ID / Kode Dosen Peminjam', 0, 0); $this->fpdf->Cell(40, 6, $bid, 0, 1);
        $this->fpdf->Cell(70, 6, 'Nama Peminjam', 0, 0); $this->fpdf->Cell(15, 6, $nama, 0, 1);
        $this->fpdf->Cell(70, 6, 'Prodi/Unit Peminjam', 0, 0); $this->fpdf->Cell(15, 6, $prodiv, 0, 1);
        $this->fpdf->Cell(70, 6, 'Email Peminjam', 0, 0); $this->fpdf->Cell(15, 6, $email, 0, 1);
        $this->fpdf->Cell(70, 6, 'No. Handphone Peminjam', 0, 0); $this->fpdf->Cell(40, 6, $hp, 0, 1);
        $this->fpdf->Cell(70, 6, 'Keperluan / Kegiatan', 0, 0); $this->fpdf->Cell(40, 6, $keperluan, 0, 1);
        $this->fpdf->Cell(70, 6, 'Tanggal Peminjaman', 0, 0); $this->fpdf->Cell(40, 6, $book . ' WIB s/d. ' . $return . ' WIB', 0, 1);
        $this->fpdf->Cell(70, 6, 'Lokasi Pemakaian', 0, 0); $this->fpdf->Cell(40, 6, $lok, 0, 1);

        $this->fpdf->Ln();

        $this->fpdf->SetFont('Arial', 'B', 11);

        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(10, 6, 'No', 1, 0, 'C');
        $this->fpdf->Cell(15, 6, 'Lokasi', 1, 0, 'C');
        $this->fpdf->Cell(30, 6, 'Nomor Seri', 1, 0, 'C');
        $this->fpdf->Cell(20, 6, 'Jenis', 1, 0, 'C');
        $this->fpdf->Cell(25, 6, 'Spesifikasi', 1, 0, 'C');
        $this->fpdf->Cell(30, 6, 'Pemilik Barang', 1, 0, 'C');
        $this->fpdf->Cell(50, 6, 'Kondisi Barang Kembali', 1, 1, 'C');

        $this->fpdf->SetFont('Arial', '', 11);

        $bookings = DB::table('bookings')
            ->join('assets', 'bookings.asset_id', '=', 'assets.id')
            ->join('asset_jenis', 'bookings.asset_jenis_id', '=', 'asset_jenis.id')
            ->select('bookings.return_conditions','bookings.asset_id','assets.serial_number', 'assets.brand', 'asset_jenis.name', 'assets.pemilik_barang')
            ->where('bookings.request_id', '=', $id)
            ->where('bookings.status', '!=', 'rejected')
            ->get();

        $i = 1;
        foreach ($bookings as $b){
            $division_asset_id = DB::table('assets')->where('id', $b->asset_id)->value('division_id');
            $division_asset = DB::table('divisions')->where('id', $division_asset_id)->value('name');

            $this->fpdf->Cell(10, 6, $i, 1, 0, 'C');
            $this->fpdf->Cell(15, 6, $division_asset, 1, 0, 'C');
            $this->fpdf->Cell(30, 6, $b->serial_number, 1, 0, 'C');
            $this->fpdf->Cell(20, 6, $b->name, 1, 0, 'C');
            $this->fpdf->Cell(25, 6, $b->brand, 1, 0, 'C');
            $this->fpdf->Cell(30, 6, $b->pemilik_barang, 1, 0, 'C');
            $this->fpdf->Cell(50, 6, $b->return_conditions, 1, 1, 'C');
            $i++;
        }

        $this->fpdf->Ln();

        $this->fpdf->Cell(30, 6, 'Keterangan pengembalian', 0, 1);
        $this->fpdf->Cell(30, 6, 'Status Barang: ' . $status, 0, 1);
        $this->fpdf->Cell(180, 20, $desc, 1, 1);
        $this->fpdf->SetFont('Arial', 'B', 7);
        $this->fpdf->Cell(180, 6, 'Catatan: Peminjam (dan/atau anggota kelompoknya) bertanggung jawab dan bersedia menerima segala konsekuensi jika terjadi hal-hal yang tidak', 0, 1);
        $this->fpdf->Cell(180, 1, 'diinginkan terhadap peralatan yang dipinjam, serta bersedia menerima sanksi jika terlambat mengembalikan peralatan.', 0, 1);
        $this->fpdf->Cell(180, 8, '', 0, 1);

        $this->fpdf->Ln();

        $this->fpdf->SetFont('Arial', 'B', 7);
        $this->fpdf->Cell(110, 6, '', 0, 0);
        $this->fpdf->Cell(35, 6, 'Tanggal ambil', 1, 0, 'C');
        $this->fpdf->Cell(35, 6, 'Tanggal kembali', 1, 1, 'C');
        $this->fpdf->SetFont('Arial', '', 7);
        $this->fpdf->Cell(110, 6, '', 0, 0);
        $this->fpdf->Cell(35, 6, $taken_date, 1, 0, 'C');
        $this->fpdf->Cell(35, 6, $realize_return_date, 1, 1, 'C');

        $is_Approve = '';
        if($req->status == "done"){
            $is_Approve = 'APPROVED';
        }

        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->SetTextColor(0, 150, 0);
        $this->fpdf->Cell(110, 6, '', 0, 0);
        if($isu == 'isu_rusak') {
            $this->fpdf->SetTextColor(255, 0, 0);
        }
        $this->fpdf->Cell(70, 6, $is_Approve, 1, 1, 'C');
        $this->fpdf->SetFont('Arial', '', 7);
        $this->fpdf->SetTextColor(0, 0, 0);
        if($isu == 'isu_rusak'){
            $this->fpdf->SetTextColor(255, 0, 0);
            $this->fpdf->Cell(180, 6, 'Isu kerusakan barang akan dibahas lebih lanjut dengan BM [contact BM]', 0, 1, 'R');
        }
        $this->fpdf->SetTextColor(0, 0, 0);
        $this->fpdf->Cell(180, 6, '*Dokumen ini sah diketahui SCC koordinator dan peminjam meskipun tanpa tanda tangan', 0, 1, 'R');

        $this->fpdf->Output();

        exit;
    }
}
