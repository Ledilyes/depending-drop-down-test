<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\state;
use App\Models\city;




class UserProduct extends Controller
{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         
        $products['products'] = Product::where('user_id','=',Auth::user()->id)->get();
        return view('user.userproduct.index')->with($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    	$category=Category::where('is_parent',1)->get();
        $state=state::all();
        $city=city::where('state_id',1)->get();
        // return $category;
        return view('user.userproduct.create')->with('categories',$category)->with('state',$state)->with('city',$city);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
            'title'=>'string|required',
            //'summary'=>'string|required',
            'description'=>'string|nullable',
            'photo'=>'string|required',
            //'size'=>'nullable',
            //'stock'=>"required|numeric",
            'city_id'=>'required|exists:cities,id',
            'state_id'=>'required|exists:states,id',
            'city_id'=>'required|exists:cities,id',
            //'brand_id'=>'nullable|exists:brands,id',
            'child_cat_id'=>'nullable|exists:categories,id',
            'is_featured'=>'sometimes|in:1',
            //'status'=>'required|in:active,inactive',
            'condition'=>'required|in:default,new,hot',
            'price'=>'required|numeric',
            //'discount'=>'nullable|numeric'
        ]);

        
        $total = Product::where('status','active')->count();
        if ($total < 3){
        $data=$request->all();
       // return $data;
       
        $slug=Str::slug($request->title);
        $count=Product::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $data['is_featured']=$request->input('is_featured',0);
       
        // return $size;
        // return $data;
        $status=Product::create($data);
        if($status){
            request()->session()->flash('success','Annance Ajoute Avec Succé');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('userproduct.index');

        }else{
            request()->session()->flash('error','you only have the rieght to post 3 annonce');      
            return redirect()->route('userproduct.index');
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
       $product=Product::findOrFail($id);
       $product->created_at=\Carbon\Carbon::now();
        $status=$product->save();
        
        if($status){
            request()->session()->flash('success','Votre annonce est actualisé');
        }
        else{
            request()->session()->flash('error','Error while deleting product');
        }
        return redirect()->route('userproduct.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $product=Product::findOrFail($id);
        $category=Category::where('is_parent',1)->get();
        $items=Product::where('id',$id)->get();
        $state=state::get();
        
        // return $items;
        return view('user.userproduct.edit')->with('product',$product)
                    ->with('state',$state)
                    ->with('categories',$category)->with('items',$items);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { $product=Product::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required',
            //'summary'=>'string|required',
            'description'=>'string|nullable',
            'photo'=>'string|required',
            //'size'=>'nullable',
            'stock'=>"required|numeric",
            'cat_id'=>'required|exists:categories,id',
            'city_id'=>'required|exists:cities,id',
            'state_id'=>'required|exists:states,id',
            'brand_id'=>'nullable|exists:brands,id',
            'child_cat_id'=>'nullable|exists:categories,id',
            'is_featured'=>'sometimes|in:1',
            //'status'=>'required|in:active,inactive',
            'condition'=>'required|in:default,new,hot',
            'price'=>'required|numeric',
            //'discount'=>'nullable|numeric'
        ]);

        $data=$request->all();
        $data['is_featured']=$request->input('is_featured',0);
        
        // return $data;
        $status=$product->fill($data)->save();
        if($status){
            request()->session()->flash('success','Product Successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('userproduct.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::findOrFail($id);
        $status=$product->delete();
        
        if($status){
            request()->session()->flash('success','Product successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting product');
        }
        return redirect()->route('userproduct.index');
    }

      public function getcitydByParent(Request $request){
        // return $request->all();
        $state=state::findOrFail($request->id);
        $city_byid=city::getcityByParentID($request->id);
        // return $child_cat;
        if(count($city_byid)<=0){
            return response()->json(['status'=>false,'msg'=>'','data'=>null]);
        }
        else{
            return response()->json(['status'=>true,'msg'=>'','data'=>$city_byid]);
        }

        
    }
}
