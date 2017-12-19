<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//login & home
Route::get('/', 'home@home');
Route::post('/dologin', 'home@login');

//registration
Route::get('/registration', function () {
    if (session('id') != null) {
        return redirect('/');
    }
    return view('home.reg');
});
Route::post('/doreg', 'home@register');

//logout
Route::get('/logout', function () {
    session()->flush();
    return redirect('/');
});

//missingperson file
Route::get('/missingperson/filereport', function () {
    if (session('id') == null) {
        return redirect('/');
    }
    return view('user.filereport');
});
Route::post('/dofile', 'missingperson@file');

//missingperson sighting
Route::get('/missingperson/reportsighting', function () {
    if (session('id') == null) {
        return redirect('/');
    }
    $data['matches'] = 'wala';
    return view('user.sighting', $data);
});

//missingperson list
Route::get('/missingperson/list', function () {
    $users = new App\missing;
    $data['missings'] = $users->where('Missing_status', '=', '0')->paginate(15);
    $data['galleries'] = $users->where('Missing_status', '=', '0')->inRandomOrder()->limit(30)->get();
    $users = new App\user;
    $data['users'] = $users->get();

    return view('missing.list', $data);
});

//missingperson list by the owner
Route::get('/missingperson/yourreports', function () {
    if (session('id') == null) {
        return redirect('/');
    }

    $users = new App\missing;
    $data['missings'] = $users->where('User_id', '=', session('id'))->where('Missing_status', '=', '0')->paginate(6);

    $users = new App\match;
    $data['matches'] = $users->get();

    $users = new App\sighting;
    $data['sightings'] = $users->get();

    $users = new App\user;
    $data['users'] = $users->get();


    return view('user.list', $data);
});

//missing person match
Route::post('/missingperson/reportsighting/match', 'missingperson@match');

//missing person found
Route::get('/missingperson/found/{id}', 'missingperson@found');

//activate user
Route::get('/user/activate/{id}', 'admin@activate');

//deny user
Route::get('/user/deny/{id}', 'admin@deny');

//missingperson list search
Route::post('/missingperson/list/search-results', 'home@search');


//admin
//users list admin
Route::get('/user/lists', 'admin@users');

//police list admin
Route::get('/police/lists', 'admin@polices');

//missingperson list admin
Route::get('/missingperson/lists', 'admin@missings');

//police add admin
Route::post('/police/register/{id}', 'admin@regpol');

//admin add admin
Route::post('/admin/register/{id}', 'admin@regpol');

//update apikey add admin
Route::get('/admin/apikey/update', 'admin@up');

//do update apikey add admin
Route::post('/apikey/update', 'admin@update');

//announcements
Route::get('/announcements', 'admin@announcements');

//admin announcements
Route::post('/announcements/add/{id}', 'admin@addann');

//admin delete announcement
Route::get('/announcements/delete/{id}', 'admin@delann');

//admin delete news
Route::get('/news/delete/{id}', 'admin@delnews');


//police
//missingperson list police
Route::get('/missingperson/reports', 'police@missings');

//geo-map
Route::get('/geomap', 'police@geomap');

Route::post('/geomap/notif', 'police@notif');


//tests
//test email send
Route::get('/test/send', function () {
    Mail::to('jofeean@gmail.com')->send(new App\Mail\Emails('subject', 'body', 'Mr. Jofeean'));
});

//test mobile send
Route::get('/test/send/mobile', function () {

    function itexmo($number, $message, $apicode)
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

    $result = itexmo("09053139902", "Josh qaqo", "ST-ANTON124629_M8INX");

    if ($result == "") {
        echo "iTexMo: No response from server!!!
            Please check the METHOD used (CURL or CURL-LESS). If you are using CURL then try CURL-LESS and vice versa.	
            Please CONTACT US for help. ";
    } else if ($result == 0) {
        echo "Message Sent!";
    } else {
        echo "Error Num " . $result . " was encountered!";
    }

});

//test search
Route::get('/test/view', function () {
    $users = new App\missing;
    $key = 'Jofeean Male';
    $searches = explode(' ', $key);
    $data['missings'] = array();

    foreach ($searches as $search) {
        $user = $users
            ->orwhere('Missing_fname', 'LIKE', "%" . $search . "%")
            ->orWhere('Missing_mname', 'LIKE', "%" . $search . "%")
            ->orWhere('Missing_lname', 'LIKE', "%" . $search . "%")
            ->orWhere('Missing_gender', 'LIKE', "%" . $search . "%")
            ->orWhere('Missing_bday', 'LIKE', "%" . $search . "%")
            ->orWhere('Missing_livaddress', 'LIKE', "%" . $search . "%")
            ->orderBy('Missing_fname', 'asc')->get();

        foreach ($user as $use) {
            array_push($data['missings'], $use);
        }
    }

    $users = new App\user;
    $data['users'] = $users->get();
    $data['missings'] = array_unique($data['missings']);

    return view('missing.listresult', $data);
});

Route::get('/test/redirect', function () {
    return redirect('/')->withErrors(['registered' => 'registered']);
});

//test
//Route::get('/test', function () {
//
//    $date1 = new DateTime('7/22/1998');
//    $date = new DateTime('7/24/2017');
//    $now = new DateTime();
//    $dodis = $now->diff($date1);
//    $age = $now->diff($date);
//
//    echo strtotime('now') .' '. date("m/d/Y", strtotime('now'));
//
//});

//add admin static
//Route::get('/test/add/admin', function () {
//    $user = new App\admin();
//    $user->Admin_Name = 'Jofeean';
//    $user->Admin_lname = 'Ogario';
//    $user->Admin_gender = 'Male';
//    $user->Admin_bday = '7/24/1998';
//    $user->Admin_address = 'Sta. Mesa Manila';
//    $user->Admin_mobilenum = '09153616520';
//    $user->Admin_email = 'jofeean@gmail.com';
//    $user->Admin_password = bcrypt('Pugson@1030');
//    $user->save();
//});


//android
Route::prefix('api')->group(function () {
    Route::post('login', 'AndroidController@login');
    Route::post('loginPolice', 'AndroidController@loginPolice');
    Route::post('register', 'AndroidController@register');
    Route::post('registerPolice', 'AndroidController@registerPolice');
    Route::post('get_missing_persons', 'AndroidController@getMissingPersons');
    Route::post('get_missing_person', 'AndroidController@getMissingPerson');
    Route::post('report', 'AndroidController@report');
    Route::post('setToken', 'AndroidController@setToken');
    Route::post('sendNotification', 'AndroidController@sendNotification');
    Route::post('sendNotificationPolice', 'AndroidController@sendNotificationPolice');
    Route::post('getMyMissingPersons', 'AndroidController@getMyMissingPersons');
    Route::post('getAccountDetails', 'AndroidController@getAccountDetails');
    Route::get('createFaceList/{faceListId}', 'AndroidController@createFaceList');
    Route::get('deleteFaceList/{faceListId}', 'AndroidController@deleteFaceList');
    Route::get('addFace/{faceListId}/{url}', 'AndroidController@addFace');
    Route::get('detect/{url}', 'AndroidController@detect');
    Route::get('isFamiliar/{faceListId}/{faceId}', 'AndroidController@isFamiliar');

    Route::post('recognize', 'AndroidController@recognize');
    Route::post('add', 'AndroidController@add');
});
