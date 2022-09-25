<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Vault;
use App\Models\Category;
use Illuminate\Support\Facades\Crypt;
use Auth;

class HomeComponent extends Component
{
	use WithPagination;
	protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $search = "";

    public $site, $link, $user_name, $email, $password, $category_id, $user_code;

    public $e_site, $e_link, $e_user_name, $e_email, $e_password, $e_category_id, $flag;

    public $v_pass = "***************";
    public $v_pass_Id;
    public $verify_pass;


    public function storeVault()
	{
		$this->validate([
			'site' => 'required',
			'link' => 'required',
			'user_name' => 'required',
			'email' => 'required',
			'password' => 'required',
			'category_id' => 'required'
		]);

		$this->user_code = Auth::user()->user_code;

		$vault = new Vault();
		$vault->site = $this->site;
		$vault->link = $this->link;
		$vault->user_name = $this->user_name;
		$vault->email = $this->email;
		$vault->password = Crypt::encryptString($this->password);
		// Crypt::decryptString($encryptedValue)
		$vault->category_id = $this->category_id;
		$vault->user_code = $this->user_code;
		// dd($vault);
		$vault->save();
		session()->flash('message','Info Has Been Added.');
		$this->emit('addDepartment');
	}

	public function getInfo($id)
	{
		$this->v_pass_Id = $id;
		
	}

	public function updateVault()
	{
		$updateInfo = Vault::find($this->v_pass_Id);
		
		$updateInfo->site = $this->e_site;
		$updateInfo->link = $this->e_link;
		$updateInfo->user_name = $this->e_user_name;
		$updateInfo->email = $this->e_email;
		$updateInfo->password = Crypt::encryptString($this->e_password);
		$updateInfo->category_id = $this->e_category_id;
		$updateInfo->save();
		session()->flash('message','Info Has Been Updated.');
		$this->emit('addDepartment');
		self::clear();
	}

	public function viewInfo()
	{
		$info = Vault::find($this->v_pass_Id);
		$verified = self::verifyPass();
		if ($verified) {
			$this->flag = $verified;
			$this->e_site = $info->site;
			$this->e_link = $info->link;
			$this->e_user_name = $info->user_name;
			$this->e_email = $info->email;
			$this->e_password = Crypt::decryptString($info->password);
			$this->e_category_id = $info->category_id;
		}
	}

	public function viewPass()
	{
		$verified = self::verifyPass();
		$info = Vault::find($this->v_pass_Id);
		$info_pass = $info->password; 

		if ($verified) {
			$this->v_pass = Crypt::decryptString($info_pass);
			// dd($this->v_pass);
		}
	}

	public function verifyPass()
	{
		$user_pass = Auth::user()->password;
		$verified = password_verify($this->verify_pass, $user_pass);
		return $verified;
	}

	public function clear()
	{
		$this->flag = false;
		$this->verify_pass = "";
		$this->e_site = "";
		$this->e_link = "";
		$this->e_user_name = "";
		$this->e_email = "";
		$this->e_password = "";
		$this->e_category_id = "";
		$this->v_pass = "***************";
		
	}

	public function deleteInfo($id)
	{
		$destroy = Vault::find($id);
		$destroy->delete();
	}

    public function render()
    {
    	$user_code = Auth::user()->user_code;
    	$allInfo = Vault::where('user_code',$user_code)->with('category')->search(trim($this->search))->paginate($this->paginate);
    	$allCategories = Category::all();
        return view('livewire.home-component',compact('allInfo','allCategories'))->layout('layouts.base');
    }
}
