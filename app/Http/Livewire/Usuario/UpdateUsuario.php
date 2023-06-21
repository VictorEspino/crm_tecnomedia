<?php

namespace App\Http\Livewire\Usuario;

use Livewire\Component;
use App\Models\User;
use App\Models\Compania;
use App\Models\Puesto;

class UpdateUsuario extends Component
{
    public $id_user;
    public $debug;

    public $open=false;
    public $procesando=0;

    public $email_inicial;

    public $usuario;
    public $email;
    public $nombre;
    public $puesto;
    public $compania;
    public $estatus;

    public $companias=[];
    public $puestos=[];

    public function render()
    {
        return view('livewire.usuario.update-usuario');
    }
    public function mount($id_user)
    {
        $this->id_user=$id_user;
    }
    public function edit_open()
    {
        $this->open=true;
        $this->procesando=0;
        $user=User::find($this->id_user);
        $this->companias=Compania::where('estatus',1)
                        ->orderBy('nombre','asc')
                        ->get();
        $this->puestos=Puesto::where('visible',1)->orderBy('nombre','asc')
                        ->get();
        $this->nombre=$user->name;
        $this->usuario=$user->usuario;
        $this->email_inicial=$user->email;
        $this->email=$user->email;
        $this->puesto=$user->puesto;
        $this->compania=$user->compania;
        $this->estatus=$user->estatus;
    }

    public function cancelar()
    {
        $this->open=false;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function guardar()
    {
        $this->validacion();
        $this->procesando=1;
        User::where('id',$this->id_user)
            ->update([
                        'email'=>$this->email,
                        'name'=>$this->nombre,
                        'puesto'=>$this->puesto,
                        'compania'=>$this->compania,
            ]);
        $this->open=false;
        $this->emit('usuarioModificado');
    }

    private function validacion()
    {
        $reglas = [
            'email'=>'required|email',
            'nombre' => 'required',
            'puesto' => 'required',
            'compania'=>'required',
          ];
        if($this->email_inicial!=$this->email)
        {
            $reglas = array_merge($reglas, [
                'email' => 'unique:users,email',
              ]);
        }
        //dd($reglas);
        $this->validate($reglas,
            [
                'required' => 'Campo requerido.',
                'numeric'=>'Debe ser un numero',
                'unique'=>'El valor ya existe en la base de datos',
                'email'=>'Se requiere una direccion de correo valida'
            ],
          );
    }
    public function cambiar_estatus()
    {
        User::where('id',$this->id_user)
            ->update(['estatus'=>($this->estatus=='1'?0:1)]);

        if($this->estatus=='1')
        {
            User::where('id',$this->id_user)
            ->update(['password'=>'INACTIVO']);
        }
        $this->open=false;
        $this->emit('usuarioModificado');
    }
    public function reset_password()
    {
        User::where('id',$this->id_user)
            ->update(['password'=>'$2y$10$l3Ie3V7nvjxar33TlexunOeoP.0t9EnvwvyEDkCk1sIdjKjoO1oRK']);
        $this->open=false;
        $this->emit('usuarioModificado');
    }
}
