<?php namespace App\Http\Controllers\Auth;


use App\User;
use App\Exceptions;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use App\Exceptions\UserCreateException;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {
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

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}


	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{
		$validator = $this->validator($request->all());

		if ($validator->fails()) {
			$this->throwValidationException(
				$request, $validator
			);
		}

		$user = $this->create($request->all());
		$user->sendVerification();

		return redirect('/')->with('status', trans('auth.email_sent'));
	}


	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array $data
	 * @return User
	 */
	protected function create(array $data)
	{
		$user = User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		]);

		return $user;
	}

	/**
	 * Validates the registration when the user clicks on the code sent to him/her.
	 *
	 * @param $code
	 * @return \Illuminate\View\View
	 */
	public function getValidate($code)
	{
		$user = User::verify($code);

		if ($user) {
			Auth::login($user);
			return redirect('setup');
		} else {
			// $user = null;
			return view('user.invalid');
		}
	}


	/**
	 * Get the path to the login route.
	 *
	 * @return string
	 */
	public function loginPath()
	{
		return property_exists($this, 'loginPath') ? $this->loginPath : '/';
	}


	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function postLogin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required', 'password' => 'required',
		]);

		$credentials = $request->only('email', 'password');

		if ($this->auth->attempt([
			'email' => $credentials['email'],
			'password' => $credentials['password'],
			'verified' => 1],
			$request->has('remember'))
		) {
            $this->checkTasks();

			return redirect()->intended($this->redirectPath());
		}

		return redirect($this->loginPath())
			->withInput($request->only('email', 'remember'))
			->withErrors([
				'email' => $this->getFailedLoginMessage(),
			]);


//		if (Auth::attempt([
//			'email' => $credentials['email'],
//			'password' => $credentials['password'],
//			'verified' => 1],
//			$request->has('remember'))
//		) {
//
//			return redirect('home');
//		}
//
//		return redirect('/')
//			->withInput($request->only('email', 'remember'))
//			->withErrors(['email' => $this->getFailedLoginMessage(),]);
	}


	/**
	 * Redirect the user to the social authentication page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function redirectToProvider($provider)
	{
		return Socialite::driver($provider)->redirect();
	}


	/**
	 * Obtain the user information from social media.
	 *
	 * @param Request $request
	 * @param $provider
	 * @return \Illuminate\Http\Response
	 */
	public function handleProviderCallback(Request $request, $provider)
	{
		//notice we are not doing any validation, you should do it
		if ($request->has('error')) {
			return redirect('/');
		}

		$user = Socialite::driver($provider)->user();


		// storing data to our users table
		$data = [
			'name' => $user->getName(),
			'email' => $user->getEmail(),
//        'avatar'    => $user->getAvatar(),
			'verified' => 1
		];

		// login the user
		try {
			Auth::login(User::firstOrCreate($data));
		} catch (QueryException $e) {
//        throw new UserCreateException();
			return redirect('/')->withErrors([Lang::get('auth.user')]);
		}


        $this->checkTasks();

        //after login redirecting to home page
		return redirect('home');
	}

	/**
	 * Get the failed login message.
	 *
	 * @return string
	 */
	protected function getFailedLoginMessage()
	{
		return Lang::get('auth.failed');
	}
}
