<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Identity;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IdentityController extends Controller
{
    public function index()
    {
        $identities = Identity::latest()->take(1)->get();

        return view('admin.identity.index', compact('identities'));
    }




    public function edit($id)
    {
        $identity = Identity::findOrfail($id);
        return view('admin.identity.edit', compact('identity'));
    }

    public function update(Request $request, Identity $identity){
        $this->validate($request, [
            'name'             => 'required',
            'logo' => 'image|mimes:jpeg,jpg,png,webp|max:300',
            'favicon' => 'image|mimes:jpeg,jpg,png,webp|max:75',

        ]); 

        $images = [];

        // Check if any image has been uploaded
        if($request->hasFile('logo')) {
            // Delete old image
            if(!is_null($identity->logo)) {
                Storage::disk('public')->delete($identity->logo);
            }

            // Upload new image
            $image = $request->file('logo');
            $image_path = $image->store('public/identities');
            $images['logo'] = basename($image_path);
        }

        if($request->hasFile('favicon')) {
            // Delete old image
            if(!is_null($identity->favicon)) {
                Storage::disk('public')->delete($identity->favicon);
            }

            // Upload new image
            $image = $request->file('favicon');
            $image_path = $image->store('public/identities');
            $images['favicon'] = basename($image_path);
        }

        // Update other fields
        $identity->update([
            'name'                   => $request->name,
            'year'                   => $request->year,
            'day_service'                   => $request->day_service,
            'time_service'                   => $request->time_service,
            'description'                   => $request->description,
            'address'                   => $request->address,
            'gmap'                   => $request->gmap,
            'phone'                   => $request->phone,
            'email'                   => $request->email,
            'fb'                   => $request->fb,
            'ig'                   => $request->ig,
            'tt'                   => $request->tt,
            'yt'                   => $request->yt,
            'logo'                => $images['logo'] ?? $identity->logo,
            'favicon'                => $images['favicon'] ?? $identity->favicon,
        ]);

        if($identity){
            //redirect dengan pesan sukses
            return redirect()->route('admin.identity.edit', $identity->id)->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.identity.edit', $identity->id)->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    
}
