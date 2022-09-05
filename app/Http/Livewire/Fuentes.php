<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Fuente;

class Fuentes extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre_fuente, $hiden;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.fuentes.view', [
            'fuentes' => Fuente::latest()
						->orWhere('nombre_fuente', 'LIKE', $keyWord)
						->paginate(10),
        ]);
    }
	
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }
	
    private function resetInput()
    {		
		$this->nombre_fuente = null;
    }

    public function store()
    {
        $this->validate([
		'nombre_fuente' => 'required',
        ]);

        Fuente::create([ 
			'nombre_fuente' => $this-> nombre_fuente
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Fuente Successfully created.');
    }

    public function edit($id)
    {
        $record = Fuente::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombre_fuente = $record-> nombre_fuente;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'nombre_fuente' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Fuente::find($this->selected_id);
            $record->update([ 
			'nombre_fuente' => $this-> nombre_fuente
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Fuente Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Fuente::where('id', $id);
            $record->delete();
        }
    }
}
