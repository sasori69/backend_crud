<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Events\Auth\UserActivationEmail;

class ActivationResendController extends Controller
{
    public function showResendForm()
    {
    	return view('auth.activate.resend');
    } 

    public function resend(Request $request)
    {
    	$this->validateResendRequest($request);

    	$user = User::where('email', $request->email)->first();

    	event(new UserActivationEmail($user));

    	return redirect()->route('login')->withSuccess('Email activation has been resent.');
    }

    protected function validateResendRequest(Request $request)
    {
    	$this->validate($request, [
    		'email' => 'required|email|exists:users,email'
    	], [
    		'email.exists' =>'This emailis not exists. Please check your email'
    	]);
    }
}
