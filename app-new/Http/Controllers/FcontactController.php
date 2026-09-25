<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Header;
use App\Models\Program;


class FcontactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headers = Header::where('id', '=', '13')->get();
        $programs = Program::oldest()->orderBy('age', 'asc')->get();
        return view('front.contact.index', compact('headers','programs'));
    }
 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('front.contact.create');
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
            'name'                  => 'required',
            'email'                 => 'required',
            'message'               => 'required',
        ]); 
 
        
        //save to DB
        $contact = Contact::create([
            'name'                  => $request->name,
            'email'                 => $request->email,
            'message'               => $request->message,
            'phone'               => $request->phone,
        ]);
 
        if($contact){
             //redirect dengan pesan sukses
             return redirect()->route('front.contact.index')->with(['success' => 'Data Berhasil Disimpan!']);
         }else{
             //redirect dengan pesan error
             return redirect()->route('front.contact.index')->with(['error' => 'Data Gagal Disimpan!']);
         }
    }

}
