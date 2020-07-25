<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

use App\Login_credential;
use App\Service;
use App\Project;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userLogged = Auth::id();
        $login_credentials = Login_credential::where('user_id', '=', $userLogged)->get();

        return view('dashboard', compact('login_credentials'));
    }

    public function store(Request $request)
    {
        // dd('hello');

        // Pensare alla questione case sensitive

        $data = $request->all();

        $validator = Validator::make($data, [
            'username' => 'required|max:100',
            'password' => 'required|max:255',
            'project' => 'required|max:100', // da aggiungere unique
            'service' => 'required|max:100', // da aggiungere unique
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data['user_id'] = Auth::id();

        $data['password'] = Crypt::encryptString($data['password']); // Encrypting Without Serialization

        // se il progetto esisite prendo l'id
        if (Project::where('name', '=', $data['project'])->exists()) {
            $data['project_id'] = Project::where('name', '=', $data['project'])->value('id');
        } else { // se non esiste lo creo e prendo l'id
            $project = new Project;
            $project->name = $data['project'];
            $project->user_id = $data['user_id'];
            $project->save();
            // sleep(1);

            $data['project_id'] = Project::find($project->id)->id;
        }

        if (Service::where('name', '=', $data['service'])->exists()) {
            $data['service_id'] = Service::where('name', '=', $data['service'])->value('id');
        } else {
            $service = new Service;
            $service->name = $data['service'];
            $service->user_id = $data['user_id'];
            $service->save();
            // sleep(1);

            $data['service_id'] = Service::find($service->id)->id;
        }

        $login_credential = new Login_credential;
        $login_credential->fill($data);

        $saved = $login_credential->save();

        if (!$saved) {
            return redirect()->back()->withInput(); // with status ???
        }

        return redirect()->route('dashboard');
    }

    // public function decrypt_password(Request $request) {
    //     // code...
    // }
}
