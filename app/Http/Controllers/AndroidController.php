<?php

namespace App\Http\Controllers;

use App\missing;
use App\MissingPerson;
use App\police;
use App\sighting;
use App\user;
use App\match;
use App\UserTokens;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AndroidController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:250',
            'password' => 'required|string|max:250',
        ]);

        if ($validator->fails()) {
            echo "Please check all the fields";
        }

        $user = new user;
        $user = $user->where('User_email', '=', trim(htmlspecialchars(strip_tags($request->email))))->first();
        $data = array();
        if ($user == null) {
            echo json_encode($data['response'] = "Wrong Email or Password");
        } elseif (!(Hash::check(trim(htmlspecialchars(strip_tags($request->password))), $user->User_password))) {
            echo json_encode($data['response'] = "Wrong Email or Password");
        } elseif
        (Hash::check(trim(htmlspecialchars(strip_tags($request->password))), $user->User_password)) {

            if ($user->User_status == 0) {
                echo json_encode($data['response'] = "Account not Activated");
            }
            if ($user->User_status != 0) {
                $data['response'] = "Success";
                $data['data']['id'] = $user->User_id;
                $data['data']['email'] = $request->email;
                echo json_encode($data);
            }
        }
    }

    public function register(Request $request)
    {
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
            echo "Please check all the fields";
            die();
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
//        Image::make($request->file('dp'))
//            ->save(public_path('images/dp/' . $filename), 100);
//
//        Image::make($request->file('vi1'))
//            ->save(public_path('images/vi1/' . $filename), 100);

        //thumbnail
//        Image::make($request->file('dp'))->resize(null, 400, function ($constraint) {
//            $constraint->aspectRatio();
//        })->save(public_path('images/dpthumb/' . $filename), 100);
//
//        Image::make($request->file('vi1'))->resize(null, 400, function ($constraint) {
//            $constraint->aspectRatio();
//        })->save(public_path('images/vi1thumb/' . $filename), 100);
//
//        $user->save();

        echo "Sucess";
    }

    public function list()
    {
        $missings = new missing;
        $missings = $missings->get();

        $jmissings = array();

        foreach ($missings as $missing) {
            $jmissing = array();

            $date = new DateTime($missing->Missing_bday);
            $now = new DateTime();
            $interval = $now->diff($date);

            $jmissing['id'] = $missing->Missing_id;
            $jmissing['name'] = $missing->Missing_fname . ' ' . $missing->Missing_mname . ' ' . $missing->Missing_lname;
            $jmissing['age'] = $interval->y;
            $jmissing['dodis'] = $missing->Missing_dodis;
            $jmissing['image'] = $missing->Missing_picture;
            $jmissing['userid'] = $missing->User_id;

            array_push($jmissings, $jmissing);
        }


        $json['result'] = $jmissings;
        echo json_encode($json);
    }

    public function profile(Request $request)
    {
        $missing = new missing;
        $missing = $missing->where('Missing_id', "=", $request->id)->first();
        $user = new user;
        $user = $user->where('User_id', '=', $missing->User_id)->first();
        $dat = array();

        $data['name'] = $missing->Missing_fname . " " . $missing->Missing_mname . " " . $missing->Missing_lname;
        $data['gender'] = $missing->Missing_gender;
        $data['bday'] = $missing->Missing_bday;

        $data['height'] = $missing->Missing_height . ' cm';
        $data['weight'] = $missing->Missing_weight . ' kg';
        $data['eyecolor'] = $missing->Missing_eyecolor . ' eyes';
        $data['body'] = $missing->Missing_bodytype . ' body ';

        $data['dodis'] = $missing->Missing_dodis;
        $data['address'] = $missing->Missing_disaddress . " " . $missing->Missing_discity;

        $data['clothes'] = 'Clothes:     ' . $missing->Missing_clothes;
        $data['bodym'] = 'Body Markings:     ' . $missing->Missing_bodymarkings;
        $data['other'] = 'Other Info:     ' . $missing->Missing_other;

        $data['img'] = $missing->Missing_picture;

        $data['repname'] = $user->User_fname . ' ' . $user->User_mname . ' ' . $user->User_lname;
        $data['repcon'] = $user->User_mobilenum;
        $data['repimg'] = $user->User_picture;

        $dat['data'] = $data;

        echo json_encode($dat);
    }

    public function itexmo($number, $message, $apicode)
    {
        $url = 'https://www.itexmo.com/php_api/api.php';
        $itexmo = array('1' => $number, '2' => $message, '3' => $apicode);
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
}
