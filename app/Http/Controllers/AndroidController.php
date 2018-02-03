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

        $data['clothes'] = 'Clothes:     '. $missing->Missing_clothes;
        $data['bodym'] = 'Body Markings:     ' . $missing->Missing_bodymarkings;
        $data['other'] = 'Other Info:     ' . $missing->Missing_other;

        $data['img'] = $missing->Missing_picture;

        $data['repname'] = $user->User_fname . ' ' . $user->User_mname . ' ' . $user->User_lname;
        $data['repcon'] = $user->User_mobilenum;
        $data['repimg'] = $user->User_picture;

        $dat['data'] = $data;

        echo json_encode($dat);
    }

    public function register(Request $request)
    {
        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $gender = $request->gender;
        $birthday = $request->birthday;
        $city = $request->city;
        $address = $request->address;
        $contactnumber = $request->contactnumber;
        $email = $request->email;
        $password = $request->password;
        $mname = $request->mname;
        $filename = date('mdyhi') . time() . '.' . $request->file('dp')->getClientOriginalExtension();

        $decoded = base64_decode($request->image);

        //image
        //original
        Image::make($decoded)
            ->save(public_path('images/dp/' . $filename), 100);

//        Image::make($request->file('vi1'))
//            ->save(public_path('images/vi1/' . $filename), 100);

        //thumbnail
        Image::make($decoded)->resize(null, 400, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('images/dpthumb/' . $filename), 100);

//        Image::make($request->file('vi1'))->resize(null, 400, function ($constraint) {
//            $constraint->aspectRatio();
//        })->save(public_path('images/vi1thumb/' . $filename), 100);


        $user = user::where('User_Email', $email)->first();
        if ($user != null) return 0;

        $user = new User();
        $user->User_FName = $firstname;
        $user->User_LName = $lastname;
        $user->User_mname = $mname;
        $user->User_Gender = $gender;
        $user->User_bday = $birthday;
        $user->User_address = $address;
        $user->User_City = $city;
        $user->User_mobilenum = $contactnumber;
        $user->User_Email = $email;
        $user->User_Password = Hash::make($password);
        $user->User_Status = 1;
        $user->User_Code = 'WQKZ1qTQTI';
        $user->User_picture = $filename;
        $user->User_valId1 = $filename;
        $user->save();

        $name = $firstname . ' ' . $lastname;
        $body = 'Thank you for registering at HANAP. Your account will be verified first before it can be use. Please wait for the verification.';
        $subject = 'Account Verification';

        Mail::to($email)->send(new Emails($subject, $body, $name));

        $this->itexmo($user->User_mobilenum, "Thank you for registering at HANAP. Your account will be verified first before it can be use. Please wait for the verification.", "ST-ANTON124629_M8INX");

        return 1;
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
