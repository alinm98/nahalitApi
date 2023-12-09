<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\sendSmsRequest;
use App\Http\Requests\StoreSmsRequest;
use App\Http\Requests\UpdateSmsRequest;
use App\Http\Requests\verifySmsRequest;
use App\Models\Sms;
use App\Models\User;
use Carbon\Carbon;

use http\Env\Response;
use Illuminate\Console\View\Components\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use IPPanel\Client;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSmsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSmsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sms  $sms
     * @return \Illuminate\Http\Response
     */
    public function show(Sms $sms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sms  $sms
     * @return \Illuminate\Http\Response
     */
    public function edit(Sms $sms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSmsRequest  $request
     * @param  \App\Models\Sms  $sms
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSmsRequest $request, Sms $sms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sms  $sms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sms $sms)
    {
        //
    }




    public function sendSms(): \Illuminate\Http\JsonResponse
    {
        if (auth()->user()->mobile_verify == 1){
            return Response()->json([
                'massage' => 'شماره شما قبلا تایید شده است'
            ],401);
        }


        $mobileExist = Sms::query()->where('mobile', auth()->user()->mobile)->exists();
        if ($mobileExist){
            $sms = Sms::query()->where('mobile', auth()->user()->mobile)->firstOrFail();
            if (date_diff($sms->created_at, Carbon::now())->i > 1){
                $sms->delete();
            }
            else {
                return Response()->json([
                    'massage' => 'کد تایید ارسال شده است . برای درخواست کد جدید لطفا تا دو دقیقه صبر کنید'
                ], 403);
            }
        }



        $apiKey = 'r36IPCYj0c_S2W2a3n4LzvxOjugs_9EgMfjzDKGYO-c=';
        $client = new Client($apiKey);

        $code = rand(10000, 99999);
        /*$massage = auth()->user()->first_name . " " . auth()->user()->last_name . " عزیز،\n خوش آمدید. کد تایید شما :\n" .
            $code . "\nشرکت نهال ای تی";*/

        $mobile = auth()->user()->mobile;

        //send with pattern
        $value = [
            'code' => $code
        ];
        $massageID = $client->sendPattern(
            'fzosmal7lxz7o3l',
            '3000505',
            $mobile,
            $value
        );
        //end send with pattern

        //send with Send one to many
        /*$massageID = $client->send(
            '3000505',
            ['989938860644'],
            $massage,
            ''
        );*/
        //end send with Send one to many


        Sms::query()->create([
            'mobile' => auth()->user()->mobile,
            'code' => bcrypt($code),

        ]);


        return Response()->json([
            'massage' => 'کد تایید ارسال شد. لطفا تا دو دقیقه دیگر کد تایید را وارد کنید.',
        ], 201);

    }

    public function verify(verifySmsRequest $request): \Illuminate\Http\JsonResponse
    {
        $mobileExist = Sms::query()->where('mobile',auth()->user()->mobile)->exists();
        if (!$mobileExist){
            return Response()->json([
                'massage' => 'کد تایید برای این شماره ارسال نشده است'
            ],403);
        }


        $sms = Sms::query()->where('mobile',auth()->user()->mobile)->firstOrFail();
        if (date_diff($sms->created_at, Carbon::now())->i > 1){
            $sms->delete();
            return Response()->json([
                'massage' => 'کد تایید منقضی شده است. لطفا دوباره درخواست کد کنید.'
            ],403);
        }
        $user = auth()->user();

        if (Hash::check($request->get('code'),$sms->code)){
            $user->update([
                'mobile_verify' => 1
            ]);
            $sms->delete();

            return Response()->json([
                'massage' => 'شماره تلفن شما با موفقیت تایید شد'
            ],200);

        }
        else{
            return Response()->json([
                'massage' => 'کد وارد شده اشتباه است'
            ],403);
        }

    }



    public function oneTimeCode(Request $request): \Illuminate\Http\JsonResponse
    {
        $mobile = $request->get('mobile');

        $userExists = User::query()->where('mobile', $mobile)->exists();
        if (!$userExists){
            return response()->json([
                'massage' => 'کاربری با این شماره وجود ندارد'
            ],'403');
        }

        $user = User::query()->where('mobile', $mobile)->firstOrFail()->toArray();

        $mobileExist = Sms::query()->where('mobile', $user['mobile'])->exists();
        if ($mobileExist){
            $sms = Sms::query()->where('mobile', $user['mobile'])->firstOrFail();
            if (date_diff($sms->created_at, Carbon::now())->i > 1){
                $sms->delete();
            }
            else {
                return Response()->json([
                    'massage' => 'کد یکبار مصرف ارسال شده است . برای درخواست کد جدید لطفا تا دو دقیقه صبر کنید'
                ], 403);
            }
        }

        $apiKey = 'r36IPCYj0c_S2W2a3n4LzvxOjugs_9EgMfjzDKGYO-c=';
        $client = new Client($apiKey);

        $code = rand(10000, 99999);

        $mobile = $user['mobile'];

        //send with pattern
        $value = [
            'code' => $code
        ];
        $massageID = $client->sendPattern(
            '6jn13rj19p0hid5',
            '3000505',
            $mobile,
            $value
        );

        Sms::query()->create([
            'mobile' => auth()->user()->mobile,
            'code' => bcrypt($code),

        ]);

        return Response()->json([
            'massage' => 'کد یکبار مصرف ارسال شد. لطفا تا دو دقیقه دیگر کد تایید را وارد کنید.',
        ], 201);
    }


    public function verifyOneTimeCode(Request $request): \Illuminate\Http\JsonResponse
    {
        $mobile = $request->get('mobile');
        $code = $request->get('code');

        $mobileExist = Sms::query()->where('mobile',$mobile)->exists();
        if (!$mobileExist){
            return Response()->json([
                'massage' => 'کد یکبار مصرف برای این شماره ارسال نشده است'
            ],403);
        }


        $sms = Sms::query()->where('mobile',$mobile)->firstOrFail();
        if (date_diff($sms->created_at, Carbon::now())->i > 1){
            $sms->delete();
            return Response()->json([
                'massage' => 'کد یکبار مصرف منقضی شده است. لطفا دوباره درخواست کد کنید.'
            ],403);
        }
        $user = User::query()->where('mobile', $mobile)->firstOrFail();

        if (Hash::check($request->get('code'),$sms->code)){
            $token = $user->createToken($user->username)->plainTextToken;
            $sms->delete();

            return Response()->json([
                'massage' => 'شما با موفقیت وارد شدید',
                'user' => $user,
                'token' => $token
            ], 200);

        }
        else{
            return Response()->json([
                'massage' => 'کد وارد شده اشتباه است'
            ],403);
        }
    }

    public function verifyResetPassword(Request $request): \Illuminate\Http\JsonResponse
    {
        $mobile = $request->get('mobile');
        $code = $request->get('code');

        $mobileExist = Sms::query()->where('mobile',$mobile)->exists();
        if (!$mobileExist){
            return Response()->json([
                'massage' => 'کد تایید برای این شماره ارسال نشده است'
            ],403);
        }


        $sms = Sms::query()->where('mobile',$mobile)->firstOrFail();
        if (date_diff($sms->created_at, Carbon::now())->i > 1){
            $sms->delete();
            return Response()->json([
                'massage' => 'کد تایید منقضی شده است. لطفا دوباره درخواست کد کنید.'
            ],403);
        }
        $user = User::query()->where('mobile', $mobile)->firstOrFail();

        if (Hash::check($code,$sms->code)){
            $sms->delete();

            return Response()->json([
                'massage' => 'کد وارد شده درست است',
                'result' => true
            ], 200);

        }
        else{
            return Response()->json([
                'massage' => 'کد وارد شده اشتباه است',
                'result' => false
            ],403);
        }
    }





}
