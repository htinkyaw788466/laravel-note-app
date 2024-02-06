<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes=Note::latest()->simplePaginate(10);
        return view('admin.note.index',compact('notes'));
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
        return redirect()->route('note.index')
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
        return redirect()->route('note.index')
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
              return redirect()->route('note.index')
              ->with('alert','note deleted');
    }

    public function Logout()
    {
        Auth::logout();
        return Redirect()->route('login')->with('success','user logout');
    }
}
