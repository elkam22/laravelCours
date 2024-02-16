<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AvatarController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

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


    // CRUD with DataBase
    /* Way 1
        select the data
        $users = DB::select("select * from users");
        foreach($users as $user){
            echo 'User Name:' . $user->name . "\n";
            echo 'User Email:' . $user->email .  "\n";
            echo 'User Password:' . $user->password;
        }

        create a new user
        $user = DB::insert("insert into users (name, email, password) values(?,?,?)", ["ahmed", "ahmed@gmail.com", "ahmed1234"]);

        update user
        $user = DB::update("update users set email=? where id=?", ['akam@gmail.com', 1]);

        delete user
        $user = DB::delete("delete from users where id=?", [1]);

        dd($users);
    */

    /* Way 2
        select the data
        $users = DB::table('mytab')->get();

        insert user
        $user = DB::table('mytab')->insert([
            'name' => 'elkamraoui',
            'email' => 'elkam@gmail.com',
            'password' => 'elkam4321'
        ]);

        update user
        $user = DB::table('mytab')->where('id', 2)->update(['email' => 'elkam860@gmail.com']);

        delete user
        $user = DB::table('mytab')->where('id', 2)->delete();

        dd($users);
    */

    /* Way 3
        select the data
        $users = User::get();

        insert user
        $user = User::create([
            'name' => 'elkamraoui',
            'email' => 'elkam860@gmail.com',
            'password' => 'akam2222'
        ]);

        update user
        $users->where('id', 3)->update(['name' => 'abdel ghani']);
        $user = User::where('id', 4)->update(['email' => 'abde@gmail.com']);

        delete user
        $user = User::where('id', 2)->delete();

        dd($users);
    */

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// login with github
Route::post('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
})->name('login.github');

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();

    $user = User::updateOrCreate(['email' => $user['email'],],[
        'name' => 'El kamraoui',
        'password' => 'password',
    ]);

    Auth::login($user);

    return redirect('/dashboard');
    // dd($user);
    // $user->token
});

// help ticket project routers
Route::middleware('auth')->group(function () {
    Route::resource('/ticket', TicketController::class);
});

