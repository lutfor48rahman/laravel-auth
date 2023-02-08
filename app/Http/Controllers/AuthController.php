<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB,Mail;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['login','signup']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
         $validated = $request->validate([
        'email' => 'required',
        'password' => 'required',
    ]);
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }


    public function signup(Request $request)
    {
        $validateData = $request->validate([
            'email' => 'required|unique:users|max:255',
            'name' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $data =array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        DB::table('users')->insert($data);

        
        // return response('create successfully user');

        return $this->login($request);
    }


    public function sendVerifyMail($email){
        if(auth()->user()){
            $user = USer::where('email',$email)->get();
            if(count($user) > 0){
                
                $random = Str::random(40);
                $domain = URL::to('/');
                $url = $domain.'/verify-mail/'.$random;

                $data['url'] = $url;
                $data['email'] = $email;
                $data['title'] = 'Email Verification';
                $data['body'] = 'Please click here to below to verify your mail.';

                Mail::send('verify',['data'=>$data],function($message)use($data){
                    $message->to($data['email'])->subject($data['title']);
                });

                $user = User::find($user[0]['id']);
                $user->remember_token = $random;
                $user->save();

                return response()->json(['success' =>true,'msg' => 'Mil sent successfully.']);
                
            }
            else{
                return response()->json(['success' => false, 'msg' => 'User is not found!']);
            }
        }
        else{
            return response()->json(['success' => false,'msg' => 'User is not Authenticated']);
        }
    }


    public function verifyConfirmMail($token){

        $user = User::where('remember_token',$token)->get();
        if(count($user) > 0){
            $dateTime = Carbon::now()->format('Y-m-d H:i:s');
           $user = User::find($user[0]['id']);
           $user->remember_token = '';
           $user->is_verified = 1;
           $user->email_verified_at = $dateTime;
           $user->save();
           return "<h1>Email verified successfully.";
        }
        else{
            return view('404');
        }
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60,
            'name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
            'email' => auth()->user()->email,
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}
