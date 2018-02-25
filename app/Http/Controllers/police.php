<?php

namespace App\Http\Controllers;

use App\notif;
use Illuminate\Http\Request;
use App\user;
use App\missing;
use App\Mail\Emails;
use Illuminate\Support\Facades\Mail;
use Validator;
use DateTime;

class police extends Controller
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

    public function missings()
    {
        if (session('priv') == 'police') {
            $users = new user;
            $data['users'] = $users->get();
            $users = new missing;
            $data['galleries'] = $users->where('Missing_status', '=', '0')->inRandomOrder()->limit(30)->get();
            $data['missings'] = $users->orderBy('Missing_fname', 'asc')->get();
            return view('police.missings', $data);
        }
        return redirect('/');
    }

    public function geomap()
    {
        if (session('priv') != 'police') {
            return redirect('/');
        }

        $missings = new missing;
        $data['galleries'] = $missings->where('Missing_status', '=', '0')->inRandomOrder()->limit(30)->get();
        $missings = $missings->get();

        $data['cal'] = $data['las'] = $data['mak'] =
        $data['mal'] = $data['mand'] = $data['man'] =
        $data['mar'] = $data['mun'] = $data['nav'] =
        $data['par'] = $data['pas'] = $data['pasi'] =
        $data['que'] = $data['san'] = $data['tag'] =
        $data['val'] = 0;

        foreach ($missings as $missing) {
            if ($missing->Missing_discity == 'Caloocan City') {
                $data['cal']++;
            }
            if ($missing->Missing_discity == 'Las Piñas City') {
                $data['las']++;
            }
            if ($missing->Missing_discity == 'Makati City') {
                $data['mak']++;
            }
            if ($missing->Missing_discity == 'Malabon City') {
                $data['mal']++;
            }
            if ($missing->Missing_discity == 'Mandaluyong City') {
                $data['mand']++;
            }
            if ($missing->Missing_discity == 'Manila City') {
                $data['man']++;
            }
            if ($missing->Missing_discity == 'Marikina City') {
                $data['mar']++;
            }
            if ($missing->Missing_discity == 'Muntinlupa City') {
                $data['mun']++;
            }
            if ($missing->Missing_discity == 'Navotas City') {
                $data['nav']++;
            }
            if ($missing->Missing_discity == 'Parañaque City') {
                $data['par']++;
            }
            if ($missing->Missing_discity == 'Pasay City') {
                $data['pas']++;
            }
            if ($missing->Missing_discity == 'Pasig City') {
                $data['pasi']++;
            }
            if ($missing->Missing_discity == 'Quezon City') {
                $data['que']++;
            }
            if ($missing->Missing_discity == 'San Juan City') {
                $data['san']++;
            }
            if ($missing->Missing_discity == 'Taguig City') {
                $data['tag']++;
            }
            if ($missing->Missing_discity == 'Valenzuela City') {
                $data['val']++;
            }
        }

        return view('police.geo', $data);
    }

    public function notif(Request $request)
    {
        if (session('priv') == 'police') {
            $validator = Validator::make($request->all(), [
                'city' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput($request->input());
            }

            $notif = new notif;
            $notifs = $notif->where('Notif_city', 'LIKE', '%' . $request->city . '%')
                ->orderBy('created_at', 'desc')->first();

            $last = new DateTime($notifs->created_at);
            $las = $last->add(new \DateInterval('P1D'));
            $now = new DateTime();


            if ($now >= $las) {

                $notif->Police_id = session('id');
                $notif->Notif_city = $request->city;
                $notif->save();

                $users = new user;
                $users = $users->where('User_city', 'LIKE', "%" . $request->city . "%")->get();

                $missings = new missing;
                $missings = $missings->where('Missing_discity', 'LIKE', '%' . $request->city . '%')->count();

                foreach ($users as $user) {
                    //email
                    $name = $user->User_fname . ' ' . $user->User_lname;
                    $body = "HANAP application notifies you to know that there are " . $missings . " persons went missing near your area.";
                    $subject = 'Regular Notification';

                    Mail::to($user->User_email)->send(new Emails($subject, $body, $name));

                    //text
                    $result = $this->itexmo($user->User_mobilenum,
                        "HANAP application notifies you to know that there are " . $missings . " persons went missing near your area.",
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

                return redirect()->back()->withErrors(['success' => $request->city]);

            } elseif ($now < $las) {
                $last = $last->add(new \DateInterval('P1D'));
                $dif = $last->diff($now);
                return redirect()->back()->withErrors(['error' => $dif->h]);
            }
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

        return view('police.missings', $data);
    }
}
