<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/setup', function(){
    $creds = [
        'email'    => 'admin@admin.com',
        'password' => 'password',
    ];

    if(!Auth::attempt($creds)){
        $user = new User();

        $user->name     = 'Admin';
        $user->email    = $creds['email'];
        $user->password = Hash::make($creds['password']);

        $user->save();

        // send tokens to user
        if(Auth::attempt($creds)){
            $user = Auth::user();

            $adminToken  = $user->createToken('admin-token', ['create', 'update', 'delete']);
            $updateToken = $user->createToken('update-token', ['update', 'delete']);
            $basicToken  = $user->createToken('basic-token');

            return [
                'admin'  => $adminToken->plainTextToken,
                'update' => $updateToken->plainTextToken,
                'basic'  => $basicToken->plainTextToken,
            ];
        }
    }
});