<?php

namespace App\Http\Controllers;

use App\MissingPerson;
use App\police;
use App\sighting;
use App\user;
use App\match;
use App\UserTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AndroidController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = user::where('User_email', $email)->first();
        if ($user == null) return 0;
        if (!Hash::check($password, $user->User_password)) return 2;

        return 1;
    }

    public function loginPolice(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = police::where('Police_email', $email)->first();
        if ($user == null) return 0;
        if (!Hash::check($password, $user->Police_password)) return 2;

        return 1;
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

        $file = 'user_' . strtotime("now") . '_' . rand(10, 20) . '.jpg';
        $path = public_path('images/' . $file);
        $decoded = base64_decode($request->image);
        file_put_contents($path, $decoded);

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
        $user->User_picture = $file;
        $user->User_valId1 = $file;
        $user->save();

        $name = $firstname . ' ' . $lastname;
        $body = 'Thank you for registering at HANAP. Your account will be verified first before it can be use. Please wait for the verification.';
        $subject = 'Account Verification';

        Mail::to($email)->send(new Emails($subject, $body, $name));

        $this->itexmo($user->User_mobilenum, "Thank you for registering at HANAP. Your account will be verified first before it can be use. Please wait for the verification.", "ST-ANTON124629_M8INX");

        return 1;
    }

    public function registerPolice(Request $request)
    {
        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $gender = $request->gender;
        $birthday = $request->birthday;
        $address = $request->address;
        $contactnumber = $request->contactnumber;
        $email = $request->email;
        $password = $request->password;

        $file = 'user_' . strtotime("now") . '_' . rand(10, 20) . '.jpg';
        $path = public_path('images/' . $file);
        $decoded = base64_decode($request->image);
        file_put_contents($path, $decoded);

        $user = police::where('Police_email', $email)->first();
        if ($user != null) return 0;

        $user = new police();
        $user->Police_Name = $firstname;
        $user->Police_lname = $lastname;
        $user->Police_gender = $gender;
        $user->Police_bday = $birthday;
        $user->Police_address = $address;
        $user->Police_mobilenum = $contactnumber;
        $user->Police_email = $email;
        $user->Police_password = Hash::make($password);
        $user->Police_code = 'WQKZ1qTQTI';
        $user->Police_picture = $file;
        $user->save();

        $name = $firstname . ' ' . $lastname;
        $body = 'Thank you for registering at HANAP. Your account will be verified first before it can be use. Please wait for the verification.';
        $subject = 'Account Verification';

        Mail::to($email)->send(new Emails($subject, $body, $name));

        $this->itexmo($user->User_mobilenum, "Thank you for registering at HANAP. Your account will be verified first before it can be use. Please wait for the verification.", "ST-ANTON124629_M8INX");

        return 1;
    }

    public function getMissingPersons(Request $request)
    {
        $mps = MissingPerson::where('Missing_status', '=', '0')->orderBy('created_at', 'desc')->get()->toArray();

        return json_encode($mps);
    }

    public function getMyMissingPersons(Request $request)
    {
        $email = $request->email;
        $user = user::where('User_email', $email)->first();
        $mps = MissingPerson::where('User_id', $user->User_id)->orderBy('created_at', 'desc')->get()->toArray();
        $ss = sighting::where('User_id', $user->User_id)->orderBy('created_at', 'desc')->get()->toArray();

        $ret = array();
        foreach ($mps as $mp)
            $ret[] = $mp;
        foreach ($ss as $s)
            $ret[] = $s;

        return json_encode($ret);
    }

    public function getMissingPerson(Request $request)
    {
        $arr = array();

        $faceid = $request->faceid;

//        return "faceid: ".$faceid;asd

        $mp = null;
        $mps = MissingPerson::all();
        foreach ($mps as $item) {
            $faceids = json_decode($item->Missing_faceid);
            foreach ($faceids as $fid) {
                if ($faceid == $fid) {
                    $mp = $item->toArray();
                    break;
                }
            }
            if ($mp != null) break;
        }

        $user = user::where('User_id', $mp['User_id'])->first();

        $arr['reporter'] = $user->User_fname . ' ' . $user->User_mname . ' ' . $user->User_lname;
        $arr['reporter_id'] = $user->User_id;
        $arr['missing'] = $mp;

        return json_encode($arr);
    }

    public function report(Request $request)
    {
        $email = $request->email;
        $user = user::where('User_Email', $email)->first();

        $file = $user->User_id . '_' . strtotime("now") . '_' . rand(10, 20) . '.jpg';
        $path = public_path('images/' . $file);
        $decoded = base64_decode($request->image1);
        file_put_contents($path, $decoded);
        $faceid1 = json_decode($this->addUsingUrl(url('images/' . $file)))->faceid;

        $file = $user->User_id . '_' . strtotime("now") . '_' . rand(10, 20) . '.jpg';
        $path = public_path('images/' . $file);
        $decoded = base64_decode($request->image2);
        file_put_contents($path, $decoded);
        $faceid2 = json_decode($this->addUsingUrl(url('images/' . $file)))->faceid;

        $file = $user->User_id . '_' . strtotime("now") . '_' . rand(10, 20) . '.jpg';
        $path = public_path('images/' . $file);
        $decoded = base64_decode($request->image);
        file_put_contents($path, $decoded);
        $faceid3 = json_decode($this->addUsingUrl(url('images/' . $file)))->faceid;

        $firstname = $request->firstname;
        $middlename = $request->middlename;
        $lastname = $request->lastname;
        $nickname = $request->nickname;
        $gender = $request->gender;
        $birthday = $request->birthday;
        $height = $request->height;
        $weight = $request->weight;

        $address = $request->address;
        $city = $request->city;
        $hairColor = $request->hairColor;
        $hair = $request->hair;
        $eyeColor = $request->eyeColor;
        $bodyType = $request->bodyType;
        $bodyHair = $request->bodyHair;
        $facialHair = $request->facialHair;
        $bodyMarkings = $request->bodyMarkings;
        $clothes = $request->clothes;
        $otherDescriptions = $request->otherDescriptions;

        $item = new MissingPerson();
        $item->User_id = $user->User_id;
        $item->Missing_Picture = $file;
        $item->Missing_fname = $firstname;
        $item->Missing_mname = $middlename;
        $item->Missing_lname = $lastname;
        $item->Missing_nname = $nickname;
        $item->Missing_gender = $gender;
        $item->Missing_height = $height;
        $item->Missing_weight = $weight;
        $item->Missing_bday = $birthday;

        $item->Missing_livaddress = $address;
        $item->Missing_livcity = $city;
        $item->Missing_hcolor = $hairColor;
        $item->Missing_hair = $hair;
        $item->Missing_eyecolor = $eyeColor;
        $item->Missing_bodytype = $bodyType;
        $item->Missing_bodyhair = $bodyHair;
        $item->Missing_facialhair = $facialHair;
        $item->Missing_bodymarkings = $bodyMarkings;
        $item->Missing_clothes = $clothes;
        $item->Missing_other = $otherDescriptions;

        $item->Missing_dodis = $request->dateOfDisappearance;
        $item->Missing_disaddress = $request->addressOfDisappearnce;
        $item->Missing_discity = $request->cityOfDisappearance;

        $faceids = array();
        $faceids[] = $faceid1;
        $faceids[] = $faceid2;
        $faceids[] = $faceid3;
        $item->Missing_faceid = json_encode($faceids);

        //email
        $name = $user->User_fname . ' ' . $user->User_lname;
        $body = "Your report is now posted at the missing person list. We hope you'll see him/her soon.";
        $subject = 'Missing person report';

        Mail::to($user->User_email)->send(new Emails($subject, $body, $name));

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

        $item->save();

        return MissingPerson::orderBy('Missing_id', 'DESC')->first()->Missing_id;
    }

    public function setToken(Request $request)
    {
        $email = $request->email;
        $user = user::where('User_Email', $email)->first();

        if ($user == null) return 0;

        $ut = UserTokens::where('User_id', $user->User_id)->first();
        if ($ut != null) {
            if ($ut->token == $request->token) {
                return 2;
            }
        }

        $ut = new UserTokens();
        $ut->User_id = $user->User_id;
        $ut->token = $request->token;
        $ut->save();

        return 1;
    }

    public function sendNotification(Request $request)
    {
        $id = $request->id;
        $reporterId = $request->reporter_id;
        $missingPerson = $request->missing;
        $founder = $request->founder;

        $faceid = $request->faceid;

        $mp = null;
        $mps = MissingPerson::all();
        foreach ($mps as $item) {
            $faceids = json_decode($item->Missing_faceid);
            foreach ($faceids as $fid) {
                if ($faceid == $fid) {
                    $mp = $item;
                    break;
                }
            }
            if ($mp != null) break;
        }

        $user = user::where('User_Email', $founder)->first();

        $file = $user->User_id . '_' . strtotime("now") . '_' . rand(10, 20) . '.jpg';
        $path = public_path('images/' . $file);
        $decoded = base64_decode($request->picture);
        file_put_contents($path, $decoded);

        $sighting = new sighting();
        $sighting->User_id = $user->User_id;
        $sighting->Sighting_date = $request->date;
        $sighting->Sighting_time = $request->time;
        $sighting->Sighting_other = '';
        $sighting->Sighting_address = '';
        $sighting->Sighting_picture = $file;
        $sighting->save();

        $match = new match();
        $match->User_id = $user->User_id;
        $match->Missing_id = $mp->Missing_id;
        $match->Sighting_id = $sighting->Sighting_id;
        $match->Match_confidence = $request->confidence;
        $match->save();

        $tokens = array();
        $ctr = 0;
        $ut = UserTokens::where('User_id', $reporterId)->get();

        foreach ($ut as $item) {
            $tokens[$ctr++] = $item->token;
        }

        $message = array("message" => 'Hey, i think someone found ' . $missingPerson, "missingperson_id" => $id);

        return $this->send_notification($tokens, $message);
    }

    public function sendNotificationPolice(Request $request)
    {
        $city = $request->city;
        $id = $request->id;
        $faceid = $request->faceid;

        $mps = MissingPerson::where('Missing_livcity', $city)->get();
        $users = user::where('User_city', $city)->get();

        foreach ($users as $user) {
            $tokens = array();
            $ctr = 0;
            $ut = UserTokens::where('User_id', $user->User_id)->get();

            foreach ($ut as $item) {
                $tokens[$ctr++] = $item->token;
            }

            foreach ($mps as $mp) {
                $missingPerson = $mp->Missing_fname . ' ' . $mp->Missing_mname . ' ' . $mp->Missing_lname;
                $message = array("message" => 'Hey, i think someone found ' . $missingPerson, "missingperson_id" => $id);

                $this->send_notification($tokens, $message);
            }
        }
    }

    public function getAccountDetails(Request $request)
    {
        return user::where('User_Email', $request->email)->first();
    }

    public function createFaceList($faceListId)
    {
        $route = $this->FACE_API_CREATE_FACE_LIST . $faceListId;

        $params = array();
        $params['name'] = $faceListId;

        $response = $this->sendToFaceAPI(
            $route,
            $this->CONTENT_TYPE_JSON,
            $this->METHOD_PUT,
            json_encode($params));

        return $response;
    }

    public function deleteFaceList($faceListId)
    {
        $route = $this->FACE_API_DELETE . $faceListId;

        $response = $this->sendToFaceAPI(
            $route,
            $this->CONTENT_TYPE_JSON,
            $this->METHOD_DELETE,
            '');

        return $response;
    }

    public function addFace($faceListId, $url)
    {
        $route = $this->FACE_API_ADD_FACE_PT1 . $faceListId . $this->FACE_API_ADD_FACE_PT2;

//        $url="http://70fb53a8.ngrok.io/images/_1511403924_11.jpg";
//        $file = fopen($url, "rb");
//        $params = fread($file, filesize($url));
//        fclose($file);

        $params = '{ "url":"' . $url . '" }';
//        $params='{ "url":"http://70fb53a8.ngrok.io/images/mattdamon.jpg" }';
//        $params='{ "url":"http://akns-images.eonline.com/eol_images/Entire_Site/2017928/rs_1024x759-171028100741-1024.matt-damon.cm.102817.jpg" }';

        $response = $this->sendToFaceAPI(
            $route,
            $this->CONTENT_TYPE_JSON,
            $this->METHOD_POST,
            $params);

        return $response;
    }

    public function detect($url)
    {
        $route = $this->FACE_API_DETECT;

        $params = '{ "url":"' . $url . '" }';

        $response = $this->sendToFaceAPI(
            $route,
            $this->CONTENT_TYPE_JSON,
            $this->METHOD_POST,
            $params);

        return $response;
    }

    public function isFamiliar($faceListId, $faceId)
    {
        $route = $this->FACE_API_FIND_SIMILAR;

        $params = array();
        $params['faceId'] = $faceId;
        $params['faceListId'] = $faceListId;
        $params['maxNumOfCandidatesReturned '] = 1;

        $response = $this->sendToFaceAPI(
            $route,
            $this->CONTENT_TYPE_JSON,
            $this->METHOD_POST,
            json_encode($params));

        return $response;
    }

    public function recognize(Request $request)
    {
        $file = 'temp_' . strtotime("now") . '_' . rand(10, 20) . '.jpg';
        $path = public_path('images/detect/' . $file);
        $decoded = base64_decode($request->picture);
        file_put_contents($path, $decoded);

        $data = array();

        $detect = json_decode($this->detect(url('images/detect/' . $file)));
        if (array_key_exists('error', $detect)) {
            $errors = $detect->error->message;
            $data['errors'] = $errors;
            return json_encode($data);
        }
//        return json_encode($detect);
        if (count($detect) == 0) {
            $data['errors'] = "No face was found on the image";
            return json_encode($data);
        }
        $detect = $detect[0];
        $faceid = $detect->faceId;

        $isfamiliar = json_decode($this->isFamiliar($this->FACE_API_FACE_LIST, $faceid));
        if (array_key_exists('error', $isfamiliar)) {
            $errors = $isfamiliar->error->message;
            $data['errors'] = $errors;
            return json_encode($data);
        }
//        return json_encode($isfamiliar);
        if (count($isfamiliar) == 0) {
            $data['errors'] = "No face was found on the image";
            return json_encode($data);
        }
        $isfamiliar = $isfamiliar[0];
        if (array_key_exists('persistedFaceId', $isfamiliar)) {
            $data['faceid'] = $isfamiliar->persistedFaceId;
            $data['confidence'] = $isfamiliar->confidence;
            return json_encode($data);
        }
        $data['errors'] = "The face on the image is not recognized";

        return json_encode($data);
    }

    public function add(Request $request)
    {
        $file = '_' . strtotime("now") . '_' . rand(10, 20) . '.jpg';
        $path = public_path('images/' . $file);
        $decoded = base64_decode($request->picture);
        file_put_contents($path, $decoded);

        $data = array();

        $add = json_decode($this->addFace($this->FACE_API_FACE_LIST, url('images/' . $file)));
        if (array_key_exists('error', $add)) {
            $errors = $add->error->message;
            $data['errors'] = $errors;
            return json_encode($data);
        }
        if (array_key_exists('persistedFaceId', $add)) {
            $data['faceid'] = $add->persistedFaceId;
            return json_encode($data);
        }
        $data['faceid'] = "";

        return json_encode($data);
    }

    public function addUsingUrl($url)
    {
        $data = array();

        $add = json_decode($this->addFace($this->FACE_API_FACE_LIST, $url));
        if (array_key_exists('error', $add)) {
            $errors = $add->error->message;
            $data['errors'] = $errors;
            return json_encode($data);
        }
        if (array_key_exists('persistedFaceId', $add)) {
            $data['faceid'] = $add->persistedFaceId;
            return json_encode($data);
        }
        $data['faceid'] = "";

        return json_encode($data);
    }


    private function send_notification($tokens, $message)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => $tokens,
            'data' => $message
        );
        $headers = array(
            'Authorization:key = AAAAwOdcePU:APA91bE0KSGSAAnSEOeZiLLgAW_jS97qTC-r32j1pU1QbqoP2-QWH5rfn8_XRbmysqVbC9e3yRvZtJPY7rzxpazkFKi81-HkOgwCpY_rUovpaqtK-FcI9WdWWHWTiircpfc372EOe8Tr ',
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }


    public $FACE_API_FACE_LIST = "hanap_face_list";
    public $FACE_API_KEY1 = '3110270341354118b47705fc4f19289c';
    public $FACE_API_KEY2 = '8e9f868203394e7293cf190e6325cf95';
    public $FACE_API_CREATE_FACE_LIST = 'facelists/';
    public $FACE_API_DELETE = 'facelists/';
    public $FACE_API_ADD_FACE_PT1 = 'facelists/';
    public $FACE_API_ADD_FACE_PT2 = '/persistedFaces';
    public $FACE_API_FIND_SIMILAR = '/findsimilars';
    public $FACE_API_DETECT = '/detect';
    public $METHOD_PUT = 'PUT';
    public $METHOD_POST = 'POST';
    public $METHOD_GET = 'GET';
    public $METHOD_DELETE = 'DELETE';
    public $CONTENT_TYPE_JSON = 'application/json';
    public $CONTENT_TYPE_OCTET_STREAM = 'application/octet-stream';

    private function sendToFaceAPI($route, $contentType, $method, $params)
    {
        $url = 'https://southeastasia.api.cognitive.microsoft.com/face/v1.0/' . $route;
        $ch = curl_init($url);

//        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            'Content-Type: ' . $contentType,
            'Ocp-Apim-Subscription-Key: ' . $this->FACE_API_KEY1,
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
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
