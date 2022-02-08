<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Rol;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Snowfire\Beautymail\Beautymail;

class UsuarioApiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $user->load('empresa');
        return [
            'usuario' => $user,
            'empresas' => Empresa::active()->orderBy('nombre')->get()
        ];
    }
    public function search(Request $request)
    {
        $sortBy = $request->input('sort_by');
        $status = $request->input('status');
        $search = $request->input('search');
        $currentPage = $request->input('current_page');
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        $user = $request->user();
        $users = User::with([
            'roles' => function ($query) use ($user) {
                $query->current($user->empresa_id);
            }
        ])->whereHas('roles', function ($query) use ($user, $status) {
            $query->current($user->empresa_id);
            if ($status !== 'T')
                $query->where('privilegios.estado', $status);
        })
            ->where(function ($query) use ($search) {
                return $query->where('name', 'like', "%$search%")->orWhere('email', 'like', "%$search%");
            });
        if (isset($sortBy) && $sortBy !== '')
            $users->orderBy($sortBy, $request->input('sort_order'));
        return $users->paginate($request->input('per_page'));
    }
    public function cambiarEmpresaActual(Request $request, $empresaId)
    {
        $user = $request->user();
        $user->empresa_id = $empresaId;
        $user->save();
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:500|unique:users',
            'roles' => 'required|array',
            'password' => 'required|min:6|confirmed',
            'numero_identificacion' => 'required|max:20|unique:users'
        ]);
        $user = $request->user();
        $usuario = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'creador_id' => $user->id,
            'empresa_id' => $user->empresa_id,
            'password' => bcrypt($request->input('password')),
            'numero_identificacion' => $request->input('numero_identificacion')
        ]);
        $roles = $request->input('roles');
        $usuario->roles()->current($user->empresa_id)->sync($roles);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => [
                'required', 'max:500', Rule::unique('users')->ignore($id)
            ],
            'roles' => 'required|array',
            'password' => 'nullable|min:6|confirmed',
            'numero_identificacion' => ['required', 'max:20', Rule::unique('users')->ignore($id)]
        ]);
        $user = $request->user();
        $usuario = User::findOrFail($id);
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->numero_identificacion = $request->input('numero_identificacion');
        $usuario->modificador_id = $user->id;
        $password = $request->input('password');
        if (isset($password))
            $usuario->password = bcrypt($password);
        $usuario->save();
        $roles = $request->input('roles');
        $usuario->roles()->current($user->empresa_id)->sync($roles);
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'usuarios' => 'required|array'
        ]);
        $user = $request->user();
        $usuarios = $request->input('usuarios');
        DB::table('privilegios')->whereIn('usuario_id', $usuarios)
            ->whereIn('rol_id', Rol::where('empresa_id', $user->empresa_id)->get()->pluck('id')->all())
            ->update([
                'estado' => DB::raw('if(estado = "A", "I", "A")')
            ]);
    }
    public function perfil(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'name' => 'required|max:255',
            'email' => [
                'required', 'max:500', Rule::unique('users')->ignore($user->id)
            ],
            'password' => 'nullable|min:6|confirmed'
        ]);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $password = $request->input('password');
        if (isset($password))
            $user->password = bcrypt($password);
        $user->save();
    }
    public function datos(Request $request)
    {
        return $request->user();
    }
    public function reset(Request $request)
    {
        $request->validate([
            'email' => [
                'required', Rule::exists('users')->where('estado', 'A')
            ]
        ]);
        $user = User::where('email', 'like', $request->input('email'))->active()->firstOrFail();
        $user->token_recuperacion = uniqid('t' . date('YmdHi'), true);
        $user->save();
        $beautymail = app()->make(Beautymail::class);
        $beautymail->send('emails.reset', [
            'user' => $user
        ], function ($message) use ($user) {
            $message
                ->to($user->email, $user->name)
                ->subject(__('subject.password_reset'));
        });
    }
    public function setPassword(Request $request)
    {
        $request->validate([
            'email' => [
                'required', Rule::exists('users')->where('estado', 'A')
            ],
            'token' => [
                'required', Rule::exists('users', 'token_recuperacion')->where('email', $request->input('email'))
            ],
            'password' => 'nullable|min:6|confirmed'
        ]);
        $email = $request->input('email');
        $user = User::where('email', 'like', $email)
            ->where('token_recuperacion', $request->input('token'))
            ->firstOrFail();
        $user->password = bcrypt($request->input('password'));
        $user->token_recuperacion = null;
        $user->save();
    }
}
