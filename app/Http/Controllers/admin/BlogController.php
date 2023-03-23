<?php
namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Blog_model;
use App\Sites_Model;
use App\Library\Upload;
use DB;
use Auth;
class BlogController extends Controller
{
    public $blogmodel;
    public $smodel;
    public $catmodel;
    public $storemodel;
    public $blog_cat_model;
    public function __construct(){
         $this->blogmodel=new Blog_model;
         $this->middleware('auth');
         $this->smodel=new Sites_Model;
         $this->site_id=config('app.site_id');
        $this->middleware('permission:blog-create', ['only' => ['create','store']]);
        $this->middleware('permission:blog-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:blog-delete', ['only' => ['destroy']]);
        $this->middleware('permission:blog-list', ['only' => ['index']]);
    }
    public function index()
    {
        // $site_blogs=$this->blogmodel->select('*')->get();
        // $site_blogs=json_decode(json_encode($site_blogs),true);
        $site_blogs=$this->blogmodel->select('*')->paginate(5);
        return view('admin.blogs.index',compact('site_blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sites=$this->smodel->select('*')->get();
        $blog_data=$this->blogmodel->select('*')->get();
        return view('admin.blogs.blogs',compact('blog_data','sites'));
    }

    public function store(Request $request)
    {
       $data = $request->all();
       DB::beginTransaction();
       try {
        unset($data['_token']);
           $data2['blog_id']=$this->blogmodel::insertGetId($data);
            DB::commit();
           return redirect('admin/blogs')->with('message', 'Blog Save Sucessfully');
         }catch (\Exception $e) {
               DB::rollback();
               dd($e);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $site_blog=$this->blogmodel->where('blog_id',$id)->first();
      $site_blog=json_decode(json_encode($site_blog),true);
      $blog_data=$this->blogmodel->select('*')->get();
      //get sites
      $sites=$this->smodel->select('*')->get();
      return view('admin.blogs.blogs',compact('site_blog','blog_data','sites'));
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
        $this->blogmodel->find($id)->update($data);
        return redirect('admin/blogs')->with('message','Blog updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->blogmodel->find($id)->delete();
        return redirect('admin/blogs')->with('message','Blog deleted successfully');
    }
}
