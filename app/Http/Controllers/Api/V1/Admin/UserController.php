<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\checkPermissions;
use App\Http\Requests\doChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Category;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(checkPermissions::class.":view-role")->only(['index']);

        $this->middleware(checkPermissions::class.":update-role")->only(['update']);
        $this->middleware(checkPermissions::class.":delete-role")->only(['delete']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return Response()->json([
            'users' => User::all()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function store(StoreUserRequest $request): ?\Illuminate\Http\JsonResponse
    {

        $user = User::query()->create([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'username' => $request->get('username'),
            'mobile' => $request->get('mobile'),
            'password' => bcrypt($request->get('password')),
            'email' => $request->get('email'),
            'role_id' => 2,
            'mobile_verify' => 0,
        ]);

        $token = $user->createToken($user->username)->plainTextToken;

        return Response()->json([
            'massage' => 'تبریک، شما با موفقیت ثبت نام شدید',
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Display the specified resource.
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(): \Illuminate\Http\JsonResponse
    {
        if (!auth()->check()) {
            return Response()->json([
                'massage' => 'کاربر وارد نشده است'
            ], 401);
        }
        return Response()->json([
            'user' => auth()->user(),
        ], 200);

    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {


        $user = User::query()->where('mobile', $request->get('mobile'))->firstOrFail();

        if (!Hash::check($request->get('password'), $user->password)) {
            return Response()->json([
                'massage' => 'رمز وارد شده اشتباه است'
            ], 401);
        }

        $token = $user->createToken($user->username)->plainTextToken;

        return Response()->json([
            'massage' => 'شما با موفقیت وارد شدید',
            'user' => $user,
            'token' => $token
        ], 200);

    }


    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->user()->tokens()->delete();

        return Response()->json([
            'massage' => 'شما از اکانت خود خارج شدید',
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\user $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, user $user): \Illuminate\Http\JsonResponse
    {
        //check for unique username
        $usernameExist = User::query()->where('username', $request->get('username'))
            ->where('id', '!=', $user->id)->exists();

        if ($usernameExist) {
            return Response()->json([
                'error' => 'این نام کاربری اکنون وچود دارد'
            ], 400);
        }

        //check for unique mobile
        $mobileExist = User::query()->where('mobile', $request->get('mobile'))
            ->where('id', '!=', $user->id)->exists();

        if ($mobileExist) {
            return Response()->json([
                'error' => 'این شماره تلقن اکنون وچود دارد'
            ], 400);
        }

        //check for unique email
        $emailExist = User::query()->where('email', $request->get('email'))
            ->where('id', '!=', $user->id)->exists();

        if ($emailExist) {
            return Response()->json([
                'error' => 'این ایمیل اکنون وچود دارد'
            ], 400);
        }


        $code_meli = $request->get('code_meli');
        if ($code_meli){
            //check for unique code_meli
            $code_meliExist = User::query()->where('code_meli', $request->get('code_meli'))
                ->where('id', '!=', $user->id)->exists();

            if ($code_meliExist) {
                return Response()->json([
                    'error' => 'این کد ملی اکنون وچود دارد'
                ], 400);
            }
        }

        $card_number = $request->get('card_number');
        if ($card_number){
            //check for unique card_number
            $card_numberExist = User::query()->where('card_number', $request->get('card_number'))
                ->where('id', '!=', $user->id)->exists();

            if ($card_numberExist) {
                return Response()->json([
                    'error' => 'این شماره کارت اکنون وچود دارد'
                ], 400);
            }
        }


        $user->update([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'username' => $request->get('username'),
            'mobile' => $request->get('mobile'),
            'password' => bcrypt($request->get('password')),
            'email' => $request->get('email'),
            'role_id' => $request->get('role_id'),
            'code_meli' => $request->get('code_meli'),
            'card_number' => $request->get('card_number'),
        ]);

        return Response()->json([
            'massage' => 'به روزرسانی با موفقیت انجام شد',
        ], 200);

    }


    public function changePassword(ChangePasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        $password = $user->password;
        if (!Hash::check($request->get('last_password'), $password)){
            return Response()->json([
                'massage' => 'رمز قبلی وارد شده اشتباه است',
            ],401);
        }

        $user->update([
            'password' => bcrypt($request->get('new_password'))
        ]);

        return Response()->json([
            'massage' => 'رمز شما با موفقیت تغییر پیدا کرد'
        ],200);

    }

    public function getUser(User $user): \Illuminate\Http\JsonResponse
    {

        return Response()->json($user, 200);

    }

    public function doChangePassword(doChangePasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::query()->where('mobile', $request->get('mobile'));

        $user->update([
            'password' => bcrypt($request->get('new_password'))
        ]);

        return Response()->json([
            'massage' => 'رمز شما با موفقیت تغییر پیدا کرد'
        ],200);

    }


}
