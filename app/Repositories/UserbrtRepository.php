<?php

namespace App\Repositories;

use App\Models\Userbrt;
use App\Repositories\BaseRepository;
use Str;
use Illuminate\Support\Facades\Validator;

class UserbrtRepository extends BaseRepository
{
    const CODE_LENGTH = 10;

    protected $fieldSearchable = [
        
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Userbrt::class;
    }

    public function createBrt($request)
    {
        $user = auth()->user();
        $uniqueCode = $this->generateUniqueCode($user->id);
        $userbrt = Userbrt::create([
            'user_id' => $user->id,
            'brt_code' => $uniqueCode,
            'reserved_amount' => $request->reserved_amount,
        ]);
        return ['data' => [], 'message' => "User brt detail updated successfuly", 'status' => true];
    }

    public function getone($id){
        $user = auth()->user();
        $userbrt = Userbrt::where('id', $id)->where('user_id', $user->id)->first();
        if(empty($userbrt)) 
        {
           return ['data' => [], 'message' => "User brt detail not found", 'status' => false];
        }
        return ['data' => $userbrt, 'message' => "User brt detail updated successfuly", 'status' => true];
    }

    public function getall() {
        $user = auth()->user();
        $userbrt = Userbrt::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return ['data' => $userbrt, 'message' => "User brt detail updated successfuly", 'status' => true];
    }

    public function update($request, $id) {
        $validator = Validator::make($request->all(), [
            'reserved_amount' => 'required|numeric|between:0,99999999.99',
            'status' => 'required|string|in:active,pending, expired'
        ]);

        if ($validator->fails()) {
            return ['data' => [], 'message' => $validator->errors(), 'status' => false];
        }
        $user = auth()->user();
        $userbrt = Userbrt::where('id', $id)->where('user_id', $user->id)->first();
        if(empty($userbrt)) 
        {
           return ['data' => [], 'message' => "User brt detail not found", 'status' => false];
        }
        $user = Userbrt::where('id', $id)->where('user_id', $user->id)->update([
            'reserved_amount' => $request->reserved_amount,
            'status' => $request->status
        ]);

        return ['data' => [], 'message' => "User brt detail updated successfuly", 'status' => true];
    }

    public function destroy($id) {
        $user = auth()->user();
        $userbrt = Userbrt::where('id', $id)->where('user_id', $user->id)->first();
        if(empty($userbrt)) 
        {
            return ['data' => [], 'message' => "User brt detail not found", 'status' => false];
        }
        Userbrt::where('id', $id)->delete();
        return ['data' => [], 'message' => "User brt detail deleted successfuly", 'status' => true];
    }

    

    public function generateUniqueCode($user_id)
    {
        $attempts = 0;
        do {
            $code = $this->generateRandomCode();
            $exists = $this->codeExists($code, $user_id);
            $attempts++;
        } while ($exists && $attempts < 100);

        if ($attempts >= 100) {
            throw new \Exception('Unable to generate a unique code after multiple attempts.');
        }

        return $code;
    }

    private function generateRandomCode()
    {
        return Str::random(self::CODE_LENGTH);
    }

    private function codeExists($brt_code, $user_id)
    {
        return Userbrt::where('user_id', $user_id)->where('brt_code', $brt_code)->exists();
    }
}
