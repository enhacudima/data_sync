<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User; 
use Auth;

class VerificationController extends Controller
{
public function verify($user_id, Request $request) {
    if (!$request->hasValidSignature()) {
        return redirect()->to('/verifyResult');
    }

    $user = User::findOrFail($user_id);

    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    return redirect()->to('/login');
}

public function resend(Request $request) {
    $user_id=$request->data['id'];
    $user=User::find($user_id);

    if ($user->hasVerifiedEmail()) {
        return response()->json(['error' => "Email already verified."], 403);
    }

    $user->sendEmailVerificationNotification();

    return response()->json(['success'=>'Email verification link sent on your email id.'], 200);


}
}
