<?php

namespace App\Http\Controllers\Web\Backend\Settings;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Container\Attributes\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $data['user']  = auth()->user();
        $data['profile'] = $data['user'];
        return view("backend.layout.settings.profile", $data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "phone" => "nullable|string",
            "address" => "nullable|string",
        ]);
        $user = User::find(auth()->user()->id);
        $user->update($request->only('name'));

        $user->update($request->only(['address', 'phone']));

        return redirect()->back()->with('t-success', 'profile updated successfully');
    }

    public function avatar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'avatar' => 'required|mimes:png,jpg,jpeg,ico|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors'  => $validator->errors(),
                ], 422);
            }
            if ($request->hasFile('avatar')) {

                // Use the old fileUpload function here
                $path = fileUpload_old($request->file('avatar'), 'avatars/', 'user-avatar');

                $user = User::find(auth()->user()->id);
                if ($user->avatar) {
                    fileDelete($user->avatar);
                }

                if ($path !== null) {
                    $user->avatar = $path;
                }
                $user->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Avatar Uploaded successfully',
                'url' => asset($user->avatar)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function banner(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'banner' => 'required|mimes:png,jpg,jpeg,ico|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors'  => $validator->errors(),
                ], 422);
            }
            if ($request->hasFile('banner')) {

                $path = fileUpload_old($request->file('banner'), 'banners/', 'banners');
                $user = User::find(auth()->user()->id);

                if ($user->banner) {
                    fileDelete($user->banner);
                }

                if ($path !== null) {
                    $user->banner = $path;
                }
                $user->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Banner Uploaded successfully',
                'url' => asset($user->banner)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
