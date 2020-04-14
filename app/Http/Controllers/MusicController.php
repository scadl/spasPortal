<?php

namespace App\Http\Controllers;

use App\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MusicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // list all songs
        $songs = Music::all();
        return view('home', ['song_list' => $songs]);
    }

    public function playLog(Music $music)
    {
        // add one to played log
        $music->played += 1;
        $music->save();
        return $music->played;
    }

    public function dwLog(Music $music)
    {
        // add one to download log
        $music->downloads += 1;
        $music->save();
        return $music->downloads;
    }

    public function fileRefresh()
    {

        // Scan for files
        $fIndex = array();
        $files = Storage::disk('local')->listContents('public/audio', true);
        //return $files;

        // Update storage index
        $songs = Music::all();
        foreach ($files as $f) {
            $fix_path = Str::replaceFirst('public/', 'storage/', $f['path']);
            // add NEW files to DB
            if (!Music::where('file_name', $fix_path)->first()) {
                $melody = new Music();
                $melody->title = $f['filename'];
                $melody->description = $f['filename'];
                $melody->played = 0;
                $melody->downloads = 0;
                $melody->hidden = 0; // visible
                $melody->file_name = $fix_path;

                if ($f['type'] == 'dir') {
                    $melody->type = 'dir';
                } elseif ($f['type'] == 'file') {
                    if ($f['extension'] == 'txt') {
                        $melody->type = 'txt';
                        $melody->description = Storage::disk('local')->read($f['path']);
                    } else {
                        $melody->type = $f['extension'];
                    }
                }

                $melody->save();
            }
            $fIndex[] = $fix_path;
        }
        // Clean DB of OLD files
        $musicdB = Music::all();
        foreach ($musicdB as $song) {
            if (!in_array($song->file_name, $fIndex)) {
                $song->delete();
            }
        }

        return $files;
    }

    public function null(Music $music)
    {
        return null;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Music $music
     * @return \Illuminate\Http\Response
     */
    public function show(Music $music)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Music $music
     * @return \Illuminate\Http\Response
     */
    public function edit(Music $music)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Music $music
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Music $music)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Music $music
     * @return \Illuminate\Http\Response
     */
    public function destroy(Music $music)
    {
        //
    }
}
