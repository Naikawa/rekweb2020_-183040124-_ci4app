<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Pages extends BaseController
{
    protected $komikModel;
    public function __construct(){
        $this->komikModel = new KomikModel();
    }

    public funtion index(){
          
        // $komik = $this->komikModel->findAll();

        $data = [
            'title' => 'Daftar Komik',
            'komik' => $this->komikModel->getKomik($slug);
        ];

        // $db = \Config\Database\connect();
        // $komik = $db->query("SELECT * FROM komik");
        // foreach($komik->getResultArray() as $row){
        //     d($row);
    // $komikModel = new \App\Models\KomikModel();
    }

        return view('komik/indedx', $data);
    }

    public function detail($slug){
        $data = [
            'title' => 'Detail Komik',
            'komik' => $this->komikModel->getKomik($slug)
        ];

        //jika komik tidak ada di tabel 
        if(empty($data['komik'])){
            throw new \CodeIgniter\Exception\PageNotFoundException('Judul Komik' . $slug . 'tidak ditemukan');
        }

        return view('komik/detail' , $data);
    }

    public functionn create(){
        // session();
        $data = [ 
            'title' => 'form tambah data komik',
            'validation' => \Config\Services::validation()
        ];

        return view('komik/create', $data);
    }


    public function save(){

        // validast input
        if(!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} komik harus diisi.',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ]
        ])){
            $validation = \Config\Services::validation();
            return redirect()->to('/komik/create')->withInput()->with('validation', $validation);
        }
        
        $slug = url_title($this->request->getVar('judul'), '-', true)
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);

            session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/komik');

    }
    public function delete($id){
        $this->komikModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');

        return redirect()->to('/komik');
    }

    public function edit($slug){
        data = [ 
            'title' => 'form ubah data komik',
            'validation' => \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slug)
        ];

        return view('komik/edit', $data);
    }

    public function update($id){
        //cek judul
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));
        if($komikLama['judul'] == $this->request->getVar('judul')){
            $rule_judul = 'required';
        } else{
            $rule_judul = 'required|is_unique[komik.judul]';
        }

        if(!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} komik harus diisi.',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ]
        ])){
            $validation = \Config\Services::validation();
            return redirect()->to('/komik/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
        }
        
        $slug = url_title($this->request->getVar('judul'), '-', true)
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);

            session()->setFlashdata('pesan', 'Data berhasil diubah');

        return redirect()->to('/komik');
    }
}
