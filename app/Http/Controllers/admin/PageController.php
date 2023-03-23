<?php
namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sites_Model;
use App\Page_model;
use DB;
class PageController extends Controller
{
    public $pagemodel;
    public $bannermodel;
    public $smodel;
    public function __construct()
    {
        $this->middleware('auth');
        $this->pagemodel=new Page_model;
        $this->smodel=new Sites_Model;
        $this->middleware('permission:page-create', ['only' => ['create','store']]);
        $this->middleware('permission:page-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:page-delete', ['only' => ['destroy']]);
        $this->middleware('permission:page-list', ['only' => ['index']]);
    }
    public function index()
    {
        $page_data=$this->pagemodel->select('*')->paginate(5);
        return view('admin.pages.index',compact('page_data'));
    }

    public function create()
    {
        $sites=$this->smodel->select('site_id','name')->get();
        return view('admin.pages.page',compact('sites'));
    }

    public function store(Request $request)
    {
       $data = $request->all();
       if(isset($data['submit_preview']) && !empty($data['submit_preview'])){
        return $this->preview($data);
       }
        try{
            $modules_encode=json_encode($data['page_modules']);
            $data['page_modules']=$modules_encode;
            $this->pagemodel->insert($data);
            DB::commit();
            return redirect('admin/pages')->with('message', 'Page Save Sucessfully');
           } catch (\Exception $e) {
           DB::rollback();
           dd($e);
           return back()->with('error', 'error please contact your software engineer');
          }
    }

    public function show($id)
    {
        die('no data');
    }
    public function edit($id)
    {
      $sites=$this->smodel->select('site_id','name')->get();
      $page_data=$this->pagemodel->select('*')->where('page_id',$id)->first();
      $page_data=json_decode(json_encode($page_data),true);
        $templates=[];
        $modules=[];
        $pages_dir = resource_path('views/web/templates/Pages/'.$page_data['page_for']);
        $files = scandir($pages_dir);
        foreach ($files as $key => $value) {
            if($value !='.' && $value !='..'){
                $file=explode('.', $value);
                $efile=$file[0];
                $templates[$efile]=$efile;
            }
        }
        $pages_dir    = resource_path('views/web/templates/Modules/'.$page_data['page_for'].'/'.$page_data['page_template']);
        $files = scandir($pages_dir);
        foreach ($files as $key => $value) {
            if($value !='.' && $value !='..'){
                $file=explode('.', $value);
                $efile=$file[0];
                $modules[$efile]=$efile;
            }
        }
        $page_modules=json_decode($page_data['page_modules'],true);
        $page_data['page_modules']=$page_modules;
        return view('admin.pages.page',compact('sites','page_data','templates','modules'));
    }

    public function update(Request $request, $id)
    {
       $data = $request->all();
       if(isset($data['submit_preview']) && !empty($data['submit_preview'])){
        return $this->preview($data);
       }
       DB::beginTransaction();
       try {
            $modules_encode=json_encode($data['page_modules']);
            $data['page_modules']=$modules_encode;
            if(!isset($data['publish'])){
                $data['publish']=0;
            }
        $page = $this->pagemodel->find($id);
        $page->update($data);
          DB::commit();
           return redirect('admin/pages')->with('message', 'Page Updated Sucessfully');
           } catch (\Exception $e) {
           DB::rollback();
           dd($e);
           return back()->with('error', 'error please contact your software engineer');
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
        $this->pagemodel->find($id)->delete();
        return redirect('admin/pages')->with('message','Page deleted successfully');
    }

    // page preview
    public function preview($data){
        if(!isset($data['page_modules']) && empty($data['page_modules'])){
            return back()->with('error', 'You must select a template and its modules');
        }
        $template=$data['page_template'];
        $page_data=(object)$data;
        return view('web.templates.Pages.'.$data['page_for'].'.'.$template,compact('page_data'));
    }
}
