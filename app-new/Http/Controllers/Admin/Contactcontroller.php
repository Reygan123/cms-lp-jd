<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class Contactcontroller extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $contacts = Contact::latest()->when(request()->q, function($contacts) {
            $contacts = $contacts->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.contact.index', compact('contacts'));
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(contact $contact)
    {
        return view('admin.contact.show', compact('contact'));
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        if($contact){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
