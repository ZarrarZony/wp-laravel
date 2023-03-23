<?php
namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Footer_Model;
use App\Sites_Model;
use DB;
class FooterController extends Controller
{
    public $footermodel;
    public $sitesmodel;
    public $site_id;
    public function __construct()
    {
        $this->middleware('auth');
        $this->footermodel=new Footer_Model;
        $this->sitesmodel=new Sites_Model;
        $this->site_id=config('app.site_id');
        $this->middleware('permission:footer-create', ['only' => ['create','store']]);
        $this->middleware('permission:footer-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:footer-delete', ['only' => ['destroy']]);
        $this->middleware('permission:footer-list', ['only' => ['index']]);
    }

    public function index()
    {
        // $footer_data=$this->footermodel->select('*')->get();
        // $footer_data=json_decode(json_encode($footer_data),true);
        $footer_data=$this->footermodel->select('*')->paginate(5);
        return view('admin.footer.index',compact('footer_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //gather site data
        $site_db=$this->sitesmodel->select('site_id','name')->get();
        if(!empty($site_db)){
            $sites=$site_db;
        }else{
            $sites=null;
        }
        return view('admin.footer.footer',compact('sites'));
    }
    public function store(Request $request)
    {
          $data=$request->all();
          unset($data['_token']);
          if($data['content1']=='<p>&nbsp;</p>'){
            $data['content1']=null;
          }
         if($data['content2']=='<p>&nbsp;</p>'){
            $data['content2']=null;
          }
          DB::beginTransaction();
          try {
          $this->footermodel->insert($data);
            DB::commit();
           return redirect('admin/footers')->with('message', 'Footer Save Sucessfully');
            } catch (\Exception $e) {
           DB::rollback();
           dd($e);
           return back()->with('error', 'error please contact your software engineer');
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
      $footer_data=$this->footermodel->select('*')->where('site_id',$id)->get();
      $footer_data['editmod']=json_decode(json_encode($footer_data),true);
      if(empty($footer_data['editmod'])){
        $footer_data['editmod']=null;
      }
      return view('admin.footer.edit_footer',compact('footer_data'));
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
          $data=$request->all();
          unset($data['_token']);
          DB::beginTransaction();
          try {
            foreach ($data['footer'] as $key => $value){
            $footer_id=$value['footer_id'];
            unset($value['footer_id']);
            $this->footermodel->where('footer_id', $footer_id)->update($value);
            } 
            DB::commit();
           return redirect('admin/footers')->with('message', 'Footer Save Sucessfully');
            } catch (\Exception $e) {
           DB::rollback();
           dd($e);
           return back()->with('error', 'error please contact your software engineer');
          }
    }
    public function destroy($id)
    {
        $this->footermodel->find($id)->delete();
        return redirect('admin/footers')->with('message','Footer deleted successfully');
    }
}
