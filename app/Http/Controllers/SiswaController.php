<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SiswaController extends Controller
{
  //   public function index(){
  //   $siswa = [
  //        ['nama' => 'Taufiq' , 'kelas' => 'XI RPL 3' , 'jenis_kelamin' => 'Laki-Laki', 'alamat' => 'Bandung'],        
  //        ['nama' => 'Farel' , 'kelas' => 'XI RPL 3' , 'jenis_kelamin' => 'Laki-Laki', 'alamat' => 'Rancamayar'],
  //        ['nama' => 'Ripa' , 'kelas' => 'XI RPL 2' , 'jenis_kelamin' => 'Laki-Laki', 'alamat' => 'Baleendah'],
  //        ['nama' => 'Andrian' , 'kelas' => 'XI RPL 1' , 'jenis_kelamin' => 'Laki-Laki', 'alamat' => 'Bandung'],
  //        ['nama' => 'Sandy' , 'kelas' => 'XI RPL 2' , 'jenis_kelamin' => 'Laki-Laki', 'alamat' => 'Cimahi']
  //   ];

  //   return view('siswa', compact('siswa'));
  // }
  //  public function index2(){
  //   $ortu = [
  //        ['nama_ortu' => 'Dadang' , 'jenis_kelamin' => 'Laki-Laki', 'telepon' => '08123456'],        
  //        ['nama_ortu' => 'Diding' , 'jenis_kelamin' => 'Laki-Laki', 'telepon' => '08765432'],
  //        ['nama_ortu' => 'Dudung' , 'jenis_kelamin' => 'Laki-Laki', 'telepon' => '08987654'],
  //   ];

  //   return view('ortu', compact('ortu'));
  // }


  private $siswa = [
    ['id' => 1, 'nama' => 'Ahmad' , 'kelas' => 'VII-A'],
    ['id' => 2, 'nama' => 'Budi' , 'kelas' => 'VII-B'],
  ];

  public function index()
  {
    if (!Session::has('siswa')) {
      Session::put('siswa', $this->siswa);
    }
    
    $siswa = Session::get('siswa', []);
    return view ('siswa.index', compact('siswa'));
  }

  public function create()
  {
    return view('siswa.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'nama' => 'required|string|max:255',
      'kelas' => 'required|string|max:10',
    ]);

    $siswa = Session::get('siswa', []);
    $siswa[] = [
      'id' => count($siswa) + 1,
      'nama' => $request->nama,
      'kelas' => $request->kelas,
    ];
    Session::put('siswa', $siswa);

    return redirect()->route('siswa.index')->with('berhasil', 'Siswa berhasil ditambahkan');
  }

  public function edit($id)
  {
    $siswa = Session::get('siswa');
    $siswaItem = collect($siswa)->firstWhere('id', $id);
    if (!$siswaItem) {
      return redirect()->route('siswa.index')->with('erroe', 'Siswa not found');
    }
    return view ('siswa.edit', compact('siswaItem'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'nama' => 'required|string|max:255',
      'kelas' => 'required|string|max:10',
    ]);
    $siswa = Session::get('siswa', []);
    $index = collect($siswa)->search(function ($item) use ($id){
      return $item['id'] == $id;
    });

    if ($index === false) {
       return redirect()->route('siswa.index')->with('error', 'Siswa not found');
    }

    $siswa[$index] = [
      'id' => $id,
      'nama' => $request->nama,
      'kelas' => $request->kelas,
    ];
     Session::put('siswa', $siswa);

     return redirect()->route('siswa.index')->with('success', 'Siswa updated succes');
  }
  public function destroy($id)
  {
     $siswa = Session::get('siswa', []);
     $siswa = array_filter($siswa, function ($item) use ($id) {
      return $item['id'] != $id;
     });
     Session::put('siswa', array_values($siswa));

     return redirect()->route('siswa.index')->with('success', 'Siswa deleted succes');
  }
}
