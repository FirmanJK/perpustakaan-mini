<?php

namespace App\Http\Controllers;

use App\Helpers\Format_Helper;
use App\Helpers\Function_Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

/**
 * Controller khusus untuk Transaksi Peminjaman Buku (trslnx)
 * Extends MasterController dan menambahkan logika stock management
 */
class TrslnxController extends MasterController
{
    /**
     * Display the form for creating a new resource.
     * Override method dari MasterController untuk menampilkan preview nomor transaksi
     */
    public function add($data)
    {
        // function helper
        $data['format'] = new Format_Helper;
        $syslog = new Function_Helper;
        
        //list data table
        $data['table_primary'] = DB::table('sys_table')->where(['gmenu' => $data['gmenuid'], 'dmenu' => $data['dmenu'], 'primary' => '1'])->orderBy('urut')->get();
        $data['table_header'] = DB::table('sys_table')->where(['gmenu' => $data['gmenuid'], 'dmenu' => $data['dmenu'], 'show' => '1'])->orderBy('urut')->get();

        $data['table_header_l'] = DB::table('sys_table')->where(['gmenu' => $data['gmenuid'], 'dmenu' => $data['dmenu'], 'position' => '3', 'show' => '1'])->orderBy('urut')->get();
        $data['table_header_r'] = DB::table('sys_table')->where(['gmenu' => $data['gmenuid'], 'dmenu' => $data['dmenu'], 'position' => '4', 'show' => '1'])->orderBy('urut')->get();
        
        // Generate preview nomor transaksi
        $sys_id = DB::table('sys_id')->where('dmenu', $data['dmenu'])->where('isactive', '1')->first();
        if ($sys_id) {
            $data['preview_no_transaksi'] = $data['format']->IDFormat($data['dmenu']);
        }
        
        //check athorization access add
        if ($data['authorize']->add == '1') {
            // return page menu
            return view($data['url'], $data);
        } else {
            //if not athorize
            $data['url_menu'] = $data['url_menu'];
            $data['title_group'] = 'Error';
            $data['title_menu'] = 'Error';
            $data['errorpages'] = 'Not Authorized!';
            //insert log
            $syslog->log_insert('E', $data['url_menu'], 'Not Authorized!' . ' - Add -' . $data['url_menu'], '0');
            //return error page
            return view("pages.errorpages", $data);
        }
    }
    
    /**
     * Store a newly created resource in storage.
     * Override method dari MasterController dengan tambahan stock management
     */
    public function store($data)
    {
        // function helper
        $data['format'] = new Format_Helper;
        $syslog = new Function_Helper;
        //list data table
        $data['table_header'] = DB::table('sys_table')->where(['gmenu' => $data['gmenuid'], 'dmenu' => $data['dmenu'], 'show' => '1'])->orderBy('urut')->get();
        $data['table_primary'] = DB::table('sys_table')->where(['gmenu' => $data['gmenuid'], 'dmenu' => $data['dmenu'], 'primary' => '1'])->orderBy('urut')->get();
        $sys_id = DB::table('sys_id')->where('dmenu', $data['dmenu'])->where('isactive', '1')->orderBy('urut', 'ASC')->first();
        //cek data primary key
        $wherekey = [];
        $multiple = [];
        $idtrans = '';
        foreach ($data['table_primary'] as $key) {
            $wherekey[$key->field] = request()->{$key->field};
            $idtrans = ($idtrans == '') ? $idtrans = request()->{$key->field} : $idtrans . ',' . request()->{$key->field};
        }
        $data_key = DB::table($data['tabel'])->where($wherekey)->first();
        //get data validate
        foreach (
            $data['table_header']->map(function ($item) {
                return (array) $item;
            }) as $item
        ) {
            $primary = false;
            $generateid = false;
            foreach ($data['table_primary'] as $p) {
                $primary == false
                    ? ($p->field == $item['field']
                        ? ($primary = true)
                        : ($primary = false))
                    : '';
                $generateid == false
                    ? ($p->generateid != ''
                        ? ($generateid = true)
                        : ($generateid = false))
                    : '';
            }
            if ($primary  && $sys_id) {
                $validate[$item['field']] = '';
            } elseif ($primary && !$data_key) {
                $validate[$item['field']] = '';
            } else {
                $validate[$item['field']] = $item['validate'];
            }
            // check data type multiple
            if (Str::contains($item['class'], 'select-multiple')) {
                // Convert array values ​​to string with comma as separator
                $multiple[$item['field']] = request()->has($item['field']) && !empty(request()->input($item['field']))
                    ? implode(', ', request()->input($item['field']))
                    : null;
            }
        }
        //validasi data
        $attributes = request()->validate(
            $validate,
            [
                'required' => ':attribute tidak boleh kosong',
                'unique' => ':attribute sudah ada',
                'min' => ':attribute minimal :min karakter',
                'max' => ':attribute maksimal :max karakter',
                'email' => 'format :attribute salah',
                'mimes' => ':attribute format harus :values',
                'between' => ':attribute diisi antara :min sampai :max'
            ]
        );
        // check type multiple
        if (isset($multiple)) {
            $keys = array_keys($multiple);
            foreach ($keys as $m) {
                $attributes[$m] = $multiple[$m];
            }
        }
        //check password
        if (isset($attributes['password'])) {
            //encrypt password
            $new_password = bcrypt($attributes['password']);
            $attributes['password'] = $new_password;
        }
        // check data image and file
        $data['image'] = DB::table('sys_table')->where(['gmenu' => $data['gmenuid'], 'dmenu' => $data['dmenu']])->whereIn('type', ['image', 'file'])->get();
        foreach ($data['image'] as $img) {
            if (request()->file($img->field)) {
                $filenameimage = request()->file($img->field)->store($data['tabel']);
                $attributes[$img->field] = $filenameimage;
                if ($img->type == 'image') {
                    // create image manager with desired driver
                    $manager = new ImageManager(new Driver());
                    // read image from file system
                    $image = $manager->read(request()->file($img->field));
                    // resize image proportionally to 35px height
                    $image->scale(height: 35);
                    // save modified image in new format 
                    $image->toPng()->save(public_path('storage/' . $filenameimage . 'tumb.png'));
                };
            }
        }
        //list data
        $data['table_header'] = DB::table('sys_table')->where(['gmenu' => $data['gmenuid'], 'dmenu' => $data['dmenu'],  'list' => '1'])->orderBy('urut')->get();
        $data['table_detail'] = DB::table($data['tabel'])->get();
        $data['table_primary_generate'] = DB::table('sys_table')->where(['gmenu' => $data['gmenuid'], 'dmenu' => $data['dmenu'], 'primary' => '1'])->orderBy('urut')->first();
        //check data Generate ID
        if ($sys_id) {
            //set ID from generate id
            $insert_data = DB::table($data['tabel'])->insert([$data['table_primary_generate']->field => $data['format']->IDFormat($data['dmenu'])] + $attributes + ['user_create' => session('username')]);
        } else {
            //set ID manual
            $insert_data = DB::table($data['tabel'])->insert($attributes + ['user_create' => session('username')]);
        }
        //check insert
        if ($insert_data) {
            // ========== LOGIKA STOCK MANAGEMENT ==========
            // Kurangi stok buku saat peminjaman dibuat
            if (isset($attributes['book_id'])) {
                $book_id = $attributes['book_id'];
                $buku = DB::table('mst_books')->where('id', $book_id)->first();
                
                if ($buku && $buku->stok > 0) {
                    DB::table('mst_books')
                        ->where('id', $book_id)
                        ->decrement('stok', 1);
                    
                    \Log::info('Stock Management - Stock Decremented', [
                        'book_id' => $book_id,
                        'judul' => $buku->judul,
                        'stok_before' => $buku->stok,
                        'stok_after' => $buku->stok - 1
                    ]);
                }
            }
            // ========== END STOCK MANAGEMENT ==========
            
            //insert sys_log
            $syslog->log_insert('C', $data['dmenu'], 'Created : ' . $idtrans, '1');
            // Set a session message
            Session::flash('message', 'Tambah Data Berhasil!');
            Session::flash('class', 'success');
            // return page menu
            return redirect($data['url_menu'])->with($data);
        } else {
            //insert sys_log
            $syslog->log_insert('E', $data['dmenu'], 'Create Error', '0');
            // Set a session message
            Session::flash('message', 'Tambah Data Gagal!');
            Session::flash('class', 'danger');
            // return page menu
            return redirect($data['url_menu'])->with($data);
        };
    }

    /**
     * Update the specified resource in storage.
     * Override method dari MasterController dengan tambahan stock management
     */
    public function update($data)
    {
        // function helper
        $syslog = new Function_Helper;
        //check decrypt
        try {
            $id = decrypt($data['idencrypt']);
        } catch (DecryptException $e) {
            $id = "";
        }
        //list data table
        $data['table_primary'] = DB::table('sys_table')->where(['gmenu' => $data['gmenuid'], 'dmenu' => $data['dmenu'], 'primary' => '1'])->orderBy('urut')->get();
        // data primary key
        $primaryArray = explode(':', $id);
        $wherekey = [];
        $wherenotkey = [];
        $multiple = [];
        $i = 0;
        foreach ($data['table_primary'] as $key) {
            $wherekey[$key->field] = $primaryArray[$i];
            $wherenotkey[] = $key->field;
            $i++;
        }
        //list data
        $data['table_header'] = DB::table('sys_table')->where(['gmenu' => $data['gmenuid'], 'dmenu' => $data['dmenu'], 'filter' => '1', 'show' => '1'])->whereNotIn('field', $wherenotkey)->orderBy('urut')->get();
        //get data validate
        foreach (
            $data['table_header']->map(function ($item) {
                return (array) $item;
            }) as $item
        ) {
            //If Data Unique
            if ($item['primary'] == '2') {
                $i = 0;
                $rule = [];
                //set Rule Unique
                foreach ($data['table_primary'] as $key) {
                    $rule = array_merge($rule, [Rule::unique($data['tabel'], $item['field'])->ignore($primaryArray[$i], $key->field)]);
                    $i++;
                }
                $primarykey = explode('|', $item['validate']);
                $p = [$primarykey[0]];
                for ($i = 1; $i < count($primarykey); $i++) {
                    (substr($primarykey[$i], 0, 6) != 'unique') ? $p = array_merge($p, [$primarykey[$i]]) : '';
                }
                //set validate
                $validate[$item['field']] = array_merge($p, $rule);
            } else if ($item['field'] == 'password' && request()->email && empty(request()->password)) {
                unset($validate[$item['field']]);
            } else {
                $validate[$item['field']] = $item['validate'];
            }
            // check data type multiple
            if (Str::contains($item['class'], 'select-multiple')) {
                // Convert array values ​​to string with comma as separator
                $multiple[$item['field']] = request()->has($item['field']) && !empty(request()->input($item['field']))
                    ? implode(', ', request()->input($item['field']))
                    : null;
            }
        }
        //validasi data
        $attributes = request()->validate(
            $validate,
            [
                'required' => ':attribute tidak boleh kosong',
                'unique' => ':attribute sudah ada',
                'min' => ':attribute minimal :min karakter',
                'max' => ':attribute maksimal :max karakter',
                'email' => 'format :attribute salah',
                'mimes' => ':attribute rormat harus :values',
                'between' => ':attribute diisi antara :min sampai :max',
                'regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.'
            ]
        );
        // check type multiple
        if (isset($multiple)) {
            $keys = array_keys($multiple);
            foreach ($keys as $m) {
                $attributes[$m] = $multiple[$m];
            }
        }
        //data password
        if (isset($attributes['password'])) {
            //encryp password
            $new_password = bcrypt($attributes['password']);
            $attributes['password'] = $new_password;
        }
        // check data image and file
        $data['image'] = DB::table('sys_table')->where(['gmenu' => $data['gmenuid'], 'dmenu' => $data['dmenu']])->whereIn('type', ['image', 'file'])->get();
        foreach ($data['image'] as $img) {
            if (request()->file($img->field)) {
                $filenameimage = request()->file($img->field)->store($data['tabel']);
                $attributes[$img->field] = $filenameimage;
                if ($img->type == 'image') {
                    // create image manager with desired driver
                    $manager = new ImageManager(new Driver());
                    // read image from file system
                    $image = $manager->read(request()->file($img->field));
                    // resize image proportionally to 35px height
                    $image->scale(height: 35);
                    // save modified image in new format 
                    $image->toPng()->save(public_path('storage/' . $filenameimage . 'tumb.png'));
                };
            }
        }
        //list data 
        $data['table_header'] = DB::table('sys_table')->where(['gmenu' => $data['gmenuid'], 'dmenu' => $data['dmenu'],  'list' => '1'])->orderBy('urut')->get();
        $data['table_detail'] = DB::table($data['tabel'])->get();
        
        // ========== LOGIKA STOCK MANAGEMENT ==========
        // Ambil data transaksi lama SEBELUM update
        $transaksi_lama = DB::table($data['tabel'])->where($wherekey)->first();
        // ========== END PREPARATION ==========
        
        // Update data by id
        $updateData = DB::table($data['tabel'])->where($wherekey)->update($attributes + ['user_update' => session('username')]);
        //check update
        if ($updateData) {
            // ========== LOGIKA STOCK MANAGEMENT ==========
            // Tambah/kurangi stok saat status berubah
            if (isset($attributes['status']) && $transaksi_lama) {
                // Jika status berubah menjadi "Dikembalikan" dan sebelumnya "Dipinjam"
                if ($attributes['status'] == 'Dikembalikan' && $transaksi_lama->status == 'Dipinjam') {
                    DB::table('mst_books')
                        ->where('id', $transaksi_lama->book_id)
                        ->increment('stok', 1);
                    
                    \Log::info('Stock Management - Stock Incremented (Return)', [
                        'book_id' => $transaksi_lama->book_id,
                        'status_change' => 'Dipinjam -> Dikembalikan'
                    ]);
                }
                // Jika status berubah dari "Dikembalikan" kembali ke "Dipinjam"
                elseif ($attributes['status'] == 'Dipinjam' && $transaksi_lama->status == 'Dikembalikan') {
                    $buku = DB::table('mst_books')->where('id', $transaksi_lama->book_id)->first();
                    if ($buku && $buku->stok > 0) {
                        DB::table('mst_books')
                            ->where('id', $transaksi_lama->book_id)
                            ->decrement('stok', 1);
                        
                        \Log::info('Stock Management - Stock Decremented (Re-borrow)', [
                            'book_id' => $transaksi_lama->book_id,
                            'status_change' => 'Dikembalikan -> Dipinjam'
                        ]);
                    }
                }
            }
            // ========== END STOCK MANAGEMENT ==========
            
            //insert sys_log
            $syslog->log_insert('U', $data['dmenu'], 'Updated : ' . $id, '1');
            // Set a session message
            Session::flash('message', 'Edit Data Berhasil!');
            Session::flash('class', 'success');
            // return page menu
            return redirect($data['url_menu'])->with($data);
        } else {
            //insert sys_log
            $syslog->log_insert('E', $data['dmenu'], 'Update Error', '0');
            // Set a session message
            Session::flash('message', 'Edit Data Gagal!');
            Session::flash('class', 'danger');
            //return error page
            return redirect($data['url_menu'])->with($data);
        };
    }
}
