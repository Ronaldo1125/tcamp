<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Profile;
use App\Models\Division;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileController extends Controller
{
    public function index()
    {
        $current_userid = Auth()->user()->id;
        $userinfo = User::where('id','=',$current_userid)->first();
        $userprofile = Profile::where('user_id','=',$current_userid)->first();
        //dd($userinfo->division->division_name);

        return view('profiles.index',compact('userprofile','userinfo'));
    }

    public function create()
    {
        return view('profiles.create');
    }

    public function adminApproval()
    {
        return view('profiles.admin_approval');
    }

    public function update(ProfileUpdateRequest $request)
    {
        $request->validated();

        $user = User::find($request->id);

        //add the image
        if($request->hasFile('esignature_filename')) 
        {
            $newImageName = time() . '-' . trim(str_replace(' ', '', str_replace('.', '', $user->name))) . '.' . $request->esignature_filename->extension();
            $request->esignature_filename->move(public_path('esignature_image'), $newImageName);
        }

        //delete the previous image
        if(!is_null($user->esignature_filename)) 
        {
            $image_path = public_path('esignature_image/'.$user->esignature_filename);
            
            if(file_exists($image_path))
            {
                unlink($image_path);
            }
        }

        $user->update([
            'esignature_filename' => $newImageName,
        ]);

        //dd($request);
   
        toast('User updated successfully!','success');

        return redirect()->route('home');

    }

    public function changePassword()
    {
        $user = User::find(auth()->user()->id);

        return view('profiles.change_password', compact('user'));
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        $request->validated();

        $user = User::find($request->id);

        if(Hash::check($request->current_password, $user->password))
        {
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            toast('Password updated successfully!','success');
        } else {
            toast('Old password does not match.','error');
        }
        
        return redirect()->back();
        
    }

    public function updatePic(Request $request)
    {
        if($request->hasFile('avatar'))
        {
            $manager = new ImageManager(new Driver());
            $avatar = $request->file('avatar');
            $userid = $request['user_id'];
            $uploadedfile = time() . $avatar->getClientOriginalName();
            $img = $manager->read($avatar);
            $img = $img->resize(300,300);

            $img->toJpeg(80)->save(public_path('images/' . $uploadedfile));
            
            $user = Profile::where('user_id','=',$userid)->first();
            $user->picture =$uploadedfile;
            $user->save();

            toast('User Profile Picture updated successfully!','success');

        }
        return redirect()->route('profiles.index');
    }

    public function updateInfo(ProfileUpdateRequest $request)
    {
        $request->validated();
        
        $newmobile = $request['mobile_no']; 
        $newaddress = $request['address'];  
        $userid = $request['user_id'];

        if($request->hasFile('esignature'))
        {
            $manager = new ImageManager(new Driver());
            $esignature = $request->file('esignature');
            $uploadedfile = time() . $esignature->getClientOriginalName();
            $img = $manager->read($esignature);
            $img = $img->resize(450,300);
            $img->save(public_path('images/' . $uploadedfile));

        }

        $userinfo = Profile::where('user_id','=',$userid)->first();
        $userinfo->mobile_no = $newmobile;
        $userinfo->address = $newaddress;
        $userinfo->esignature = $uploadedfile;
        $userinfo->save();

        toast('User Profile Data updated successfully!','success');

        return redirect()->route('profiles.index');
    }
}
