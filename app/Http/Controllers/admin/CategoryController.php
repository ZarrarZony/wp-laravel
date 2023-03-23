<?php
namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sites_Model;
use App\Categories_Model;
use Illuminate\Support\Facades\File;
use App\Library\Upload;
use DB;
class CategoryController extends Controller
{
    public $catmodel;
    public $smodel;
    public function __construct()
    {
        $this->catmodel=new Categories_Model;
        $this->middleware('auth');
        $this->smodel=new Sites_Model;
        $this->middleware('permission:category-create', ['only' => ['create','store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
        $this->middleware('permission:category-list', ['only' => ['index']]);
    }

    public function index()
    {
        // $cat_data=$this->catmodel->select('*')->get();
        // $cat_data=json_decode(json_encode($cat_data),true);
        $cat_data=$this->catmodel->select('*')->paginate(5);
        return view('admin.category.index',compact('cat_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $for_slug=$this->catmodel->select('*')->get();
        //get sites
        $sites=$this->smodel->select('*')->get();
        return view('admin.category.category',compact('for_slug','sites'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    $data=$request->all();
     DB::beginTransaction();
      try {
        if(!empty($data['icon'])){
        $file=$data['icon'][0];
        $image_content = @file_get_contents($file);
        $site_short_name = getSiteShortNameBySiteIds($data['site_id']);
        $name = renameUploadFile(basename($file));
        $data['icon']=$name;
        if($image_content){
        uploadFileToS3Bucket($name, $image_content, $site_short_name, 'category');
        }
        } 
       unset($data['_token']);
       if(isset($data['slug_parent_id']) && !empty($data['slug_parent_id'])){
        $parent_slug=$this->catmodel->select('slug')->where(['cat_id'=>$data['slug_parent_id']])->first();
        $slug_concatenate=$parent_slug['slug'].'/'.$data['slug'];
        $data['slug']=$slug_concatenate;
       }
       $this->catmodel->insert($data);
       DB::commit();
       return redirect('admin/categories')->with('message', 'Data Save Sucessfully');
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
      $cat_data=DB::table('site_categories')->select('*')->where('cat_id',$id)->first();
      $cat_data=json_decode(json_encode($cat_data),true);
      $for_slug=$this->catmodel->select('*')->get();
        //get sites
      $sites=$this->smodel->select('*')->get();
      @$cat_img = $cat_data['icon'];
      @$site_id = @$cat_data['site_id'];
      $unique_name = "icon";
      $folder='category';
      $upload = new Upload();
      $cat_img = $upload->kc_finder_images2($cat_img,$unique_name,$site_id,$folder);
      return view('admin.category.category',compact('cat_data','for_slug','sites','cat_img'));
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
       $data = $request->all();
       DB::beginTransaction();
       try {
        if(!empty($data['icon'])){
        $file=$data['icon'][0];
        $image_content = @file_get_contents($file);
        $site_short_name = getSiteShortNameBySiteIds($data['site_id']);
        $name = renameUploadFile(basename($file));
        $data['icon']=$name;
        if($image_content){
        uploadFileToS3Bucket($name, $image_content, $site_short_name, 'category');
        }
        } 
        unset($data['_token']);
        $category = $this->catmodel->find($id);
        $category->update($data);
            DB::commit();
            return redirect('admin/categories')->with('message', 'Category Updated Sucessfully');
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
        $this->catmodel->find($id)->delete();
        return redirect('admin/categories')->with('message','Category deleted successfully');
    }
}
