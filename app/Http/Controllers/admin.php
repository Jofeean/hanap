<?php

namespace App\Http\Controllers;

use App\announcement;
use App\apikey;
use App\Mail\Emails;
use App\missing;
use App\news;
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
        if (session('priv') != 'admin') {
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
            $result = $this->itexmo($user->User_mobilenum,
                "Thank you for registering at HANAP. Your account has been verified and activated now you can login to our website.",
                "ST-ANTON124629_M8INX");

            if ($result == "") {
                echo "something went wrong please try it again 1";
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

    public function deny($id)
    {
        if (session('priv') != 'admin') {
            return redirect('/');
        }

        $user = new user;
        $user = $user->where('User_id', '=', trim(strip_tags(htmlspecialchars($id))))->first();

        if ($user->User_status == '0') {
            //email
            $name = $user->User_fname . ' ' . $user->User_lname;
            $body = 'Sorry your account at HANAP has been denied for various reasons. For more questions please visit the nearest police station.';
            $subject = 'Denied';

            Mail::to($user->User_email)->send(new Emails($subject, $body, $name));

            //text
            $result = $this->itexmo($user->User_mobilenum,
                "Sorry your account at HANAP has been denied for various reasons. For more questions please visit the nearest police station.",
                "ST-ANTON124629_M8INX");

            if ($result == "") {
                echo "something went wrong please try it again";
                die();
            } else if ($result == 0) {

            } else {
                echo "something went wrong please try it again";
                die();
            }

            $user->where('User_id', '=', trim(strip_tags(htmlspecialchars($id))))->update(['User_status' => '2']);
            return redirect()->back()->withErrors(['success1' => 'success1']);
        }

        return redirect()->back()->withErrors(['denied1' => 'denied1']);
    }

    public function missings()
    {
        if (session('priv') == 'admin') {
            $users = new user;
            $data['users'] = $users->get();
            $users = new missing;
            $data['galleries'] = $users->where('Missing_status', '=', '0')->inRandomOrder()->limit(30)->get();
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

            $request = new Http_Request2('https://southeastasia.api.cognitive.microsoft.com/face/v1.0/persongroups/{personGroupId}');
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

                $request = new Http_Request2('https://southeastasia.api.cognitive.microsoft.com/face/v1.0/persongroups/{personGroupId}/persons');
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
                $request = new Http_Request2('https://southeastasia.api.cognitive.microsoft.com/face/v1.0/persongroups/{personGroupId}/persons/{personId}/persistedFaces');
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

    public function announcements()
    {
        if (session('priv') == 'admin') {

            $ann = new announcement;
            $data['announcements'] = $ann->get();
            $ann = new news;
            $data['news'] = $ann->get();

            return view('admin/announcements', $data);
        }
        return redirect('/');
    }

    public function addann(Request $request, $id)
    {
        if (session('priv') == 'admin') {
            if ($id == 1) {
                $validator = Validator::make($request->all(), [
                    'ann' => 'required|image'
                ]);

                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->withErrors(['announcements' => 'announcements', 'den' => 'den'])
                        ->withInput($request->input());
                }

                $filename = date('mdyhi') . time() . '.' . $request->file('ann')->getClientOriginalExtension();

                $news = new announcement;
                $news->Announcement_picture = $filename;

                //original
                Image::make($request->file('ann'))
                    ->save(public_path('images/announcements/' . $filename), 100);

                $news->save();

                return redirect()->back()->withErrors(['announcements' => 'announcements', 'success' => 'success']);
            }
            if ($id == 2) {
                $validator = Validator::make($request->all(), [
                    'news' => 'required|image',
                    'caption' => 'required|string|max:250'
                ]);

                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->withErrors(['news' => 'news', 'den' => 'den'])
                        ->withInput($request->input());
                }

                $filename = date('mdyhi') . time() . '.' . $request->file('news')->getClientOriginalExtension();

                $news = new news;
                $news->News_caption = $request->caption;
                $news->News_picture = $filename;

                //original
                Image::make($request->file('news'))
                    ->save(public_path('images/articles/' . $filename), 100);

                $news->save();

                return redirect()->back()->withErrors(['news' => 'news', 'success' => 'success']);
            }
        }
        return redirect('/');
    }

    public function delann($id)
    {
        if (session('priv') == 'admin') {

            $news = new announcement;
            $news->where('Announcement_id', '=', $id)->delete();

            return redirect()->back()->withErrors(['announcements' => 'announcements', 'del' => 'del']);
        }
        return redirect('/');
    }

    public function delnews($id)
    {
        if (session('priv') == 'admin') {

            $news = new news;
            $news->where('News_id', '=', $id)->delete();

            return redirect()->back()->withErrors(['news' => 'news', 'del' => 'del']);
        }
        return redirect('/');
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
                array_push($data['missings'], $use);
            }

            $user = $users->where('Missing_status', '=', $search)->get();
            foreach ($user as $use) {
                array_push($data['missings'], $use);
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
                array_push($data['missings'], $use);
            }
        }

        $users = new user;
        $data['users'] = $users->get();
        $data['missings'] = array_unique($data['missings']);

        return view('admin.missings', $data);
    }
}
