<?php


namespace App\Modules\User\Infrastructure\Controller;

use App\Http\Controllers\Controller;
use App\Modules\Base\Traits\CustomerDB;
use App\Modules\Base\Traits\CustomerDBInterface;
use App\Modules\Ulises\Channel\Domain\Channel;
use App\Modules\Ulises\Vendor\Domain\Vendor;
use App\Modules\User\Domain\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Api extends Controller implements CustomerDBInterface
{
    use CustomerDB;

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        /** @var User $user */
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales son incorrectas.'],
            ]);
        }

        $return = new \stdClass();
        $return->token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json($return);
    }

    /**
     * @return JsonResponse
     * @throws
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json('Exit to logout');
    }

    protected function generateRandomPassword()
    {
        $string = "";
        $length = '16';
        $chars = "abcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);
        for ($i = 0; $i < $length; $i++) {
            $string .= $chars[rand(0, $size - 1)];
        }
        return $string;
    }

    protected function createDatabase($user, $urlApi, $username, $password, $dbHost, $command, $dbUser, $dbName, $dbPassword)
    {
        if (!$user || !$urlApi || !$username || !$password || !$dbHost || !$command || !$dbUser || !$dbName || !$dbPassword) {
            throw new \Exception('Cannot get hosting data from config');
        }

        $args = array('responseType' => 'Json',
            'hosting' => $dbHost,
            'ddbbName' => $dbName,
            'userName' => $dbUser,
            'userPassword' => $dbPassword,
            'accessHost' => 'any',
            'command' => $command,
        ) ;
        $args = ( is_array ( $args ) ? http_build_query ( $args, '', '&' ) : $args );
        $headers = array();

        $handle = curl_init($urlApi);
        if( $handle === false ) // error starting curl
        {
            throw new \Exception('0 - Couldnot start curl');
        } else {
            curl_setopt ( $handle, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt ( $handle, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $handle, CURLOPT_URL, $urlApi );

            curl_setopt( $handle, CURLOPT_USERPWD, $username.':'.$password );
            curl_setopt( $handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );

            curl_setopt( $handle, CURLOPT_TIMEOUT, 60 );
            curl_setopt( $handle, CURLOPT_CONNECTTIMEOUT, 4); // set higher if you get a "28 - SSL connection timeout" error

            curl_setopt ( $handle, CURLOPT_HEADER, true );
            curl_setopt ( $handle, CURLOPT_HTTPHEADER, $headers );

            $curlversion = curl_version();
            curl_setopt ( $handle, CURLOPT_USERAGENT, 'PHP '.phpversion().' + Curl '.$curlversion['version'] );
            curl_setopt ( $handle, CURLOPT_REFERER, null );

            curl_setopt ( $handle, CURLOPT_SSL_VERIFYPEER, false ); // set false if you get a "60 - SSL certificate problem" error

            curl_setopt ( $handle, CURLOPT_POSTFIELDS, $args );
            curl_setopt ( $handle, CURLOPT_POST, true );

            $response = curl_exec ( $handle );

            if ($response)
            {
                $response = substr( $response,  strpos( $response, "\r\n\r\n" ) + 4 ); // remove http headers
                // parse response


                $responseDecoded = json_decode($response, true);
                if( $responseDecoded === false )
                {
                    throw new \Exception('0 - Invalid json respond');
                }
                else
                {
                    // parse response
                    if( false == isset($responseDecoded['responseCode']) )
                    {
                        throw new \Exception('0 - Unexpected internal error');
                    }
                    else if( $responseDecoded['responseCode'] == 1000  )
                    {
                        $data = $responseDecoded['data'];
                    }
                    else
                    {
                        // normal error
                        $errors = $responseDecoded['errors'];

                        throw new \Exception('0 - Error logged');
                    }
                }


            }
            else // http response code != 200
            {
                $error = curl_errno ( $handle ) . ' - ' . curl_error ( $handle );

                throw new \Exception($error);
            }

            curl_close($handle);
        }
    }

    protected function createDefaultStructureToDb($user)
    {
        $this->setToCustomerDB($user);

        Artisan::call('migrate');
    }

    protected function createDefaultDataToDb($data, $dbHost, $dbUser, $dbPassword, $dbName)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'db_host' => $dbHost,
            'db_user' => $dbUser,
            'db_password' => $dbPassword,
            'db_name' => $dbName,
        ]);

        $defaultVendor = new Vendor([
            'creator_id' => $user->id,
            'description' => $data['name'],
            'short_description' => $data['name'],
        ]);
        $defaultVendor->save();

        $defaultChannel = new Channel([
            'creator_id' => $user->id,
            'description' => 'Ulises',
            'short_description' => 'Ulises',
        ]);
        $defaultChannel->save();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $data = $request->validate(User::VALIDATION_COTNEXT);

        $urlApi = env("HOSTING_API", null);
        $username = env("HOSTING_USER", null);
        $password = env("HOSTING_PASS", null);
        $command = env("HOSTING_DATABASE_CREATE_COMMAND", null);
        $dbHost = env("HOSTING_URL", null);
        $dbUser = uniqid('ul_');
        $dbName = $dbUser;
        $dbPassword = $this->generateRandomPassword();

        event(new Registered($user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'db_host' => $dbHost,
            'db_user' => $dbUser,
            'db_password' => $dbPassword,
            'db_name' => $dbName,
        ])));

        try {
            $this->createDatabase($user, $urlApi, $username, $password, $dbHost, $command, $dbUser, $dbName, $dbPassword);
            $this->createDefaultStructureToDb($user);
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'name' => ['El usuario se ha registrado. Aún así ha ocurrido un error inesperado, contacta con nosotros para que terminemos tu alta.'],
            ]);
        }

        try {
            $this->createDefaultDataToDb($data, $dbHost, $dbUser, $dbPassword, $dbName);
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'name' => ['El usuario se ha registrado. Aún así contacta con nosotros ya que no ha sido posible asignar el nombre a tu empresa.'],
            ]);
        }

        return response()->json('User registered');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function forgotSendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = Password::broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? response()->json('Reset link sent')
            : response()->json('Error to send reset link', 500);
    }

    /**
     * Set the user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function setUserPassword($user, $password)
    {
        $user->password = Hash::make($password);
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Reset the given user's password.
     *
     * @param  User $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function forgotReset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
            ? response()->json('Password reset')
            : response()->json('Error to reset password', 500);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws
     */
    public function verify(Request $request)
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');

        if (! hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            return response()->json('User already has an verified email');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return response()->json('Verified');
    }
}
