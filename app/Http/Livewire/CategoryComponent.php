<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Category;

class CategoryComponent extends Component
{

	use WithPagination;
	protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $search = "";

	public $name, $description;

	public $e_name, $e_description,$e_id;


	public function storeCategory()
	{
		$this->validate([
			'name' => 'required',
			'description' => 'required'
		]);

		$category = new Category();
		$category->name = $this->name;
		$category->description = $this->description;
		$category->save();
		session()->flash('message','Category Has Been Created.');
		$this->emit('addDepartment');
	}

	public function getCategory($id)
    {
        $category = Category::find($id);
        $this->e_id = $category->id;
        $this->e_name = $category->name;
        $this->e_description = $category->description;
    }

    public function updateCategory()
    {
    	$validatedDate = $this->validate([
            'e_name' => 'required|max:255',
	        'e_description' => 'required',
        ]);

        $category = Category::find($this->e_id);
        $category->name = $this->e_name;
        $category->description = $this->e_description;
        $category->save();
        session()->flash('message','Category Has Been Updated.');
        $this->emit('addDepartment');
    }

    public function deleteCategory($id)
    {
        $category = Category::with('info')->find($id);
        // $category->doctors()->delete();
        // $category->delete();
        dd("find me");
    }


    public function render()
    {
    	$allCategories = Category::search(trim($this->search))->paginate($this->paginate);
        return view('livewire.category-component',compact('allCategories'))->layout('layouts.base');
    }
}
