<?php

namespace App\Http\Controllers;

use App\admin;
use App\news;
use App\announcement;
use App\missing;
use App\police;
use App\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\Emails;
use Illuminate\Support\Facades\Mail;
use Validator;
use DateTime;
use Image;

class home extends Controller
{
    public function itexmo($number, $message, $apicode)
    {
        $url = 'https://www.itexmo.com/php_api/api.php';
        $itexmo = array('1' => $number, '2' => $message, '3' => "ST-GORDS124629_SX6A4");
        $param = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($itexmo),
            ),
        );
        $context = stream_context_create($param);
        return file_get_contents($url, false, $context);
    }

    public function register(Request $request)
    {
        if (session('id') != null) {
            return redirect('/');
        }

        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:250',
            'mname' => 'max:250',
            'lname' => 'required|string|max:250',
            'gender' => 'required|alpha|max:6',
            'birthday' => 'required',
            'connum' => 'required|digits:11',
            'address' => 'required|string|max:250',
            'city' => 'required|string|max:50',

            'email' => 'required|email|unique:users,User_email|unique:admins,Admin_email|unique:polices,Police_email|max:250',
            'password' => 'required|min:6|max:50',
            'repass' => 'required|max:50|same:password',

            'dp' => 'required|image',
            'vi1' => 'required|image',
        ]);

        if ($validator->fails()) {

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }

        $token = $request->input('g-recaptcha-response');
        if (!(strlen($token) > 0)) {
            return redirect()->back()->withErrors(['recaptcha' => 'recaptcha'])->withInput($request->input());
        }


        $date = new DateTime($request->birthday);
        $now = new DateTime();
        $interval = $now->diff($date);

        if ($interval->y < 18) {
            return redirect()->back()->withErrors(['bday' => 'bday'])->withInput($request->input());
        }

        //inserting data
        $filename = date('mdyhi') . time() . '.' . $request->file('dp')->getClientOriginalExtension();
        $user = new user;
        $user->User_fname = ucwords(trim(strip_tags(htmlspecialchars($request->fname))));
        $user->User_mname = ucwords(trim(strip_tags(htmlspecialchars($request->mname))));
        $user->User_lname = ucwords(trim(strip_tags(htmlspecialchars($request->lname))));

        $user->User_gender = ucfirst(trim(strip_tags(htmlspecialchars($request->gender))));
        $user->User_bday = trim(strip_tags(htmlspecialchars($request->birthday)));
        $user->User_address = ucwords(trim(strip_tags(htmlspecialchars($request->address))));
        $user->User_city = ucwords(trim(strip_tags(htmlspecialchars($request->city))));

        $user->User_email = trim(strip_tags(htmlspecialchars($request->email)));
        $user->User_password = bcrypt(trim(strip_tags(htmlspecialchars($request->password))));
        $user->User_mobilenum = trim(strip_tags(htmlspecialchars($request->connum)));

        $user->User_picture = $filename;
        $user->User_valId1 = $filename;

        //email
        $name = $user->User_fname . ' ' . $user->User_lname;
        $body = 'Thank you for registering at HANAP. Your account will be verified first before it can be use. Please wait for the verification.';
        $subject = 'Account Verification';

        Mail::to($user->User_email)->send(new Emails($subject, $body, $name));

        //text
        $result = $this->itexmo($user->User_mobilenum, "Thank you for registering at HANAP. Your account will be verified first before it can be use. Please wait for the verification.", "ST-ANTON124629_M8INX");

        if ($result == "") {
            echo "something went wrong please try it again";
            die();
        } else if ($result == 0) {

        } else {
            echo "something went wrong please try it again";
            die();
        }

        //image
        //original
        Image::make($request->file('dp'))
            ->save(public_path('images/dp/' . $filename), 100);

        Image::make($request->file('vi1'))
            ->save(public_path('images/vi1/' . $filename), 100);

        //thumbnail
        Image::make($request->file('dp'))->resize(null, 400, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('images/dpthumb/' . $filename), 100);

        Image::make($request->file('vi1'))->resize(null, 400, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('images/vi1thumb/' . $filename), 100);

        $user->save();

        return redirect('/');
    }

    public function login(Request $request)
    {
        if (session('id') != null) {
            return redirect('/');
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:250',
            'password' => 'required|string|max:250',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }

        $user = new user;
        $user = $user->where('User_email', '=', trim(strip_tags(htmlspecialchars($request->email))))->first();

        $admin = new admin;
        $admin = $admin->where('Admin_email', '=', trim(strip_tags(htmlspecialchars($request->email))))->first();

        $police = new police;
        $police = $police->where('Police_email', '=', trim(strip_tags(htmlspecialchars($request->email))))->first();

        if ($user == null) {

            if ($admin == null) {

                if ($police == null) {
                    return redirect()->back()->withErrors(['email' => 'not found'])->withInput($request->input());
                } elseif (!(Hash::check(strip_tags(trim(htmlspecialchars($request->password))), $police->Police_password))) {
                    return redirect()->back()->withErrors(['password' => 'wrong password'])->withInput($request->input());
                } elseif (Hash::check(strip_tags(trim(htmlspecialchars($request->password))), $police->Police_password)) {
                    $request->session()->put('id', $police->Police_id);
                    $request->session()->put('uname', $police->Police_email);
                    $request->session()->put('fname', $police->Police_Name);
                    $request->session()->put('lname', $police->Police_lname);
                    $request->session()->put('priv', 'police');
                    return redirect('/');
                }

            } elseif (!(Hash::check(strip_tags(trim(htmlspecialchars($request->password))), $admin->Admin_password))) {
                return redirect()->back()->withErrors(['password' => 'wrong password'])->withInput($request->input());
            } elseif (Hash::check(strip_tags(trim(htmlspecialchars($request->password))), $admin->Admin_password)) {
                $request->session()->put('id', $admin->Admin_id);
                $request->session()->put('uname', $admin->Admin_email);
                $request->session()->put('fname', $admin->Admin_Name);
                $request->session()->put('lname', $admin->Admin_lname);
                $request->session()->put('priv', 'admin');
                return redirect('/');
            }

        } elseif (!(Hash::check(strip_tags(trim(htmlspecialchars($request->password))), $user->User_password))) {
            return redirect()->back()->withErrors(['password' => 'wrong password'])->withInput($request->input());
        } elseif
        (Hash::check(strip_tags(trim(htmlspecialchars($request->password))), $user->User_password)) {

            if ($user->User_status == 0) {
                return redirect()
                    ->back()
                    ->withErrors(['notactive' => 'notactive']);
            }

            $request->session()->put('id', $user->User_id);
            $request->session()->put('uname', $user->User_email);
            $request->session()->put('fname', $user->User_fname);
            $request->session()->put('lname', $user->User_lname);
            $request->session()->put('priv', 'user');
            return redirect('/');
        }
    }

    public function home()
    {
        $users = new missing;
        $data['missings'] = $users->where('Missing_status', '=', '0')->inRandomOrder()->limit(9)->get();
        $users = new user;
        $data['users'] = $users->get();
        $users = new news;
        $data['news'] = $users->get();
        $users = new announcement;
        $data['announcements'] = $users->get();

        if (session('priv') == 'admin') {

            $users = new missing;
            $data['missings'] = $users->get();
            $data['report'] = $users->count();
            $data['found'] = $users->where('Missing_status', '=', '1')->count();
            $founds = $users->where('Missing_status', '=', '1')->get();
            $users = new user;
            $data['unverified'] = $users->where('User_status', '=', '0')->count();
            $users = new police;
            $data['police'] = $users->count();

            $data['age1'] = $data['age2'] = $data['age3'] =
            $data['age4'] = $data['age5'] = $data['age6'] =
            $data['male'] = $data['female'] =

            $data['fage1'] = $data['fage2'] = $data['fage3'] =
            $data['fage4'] = $data['fage5'] = $data['fage6'] =
            $data['fmale'] = $data['ffemale'] =

            $data['jan'] = $data['feb'] = $data['mar'] =
            $data['apr'] = $data['may'] = $data['jun'] =
            $data['jul'] = $data['aug'] = $data['sep'] =
            $data['oct'] = $data['nov'] = $data['dec'] =

            $data['fjan'] = $data['ffeb'] = $data['fmar'] =
            $data['fapr'] = $data['fmay'] = $data['fjun'] =
            $data['fjul'] = $data['faug'] = $data['fsep'] =
            $data['foct'] = $data['fnov'] = $data['fdec'] = 0;

            //missing
            foreach ($data['missings'] as $missing) {
                $date = new DateTime($missing->Missing_bday);
                $now = new DateTime();
                $interval = $now->diff($date);

                if ($interval->y < 11) {
                    $data['age1']++;
                } elseif ($interval->y < 21) {
                    $data['age2']++;
                } elseif ($interval->y < 31) {
                    $data['age3']++;
                } elseif ($interval->y < 41) {
                    $data['age4']++;
                } elseif ($interval->y < 51) {
                    $data['age5']++;
                } elseif ($interval->y > 51) {
                    $data['age6']++;
                }

                if ($missing->Missing_gender == 'Male') {
                    $data['male']++;
                } elseif ($missing->Missing_gender == 'Female') {
                    $data['female']++;
                }

                $date = date_create($missing->created_at);
                $date = date_format($date, 'm');

                if ($date == 01) {
                    $data['jan']++;
                } else if ($date == 02) {
                    $data['feb']++;
                } else if ($date == 03) {
                    $data['mar']++;
                } else if ($date == 04) {
                    $data['apr']++;
                } else if ($date == 05) {
                    $data['may']++;
                } else if ($date == 06) {
                    $data['jun']++;
                } else if ($date == 07) {
                    $data['jul']++;
                } else if ($date == '08') {
                    $data['aug']++;
                } else if ($date == '09') {
                    $data['sep']++;
                } else if ($date == 10) {
                    $data['oct']++;
                } else if ($date == 11) {
                    $data['nov']++;
                } else if ($date == 12) {
                    $data['dec']++;
                }

            }

            //found
            foreach ($founds as $found) {
                $date = new DateTime($found->Missing_bday);
                $now = new DateTime();
                $interval = $now->diff($date);

                if ($interval->y < 11) {
                    $data['fage1']++;
                } elseif ($interval->y < 21) {
                    $data['fage2']++;
                } elseif ($interval->y < 31) {
                    $data['fage3']++;
                } elseif ($interval->y < 41) {
                    $data['fage4']++;
                } elseif ($interval->y < 51) {
                    $data['fage5']++;
                } elseif ($interval->y > 51) {
                    $data['fage6']++;
                }

                if ($found->Missing_gender == 'Male') {
                    $data['fmale']++;
                } elseif ($found->Missing_gender == 'Female') {
                    $data['ffemale']++;
                }


                if ($found->Missing_foundate != null) {
                    $date = date_create($found->Missing_foundate);
                    $date = date_format($date, 'm');

                    if ($date == 01) {
                        $data['fjan']++;
                    } else if ($date == 02) {
                        $data['ffeb']++;
                    } else if ($date == 03) {
                        $data['fmar']++;
                    } else if ($date == 04) {
                        $data['fapr']++;
                    } else if ($date == 05) {
                        $data['fmay']++;
                    } else if ($date == 06) {
                        $data['fjun']++;
                    } else if ($date == 07) {
                        $data['fjul']++;
                    } else if ($date == '08') {
                        $data['faug']++;
                    } else if ($date == '09') {
                        $data['fsep']++;
                    } else if ($date == 10) {
                        $data['foct']++;
                    } else if ($date == 11) {
                        $data['fnov']++;
                    } else if ($date == 12) {
                        $data['fdec']++;
                    }
                }

            }

            return view('admin.home', $data);
        }
        if (session('priv') == 'police') {

            $users = new missing;
            $data['missings'] = $users->get();
            $data['report'] = $users->count();
            $data['found'] = $users->where('Missing_status', '=', '1')->count();
            $founds = $users->where('Missing_status', '=', '1')->get();

            $data['age1'] = $data['age2'] = $data['age3'] =
            $data['age4'] = $data['age5'] = $data['age6'] =
            $data['male'] = $data['female'] =

            $data['fage1'] = $data['fage2'] = $data['fage3'] =
            $data['fage4'] = $data['fage5'] = $data['fage6'] =
            $data['fmale'] = $data['ffemale'] =

            $data['jan'] = $data['feb'] = $data['mar'] =
            $data['apr'] = $data['may'] = $data['jun'] =
            $data['jul'] = $data['aug'] = $data['sep'] =
            $data['oct'] = $data['nov'] = $data['dec'] =

            $data['fjan'] = $data['ffeb'] = $data['fmar'] =
            $data['fapr'] = $data['fmay'] = $data['fjun'] =
            $data['fjul'] = $data['faug'] = $data['fsep'] =
            $data['foct'] = $data['fnov'] = $data['fdec'] = 0;

            //missing
            foreach ($data['missings'] as $missing) {
                $date = new DateTime($missing->Missing_bday);
                $now = new DateTime();
                $interval = $now->diff($date);

                if ($interval->y < 11) {
                    $data['age1']++;
                } elseif ($interval->y < 21) {
                    $data['age2']++;
                } elseif ($interval->y < 31) {
                    $data['age3']++;
                } elseif ($interval->y < 41) {
                    $data['age4']++;
                } elseif ($interval->y < 51) {
                    $data['age5']++;
                } elseif ($interval->y > 51) {
                    $data['age6']++;
                }

                if ($missing->Missing_gender == 'Male') {
                    $data['male']++;
                } elseif ($missing->Missing_gender == 'Female') {
                    $data['female']++;
                }

                $date = date_create($missing->created_at);
                $date = date_format($date, 'm');

                if ($date == 01) {
                    $data['jan']++;
                } else if ($date == 02) {
                    $data['feb']++;
                } else if ($date == 03) {
                    $data['mar']++;
                } else if ($date == 04) {
                    $data['apr']++;
                } else if ($date == 05) {
                    $data['may']++;
                } else if ($date == 06) {
                    $data['jun']++;
                } else if ($date == 07) {
                    $data['jul']++;
                } else if ($date == '08') {
                    $data['aug']++;
                } else if ($date == '09') {
                    $data['sep']++;
                } else if ($date == 10) {
                    $data['oct']++;
                } else if ($date == 11) {
                    $data['nov']++;
                } else if ($date == 12) {
                    $data['dec']++;
                }

            }

            //found
            foreach ($founds as $found) {
                $date = new DateTime($found->Missing_bday);
                $now = new DateTime();
                $interval = $now->diff($date);

                if ($interval->y < 11) {
                    $data['fage1']++;
                } elseif ($interval->y < 21) {
                    $data['fage2']++;
                } elseif ($interval->y < 31) {
                    $data['fage3']++;
                } elseif ($interval->y < 41) {
                    $data['fage4']++;
                } elseif ($interval->y < 51) {
                    $data['fage5']++;
                } elseif ($interval->y > 51) {
                    $data['fage6']++;
                }

                if ($found->Missing_gender == 'Male') {
                    $data['fmale']++;
                } elseif ($found->Missing_gender == 'Female') {
                    $data['ffemale']++;
                }


                if ($found->Missing_foundate != null) {
                    $date = date_create($found->Missing_foundate);
                    $date = date_format($date, 'm');

                    if ($date == 01) {
                        $data['fjan']++;
                    } else if ($date == 02) {
                        $data['ffeb']++;
                    } else if ($date == 03) {
                        $data['fmar']++;
                    } else if ($date == 04) {
                        $data['fapr']++;
                    } else if ($date == 05) {
                        $data['fmay']++;
                    } else if ($date == 06) {
                        $data['fjun']++;
                    } else if ($date == 07) {
                        $data['fjul']++;
                    } else if ($date == '08') {
                        $data['faug']++;
                    } else if ($date == '09') {
                        $data['fsep']++;
                    } else if ($date == 10) {
                        $data['foct']++;
                    } else if ($date == 11) {
                        $data['fnov']++;
                    } else if ($date == 12) {
                        $data['fdec']++;
                    }
                }

            }

            return view('police.home', $data);
        }

        return view('home.login', $data);
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|max:250'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }

        $users = new missing;
        $key = strip_tags(htmlspecialchars(trim($request->fname)));
        $searches = explode(' ', $key);
        $data['missings'] = array();
        $data['galleries'] = $users->where('Missing_status', '=', '0')->inRandomOrder()->limit(30)->get();

        foreach ($searches as $search) {

            $user = $users->where('Missing_gender', '=', $search)->get();
            foreach ($user as $use) {
                if ($use->Missing_status == 0) {
                    array_push($data['missings'], $use);
                }
            }

            $user = $users
                ->orwhere('Missing_fname', 'LIKE', "%" . $search . "%")
                ->orWhere('Missing_mname', 'LIKE', "%" . $search . "%")
                ->orWhere('Missing_lname', 'LIKE', "%" . $search . "%")
                ->orWhere('Missing_bday', 'LIKE', "%" . $search . "%")
                ->orwhere('Missing_hcolor', 'LIKE', "%" . $search . "%")
                ->orWhere('Missing_height', 'LIKE', "%" . $search . "%")
                ->orWhere('Missing_eyecolor', 'LIKE', "%" . $search . "%")
                ->orWhere('Missing_hair', 'LIKE', "%" . $search . "%")
                ->orWhere('Missing_weight', 'LIKE', "%" . $search . "%")
                ->orWhere('Missing_bodytype', 'LIKE', "%" . $search . "%")
                ->orWhere('Missing_bodyhair', 'LIKE', "%" . $search . "%")
                ->orWhere('Missing_facialhair', 'LIKE', "%" . $search . "%")
                ->orWhere('Missing_dodis', 'LIKE', "%" . $search . "%")
                ->orWhere('Missing_disaddress', 'LIKE', "%" . $search . "%")
                ->orWhere('Missing_discity', 'LIKE', "%" . $search . "%")
                ->orWhere('Missing_bodymarkings', 'LIKE', "%" . $search . "%")
                ->orWhere('Missing_clothes', 'LIKE', "%" . $search . "%")
                ->orWhere('Missing_other', 'LIKE', "%" . $search . "%")->get();

            foreach ($user as $use) {
                if ($use->Missing_status == 0) {
                    array_push($data['missings'], $use);
                }
            }
        }

        $users = new user;
        $data['users'] = $users->get();
        $data['missings'] = array_unique($data['missings']);

        return view('missing.listresult', $data);
    }
}
