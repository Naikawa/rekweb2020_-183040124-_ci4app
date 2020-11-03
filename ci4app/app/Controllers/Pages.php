<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home | WebProgrammingUNPAS'
        ];
        return view('pages/home', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About Me | WebProgrammingUNPAS'
        ];
        return view('pages/about', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact Us',
            'alamat' => [
                'tipe' => 'rumah',
                'alamat' => 'jl. Setiabudhi',
                'kota' => 'Bandung'
            ],
            [
                'tipe' => 'Kantor',
                'alamat' => 'Setia Budhi',
                'kota' => 'Bandung'
            ]
        ];

        return view('page/contact', $data);
    }

    //--------------------------------------------------------------------

}
