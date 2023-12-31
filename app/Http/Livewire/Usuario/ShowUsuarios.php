<?php

namespace App\Http\Livewire\Usuario;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ShowUsuarios extends Component
{
    use WithPagination;

    public $filtro='';
    public $elementos=10;

    protected $listeners = ['usuarioAgregado' => 'render','usuarioModificado'=>'render'];

    public function updatingElementos()
    {
        $this->resetPage();
    }
    public function updatingFiltro()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users=User::with('compania_desc','puesto_desc')->where('name','like','%'.$this->filtro.'%')
                        ->where('visible',1)
                        ->orderBy('name','asc')
                        ->paginate($this->elementos);

        return view('livewire.usuario.show-usuarios',['users'=>$users]);
    }
    public function mount()
    {
        if(Auth::user()->perfil=='MIEMBRO' && Auth::user()->carga_empleados=="0")
        {
            return redirect()->to('/');
        }
    }
}
