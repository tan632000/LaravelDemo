<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\slide;
class SlideController extends Controller
{
    public function getdanhsach(){
        $slide = slide::all();
        return view('admin.slide.danhsach',['slide'=>$slide]);
    }
    public function getThem(){
        return view('admin.slide.them');
    }
    public function postThem(Request $request){
        $this->validate($request,[
            'Ten'=>'required',
            'NoiDung'=>'required'
        ],[
            'Ten.required'=>'Bạn chưa nhập tên',
            'NoiDung.required'=>'Bạn chưa nhập nội dung'
        ]);
        $slide = new slide;
        $slide->Ten = $request->Ten;
        $slide->NoiDung = $request->NoiDung;
        if($request->has('link')){
            $slide->link = $request->link;
        }
        if($request->hasFile('Hinh')){
            $file = $request->file( 'Hinh');
            // kiểm tra loại ảnh
            $tag = $file->getClientOriginalExtension();
            if($tag!='jpg' && $tag!= 'png' && $tag!= 'jpeg'){
                return redirect('admin/slide/them')->with('loi','Bạn chỉ được chọn file jpg, jpeg, png thôi');
            }
            // kiểm tra tên
            $name = $file->getClientOriginalName();
            $Hinh = "_".$name;
            while(file_exists("upload/slide/".$Hinh)){
                $Hinh = "_".$name; // random cho ảnh k bao giờ trùng tên
            }
            $file->move("upload/slide",$Hinh);
            $slide->Hinh = $Hinh;
        }else{
            $slide->Hinh = '';
        }
        $slide->save();
        return redirect('admin/slide/them')->with('thongbao','Thêm thành công');
    }
    public function getSua($id){
        $slide = slide::find($id);
        return view('admin.slide.sua',['slide'=>$slide]);
    }
    public function postSua(Request $request,$id){
        $slide = slide::find($id);
        $this->validate($request,
        [
            'Ten'=>'required',
            'NoiDung'=>'required'
        ],
        [
            'Ten.required'=>'Bạn chưa nhập tên',
            'NoiDung.required'=>'Bạn chưa nhập nội dung'
        ]
        );
        $slide->Ten = $request->Ten;
        $slide->NoiDung = $request->NoiDung;
        if($request->has('link')){
            $slide->link = $request->link;
        }
        if($request->hasFile('Hinh')){
            $file = $request->file( 'Hinh');
            // kiểm tra loại ảnh
            $tag = $file->getClientOriginalExtension();
            if($tag!='jpg' && $tag!= 'png' && $tag!= 'jpeg'){
                return redirect('admin/slide/them')->with('loi','Bạn chỉ được chọn file jpg, jpeg, png thôi');
            }
            // kiểm tra tên
            $name = $file->getClientOriginalName();
            $Hinh = "_".$name;
            while(file_exists("upload/slide/".$Hinh)){
                $Hinh = "_".$name; // random cho ảnh k bao giờ trùng tên
            }

            $file->move("upload/slide",$Hinh);
            // xóa file cũ và lưu file mới
            unlink("upload/slide/".$slide->Hinh);
            $slide->Hinh = $Hinh;
        }
        $slide->save();
        return redirect('admin/slide/sua/'.$id)->with('thongbao','Bạn đã sửa slide thành công');
    }
    public function getXoa($id){
        $slide = slide::find($id);
        $slide->delete();
        return redirect('admin/slide/danhsach')->with('thongbao','Bạn đã xóa thành công');
    }
}
