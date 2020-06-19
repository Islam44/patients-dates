<?php

namespace App\Http\Controllers;

use App\Pain;
use App\Repositories\Repository;
use App\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PainController extends Controller
{
    protected $model;
    protected $specialtyModel;

    public function __construct(Pain $pain,Specialty $specialtyModel)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['except' => ['pains']]);
        $this->model = new Repository($pain);
        $this->specialtyModel = (new Repository($specialtyModel));
    }

    public function index()
    {
        $collection=$this->model->paginate(1);
        return view('pains.index',['collection'=>$collection]);

    }

    public function create()
    {
        $specialties=$this->specialtyModel->all();
        return view('pains.create',['specialties'=>$specialties]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|max:500',
            'specialty_id'=>'required'
        ]);
        $this->model->create($request->only($this->model->getModel()->fillable));
        return redirect('pains')->with('message','created done');
    }

    public function show($id)
    {
        return $this->model->show($id);
    }

    public function edit($id)
    {
        $specialties=$this->specialtyModel->all();
        return view('pains.edit',['pain'=>$this->model->show($id),'specialties'=>$specialties]);
    }

    public function update(Request $request, $id)
    {
        $this->model->update($request->only($this->model->getModel()->fillable), $id);
        return redirect('pains')->with('message','updated done');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id){
            $pain=$this->model->show($id);
            DB::table('notifications')->whereIn('identifier',$pain->appointments)->delete();
            $this->model->delete($id);
        });
        return redirect('pains')->with('message','deleted done');
    }

    public function pains(Specialty $specialty)
    {
        return response()->json($specialty->pains);
    }
}
