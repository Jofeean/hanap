<?php

namespace App\Http\Controllers;

use App\apikey;
use App\Mail\Emails;
use App\missing;
use App\police;
use App\user;
use Image;
use HTTP_Request2;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class admin extends Controller
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

    public function regpol(Request $request, $id)
    {
        if (session('priv') == 'admin') {
            return redirect('/');
        }

        if ($id == 1) {
            $validator = Validator::make($request->all(), [
                'pfname' => 'required|string|max:250',
                'plname' => 'required|string|max:250',
                'pgender' => 'required|alpha|max:6',
                'pbirthday' => 'required',
                'pmobilenum' => 'required|digits:11',
                'paddress' => 'required|string|max:250',
                'pemail' => 'required|email|unique:polices,Police_email|max:250',
                'ppassword' => 'required|min:6|max:50',
                'prepass' => 'required|max:50|same:ppassword',

                'dp' => 'required|image'
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withErrors(['police' => 'admin', 'den' => 'den'])
                    ->withInput($request->input());
            }

            $date = date_create(trim(strip_tags(htmlspecialchars($request->pbirthday))));
            $date = date_format($date, 'n/d/Y');

            $filename = date('mdyhi') . time() . '.' . $request->file('dp')->getClientOriginalExtension();

            $user = new police;
            $user->Police_Name = ucwords(trim(strip_tags(htmlspecialchars($request->pfname))));
            $user->Police_lname = ucwords(trim(strip_tags(htmlspecialchars($request->plname))));
            $user->Police_gender = ucwords(trim(strip_tags(htmlspecialchars($request->pgender))));
            $user->Police_bday = $date;
            $user->Police_address = ucwords(trim(strip_tags(htmlspecialchars($request->paddress))));
            $user->Police_mobilenum = trim(strip_tags(htmlspecialchars($request->pmobilenum)));
            $user->Police_email = trim(strip_tags(htmlspecialchars($request->pemail)));
            $user->Police_password = bcrypt(trim(strip_tags(htmlspecialchars($request->ppassword))));
            $user->Police_picture = $filename;

            //original
            Image::make($request->file('dp'))
                ->save(public_path('images/dp/' . $filename), 100);

            //thumbnail
            Image::make($request->file('dp'))->resize(null, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/dpthumb/' . $filename), 100);

            $user->save();

            return redirect()->back()->withErrors(['police' => 'police', 'success' => 'success']);
        }
        if ($id == 2) {
            $validator = Validator::make($request->all(), [
                'fname' => 'required|string|max:250',
                'lname' => 'required|string|max:250',
                'gender' => 'required|alpha|max:6',
                'birthday' => 'required',
                'mobilenum' => 'required|digits:11',
                'address' => 'required|string|max:250',
                'email' => 'required|email|unique:admins,Admin_email|max:250',
                'password' => 'required|min:6|max:50',
                'repass' => 'required|max:50|same:password'
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withErrors(['admin' => 'admin', 'den' => 'den'])
                    ->withInput($request->input());
            }

            $date = date_create(trim(strip_tags(htmlspecialchars($request->birthday))));
            $date = date_format($date, 'n/d/Y');

            $user = new \App\admin;
            $user->Admin_Name = ucwords(trim(strip_tags(htmlspecialchars($request->fname))));
            $user->Admin_lname = ucwords(trim(strip_tags(htmlspecialchars($request->lname))));
            $user->Admin_gender = ucwords(trim(strip_tags(htmlspecialchars($request->gender))));
            $user->Admin_bday = $date;
            $user->Admin_address = ucwords(trim(strip_tags(htmlspecialchars($request->address))));
            $user->Admin_mobilenum = trim(strip_tags(htmlspecialchars($request->mobilenum)));
            $user->Admin_email = trim(strip_tags(htmlspecialchars($request->email)));
            $user->Admin_password = bcrypt(trim(strip_tags(htmlspecialchars($request->password))));
            $user->save();

            return redirect()->back()->withErrors(['admin' => 'admin', 'success' => 'success']);
        }

    }

    public function users()
    {
        if (session('priv') == 'admin') {
            $users = new user;
            $data['users'] = $users->orderBy('User_fname', 'desc')->get();
            return view('admin/accounts', $data);
        }
        return redirect('/');
    }

    public function activate($id)
    {
        if (session('priv') != 'admin') {
            return redirect('/');
        }

        $user = new user;
        $user = $user->where('User_id', '=', trim(strip_tags(htmlspecialchars($id))))->first();

        if ($user->User_status == '0') {
            //email
            $name = $user->User_fname . ' ' . $user->User_lname;
            $body = 'Thank you for registering at HANAP. Your account has been verified and activated now you can login to our website.';
            $subject = 'Confirmation';

            Mail::to($user->User_email)->send(new Emails($subject, $body, $name));

            //text
            $result = $this->itexmo($user->User_mobilenum, "Thank you for registering at HANAP. Your account has been verified and activated now you can login to our website.", "ST-JOSHU107250_XJ3V7 ");

            if ($result == "") {
                echo "something went wrong please try it again";
                die();
            } else if ($result == 0) {

            } else {
                echo "something went wrong please try it again";
                die();
            }

            $user->where('User_id', '=', trim(strip_tags(htmlspecialchars($id))))->update(['User_status' => '1']);
            return redirect()->back()->withErrors(['success' => 'success']);
        }

        return redirect()->back()->withErrors(['denied' => 'denied']);
    }

    public function missings()
    {
        if (session('priv') == 'admin') {
            $users = new user;
            $data['users'] = $users->get();
            $users = new missing;
            $data['missings'] = $users->orderBy('Missing_fname', 'asc')->get();
            return view('admin.missings', $data);
        }
        return redirect('/');
    }

    public function polices()
    {
        if (session('priv') == 'admin') {
            $users = new police;
            $data['users'] = $users->orderBy('Police_Name', 'asc')->get();
            return view('admin.police', $data);
        }
        return redirect('/');
    }

    public function up()
    {
        if (session('priv') == 'admin') {
            return view('admin.update');
        }

        return redirect('/');
    }

    public function update(Request $request)
    {
        if (session('priv') == 'admin') {
            $validator = Validator::make($request->all(), [
                'apikey' => 'required|string|max:250',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput($request->input());
            }

            $api = new apikey;
            $missings1 = new missing;
            $missings = $missings1->get();
            $api->Apikey = trim(strip_tags(htmlspecialchars($request->apikey)));

            $apikey = trim(strip_tags(htmlspecialchars($request->apikey)));

            //person group
            require_once 'HTTP/Request2.php';

            $request = new Http_Request2('https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/{personGroupId}');
            $url = $request->getUrl();

            $headers = array(
                // Request headers
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => $apikey,
            );

            $request->setHeader($headers);

            $parameters = array(
                // Request parameters
                'personGroupId' => 'hanapmissing'
            );

            $url->setQueryVariables($parameters);

            $request->setMethod(HTTP_Request2::METHOD_PUT);

            // Request body
            $request->setBody("{'name':'hanapmissing'}");

            try {
                $response = $request->send();
                echo $response->getBody();
            } catch (HttpException $ex) {
                echo $ex;
            }

            foreach ($missings as $missing) {

                //person
                require_once 'HTTP/Request2.php';

                $request = new Http_Request2('https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/{personGroupId}/persons');
                $url = $request->getUrl();

                $headers = array(
                    // Request headers
                    'Content-Type' => 'application/json',
                    'Ocp-Apim-Subscription-Key' => $apikey,
                );

                $request->setHeader($headers);

                $parameters = array(
                    // Request parameters
                    "personGroupId" => "hanapmissing"
                );

                $url->setQueryVariables($parameters);

                $request->setMethod(HTTP_Request2::METHOD_POST);

                // Request body
                $request->setBody('{"name":"' . $missing->Missing_picture . '"}');

                try {
                    $response = $request->send();
                    $json1 = json_decode($response->getBody());
                    $personid = $json1->personId;

                } catch (HttpException $ex) {
                    echo $ex;
                }


                //person face
                $request = new Http_Request2('https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/{personGroupId}/persons/{personId}/persistedFaces');
                $url = $request->getUrl();

                $headers = array(
                    // Request headers
                    'Content-Type' => 'application/octet-stream',
                    'Ocp-Apim-Subscription-Key' => $apikey,
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
                $image = public_path('images/missingthumb/' . $missing->Missing_picture);
                $fp = fopen($image, 'rb');
                $request->setBody($fp);

                try {
                    $response = $request->send();
                    $response->getBody();
                } catch (HttpException $ex) {
                    echo $ex;
                }

                $missings1->where('Missing_id', '=', $missing->Missing_id)->update(['Missing_faceid' => $personid]);
            }


            $api->save();
        }

        return redirect('/');
    }
}
