<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function posts($id)
    {
        $user = User::findOrFail($id);
        
        $posts = $user->posts()->latest()->paginate(30);

        return view('users.posts', compact('user', 'posts'));
    }
}