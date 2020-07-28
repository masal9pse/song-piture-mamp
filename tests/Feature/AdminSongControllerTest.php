<?php

namespace Tests\Feature;

use App\Admin;
use App\Models\Song;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminSongControllerTest extends TestCase
{
 use RefreshDatabase;

 public function setUp(): void
 {
  parent::setUp();

  $this->admin = factory(Admin::class)->create();
 }


 public function test_画像とタグが未入力で歌詞を投稿に成功した時()
 {
  $this->withoutExceptionHandling();
  $response = $this->actingAs($this->admin, 'admin')
   ->post(route('admin.store'), [
    'title' => '今夜このまま',
    'detail' => '苦いようで甘いような〜',
    'file_name' => ''
   ]);;

  $response->assertRedirect('/admin/create');
 }

 public function test_入力必須項目が未入力で歌詞を投稿すると失敗する()
 {
  $response = $this->actingAs($this->admin, 'admin')
   ->post(route('admin.store'), [
    'title' => '',
    'detail' => '',
    'file_name' => ''
   ]);;

  // dd($response);
  $response->assertSessionHasErrors([
   'title' => 'タイトルは必須です。',
   'detail' => '歌詞は必須です。'
  ]);
  // バリデーションはリダイレクトしないみたい。
 }

 public function test_タイトルが未入力で歌詞を投稿すると失敗する()
 {
  $response = $this->actingAs($this->admin, 'admin')
   ->post(route('admin.store'), [
    'title' => '',
    'detail' => '苦いようで甘いような〜',
    'file_name' => ''
   ]);

  $response->assertSessionHasErrors([
   'title' => 'タイトルは必須です。'
  ]);
 }

 public function test_歌詞を更新したとき()
 {
  $this->withoutExceptionHandling();
  $song = Song::create([
   'title' => 'test',
   'detail' => 'test',
   'file_name' => false
  ]);

  $this->assertEquals('test', $song->title);
  $this->assertEquals('test', $song->detail);
  $this->assertFalse($song->file_name);

  $song->fill(['title' => 'テスト', 'detail' => 'テスト']);
  $song->save();

  // $this->assertRedirect('/admin/create');
  // $task2 = Task::find($song->id);
  // $this->assertEquals('テスト', $task2->title);
 }
}
