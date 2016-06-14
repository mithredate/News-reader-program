<?php

namespace App\Http\Controllers\Auth;

use App\Facades\Verify;
use App\Traits\AuthenticateAndRegisterUsersAndResetPasswords;
use App\User;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticateAndRegisterUsersAndResetPasswords, ThrottlesLogins;


    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';


    /**
     * Create a new authentication controller instance.
     *
     * @param TokenRepositoryInterface $tokens
     * @param $app
     * @internal param Application $app
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'email' => $data['email']
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @param TokenRepositoryInterface $tokens
     * @param Mailer $mailer
     * @param $app
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Foundation\Validation\ValidationException
     * @internal param TokenRepositoryInterface $token
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $this->create($request->all());
        $this->subject = 'Verification Email';
        $response = Verify::broker($this->getBroker())->sendResetLink(
            $this->getSendResetLinkEmailCredentials($request),
            $this->resetEmailBuilder()
        );

        switch ($response){
            case Password::RESET_LINK_SENT:
                $request->session()->push('message',[
                    'type' => 'success',
                    'content' => 'Verification email sent successfully. Please verify you\'re email to continue'
                ]);
                break;
            case Password::INVALID_USER:
            default:
                $request->session()->push('message',[
                    'type' => 'danger',
                    'content' => 'There was a problem sending out the verification email. Please try later!'
                ]);
                break;
        }
        return redirect()->back();
    }


    /**
     * @param Request $request
     * @param null $token
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request, $token = null){
        $user = $this->getUserByToken($token, $request->only('email'));
        if(! is_null($user)) {
            if (($verify = $user->status->verify()) === true) {
                $this->resetView = 'auth.verify.setPassword';
                return $this->showResetForm($request, $token);
            }
            return $verify;
        }

        $request->session()->push('message',[
            'type' => 'warning',
            'content' => 'Invalid token provided!'
        ]);
        return redirect('/');
    }

    public function setPassword(Request $request){
        $user = $this->getUserByToken($request->get('token'), $request->only('email'));
        $this->validate(
            $request,
            $this->getResetValidationRules(),
            $this->getResetValidationMessages(),
            $this->getResetValidationCustomAttributes()
        );

        $credentials = $this->getResetCredentials($request);
        if(! is_null($user) ){
            if( ($response = $user->status->setPassword($credentials)) === true ){
                $broker = $this->getBroker();

                $response = Password::broker($broker)->reset($credentials, function ($user, $password) {
                    $this->resetPassword($user, $password);
                });

                switch ($response) {
                    case Password::PASSWORD_RESET:
                        Auth::login($user);
                        $request->session()->push('message', [
                            'type' => 'info',
                            'content' => 'Thank you for setting your password'
                        ]);
                        $request->session()->push('message', [
                            'type' => 'success',
                            'content' => 'Your registration is now complete. You can start using our services!'
                        ]);
                        return redirect('home');
                    default:
                        $request->session()->push('message', [
                            'type' => 'warning',
                            'content' => 'There was a problem with your registration! Please try later.'
                        ]);
                        return back();
                }
            }
            return $response;
        }

        $request->session()->push('message',[
            'type' => 'warning',
            'content' => 'Invalid Token provided!'
        ]);

        return redirect('/');


    }
    private function getUserByToken($token, $credentials)
    {
        $user = Password::getUser($credentials);
        if($user && Password::tokenExists($user, $token) ){
            return $user;
        }

        return null;
    }

}


