<?php

namespace App\Http\Controllers\Secure;

use App\Helpers\Thumbnail;
use App\Http\Requests\Auth\ProfileChangeRequest;
use App\Models\CertificateUser;
use App\Models\User;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Sentinel;
use Session;

class ProfileController extends SecureController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Profile page.
     *
     * @return Redirect
     */
    public function getProfile()
    {
        if (!Sentinel::check()) {
            return redirect("/");
        }
        $student_id = session('current_student_id');
        view()->share('current_student_id', $student_id);

        $title = trans('auth.user_profile');
        $user = User::find(Sentinel::getUser()->id);
        return view('profile', compact('title', 'user'));
    }

    public function getAccount()
    {
        if (!Sentinel::check()) {
            return redirect("/");
        }
        $student_id = session('current_student_id');
        view()->share('current_student_id', $student_id);
        $title = trans('auth.edit_profile');
        $user = User::find(Sentinel::getUser()->id);
        return view('account', compact('title', 'user'));
    }

    public function postAccount(ProfileChangeRequest $request)
    {
        $user = User::find(Sentinel::getUser()->id);
        if ($request->hasFile('user_avatar_file') != "") {
            $file = $request->file('user_avatar_file');
            $extension = $file->getClientOriginalExtension();
            $picture = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/avatar/';
            $file->move($destinationPath, $picture);
            Thumbnail::generate_image_thumbnail($destinationPath . $picture, $destinationPath . 'thumb_' . $picture);
            $user->picture = $picture;
            $user->save();
        }
        if ($request->get('password') != "") {
            $user->password = bcrypt($request->get('password'));
            $user->save();
        }
        $user->update($request->except('user_avatar_file', 'password', 'password_confirmation'));

        Flash::success(trans('auth.successfully_change_profile'));
        return redirect('profile');
    }

    public function postWebcam(Request $request)
    {
        $user = User::find(Sentinel::getUser()->id);
        if (isset($request['photo_url'])) {
            $output_file = uniqid() . ".jpg";
            $ifp = fopen(public_path() . '/uploads/avatar/' . $output_file, "wb");
            $data = explode(',', $request['photo_url']);
            fwrite($ifp, base64_decode($data[1]));
            fclose($ifp);
            $user->picture = $output_file;
        }
        $user->update($request->except('photo_url', 'password', 'password_confirmation'));
    }

    public function getCertificate()
    {
        if (!Sentinel::check()) {
            return redirect("/");
        }
        $user = User::find(Sentinel::getUser()->id);
        $certificates = CertificateUser::join('certificates', 'certificates.id', '=', 'certificate_user.certificate_id')
            ->whereNull('certificate_user.deleted_at')
            ->where('user_id', $user->id)
            ->select('certificates.*')->get();
        $title = trans('auth.my_certificate');

        $student_id = session('current_student_id');
        view()->share('current_student_id', $student_id);

        return view('certificate', compact('title', 'certificates', 'user'));
    }

    public function loginAsUser(Request $request, User $user)
    {
        if (Sentinel::getUser()->inRole('super_admin')) {
            session(['was_super_admin' => Sentinel::getUser()->id]);
        } else if (Sentinel::getUser()->inRole('admin')) {
            session(['was_admin' => Sentinel::getUser()->id]);
        } else if (Sentinel::getUser()->inRole('admin_super_admin')) {
            session(['was_admin_super_admin' => Sentinel::getUser()->id]);
        } else {
            return back();
        }

        $user = Sentinel::findById($user->id);
        Sentinel::login($user);

        return redirect("/");
    }

    public function backToSuperAdmin(Request $request)
    {
        if (!is_null(session('was_super_admin'))) {
            $user = Sentinel::findById(session('was_super_admin'));
            Sentinel::login($user);
        }

        return redirect("/");
    }

    public function backToAdmin(Request $request)
    {
        if (!is_null(session('was_admin'))) {
            $user = Sentinel::findById(session('was_admin'));
            Sentinel::login($user);
        }

        return redirect("/");
    }

    public function backToAdminSuperAdmin(Request $request)
    {
        if (!is_null(session('was_admin_super_admin'))) {
            $user = Sentinel::findById(session('was_admin_super_admin'));
            Sentinel::login($user);
        }

        return redirect("/");
    }

    public function setYear($id)
    {
        session(['current_school_year' => $id]);
        return redirect('/');
    }

    public function setSemester($id)
    {
        session(['current_school_semester' => $id]);
        return redirect('/');
    }

    public function setSchool($id)
    {
        session(['current_school' => $id]);
        return redirect('/');
    }

    public function setGroup($id)
    {
        session(['current_student_group' => $id]);
        return redirect('/');
    }

    public function setStudent($id)
    {
        session(['current_student_id' => $id]);
        return redirect('/');
    }

    public function changeLang($lang)
    {
        if (array_key_exists($lang, config('languages'))) {
            session(['applocale' => $lang]);
        }
        return redirect()->back();
    }
}