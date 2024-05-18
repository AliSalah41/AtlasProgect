<?php

namespace App\Http\Controllers;

use App\DataTables\AlbumDataTable;
use App\Http\Requests\StoreAlbumRequest;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index (AlbumDataTable $dataTable)
    {
        return $dataTable->render('pages.album.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $route = route('album.store');
        return view('pages.album.form',['route'=>$route]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlbumRequest $request)
    {
        $album = new Album();
        $album->name = $request->name;
        $album->save();
        if ($request->image){
            foreach ($request->image as $image){
                $pathToMedia = public_path('uploads/'.$image);
                $media = $album->addMedia($pathToMedia)->toMediaCollection();
                $media->save();
            }
        }
        return response()->json(['status'=>true,'msg'=>'تم الحفظ بنجاح']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album)
    {
        $route = route('album.update',$album->id);
        return view('pages.album.form',['model'=>$album,'route'=>$route]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAlbumRequest $request)
    {
        $album = Album::find($request->id);

        if ($album) {
            $album->update([
                'name' => $request->name,
            ]);

            if ($request->image) {
                foreach ($request->image as $image) {
                    $pathToMedia = public_path('uploads/' . $image);
                    $media = $album->addMedia($pathToMedia)->toMediaCollection();
                    $media->save();
                }
            }
            return response()->json(['status'=>true,'msg'=>'تم الحفظ بنجاح']);
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     $album = Album::find($id);

    //     if($album)
    //     {
    //         $album->delete();
    //         return redirect()->back();
    //     }

    //     return redirect()->back();
    // }

    public function uploadImage(Request $request)
    {
        $file = $request->file('image');
        $filename = Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);

        return response()->json(['filename' => $filename]);
    }

    public function deleteWithImages($id)
    {
        $album = Album::find($id);
        $album->delete();
        return response()->json(['status' => 'Album and images deleted successfully']);
    }

    public function moveImages(Request $request, $albumId)
    {
        $targetAlbumId = $request->input('target_album_id');

        $album = Album::findOrFail($albumId);
        $targetAlbumId = $request->input('target_album_id');
        $targetAlbum = Album::findOrFail($targetAlbumId);
    
        foreach ($album->media as $media) {
            $media->update(['model_id' => $targetAlbum->id]);
        }

        $album->delete();
    
        return response()->json(['status' => true]);
    }
    

    public function getAllAlbums()
    {
        return response()->json(Album::all());
    }
    

}
