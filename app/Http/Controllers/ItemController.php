<?php

namespace App\Http\Controllers;

use App\Item;
use App\Licensor;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('DisablePreventBack');
    }

    public function index() //ini method controller
    {
        $items = Item::all();
        return view('Item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        return view('Item.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'item_name'     => 'required|unique:items',
            'total_item'    => 'required',
        ]);

        $items = new Item;
        $items->item_name = $request->item_name;
        $items->total_item = $request->total_item;      
        $total = $request->input('total_item');
        $items->total_item = $total;
        $items->stock_item = $total;
        $items->save();
        \Session::flash('sukses', 'Data berhasil di Tambahkan');


        return redirect('/items');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);
        return view('Item.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $items = Item::find($id);
        return view('Item.edit', compact('items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'total_item' => 'required'
        ]);


        $items = Item::whereId($id)->first();

        if ($items->total_item == $items->stock_item) {

            $items->item_name = $request->item_name;
            $items->total_item = $request->total_item;      
            $total = $request->input('total_item');
            $items->total_item = $total;
            $items->stock_item = $total;
            $items->update();
            \Session::flash('sukses', 'Data berhasil di Update');
        } else {
            \Session::flash('gagal', 'Barang Tidak dapat di edit');
        }

        return redirect('/items');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $items = Item::whereId($id)->first();
            if ($items->total_item == $items->stock_item) {
                Item::where('id', $id)->delete();
            } else {
                \Session::flash('gagal','Barang tidak dapat di Hapus');
            }
            \Session::flash('sukses', 'Data berhasil dihapus');
        } catch (Exception $e) {
            \Session::flash('gagal', $e->getMessage());
        }
        return redirect('items');
    }
}
