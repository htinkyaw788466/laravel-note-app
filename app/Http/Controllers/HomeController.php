<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{

    protected $limit=5;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.note.index',
        ['notes' => auth()->user()->notes()->simplePaginate($this->limit)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.note.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'image'=>'required|mimes:png,jpg,jpeg',
            'title'=>'required',
            'content'=>'required'
        ]);

         // Get Form Image
         $image = $request->file('image');
         if (isset($image)) {

             // Make Unique Name for Image
             $currentDate = Carbon::now()->toDateString();
             $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

             // Check Note Dir is exists
             if (!Storage::disk('public')->exists('note')) {
                 Storage::disk('public')->makeDirectory('note');
             }

             // Resize Image for note and upload
             $note = Image::make($image)->resize(1024,768)->stream();
             Storage::disk('public')->put('note/' . $imagename, $note);

         } else {
             $imagename = 'default.png';
         }

        $note=new Note();
        $note->user_id = Auth::id();
        $note->image=$imagename;
        $note->title=$request->title;
        $note->content=$request->content;
        $note->save();
        return redirect()->route('note')
               ->with('success','note created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $note=Note::findOrFail($id);
        return view('admin.note.show',compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $note=Note::find($id);
        return view('admin.note.edit',compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'image'=>'required|mimes:png,jpg,jpeg',
            'title'=>'required',
            'content'=>'required'
        ]);

         // Get Form Image
         $image = $request->file('image');
         $note=Note::find($id);
         if (isset($image)) {

             // Make Unique Name for Image
             $currentDate = Carbon::now()->toDateString();
             $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

             // Check Note Dir is exists
             if (!Storage::disk('public')->exists('note')) {
                 Storage::disk('public')->makeDirectory('note');
             }

             // Delete Old Image
            if (Storage::disk('public')->exists('note/' . $note->image)) {
                Storage::disk('public')->delete('note/' . $note->image);
            }

             // Resize Image for note and upload
             $note = Image::make($image)->resize(1024,768)->stream();
             Storage::disk('public')->put('note/' . $imagename, $note);

         } else {
            $imagename = $note->image;
         }


        $note=Note::find($id);
        $note->user_id = Auth::id();
        $note->image=$imagename;
        $note->title=$request->title;
        $note->content=$request->content;
        $note->save();
        return redirect()->route('note')
               ->with('success','note updated');
        }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $note = Note::find($id);

        // Delete Old Image
           if (Storage::disk('public')->exists('note/'.$note->image)) {
               Storage::disk('public')->delete('note/'.$note->image);
             }

             $note->delete();
              return redirect()->route('note')
              ->with('alert','note deleted');
    }

    public function Logout()
    {
        Auth::logout();
        return Redirect()->route('login')->with('success','user logout');
    }

    public function setting()
    {
        return view('admin.setting.index');
    }

    public function settingUpdate(Request $request)
    {
        $image = $request->file('image');
        $slug = str_slug($request->name);
        $user = User::findOrFail(Auth::id());

        if (isset($image)) {

            // Make Unique Name for Image
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();


            // Check Category Dir is exists

            if (!Storage::disk('public')->exists('profile')) {
                Storage::disk('public')->makeDirectory('profile');
            }

            // Delete Old Image
            if (Storage::disk('public')->exists('profile/' . $user->image)) {
                Storage::disk('public')->delete('profile/' . $user->image);
            }

            // Resize Image for category and upload
            $profile = Image::make($image)->resize(500, 500)->stream();
            Storage::disk('public')->put('profile/' . $imageName, $profile);
        } else {
            $imageName = $user->image;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $imageName;
        $user->save();
        return redirect()->back()->with('success', 'Profie Updated');
    }

    public function password()
    {
        return view('admin.setting.password');
    }

    public function passwordUpdate(Request $request)
    {
        $validateData=$this->validate($request,[
            'oldpassword'=>'required',
            'password'=>'required|confirmed'
        ]);

        $hashedPassword=Auth::user()->password;
        if(Hash::check($request->oldpassword,$hashedPassword)){
            $user=User::find(Auth::id());
            $user->password=Hash::make($request->password);
            $user->save();
            Auth::logout();
            return redirect()->route('login');
        }else{
            return redirect()->back()->with('error','current password is invalid');
        }
    }
}
