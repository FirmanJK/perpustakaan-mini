<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     * Pemisahan view berdasarkan role user
     *
     * @return \Illuminate\View\View
     */
    public function index($data)
    {
        // Get user login information
        $user_login = User::find(session('username'));
        $users_rules = array_map('trim', explode(',', $user_login->idroles));
        
        // Check if user is admin (pustka)
        $is_admin = in_array('pustka', $users_rules);
        
        if ($is_admin) {
            // Admin Dashboard - Data Lengkap
            return $this->adminDashboard($data);
        } else {
            // Guest Dashboard - Data Terbatas
            return $this->guestDashboard($data);
        }
    }
    
    /**
     * Admin Dashboard - Full Access
     */
    private function adminDashboard($data)
    {
        // Statistics untuk Admin
        $data['stats'] = [
            'total_books' => DB::table('mst_books')->where('isactive', '1')->count(),
            'total_members' => DB::table('mst_members')->where('isactive', '1')->count(),
            'dipinjam' => DB::table('trs_loans')->where(['status' => 'Dipinjam', 'isactive' => '1'])->count(),
            'dikembalikan' => DB::table('trs_loans')->where(['status' => 'Dikembalikan', 'isactive' => '1'])->count(),
        ];
        
        // Chart data - Peminjaman per bulan (6 bulan terakhir)
        $monthly_loans = DB::table('trs_loans')
            ->select(DB::raw('DATE_FORMAT(tgl_pinjam, "%Y-%m") as month'), DB::raw('COUNT(*) as total'))
            ->where('isactive', '1')
            ->where('tgl_pinjam', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 6 MONTH)'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        $data['chart_labels'] = [];
        $data['chart_data'] = [];
        foreach ($monthly_loans as $loan) {
            $data['chart_labels'][] = date('M Y', strtotime($loan->month . '-01'));
            $data['chart_data'][] = $loan->total;
        }
        
        // Popular books
        $data['popular_books'] = DB::table('mst_books as b')
            ->leftJoin('trs_loans as t', 'b.id', '=', 't.book_id')
            ->select('b.judul', 'b.penulis', 'b.stok', DB::raw('COUNT(t.id) as total_dipinjam'))
            ->where('b.isactive', '1')
            ->groupBy('b.id', 'b.judul', 'b.penulis', 'b.stok')
            ->orderBy('total_dipinjam', 'DESC')
            ->limit(5)
            ->get();
        
        return view('pages.dashboard.admin', $data);
    }
    
    /**
     * Guest Dashboard - Limited Access
     */
    private function guestDashboard($data)
    {
        // Statistics untuk Guest - Hanya Total Buku
        $data['stats'] = [
            'total_books' => DB::table('mst_books')->where('isactive', '1')->count(),
        ];
        
        // Chart data - Peminjaman per bulan (6 bulan terakhir)
        $monthly_loans = DB::table('trs_loans')
            ->select(DB::raw('DATE_FORMAT(tgl_pinjam, "%Y-%m") as month'), DB::raw('COUNT(*) as total'))
            ->where('isactive', '1')
            ->where('tgl_pinjam', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 6 MONTH)'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        $data['chart_labels'] = [];
        $data['chart_data'] = [];
        foreach ($monthly_loans as $loan) {
            $data['chart_labels'][] = date('M Y', strtotime($loan->month . '-01'));
            $data['chart_data'][] = $loan->total;
        }
        
        // Popular books
        $data['popular_books'] = DB::table('mst_books as b')
            ->leftJoin('trs_loans as t', 'b.id', '=', 't.book_id')
            ->select('b.judul', 'b.penulis', 'b.stok', DB::raw('COUNT(t.id) as total_dipinjam'))
            ->where('b.isactive', '1')
            ->groupBy('b.id', 'b.judul', 'b.penulis', 'b.stok')
            ->orderBy('total_dipinjam', 'DESC')
            ->limit(5)
            ->get();
        
        return view('pages.dashboard.guest', $data);
    }
}
