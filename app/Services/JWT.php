<?php

namespace App\Services;

use DB;
use Carbon\Carbon;
use App\Repositories\Facades\Users;
use Firebase\JWT\JWT as JWTBase;

class JWT
{
    protected $user;

    protected $key;

    private $tokenInfo;

    public function __construct()
    {
        $this->key = config('jwt.secret');
    }

    public function encode(array $data)
    {
        return JWTBase::encode($data, $this->key);
    }

    // if token is invalid or expired, it can not be decoded
    public function decode($token)
    {
        try {
            return JWTBASE::decode($token, $this->key, ['HS256']);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function generate($id, $updatedAt)
    {
        $now = Carbon::now()->timestamp;
        $rfa = Carbon::now()->addDay(8)->timestamp;
        $exp = Carbon::now()->addDay(10)->timestamp;

        $data = [
            'sub' => $id,
            'aud' => 'DataPlanner',
            'upd' => $updatedAt,
            'iat' => $now,
            'exp' => $exp,
            'rfa' => $rfa
        ];

        return $this->encode($data);
    }
    
    public function parseToken()
    {
        $this->tokenInfo = $this->decode(
            substr(request()->header('authorization'), 7)
        );

        if ($this->tokenInfo) return true;
        else return false;
    }

    // 利用 token 检查用户信息是否已更新
    public function isUpdated()
    {
        $upd = $this->user()->updated_at;
        $upd = Carbon::parse($upd)->timestamp;

        return $upd !== $this->tokenInfo->upd;
    }

    public function isRefresh()
    {
        $now = Carbon::now()->timestamp;

        return $now > $this->tokenInfo->rfa;
    }

    public function refresh()
    {
        $id = $this->tokenInfo->sub;
        $upd = $this->user($id)->updated_at;
        $upd = Carbon::parse($upd)->timestamp;
        return $this->generate($id, $upd);
    }

    public function user($id = false)
    {
        if (!$this->user) {
            if ($id === false) $id = $this->tokenInfo->sub;
            $user = Users::find($id);
            // 将 [{"id": 1, "name": "master"}] 转为 {"master": true} 格式
            $roles = [];

            foreach ($user->roles as $role) {
                $roles[$role['name']] = true;
            }

            $this->user = (object)[
                'id' => $user->id,
                'username' => $user->username,
                'roles' => $roles,
                'updated_at' => $user->updated_at
            ];
        }

        return $this->user;
    }
}
