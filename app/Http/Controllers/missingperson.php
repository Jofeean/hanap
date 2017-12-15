<?php

namespace App\Http\Controllers;

use App\match;
use App\sighting;
use App\user;
use App\apikey;
use Illuminate\Http\Request;
use App\missing;
use Validator;
use Image;
use App\Mail\Emails;
use Illuminate\Support\Facades\Mail;
use HTTP_Request2;

class missingperson extends Controller
{

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

    public function file(Request $request)
    {

        if (session('id') == null) {
            return redirect('/');
        }

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

            'pmp' => 'required|image'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }

        $bday = strtotime($request->birthday);
        $dodis = strtotime($request->dodis);
        $now = strtotime('now');

        if ($bday > $now) {
            return redirect()->back()->withErrors(['bdayy' => 'bdayy'])->withInput($request->input());
        }

        if ($dodis > $now) {
            return redirect()->back()->withErrors(['dodiss' => 'dodiss'])->withInput($request->input());
        }

        if ($bday > $dodis) {
            return redirect()->back()->withErrors(['dodisss' => 'dodisss'])->withInput($request->input());
        }

        $apikey = new apikey;
        $apikey = $apikey->orderBy('created_at', 'desc')->first();


        //inserting data
        $filename = date('mdyhi') . time() . '.' . $request->file('pmp')->getClientOriginalExtension();
        $missing = new missing;
        $missing->User_id = trim(htmlspecialchars(strip_tags(session('id'))));
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

        //image
        Image::make($request->file('pmp'))
            ->save(public_path('images/missing/' . $filename), 100);

        Image::make($request->file('pmp'))->resize(null, 400, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('images/missingthumb/' . $filename), 100);

        require_once 'HTTP/Request2.php';

        //detect
        $request = new Http_Request2('https://southeastasia.api.cognitive.microsoft.com/face/v1.0/detect');
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
            $request = new Http_Request2('https://southeastasia.api.cognitive.microsoft.com/face/v1.0/verify');
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
                    return redirect()->back()->withErrors(['reported' => 'reported'])->withInput();
                }

            } catch (HttpException $ex) {
                echo $ex;
            }
        }

        //person
        $request = new Http_Request2('https://southeastasia.api.cognitive.microsoft.com/face/v1.0/persongroups/{personGroupId}/persons');
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
        $request = new Http_Request2('https://southeastasia.api.cognitive.microsoft.com/face/v1.0/persongroups/{personGroupId}/persons/{personId}/persistedFaces');
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

        //email
        $name = session('fname') . ' ' . session('lname');
        $body = "Your report is now posted at the missing person list. We hope you'll see him/her soon.";
        $subject = 'Missing person report';

        Mail::to(session('uname'))->send(new Emails($subject, $body, $name));

        $user = new user;
        $user = $user->where('User_id', '=', session('id'))->first();

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

        return redirect("/missingperson/yourreports");

    }

    public function match(Request $request)
    {
        if (session('id') == null) {
            return redirect('/');
        }

        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'time' => 'required',
            'other' => 'required|string|max:250',
            'address' => 'required|string|max:250',

            'pmp' => 'required|image'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }

        //inserting data for sighting table
        $filename = date('mdyhi') . time() . '.' . $request->file('pmp')->getClientOriginalExtension();
        $faceid = '';

        $sighting = new sighting;
        $sighting->User_id = trim(htmlspecialchars(strip_tags(session('id'))));
        $sighting->Sighting_date = trim(htmlspecialchars(strip_tags($request->date)));
        $sighting->Sighting_time = trim(htmlspecialchars(strip_tags($request->time)));
        $sighting->Sighting_other = ucfirst(trim(htmlspecialchars(strip_tags($request->other))));
        $sighting->Sighting_address = ucwords(trim(htmlspecialchars(strip_tags($request->address))));;
        $sighting->Sighting_picture = $filename;

        //image
        Image::make($request->file('pmp'))
            ->save(public_path('images/sighting/' . $filename), 100);

        Image::make($request->file('pmp'))->resize(null, 400, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('images/sightingthumb/' . $filename), 100);


        $apikey = new apikey;
        $apikey = $apikey->orderBy('created_at', 'desc')->first();

        //detect
        $request = new Http_Request2('https://southeastasia.api.cognitive.microsoft.com/face/v1.0/detect');
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
        $data['matches'] = array();

        foreach ($missings as $missing) {

            //face verification
            $request = new Http_Request2('https://southeastasia.api.cognitive.microsoft.com/face/v1.0/verify');
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


//                if ($json1->confidence > 0.5) {
//                    $user = new user;
//                    $user = $user->where('User_id', '=', $missing->User_id)->first();
//
//                    //inserting data for matches table
//                    $matches = new match;
//                    $matches->User_id = trim(htmlspecialchars(strip_tags(session('id'))));;
//                    $matches->Missing_id = $missing->Missing_id;
//                    $matches->Missing_id = $missing->Missing_id;
//                    $matches->Sighting_id = $sighting->Sighting_id;
//                    $matches->Match_confidence = ($json1->confidence * 100);
//
//                    //email
//                    $name = $user->User_fname . ' ' . $user->User_lname;
//                    $body = 'Good day! We got some good news! Someone saw a person and got ' . round($json1->confidence * 100, 2) . '% similarities at your missing relative';
//                    $subject = 'Found a Match';
//
//                    Mail::to($user->User_email)->send(new Emails($subject, $body, $name));
//
//                    //text
//                    $result = $this->itexmo($user->User_mobilenum,
//                        'Good day! We got some good news! Someone saw a person and got ' . round($json1->confidence * 100, 2) . '% similarities at your missing relative',
//                        "ST-ANTON124629_M8INX");
//
//                    if ($result == "") {
//                        echo "something went wrong please try it again";
//                        die();
//                    } else if ($result == 0) {
//
//                    } else {
//                        echo "something went wrong please try it again";
//                        die();
//                    }
//
//                    $matches->save();
//
//                    array_push($data['matches'], [
//                        'Missing_id' => $missing->Missing_id,
//                        'Missing_name' => $missing->Missing_fname . ' ' . $missing->Missing_mname . ' ' . $missing->Missing_lname,
//                        'Missing_gender' => $missing->Missing_gender,
//                        'Missing_bday' => $missing->Missing_bday,
//                        'Missing_dodis' => $missing->Missing_dodis,
//                        'Missing_disaddress' => $missing->Missing_disaddress,
//                        'Missing_height' => $missing->Missing_height,
//                        'Missing_weight' => $missing->Missing_weight,
//                        'Missing_eyecolor' => $missing->Missing_eyecolor,
//                        'Missing_bodytype' => $missing->Missing_bodytype,
//                        'Missing_bodymarkings' => $missing->Missing_bodymarkings,
//                        'Missing_clothes' => $missing->Missing_clothes,
//                        'Missing_other' => $missing->Missing_other,
//                        'Missing_picture' => $missing->Missing_picture,
//
//                        'User_id' => $user->User_id,
//                        'User_picture' => $user->User_picture,
//                        'User_name' => $user->User_fname . ' ' . $user->User_mname . ' ' . $user->User_lname,
//                        'User_mobilenum' => $user->User_mobilenum,
//
//                        'confidence' => $json1->confidence,
//                    ]);
//                }

            } catch (HttpException $ex) {
                echo $ex;
            }
        }

        var_dump($json1);

        //return view('user.sighting', $data);

    }

    public function found($id)
    {
        if (session('id') == null) {
            return redirect('/');
        }

        $user = new missing;
        $user = $user->where('Missing_id', '=', trim(strip_tags(htmlspecialchars($id))))->first();
        $missing = new user;
        $missing = $missing->where('User_id', '=', $user->User_id)->first();

        if ($user->Missing_status == '0') {

            if (session('priv') == 'police' || session('priv') == 'admin') {

                //text
                $result = $this->itexmo($missing->User_mobilenum,
                    "Your missing person report has been closed by the " . session('priv'),
                    "ST-ANTON124629_M8INX");

                if ($result == "") {
                    echo "something went wrong please try it again";
                    die();
                } else if ($result == 0) {

                } else {
                    echo "something went wrong please try it again";
                    die();
                }
            }

            $user->where('Missing_id', '=', trim(strip_tags(htmlspecialchars($id))))->update(['Missing_status' => '1', 'Missing_foundate' => date('Y-m-d H:i:s')]);
            return redirect()->back()->withErrors(['success' => 'success']);
        }

        return redirect()->back()->withErrors(['denied' => 'denied']);
    }

}
