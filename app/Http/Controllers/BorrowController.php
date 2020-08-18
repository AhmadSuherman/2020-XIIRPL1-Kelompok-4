<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Borrow;
use App\Item;

class BorrowController extends Controller
{
   	public function index()
   	{
   	$tampil= Borrow::join('items' , 'borrows.id_item' , '=' , 'items.id')
        ->join('users' , 'borrows.id_student' ,'=', 'users.id')->select(
          'items.*',
          'users.*',
          'borrows.*',
          'borrows.id as id')->get();
        return view('Borrow.index', ['tampil' => $tampil]);
   		//  $borrows = Borrow::all();
   		//  $items = Item::all();
   		// return view('Borrow.index',['borrows' => $borrows, 'items' => $items]);
   	}

   	public function borrowItem($id){
        $items= Item::whereId($id)->first();
        return view('Borrow.listborrow');
    }
    
    public function destroy($id)
    {                       
        try {
            Borrow::where('id',$id)->delete();

            \Session::flash('sukses','data berhasil dihapus');
            
        } catch (Exception $e) {
            \Session::flash('gagal',$e->getMessage());

        }
        return redirect('Borrows');
     }
    public function history(){
         $data= Borrow::join('items' , 'borrows.id_item' , '=' , 'items.id')
          ->join('users' , 'borrows.id_student' ,'=', 'users.id')->select(
          'items.*',
          'users.*',
          'borrows.*',
          'borrows.id as id')->get();

     
         return view('Borrow.history', ['data' => $data]);
    }

    public function restore(){

    }
}
