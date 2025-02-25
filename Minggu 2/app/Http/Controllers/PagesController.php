<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index() {
        return 'Selamat Datang';
    }

    public function about() {
        return 'Nama : Danica Nasywa Putriniar || NIM : 2341760122';
    }

    public function articles($Id) {
        return 'Halaman artikel dengan ID : '.$Id;
    }
}
