<?php

use App\Models\User;
use App\Models\Post;

// ==========================================
// KASUS UJI 1: CREATE (Penyimpanan Post)
// ==========================================

test('user terautentikasi dapat melihat form tambah post', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/posts/create');

    $response->assertStatus(200);
});

test('user terautentikasi dapat menyimpan post baru', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/posts', [
            'title' => 'Judul Uji Coba',
            'content' => 'Konten artikel uji coba functional testing.'
        ]);

    $response->assertRedirect('/');
    
    $this->assertDatabaseHas('posts', [
        'title' => 'Judul Uji Coba',
        'content' => 'Konten artikel uji coba functional testing.',
        'user_id' => $user->id
    ]);
});

test('guest ditolak saat mengakses form tambah post dan diarahkan ke login', function () {
    $response = $this->get('/posts/create');

    $response->assertRedirect('/login');
});

test('guest ditolak saat menyimpan post baru dan diarahkan ke login', function () {
    $response = $this->post('/posts', [
        'title' => 'Judul Uji Coba Guest',
        'content' => 'Konten artikel guest.'
    ]);

    $response->assertRedirect('/login');
    $this->assertDatabaseMissing('posts', [
        'title' => 'Judul Uji Coba Guest'
    ]);
});

test('title dan content wajib diisi untuk menyimpan post', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/posts', [
            'title' => '',
            'content' => ''
        ]);

    $response->assertSessionHasErrors(['title', 'content']);
});


// ==========================================
// KASUS UJI 2: READ (Membaca Post)
// ==========================================

test('semua user dapat melihat daftar post di homepage', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'title' => 'Artikel Menarik Hari Ini',
        'content' => 'Isi artikel menarik.',
        'user_id' => $user->id
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Artikel Menarik Hari Ini');
});

test('semua user dapat membaca detail post tertentu', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'title' => 'Detail Artikel Uji',
        'content' => 'Isi detail artikel.',
        'user_id' => $user->id
    ]);

    $response = $this->get('/posts/' . $post->id);

    $response->assertStatus(200);
    $response->assertSee('Detail Artikel Uji');
    $response->assertSee('Isi detail artikel.');
});


// ==========================================
// KASUS UJI 3: UPDATE (Mengubah Post)
// ==========================================

test('pemilik post dapat melihat form edit post miliknya', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'title' => 'Artikel Sebelum Edit',
        'content' => 'Konten lama.',
        'user_id' => $user->id
    ]);

    $response = $this
        ->actingAs($user)
        ->get("/posts/{$post->id}/edit");

    $response->assertStatus(200);
});

test('pemilik post dapat memperbarui artikel miliknya', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'title' => 'Artikel Sebelum Edit',
        'content' => 'Konten lama.',
        'user_id' => $user->id
    ]);

    $response = $this
        ->actingAs($user)
        ->put("/posts/{$post->id}", [
            'title' => 'Artikel Setelah Edit',
            'content' => 'Konten baru yang diperbarui.'
        ]);

    $response->assertRedirect('/');

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Artikel Setelah Edit',
        'content' => 'Konten baru yang diperbarui.'
    ]);
});

test('user lain tidak dapat melihat form edit post orang lain', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();
    
    $post = Post::create([
        'title' => 'Artikel User A',
        'content' => 'Konten User A.',
        'user_id' => $userA->id
    ]);

    $response = $this
        ->actingAs($userB)
        ->get("/posts/{$post->id}/edit");

    $response->assertStatus(403);
});

test('user lain tidak dapat mengubah post orang lain', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();
    
    $post = Post::create([
        'title' => 'Artikel User A',
        'content' => 'Konten User A.',
        'user_id' => $userA->id
    ]);

    $response = $this
        ->actingAs($userB)
        ->put("/posts/{$post->id}", [
            'title' => 'Penyerobotan Judul',
            'content' => 'Mencoba merubah konten.'
        ]);

    $response->assertStatus(403);
    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Artikel User A',
        'content' => 'Konten User A.'
    ]);
});

test('guest ditolak saat mencoba mengedit post dan diarahkan ke login', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'title' => 'Artikel Uji Guest',
        'content' => 'Konten.',
        'user_id' => $user->id
    ]);

    $responseEdit = $this->get("/posts/{$post->id}/edit");
    $responseEdit->assertRedirect('/login');

    $responseUpdate = $this->put("/posts/{$post->id}", [
        'title' => 'Ubah Judul Guest',
        'content' => 'Konten.'
    ]);
    $responseUpdate->assertRedirect('/login');
});

test('title dan content wajib diisi untuk mengubah post', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'title' => 'Artikel Awal',
        'content' => 'Konten.',
        'user_id' => $user->id
    ]);

    $response = $this
        ->actingAs($user)
        ->put("/posts/{$post->id}", [
            'title' => '',
            'content' => ''
        ]);

    $response->assertSessionHasErrors(['title', 'content']);
});


// ==========================================
// KASUS UJI 4: DELETE (Menghapus Post)
// ==========================================

test('pemilik post dapat menghapus post miliknya', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'title' => 'Artikel Akan Dihapus',
        'content' => 'Konten segera hilang.',
        'user_id' => $user->id
    ]);

    $response = $this
        ->actingAs($user)
        ->delete("/posts/{$post->id}");

    $response->assertRedirect('/');
    $this->assertDatabaseMissing('posts', [
        'id' => $post->id
    ]);
});

test('user lain tidak dapat menghapus post orang lain', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();
    
    $post = Post::create([
        'title' => 'Artikel User A Aman',
        'content' => 'Konten User A.',
        'user_id' => $userA->id
    ]);

    $response = $this
        ->actingAs($userB)
        ->delete("/posts/{$post->id}");

    $response->assertStatus(403);
    $this->assertDatabaseHas('posts', [
        'id' => $post->id
    ]);
});

test('guest ditolak saat mencoba menghapus post dan diarahkan ke login', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'title' => 'Artikel Uji Hapus Guest',
        'content' => 'Konten.',
        'user_id' => $user->id
    ]);

    $response = $this->delete("/posts/{$post->id}");
    
    $response->assertRedirect('/login');
    $this->assertDatabaseHas('posts', [
        'id' => $post->id
    ]);
});
