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

    public function show($id)
    {
        // Find the recordlabel by ID
        $recordlabel = Recordlabel::findOrFail($id);
    
        // Get the songs associated with the recordlabel
        // Ensure you have the correct relationship name
        $songs = $recordlabel->songs;
    
        // Return the view with the recordlabel and their songs
        return view('pertemuan2.Recordlabel.show', compact('recordlabel', 'songs'));
    }
    
    public function autocomplete(Request $request)
    {
        $term = $request->get('term');
    
        $rls = Recordlabel::where('nama', 'LIKE', '%' . $term . '%')
            ->get(['id', 'nama'])
            ->map(function($rl) {
                return [
                    'value' => $rl->id,
                    'label' => $rl->nama
                ];
            });
    
        return response()->json($rls);
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
