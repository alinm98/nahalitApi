<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\sendSmsRequest;
use App\Http\Requests\StoreSmsRequest;
use App\Http\Requests\UpdateSmsRequest;
use App\Http\Requests\verifySmsRequest;
use App\Models\Sms;
use Carbon\Carbon;
use Illuminate\Console\View\Components\Info;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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

        $mobileExist = Sms::query()->where('mobile', auth()->user()->mobile)->exists();
        if ($mobileExist){
            return Response()->json([
                'massage' => 'کد تایید قبلا ارسال شده است'
            ],403);
        }

        $code = rand(10000, 99999);

        Sms::query()->create([
            'mobile' => auth()->user()->mobile,
            'code' => bcrypt($code),
        ]);


        return Response()->json([
            'massage' => 'کد تایید ارسال شد. لطفا تا دو دقیقه دیگر کد تایید را وارد کنید.'
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
                'massage' => 'این کد تایید منقضی شده است. لطفا دوباره درخواست کد کنید.'
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
                'massage' => 'کد وارد شده شما اشتباه است'
            ],403);
        }

    }
}