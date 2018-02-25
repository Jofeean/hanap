<?php

namespace App\Http\Controllers;

use App\missing;
use App\sighting;
use App\user;
use App\match;
use App\apikey;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\Emails;
use Image;
use HTTP_Request2;
use Validator;

class AndroidController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:250',
            'password' => 'required|string|max:250',
        ]);

        if ($validator->fails()) {
            $data['response'] = "Please check all the fields";
            $data['data']['id'] = "null";
            $data['data']['email'] = "null";
            echo json_encode($data);
            die();
        }

        $user = new user;
        $user = $user->where('User_email', '=', trim(htmlspecialchars(strip_tags($request->email))))->first();
        $data = array();
        if ($user == null) {
            $data['response'] = "Wrong Email or Password";
            $data['data']['id'] = "null";
            $data['data']['email'] = "null";
            $data['data']['id'] = $user->User_id;
            $data['data']['email'] = $request->email;
            echo json_encode($data);
            die();
        } elseif (!(Hash::check(trim(htmlspecialchars(strip_tags($request->password))), $user->User_password))) {
            $data['response'] = "Wrong Email or Password";
            $data['data']['id'] = "null";
            $data['data']['email'] = "null";
            $data['data']['id'] = $user->User_id;
            $data['data']['email'] = $request->email;
            echo json_encode($data);
            die();
        } elseif
        (Hash::check(trim(htmlspecialchars(strip_tags($request->password))), $user->User_password)) {

            if ($user->User_status == 0) {
                $data['response'] = "Account not Activated";
                $data['data']['id'] = "null";
                $data['data']['email'] = "null";
                echo json_encode($data);
                die();
            }
            if ($user->User_status != 0) {
                $data['response'] = "Success";
                $data['data']['id'] = $user->User_id;
                $data['data']['email'] = $request->email;
                echo json_encode($data);
                die();
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

            'dp' => 'required|string',
            'vi1' => 'required|string',
        ]);

        if ($validator->fails()) {
            echo "Please check all the fields";
            die();
        }

        if (!$this->validateDate($request->birthday)) {
            echo "Wrong date Format";
            die();
        }
        $date = new DateTime($request->birthday);
        $now = new DateTime();
        $interval = $now->diff($date);

        if ($interval->y < 18) {
            return redirect()->back()->withErrors(['bday' => 'bday'])->withInput($request->input());
        }

        //inserting data
        $filename = date('mdyhi') . time() . '.jpg';
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

        $dp = base64_decode($request->dp);
        $vi1 = base64_decode($request->vi1);

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
        Image::make($dp)
            ->save(public_path('images/dp/' . $filename), 100);

        Image::make($vi1)
            ->save(public_path('images/vi1/' . $filename), 100);

        //thumbnail
        Image::make($dp)->resize(null, 400, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('images/dpthumb/' . $filename), 100);

        Image::make($vi1)->resize(null, 400, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('images/vi1thumb/' . $filename), 100);

        $user->save();

        echo "Sucess";
        die();
    }

    public function list()
    {
        $missings = new missing;
        $missings = $missings->get();

        $jmissings = array();

        foreach ($missings as $missing) {
            if ($missing->Missing_status == 0) {
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
        }


        $json['result'] = $jmissings;
        echo json_encode($json);
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search' => 'required|max:250'
        ]);

        if ($validator->fails()) {
            return redirect("api/list");
        }

        $jmissings = array();
        $users = new missing;
        $key = strip_tags(htmlspecialchars(trim($request->search)));
        $searches = explode(' ', $key);
        $data['missings'] = array();

        foreach ($searches as $search) {

            $user = $users->where('Missing_gender', '=', $search)->get();
            foreach ($user as $use) {
                if ($use->Missing_status == 0) {
                    $jmissing = array();

                    $date = new DateTime($use->Missing_bday);
                    $now = new DateTime();
                    $interval = $now->diff($date);

                    $jmissing['id'] = $use->Missing_id;
                    $jmissing['name'] = $use->Missing_fname . ' ' . $use->Missing_mname . ' ' . $use->Missing_lname;
                    $jmissing['age'] = $interval->y;
                    $jmissing['dodis'] = $use->Missing_dodis;
                    $jmissing['image'] = $use->Missing_picture;
                    $jmissing['userid'] = $use->User_id;

                    array_push($jmissings, $jmissing);
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
                    $jmissing = array();

                    $date = new DateTime($use->Missing_bday);
                    $now = new DateTime();
                    $interval = $now->diff($date);

                    $jmissing['id'] = $use->Missing_id;
                    $jmissing['name'] = $use->Missing_fname . ' ' . $use->Missing_mname . ' ' . $use->Missing_lname;
                    $jmissing['age'] = $interval->y;
                    $jmissing['dodis'] = $use->Missing_dodis;
                    $jmissing['image'] = $use->Missing_picture;
                    $jmissing['userid'] = $use->User_id;

                    array_push($jmissings, $jmissing);
                }
            }
            foreach ($user as $use) {
                if ($use->Missing_status == 0) {
                    $jmissing = array();

                    $date = new DateTime($use->Missing_bday);
                    $now = new DateTime();
                    $interval = $now->diff($date);

                    $jmissing['id'] = $use->Missing_id;
                    $jmissing['name'] = $use->Missing_fname . ' ' . $use->Missing_mname . ' ' . $use->Missing_lname;
                    $jmissing['age'] = $interval->y;
                    $jmissing['dodis'] = $use->Missing_dodis;
                    $jmissing['image'] = $use->Missing_picture;
                    $jmissing['userid'] = $use->User_id;

                    array_push($jmissings, $jmissing);
                }
            }
        }

        $json["result"] = $this->super_unique($jmissings, "id");

        echo json_encode($json);

    }

    public function match(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'time' => 'required',
            'other' => 'required|string|max:250',
            'address' => 'required|string|max:250',
        ]);

        if ($validator->fails()) {
            $data['error'] = "Please check all the fields.";
            $data["hits"] = 0;
            $data["result"] = "";
            echo json_encode($data);
            die();
        }

        //inserting data for sighting table
        $filename = date('mdyhi') . time() . '.jpg';
        $faceid = '';

        $sighting = new sighting;
        $sighting->User_id = trim(htmlspecialchars(strip_tags($request->userid)));
        $sighting->Sighting_date = trim(htmlspecialchars(strip_tags($request->date)));
        $sighting->Sighting_time = trim(htmlspecialchars(strip_tags($request->time)));
        $sighting->Sighting_other = ucfirst(trim(htmlspecialchars(strip_tags($request->other))));
        $sighting->Sighting_address = ucwords(trim(htmlspecialchars(strip_tags($request->address))));;
        $sighting->Sighting_picture = $filename;

        $pmp = base64_decode($request->pmp);

        //image
        Image::make($pmp)
            ->save(public_path('images/sighting/' . $filename), 100);

        Image::make($pmp)->resize(null, 400, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('images/sightingthumb/' . $filename), 100);


        $apikey = new apikey;
        $apikey = $apikey->orderBy('created_at', 'desc')->first();

        $json1 = null;
        $json = null;
        //detect
        $request = new Http_Request2('https://westcentralus.api.cognitive.microsoft.com/face/v1.0/detect');
        $url = $request->getUrl();

        $headers = array(
            // Request headers
            'Content-Type' => 'application/octet-stream',
            'Ocp-Apim-Subscription-Key' => $apikey->Apikey,
        );

        $request->setHeader($headers);

        $parameters = array(
            // Request parameters
            'returnFaceId' => 'true',
        );

        $url->setQueryVariables($parameters);

        $request->setMethod(HTTP_Request2::METHOD_POST);

        // Request body
        $image = public_path('images/sightingthumb/' . $filename);
        $fp = fopen($image, 'rb');
        $request->setBody($fp);

        try {
            $response = $request->send();
            $json1 = json_decode($response->getBody());
            $faceid = $json1[0]->faceId;
        } catch (HttpException $ex) {
            echo $ex;
        }

        $sighting->save();


        $missings = new missing;
        $missings = $missings->where('Missing_status', '=', '0')->get();
        $sighting = $sighting->where('Sighting_picture', '=', $filename)->first();
        $temp = array();
        $results = array();
        $hits = 0;

        foreach ($missings as $missing) {

            //face verification
            $request = new Http_Request2('https://westcentralus.api.cognitive.microsoft.com/face/v1.0/verify');
            $url = $request->getUrl();

            $headers = array(
                // Request headers
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => $apikey->Apikey,
            );

            $request->setHeader($headers);

            $parameters = array(// Request parameters

            );

            $url->setQueryVariables($parameters);

            $request->setMethod(HTTP_Request2::METHOD_POST);

            // Request body
            $request->setBody('{
                "faceId":"' . $faceid . '",
                "personId":"' . $missing->Missing_faceid . '",
                "personGroupId":"hanapmissing"
            }');

            try {
                $response = $request->send();
                $json1 = json_decode($response->getBody());

                if ($json1->isIdentical == true) {
                    $user = new user;
                    $user = $user->where('User_id', '=', $missing->User_id)->first();

                    //inserting data for matches table
                    $matches = new match;
                    $matches->User_id = trim(htmlspecialchars(strip_tags($_POST["userid"])));
                    $matches->Missing_id = $missing->Missing_id;
                    $matches->Missing_id = $missing->Missing_id;
                    $matches->Sighting_id = $sighting->Sighting_id;
                    $matches->Match_confidence = ($json1->confidence * 100);
                    $hits++;

                    //email
                    $name = $user->User_fname . ' ' . $user->User_lname;
                    $body = 'Good day! We got some good news! Someone saw a person and got ' . round($json1->confidence * 100, 2) . '% similarities at your missing relative';
                    $subject = 'Found a Match';

                    Mail::to($user->User_email)->send(new Emails($subject, $body, $name));

                    //text
                    $result = $this->itexmo($user->User_mobilenum,
                        'Good day! We got some good news! Someone saw a person and got ' . round($json1->confidence * 100, 2) . '% similarities at your missing relative',
                        "ST-ANTON124629_M8INX");

                    if ($result == "") {
                        echo "something went wrong please try it again";
                        die();
                    } else if ($result == 0) {

                    } else {
                        echo "something went wrong please try it again";
                        die();
                    }

                    $matches->save();

                    $date = new DateTime($missing->Missing_bday);
                    $now = new DateTime();
                    $interval = $now->diff($date);

                    $jmissing = array();

                    $jmissing['id'] = $missing->Missing_id;
                    $jmissing['name'] = $missing->Missing_fname . ' ' . $missing->Missing_mname . ' ' . $missing->Missing_lname;
                    $jmissing['age'] = $interval->y;
                    $jmissing['dodis'] = $missing->Missing_dodis;
                    $jmissing['image'] = $missing->Missing_picture;
                    $jmissing['userid'] = $user->User_id;

                    array_push($temp, $jmissing);
                }

            } catch (HttpException $ex) {
                echo $ex;
            }
        }

        $results['results'] = $temp;
        $results['hits'] = $hits;
        $results['error'] = "success";
        echo json_encode($results);
        die();

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
        $data['body'] = $missing->Missing_bodytype . ' body';

        $data['hair'] = $missing->Missing_hair . ' hair';
        $data['haircolor'] = $missing->Missing_hcolor . ' colored hair';
        $data['bodyhair'] = "Hair on " . $missing->Missing_bodyhair;
        $data['facialhair'] = $missing->Missing_facialhair . ' facial hair';

        $data['dodis'] = $missing->Missing_dodis;
        $data['address'] = $missing->Missing_disaddress . " " . $missing->Missing_discity;

        $data['clothes'] = 'Clothes:     ' . $missing->Missing_clothes;
        $data['bodym'] = 'Body Markings:     ' . $missing->Missing_bodymarkings;
        $data['other'] = 'Other Info:     ' . $missing->Missing_other;

        $data['img'] = $missing->Missing_picture;

        $data['repname'] = $user->User_fname . ' ' . $user->User_mname . ' ' . $user->User_lname;
        $data['repcon'] = $user->User_mobilenum;
        $data['repimg'] = $user->User_picture;
        $data['repid'] = $user->User_id;


        $temps = array();
        $matches = new match();
        $matches = $matches->where('Missing_id', "=", $request->id)->get();
        $users = new user;
        $sightings = new sighting;

        foreach ($matches as $match) {
            $temp = array();
            $sighting = $sightings->where('Sighting_id', "=", $match->Sighting_id)->first();
            $user = $users->where('User_id', "=", $match->User_id)->first();

            $temp['id'] = $match->Match_id;

            $temp['confidence'] = $match->Match_confidence;
            $temp['found'] = $sighting->Sighting_address;
            $temp['time'] = $sighting->Sighting_date . " " . $sighting->Sighting_time;
            $temp['other'] = $sighting->Sighting_other;
            $temp['pic'] = $sighting->Sighting_picture;

            $temp['userid'] = $match->User_id;
            $temp['username'] = $user->User_fname . " " . $user->User_lname;
            $temp['userconno'] = $user->User_mobilenum;
            $temp['userpic'] = $user->User_picture;

            array_push($temps, $temp);
        }

        $dat['data'] = $data;
        $dat['matches'] = $temps;

        echo json_encode($dat);
        die();
    }

    public function file(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:250',
            'mname' => 'max:250',
            'lname' => 'required|string|max:250',
            'nname' => 'max:250',
            'gender' => 'required|alpha|max:6',
            'birthday' => 'required',

            'hcolor' => 'required|alpha|max:20',
            'height' => 'min:0|max:3',
            'weight' => 'min:0|max:3',
            'eye' => 'required|string|max:20',
            'btype' => 'required|string|max:20',
            'hair' => 'required|max:250',
            'bhair' => 'min:0|max:250',
            'fhair' => 'min:0|max:250',

            'dodis' => 'required',
            'disaddress' => 'required|string|max:250',
            'city1' => 'required|string|max:50',

            'bmark' => 'required|string|max:250',
            'clothes' => 'required|string|max:250',
            'other' => 'required|string|max:250',

            'pmp' => 'required'
        ]);

        if ($validator->fails()) {
            echo "Please check all the fields";
            die();
        }

        if (!$this->validateDate($request->birthday) || !$this->validateDate($request->dodis)) {
            echo "Wrong date Format";
            die();
        }

        $bday = strtotime($request->birthday);
        $dodis = strtotime($request->dodis);
        $now = strtotime('now');

        if ($bday > $now) {
            echo "Invalid birth date";
            die();
        }

        if ($dodis > $now) {
            echo "Invalid date of disappearance";
            die();
        }

        if ($bday > $dodis) {
            echo "Invalid birth date";
            die();
        }

        $apikey = new apikey;
        $apikey = $apikey->orderBy('created_at', 'desc')->first();


        //inserting data
        $filename = date('mdyhi') . time() . '.jpg';
        $missing = new missing;
        $missing->User_id = trim(htmlspecialchars(strip_tags($request->id)));
        $missing->Missing_fname = ucwords(trim(htmlspecialchars(strip_tags($request->fname))));
        $missing->Missing_mname = ucwords(trim(htmlspecialchars(strip_tags($request->mname))));
        $missing->Missing_lname = ucwords(trim(htmlspecialchars(strip_tags($request->lname))));
        $missing->Missing_gender = ucfirst(trim(htmlspecialchars(strip_tags($request->gender))));
        $missing->Missing_bday = trim(htmlspecialchars(strip_tags($request->birthday)));

        $missing->Missing_hcolor = ucwords(trim(htmlspecialchars(strip_tags($request->hcolor))));
        $missing->Missing_height = ucwords(trim(htmlspecialchars(strip_tags($request->height))));
        $missing->Missing_eyecolor = ucwords(trim(htmlspecialchars(strip_tags($request->eye))));
        $missing->Missing_hair = ucwords(trim(htmlspecialchars(strip_tags($request->hair))));
        $missing->Missing_weight = ucwords(trim(htmlspecialchars(strip_tags($request->weight))));
        $missing->Missing_bodytype = ucwords(trim(htmlspecialchars(strip_tags($request->btype))));
        $missing->Missing_bodyhair = ucwords(trim(htmlspecialchars(strip_tags($request->bhair))));
        $missing->Missing_facialhair = ucwords(trim(htmlspecialchars(strip_tags($request->fhair))));

        $missing->Missing_dodis = trim(htmlspecialchars(strip_tags($request->dodis)));
        $missing->Missing_disaddress = ucwords(trim(htmlspecialchars(strip_tags($request->disaddress))));
        $missing->Missing_discity = ucwords(trim(htmlspecialchars(strip_tags($request->city1))));

        $missing->Missing_bodymarkings = ucfirst(trim(htmlspecialchars(strip_tags($request->bmark))));
        $missing->Missing_clothes = ucfirst(trim(htmlspecialchars(strip_tags($request->clothes))));
        $missing->Missing_other = ucfirst(trim(htmlspecialchars(strip_tags($request->other))));
        $missing->Missing_picture = $filename;

        $pmp = base64_decode($request->pmp);

        //image
        Image::make($pmp)
            ->save(public_path('images/missing/' . $filename), 100);

        Image::make($pmp)->resize(null, 400, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('images/missingthumb/' . $filename), 100);

        require_once 'HTTP/Request2.php';

        //detect
        $request = new Http_Request2('https://westcentralus.api.cognitive.microsoft.com/face/v1.0/detect');
        $url = $request->getUrl();

        $headers = array(
            // Request headers
            'Content-Type' => 'application/octet-stream',
            'Ocp-Apim-Subscription-Key' => $apikey->Apikey,
        );

        $request->setHeader($headers);

        $parameters = array(
            // Request parameters
            'returnFaceId' => 'true',
        );

        $url->setQueryVariables($parameters);

        $request->setMethod(HTTP_Request2::METHOD_POST);

        // Request body
        $image = public_path('images/missingthumb/' . $filename);
        $fp = fopen($image, 'rb');
        $request->setBody($fp);

        try {
            $response = $request->send();
            $json1 = json_decode($response->getBody());
            $faceid = $json1[0]->faceId;
        } catch (HttpException $ex) {
            echo $ex;
        }

        //find match
        $missings = new missing;
        $missings = $missings->where('Missing_status', '=', '0')->get();

        foreach ($missings as $missing1) {

            //face verification
            $request = new Http_Request2('https://westcentralus.api.cognitive.microsoft.com/face/v1.0/verify');
            $url = $request->getUrl();

            $headers = array(
                // Request headers
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => $apikey->Apikey,
            );

            $request->setHeader($headers);

            $parameters = array(// Request parameters

            );

            $url->setQueryVariables($parameters);

            $request->setMethod(HTTP_Request2::METHOD_POST);

            // Request body
            $request->setBody('{
                "faceId":"' . $faceid . '",
                "personId":"' . $missing1->Missing_faceid . '",
                "personGroupId":"hanapmissing"
            }');

            try {
                $response = $request->send();
                $json1 = json_decode($response->getBody());
                if ($json1->isIdentical == true) {
                    echo "Already Reported";
                    die();
                }

            } catch (HttpException $ex) {
                echo $ex;
            }
        }

        //person
        $request = new Http_Request2('https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/{personGroupId}/persons');
        $url = $request->getUrl();

        $headers = array(
            // Request headers
            'Content-Type' => 'application/json',
            'Ocp-Apim-Subscription-Key' => $apikey->Apikey,
        );

        $request->setHeader($headers);

        $parameters = array(
            // Request parameters
            "personGroupId" => "hanapmissing"
        );

        $url->setQueryVariables($parameters);

        $request->setMethod(HTTP_Request2::METHOD_POST);

        // Request body
        $request->setBody('{"name":"' . $filename . '"}');

        try {
            $response = $request->send();
            $json1 = json_decode($response->getBody());
            $missing->Missing_faceid = $personid = $json1->personId;

        } catch (HttpException $ex) {
            echo $ex;
        }

        //person face
        $request = new Http_Request2('https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/{personGroupId}/persons/{personId}/persistedFaces');
        $url = $request->getUrl();

        $headers = array(
            // Request headers
            'Content-Type' => 'application/octet-stream',
            'Ocp-Apim-Subscription-Key' => $apikey->Apikey,
        );

        $request->setHeader($headers);

        $parameters = array(
            // Request parameters
            'personGroupId' => 'hanapmissing',
            'personId' => $personid,
        );

        $url->setQueryVariables($parameters);

        $request->setMethod(HTTP_Request2::METHOD_POST);

        // Request body
        $image = public_path('images/missingthumb/' . $filename);
        $fp = fopen($image, 'rb');

        $request->setBody($fp);

        try {
            $response = $request->send();
            $response->getBody();
        } catch (HttpException $ex) {
            echo $ex;
        }
        $user = new user;
        $user = $user->where('User_id', '=', $_POST["id"])->first();

        //email
        $name = $user->User_fname . ' ' . $user->User_lname;
        $body = "Your report is now posted at the missing person list. We hope you'll see him/her soon.";
        $subject = 'Missing person report';

        Mail::to($_POST["email"])->send(new Emails($subject, $body, $name));

        //text
        $result = $this->itexmo($user->User_mobilenum,
            "Your report is now posted at the missing person list. We hope you'll see him/her soon.",
            "ST-ANTON124629_M8INX");

        if ($result == "") {
            echo "something went wrong please try it again";
            die();
        } else if ($result == 0) {

        } else {
            echo "something went wrong please try it again";
            die();
        }


        $missing->save();

        echo "Success";
        die();

    }

    public function super_unique($array, $key)
    {
        $temp_array = [];
        foreach ($array as &$v) {
            if (!isset($temp_array[$v[$key]]))
                $temp_array[$v[$key]] =& $v;
        }
        $array = array_values($temp_array);
        return $array;

    }

    public function validateDate($date)
    {
        $format = 'm/d/Y';
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

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
}
