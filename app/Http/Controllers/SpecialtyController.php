<?php

namespace App\Http\Controllers;

use App\Repositories\Repository;
use App\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    protected $model;

    public function __construct(Specialty $specialty)
    {
        $this->middleware(['auth', 'admin']);
        $this->model = new Repository($specialty);
    }

    public function index()
    {
        $collection=$this->model->paginate(1);
        return view('specialties.index',['collection'=>$collection]);

    }

    public function create()
    {
        return view('specialties.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:500'
        ]);
        $this->model->create($request->only($this->model->getModel()->fillable));
        return redirect()->back()->with('message','created done');
    }

    public function show($id)
    {
       return $this->model->show($id);
    }

    public function edit($id)
    {
        return view('specialties.edit',['specialty'=>$this->model->show($id)]);
    }

    public function update(Request $request, $id)
    {
        $this->model->update($request->only($this->model->getModel()->fillable), $id);
        return redirect()->back()->with('message','updated done');
    }

    public function destroy($id)
    {
         $this->model->delete($id);
         return redirect()->back()->with('message','deleted done');
    }
}
