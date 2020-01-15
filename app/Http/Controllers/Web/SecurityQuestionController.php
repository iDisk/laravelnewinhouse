<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SecurityQuestion;
use Yajra\DataTables\Facades\DataTables;
use App\Support\Util;
use Validator;

class SecurityQuestionController extends Controller
{
    /*
    * Constructor de la clase que instancia el middleware auth
    */
    public function __construct()
    {
        $this->middleware('seguridad')->only('index');
    }

    //Funcion para DataTable
    public function datasecurityquestions()
    {

        $question_types = array('1'=>'Question 1','2'=>'Question 2','3'=>'Question 3');

        if(\Lang::locale() == 'es'){
            $question_types = array('1'=>'Pregunta 1','2'=>'Pregunta 2','3'=>'Pregunta 3');
        }

        $security_questions = SecurityQuestion::select('security_questions.*');

        return DataTables::of($security_questions)
            ->addColumn('action', function ($security_questions) {
                $botones = '<a href="'.url('security_questions/'.$security_questions->id.'/edit').'" class="btn btn-xs btn-info waves-effect waves-light"><i class="fa fa-edit"></i> '.__('sistema.btn_edit').'</a> ';
                return $botones;
            })
            ->editColumn('question_type', function ($security_questions)  use ($question_types){

                if($question_types[$security_questions->question_type])
                {
                    return $question_types[$security_questions->question_type];
                }else{
                    return '';
                }
            })
            ->editColumn('created_at', function ($security_questions) {
                return $security_questions->created_at->format('d/m/Y H:i');                
            })
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);

        return view('catalogos.security_questions.index')->with('elmenu',['elmenu'=>$lstMenus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);

        $question_types = array(array('id'=>1,'value'=>'Question 1'),array('id'=>2,'value'=>'Question 2'),array('id'=>3,'value'=>'Question 3'));

        if(\Lang::locale() == 'es'){
            $question_types = array(array('id'=>1,'value'=>'Pregunta 1'),array('id'=>2,'value'=>'Pregunta 2'),array('id'=>3,'value'=>'Pregunta 3'));
        }

        return view('catalogos.security_questions.new')
                ->with('question_types',$question_types)
                ->with('elmenu',['elmenu'=>$lstMenus]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $campos = $request->all();

        $rules = array(
            'question_en' => 'required',
            'question_es' => 'required',
            'question_type' => 'required',
        );
        $messages = array(
            'question_en.required' =>  __('sistema.security_question.questionen_required'),
            'question_es.required' =>  __('sistema.security_question.questiones_required'),
            'question_type.required' =>  __('sistema.security_question.question_type_required'),
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails())
        {
            return redirect('security_questions/create')->withInput()->withErrors($validator);
            
        }else{

            //Create
            $security_question = new SecurityQuestion;
            $security_question->fill($campos);
            $security_question->save();

            return redirect('security_questions')->with('msg',__('sistema.save_success_msg'))->with('type','success');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        $security_question = SecurityQuestion::find($id);

        $question_types = array(array('id'=>'1','value'=>'Question 1'),array('id'=>'2','value'=>'Question 2'),array('id'=>'3','value'=>'Question 3'));

        if(\Lang::locale() == 'es'){
            $question_types = array(array('id'=>'1','value'=>'Pregunta 1'),array('id'=>'2','value'=>'Pregunta 2'),array('id'=>'3','value'=>'Pregunta 3'));
        }

        return view('catalogos.security_questions.edit')
                ->with('elmenu',['elmenu'=>$lstMenus])
                ->with('question_types',$question_types)
                ->with('security_question',$security_question);                
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $campos = $request->all();

        $rules = array(
            'question_en' => 'required',
            'question_es' => 'required',
            'question_type' => 'required',
        );
        $messages = array(
            'question_en.required' =>  __('sistema.security_question.questionen_required'),
            'question_es.required' =>  __('sistema.security_question.questiones_required'),
            'question_type.required' =>  __('sistema.security_question.question_type_required'),
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails())
        {
            return redirect('security_questions/'.$id.'/edit')->withInput()->withErrors($validator);
            
        }else{

            //Udate
            $security_question = SecurityQuestion::find($id);
            $security_question->fill($campos);
            $security_question->save();

            return redirect('security_questions')->with('msg',__('sistema.update_success_msg'))->with('type','success');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
