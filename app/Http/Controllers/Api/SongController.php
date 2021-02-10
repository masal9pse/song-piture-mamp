<?php

namespace App\Http\Controllers\Api;

use App\Models\Song;
use App\Http\Controllers\Controller; // 大事！！
use App\Http\Requests\CreateSongTask;
use App\Services\SongService;
use Illuminate\Support\Facades\Request;

class SongController extends Controller
{
 protected $songService;
 public function __construct(SongService $song_service)
 {
  $this->songService = $song_service;
 }

 //public function index(Request $request)
 public function index()
 {
  $higedan = new SongService;
  $higedans = $higedan->higedan();
  $songs = $this->songService->getSong();
  return [$higedans, $songs];
 }

 public function store(CreateSongTask $request)
 {
  $song = Song::create([
   'title' => $request->title,
   'detail' => $request->detail,
  ]);

  return response()->json([
   'song' => $song,
   'message' => '投稿に成功しました。'
  ], 200);
 }
}
