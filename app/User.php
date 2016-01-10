<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use Lang;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /***
     * The array with dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'city',
        'state',
        'address',
        'address_alt',
        'phone',
        'post',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $append = [
        'full_name',
    ];

    /***
     * Use this function to get rules for database.
     * To get rules for update set first param to true.
     * If you want to get current key set second parameter to get current rule key.
     *
     * @param bool $isUpdate - by default is false set to true if you want rules for update database
     * @param null $key - set key as string if you want to get selected rule
     * @return array - retunrs all rules or selected key
     */
    public static function rules($option = 'none', $key = null) {
        $rules = [
            'first_name' => 'required|between:3,255',
            'last_name' => 'required|between:3,255',
            'email' => 'required|between:3,255|email|unique:users,email'
        ];

        if(Auth::check()) $rules['email'] .= ',' . Auth::user() -> id;

        switch($option) {
            case 'register':
                $rules['password'] = 'required|between:6,255';
                $rules['confirm_password'] = 'required|same:password';
                break;
            case 'update':
                $rules['city'] = 'required|between:3,85';
                $rules['state'] = 'required|between:3,85';
                $rules['address'] = 'required|between:6,255';
                $rules['address_alt'] = 'between:6,255';
                $rules['phone'] = 'required|between:5,42';
                $rules['post'] = 'required|between:4,255';
                break;
            case 'change-password':
                unset($rules);
                $rules = [
                    'password' => 'required|between:6,255',
                    'new_password' => 'required|between:6,255',
                    'confirm_password' => 'required|same:new_password'
                ];
                break;
        }

        if($key) return $rules[$key];

        return $rules;
    }

    public static function messages($options = 'none', $key = null) {
        $messages = [
            'first_name.required' => Lang::get('validation.models.user.first_name.required'),
            'first_name.between' => Lang::get('validation.models.user.first_name.between'),

            'last_name.required' => Lang::get('validation.models.user.last_name.required'),
            'last_name.between' => Lang::get('validation.models.user.last_name.between'),

            'email.required' => Lang::get('validation.models.user.email.required'),
            'email.between' => Lang::get('validation.models.user.email.between'),
            'email.email' => Lang::get('validation.models.user.email.email'),
            'email.unique' => Lang::get('validation.models.user.email.unique'),
        ];
        switch($options) {
            case 'register':
                $messages['password.required'] = Lang::get('validation.models.user.password.required');
                $messages['password.between'] = Lang::get('validation.models.user.password.between');

                $messages['confirm_password.required'] = Lang::get('validation.models.user.confirm_password.required');
                $messages['confirm_password.same'] = Lang::get('validation.models.user.confirm_password.same');
                break;
            case 'update':
                $messages['city.required'] = Lang::get('validation.models.user.city.required');
                $messages['city.between'] =  Lang::get('validation.models.user.city.between');
                $messages['state.required'] = Lang::get('validation.models.user.state.required');
                $messages['state.between'] = Lang::get('validation.models.user.state.between');
                $messages['address.required'] = Lang::get('validation.models.user.address.required');
                $messages['address.between'] = Lang::get('validation.models.user.address.between');
                $messages['address_alt'] = Lang::get('validation.models.user.address_alt.between');
                $messages['phone.required'] = Lang::get('validation.models.user.phone.required');
                $messages['phone.between'] = Lang::get('validation.models.user.phone.between');
                $messages['post.required'] = Lang::get('validation.models.user.post.required');
                $messages['post.between'] = Lang::get('validation.models.user.post.between');
                break;
            case 'change-password':
                unset($messages);
                $messages = [
                    'password.required' => Lang::get('validation.models.user.password.required'),
                    'password.between' => Lang::get('validation.models.user.password.between'),
                    'new_password.required' => Lang::get('validation.models.user.new_password.required'),
                    'new_password.between' => Lang::get('validation.models.user.new_password.between'),
                    'confirm_password.required' => Lang::get('validation.models.user.confirm_password.required'),
                    'confirm_password.same' => Lang::get('validation.models.user.confirm_password.same'),
                ];
                break;
        }

        if($key) return $messages[$key];
        return $messages;
    }

    public function full_name() {
        return $this -> first_name . ' ' . $this -> last_name;
    }

    public function edit($data) {
        $validator = Validator::make(
            $data,
            self::rules('update'),
            self::messages('update')
        );
        if($validator -> fails()) {
            return [
                'error' => [
                    'type' => 'validation',
                    'messages' => $validator
                ]
            ];
        }
        try {
            $user = Auth::user();
            $user -> first_name = $data['first_name'];
            $user -> last_name = $data['last_name'];
            $user -> email = $data['email'];
            $user -> city = $data['city'];
            $user -> state = $data['state'];
            $user -> address = $data['address'];
            $user -> address_alt = $data['address_alt'];
            $user -> phone = $data['phone'];
            $user -> post = $data['post'];
            $user -> save();
        } catch(\Exception $exception) {
            return [
                'error' => [
                    'type' => 'saving',
                    'message' => $exception -> getMessage(),
                    'trace' => $exception -> getTraceAsString()
                ]
            ];
        }

        return [
            'error' => [
                'type' => 'no'
            ],
            'success' => [
                'message' => 'You are registered successfully.',
                'data' => $user
            ]
        ];
    }

    public function changePassword($data) {
        $validator = Validator::make(
            $data,
            self::rules('change-password'),
            self::messages('change-password')
        );
        if($validator -> fails()) {
            return [
                'error' => [
                    'type' => 'validation',
                    'messages' => $validator
                ]
            ];
        }
        if(!Hash::check($data['password'], Auth::user() -> password)) {
            $validator -> errors() -> add('password', 'Password is incorrect!');
            return [
                'error' => [
                    'type' => 'password',
                    'messages' => $validator
                ]
            ];
        }
        try {
            $user = Auth::user();
            $user -> password = Hash::make($data['new_password']);
            $user -> save();
        } catch(\Exception $exception) {
            return [
                'error' => [
                    'type' => 'saving',
                    'message' => $exception -> getMessage(),
                    'trace' => $exception -> getTraceAsString()
                ]
            ];
        }
        return [
            'error' => [
                'type' => 'no'
            ],
            'success' => [
                'message' => 'Your password has been changed successfully',
            ],
        ];
    }

    public static function login($data) {
        if(!Auth::attempt(array('email' => $data['email'], 'password' => $data['password']), isset($data['remember']))) {
            return [
                'error' => [
                    'type' => 'invalid',
                    'message' => Lang::get('auth.failed')
                ]
            ];
        }

        return [
            'error' => [
                'type' => 'no'
            ],
            'success' => [
                'message' => Lang::get('auth.completed')
            ]
        ];
    }

    public function logout() {
        try {
            Auth::logout();
        } catch(\Exception $exception) {
            return [
                'error' => [
                    'type' => 'logout',
                    'message' => $exception -> getMessage(),
                    'trace' => $exception -> getTraceAsString()
                ]
            ];
        }

        return [
            'error' => [
                'type' => 'no',
            ],
            'success' => [
                'message' => 'You has been logged out.'
            ]
        ];
    }

    public static function register($data) {
        $validator = Validator::make(
            $data,
            self::rules('register'),
            self::messages('register')
        );
        if($validator -> fails()) {
            return [
                'error' => [
                    'type' => 'validation',
                    'messages' => $validator
                ]
            ];
        }
        try {
            $user = new User();
            $user -> first_name = $data['first_name'];
            $user -> last_name = $data['last_name'];
            $user -> email = $data['email'];
            $user -> password = Hash::make($data['password']);
            $user -> save();
        } catch(\Exception $exception) {
            return [
                'error' => [
                    'type' => 'saving',
                    'message' => $exception -> getMessage(),
                    'trace' => $exception -> getTraceAsString()
                ]
            ];
        }

        return [
            'error' => [
                'type' => 'no'
            ],
            'success' => [
                'message' => 'You are registered successfully.',
                'data' => $user
            ]
        ];
    }
}
