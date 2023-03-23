<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sites_Model;
use Illuminate\Support\Facades\File;
use App\Library\Upload;
use DB;

class SitesController extends Controller
{
    public $sitemodel;
    public function __construct(){
    $this->sitemodel=new Sites_Model;
    $this->middleware('permission:sites-create', ['only' => ['create','store']]);
    $this->middleware('permission:sites-edit', ['only' => ['edit','update']]);
    $this->middleware('permission:sites-delete', ['only' => ['destroy']]);
    $this->middleware('permission:sites-list', ['only' => ['index']]);
    }
    public function index()
    {
          $sites=$this->sitemodel->select('*')->paginate(5);
          return view('admin.sites.index',compact('sites'));
    }

    public function create()
    {
        $temp_header=null;
        $temp_header=null;
        $temp_header=getheadfoot('header');
        $temp_footer=getheadfoot('footer');
        return view('admin.sites.sites',compact('temp_header','temp_footer'));
    }

    public function store(Request $request)
    {
        $data=$request->all();
        $data=$data['insert'];
        if(!isset($data['publish'])){
           $data['publish']=0;
         }
        DB::beginTransaction();
        //get check weather the site already exists or not
        $exists=$this->sitemodel->select('url')->where(['url'=>$data['url']])->first();
        if($exists){
        return back()->with('error', 'error site duplication not allowed');
        exit;
        }
        try {
            $data['site_id']=$this->sitemodel->insertGetId($data);
            DB::commit();
            return redirect('admin/sites')->with('message', 'Data Save Sucessfully');
            }
            catch (\Exception $e) {
                   DB::rollback();
                   return back()->with('error', 'error please contact you software engineer');
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

    public function edit($id)
    {
      $site_data=$this->sitemodel->find($id);
      $site_data=json_decode(json_encode($site_data),true);
      $temp_header=[];
      $temp_footer=[];
      $temp_header=getheadfoot('header');
      $temp_footer=getheadfoot('footer');
      return view('admin.sites.sites',compact('temp_header','temp_footer','site_data'));
    }

    public function update(Request $request, $id)
    {
        $data=$request->all();
        $data=$data['insert'];
        if(!isset($data['publish'])){
           $data['publish']=0;
         }
        DB::beginTransaction();
        try {
            unset($data['_token']);
            $site_data = $this->sitemodel->find($id);
            $site_data->update($data);
            DB::commit();
            return redirect('admin/sites')->with('message', 'Data Updated Sucessfully');
            }
            catch (\Exception $e) {
                   DB::rollback();
                   dd($e);
                   return back()->with('error', 'error please contact you software engineer');
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
        $this->sitemodel->find($id)->delete();
        return redirect('admin/sites')->with('message','Site deleted successfully');
    }
}
