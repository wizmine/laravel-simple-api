<?php

namespace App\Services;

use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function __construct()
    {
        \Tinify\setKey(env('TINIFY_API_KEY'));
    }

    private User $user;

    public function index(int $offset = 0, int $limit = null): Collection
    {
        $query = User::with('position');

        if ($limit) {
            return $query->skip($offset)->take($limit)->get();
        } else {
            return $query->get();
        }
    }

    public function store(StoreUserRequest $request): User
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $source = \Tinify\fromFile($request->file('photo')->getRealPath())->resize([
            "method" => "cover",
            "width" => 70,
            "height" => 70,
        ]);
        
        $optimizedPath = 'public/optimized_' . $request->file('photo')->hashName();
        $source->toFile(Storage::path($optimizedPath));
        $imagePath = config('app.url') . ':8000' . Storage::url($optimizedPath);

        $imagePath = Storage::url($optimizedPath);
        $fullImageUrl = url($imagePath);

        /** @var User $user */
        $user = User::create([
            'name' => $request->str('name'),
            'email' => $email,
            'password' => $password,
            'phone' => $request->str('phone'),
            'position_id' => $request->integer('position_id'),
            'photo' => $fullImageUrl,
        ]);
        /** @var \Laravel\Sanctum\NewAccessToken $token */
        $token = $user->createToken('signup');

        $user->update(['api_token' => $token]);

        return $user;
    }
}
