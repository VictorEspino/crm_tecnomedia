<?php

namespace App\Http\Livewire\Prospecto;

use Livewire\Component;

class NuevoProspecto extends Component
{
    public $open=false;

    public function render()
    {
        return view('livewire.prospecto.nuevo-prospecto');
    }
    public function nuevo()
    {
        $this->open=true;
    }
    public function cancelar()
    {
        $this->open=false;
    }
}
