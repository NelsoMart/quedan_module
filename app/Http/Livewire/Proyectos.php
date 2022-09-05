<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Proyecto;

class Proyectos extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre_proyecto, $hiden;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.proyectos.view', [
            'proyectos' => Proyecto::latest()
						->orWhere('nombre_proyecto', 'LIKE', $keyWord)
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
		$this->nombre_proyecto = null;
    }

    public function store()
    {
        $this->validate([
		'nombre_proyecto' => 'required',
        ]);

        Proyecto::create([ 
			'nombre_proyecto' => $this-> nombre_proyecto
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Proyecto Successfully created.');
    }

    public function edit($id)
    {
        $record = Proyecto::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombre_proyecto = $record-> nombre_proyecto;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'nombre_proyecto' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Proyecto::find($this->selected_id);
            $record->update([ 
			'nombre_proyecto' => $this-> nombre_proyecto
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Proyecto Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Proyecto::where('id', $id);
            $record->delete();
        }
    }
}
