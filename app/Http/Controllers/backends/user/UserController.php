<?php

namespace App\Http\Controllers\backends\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backends.pages.user.index');
    }


    /**
     * Display a tables data.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        try {
            $users = User::with('user')->get();
            return Datatables::of($users)->addIndexColumn()
            ->addColumn('actions', function ($user) {
                return (string) view('backends.pages.user.actions', ['user' => $user]);
            })->rawColumns(['actions','status'])->make();
        } catch (\Exception $th) {
            // return back()->withErrors([
            //     'error'=>'Seek system administrator help',
            //     'error-dev'=> $th->getMessage()
            // ]);
        }

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backends.pages.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->active_fg = 1;
            // $user->created_by = 1;
            $user->created_by = Auth::user()->id;
            $is_saved = $user->save();
            if ($is_saved) {
                return back()->with('message', 'User has been added');
            } else {
                return back()->withErrors(['error'=>'User has not been added']);
            }
        } catch (\Exception $th) {
            return back()->withErrors([
                'error'=>'Seek system administrator help',
                'error-dev'=> $th->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findorFail($id);
        return view('backends.pages.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            // $user->updated_by = 1;
            $user->updated_by = Auth::user()->id;
            $is_saved = $user->save();
            if ($is_saved) {
                return back()->with('message', 'User has been deleted');
            } else {
                return back()->withErrors(['error'=>'User has not been deleted']);
            }
        } catch (\Exception $th) {
            return back()->withErrors([
                'error'=>'Seek system administrator help',
                'error-dev'=> $th->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->active_fg = 0;
            // $user->updated_by = Auth::user()->id;
            $user->updated_by = 1;
            $is_saved = $user->save();
            if ($is_saved) {
                return back()->with('message', 'User has been deleted');
            } else {
                return back()->withErrors(['error'=>'User has not been deleted']);
            }
        } catch (\Exception $th) {
            return back()->withErrors([
                'error'=>'Seek system administrator help',
                'error-dev'=> $th->getMessage()
            ]);
        }
    }
}
