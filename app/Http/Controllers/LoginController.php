<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('fe.login', [
            'title' => 'Login'
        ]);
    }

    function login(Request $request){
        
        $request->validate([
            'email'=> 'required',
            'password' => 'required'
        ],[
            'email.required'=> 'Email Wajib Diisi!',
            'password.required'=> 'Password Wajib Diisi!',
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(Auth::attempt($infologin)){
           if (Auth::user()->level == 'pemilik'){
                return redirect('/owner');
           }elseif (Auth::user()->level == 'admin'){
                return redirect('/admin');
           }elseif (Auth::user()->level == 'bendahara'){
                return redirect('/bendahara');
           }
        }else{
            return redirect('/login')->withErrors('Username yang digunakan tidak sesuai')->withInput();
        }
    }

    function logout(){
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
