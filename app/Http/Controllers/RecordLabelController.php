<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recordlabel;

class RecordlabelController extends Controller
{
        // public function tampil()
    // {
    //     $recordlabel = Recordlabel::get();
    //     return view('pertemuan2.Recordlabel.tampil', compact('recordlabel'));
    // }

    public function tampil(Request $request)
    {
        $search = $request->input('search'); // Menerima input search dari request
    
        // Jika ada pencarian, filter data berdasarkan nama atau country
        $recordlabel = Recordlabel::when($search, function ($query, $search) {
            return $query->where('nama', 'LIKE', "%{$search}%")
                         ->orWhere('country', 'LIKE', "%{$search}%");
        })
        ->paginate(10); // Pagination dengan 10 data per halaman
    
        return view('pertemuan2.Recordlabel.tampil', compact('recordlabel', 'search'));
    }
    


    public function tambah()
    {
        // $data['recordlabel'] = $recordlabel;
        return view('pertemuan2.Recordlabel.tambah');
    }

    public function submit(Request $request)
    {
        // $data['recordlabel'] = $recordlabel;
        $recordlabel = new Recordlabel();

        $recordlabel->nama = $request->nama;
        $recordlabel->country = $request->country;
        $recordlabel->save();

        return redirect()->route('crud-recordlabel.tampil');
    }

    public function edit($id)
    {
        // $data['recordlabel'] = $recordlabel;
        $recordlabel = Recordlabel::find($id);
        return view('pertemuan2.Recordlabel.edit', compact('recordlabel'));

    }

    public function update(Request $request, $id)
    {
        // $data['recordlabel'] = $recordlabel;
        $recordlabel = Recordlabel::find($id);

        $recordlabel->nama = $request->nama;
        $recordlabel->country = $request->country;
        $recordlabel->update();

        return redirect()->route('crud-recordlabel.tampil');
    }
    
    public function delete($id)
    {
        // $data['recordlabel'] = $recordlabel;
        $recordlabel = Recordlabel::find($id);

        $recordlabel->delete();

        return redirect()->route('crud-recordlabel.tampil');
    }

}
