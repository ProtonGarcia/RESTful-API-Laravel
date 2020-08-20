<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Mail\UserCreated;
use App\User;
use Illuminate\Support\Facades\Mail;

class userController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();
        return $this->showAll($usuarios);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];

        $this->validate($request, $rules);

        $campos = $request->all();

        #encriptando la password
        $campos['password'] = bcrypt($request->password);

        #por defecto los usuarios no estan verificados
        $campos['verified'] = User::UNVERIFIED_USER;

        $campos['verification_token'] = User::verificationTokenGenerator();

        $campos['admin'] = User::NOT_ADMIN;


        $usuario = User::create($campos); //es una insercion masiva ya que se le pasa todo el array

        //return response()->json(['data' => $usuario], 201);

        return $this->showOne($usuario,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // $usuario = User::findOrFail($id);

       
        return $this->showOne($user);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in' . User::IS_ADMIN . ',' . User::NOT_ADMIN,
        ];

        $this->validate($request, $rules);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email') && $user->email != $request->email) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::verificationTokenGenerator();
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->has('admin')) {
            //$this->allowedAdminAction();

            if (!$user->isVerified()) {
                return $this->errorResponse('Unicamente los usuarios verificados pueden cambiar su valor de administrador', 409);
            }

            $user->admin = $request->admin;
        }

        if (!$user->isDirty()) {
            return $this->errorResponse('hay hay cambios para realizar', 422);
        }

        $user->save();

        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->showOne($user);
    }

    public function verify($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();

        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;

        $user->save();

        return $this->showMesage('la cuenta ha sido verificada');
    }

    public function resend(User $user)
    {
        if ($user->isVerified()) {
            return $this->errorResponse('Este usuario ya es verificado', 409);

        }

        Retry(5, function () use ($user) {
            Mail::to($user)->send(new UserCreated($user));
        }, 100);

        return $this->showMesage('el correo de verificacion se ha envidado');
    }
}
