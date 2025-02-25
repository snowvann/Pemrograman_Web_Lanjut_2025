<?php

namespace App\Http\Controllers; //menentukan bahwa controller ini berada di space yang benar

use App\Models\Item; //menginpor model Item agar dapat digunakan di controller ini
use Illuminate\Http\Request; //menginpor request, yang digunakan untuk menangani input dari pengguna

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all(); //mengambil semua data dari tabel
        return view('items.index', compact('items')); //mengembalikan view items.index dan mengirim data $items
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('items.create'); //mengembalikan view yang merupakan halaman untuk menambahkan item baru
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([ //mengembalikan ininput name dan description harus diisi
            'name'=> 'required',
            'description' => 'required',
        ]);

        //Item:create($request->all());
        //return redirect()->route('items.index');

        //hanya masukkan atribut yang diizinkan
        Item::create($request->only(['name', 'description'])); //menyimpan data baru ke database
        return redirect()->route('items.index')->with('success', 'Item added successfully.'); //setelah data disimpan, akan diarahkan ke halaman daftar item dengan pesan
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return view('items.show', compact('item')); //menampilkan view dengan data item
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        return view('items.edit', compact('item')); //menampilkan form edit item
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name'=> 'required',
            'description' => 'required',
        ]);

        //Item:create($request->all());
        //return redirect()->route('items.index');
        //hanya masukkan atribut yang diizinkan
        $item->update($request->only(['name', 'description']));
        return redirect()->route('items.index')->with('success', 'Item added successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //retun redirect()->route('items.index');
        $item->delete(); //menghapus item dari database
        return redirect()->route('items.index')->with('success', 'Item deleted successfully.'); //mengembalikan halaman daftar item dengan pesan sukses
    }
}
