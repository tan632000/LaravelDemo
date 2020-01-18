<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TinTuc;
use App\LoaiTin;
use App\TheLoai;
use App\Comment;
class NewsController extends Controller
{
    public function getDanhSach(){
        $tintuc = TinTuc::orderBy('id','DESC')->get();
        return view('admin.tintuc.danhsach',['tintuc'=>$tintuc]);
    }
    public function getThem(){
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        return view('admin.tintuc.them',['theloai'=>$theloai,'loaitin'=>$loaitin]);
    }
    public function postThem(Request $request){
        $this->validate($request,
        [
            'LoaiTin'=>'required',
            'TieuDe'=>'required|min:3|unique:TinTuc,TieuDe',
            'TomTat'=>'required',
            'NoiDung'=>'required'
        ],
        [
            'LoaiTin.required'=>'Bạn chưa chọn loại tin',
            'TieuDe.required'=>'Bạn chưa chọn tiêu đề',
            'TieuDe.min'=>'Giới hạn ít nhất 3 từ',
            'TieuDe.unique'=>'Tiêu đề đã tồn tại',
            'Tomtat.required'=>'Bạn chưa nhập tóm tắt',
            'NoiDung.required'=>'Bạn chưa nhập nội dung'
        ]
        );
        $tintuc = new TinTuc;
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->SoLuotXem = 0;

        if($request->hasFile('Hinh')){
            $file = $request->file( 'Hinh');
            // kiểm tra loại ảnh
            $tag = $file->getClientOriginalExtension();
            if($tag!='jpg' && $tag!= 'png' && $tag!= 'jpeg'){
                return redirect('admin/tintuc/them')->with('loi','Bạn chỉ được chọn file jpg, jpeg, png thôi');
            }
            // kiểm tra tên
            $name = $file->getClientOriginalName();
            $Hinh = "_".$name;
            while(file_exists("upload/tintuc/".$Hinh)){
                $Hinh = "_".$name; // random cho ảnh k bao giờ trùng tên
            }
            $file->move("upload/tintuc",$Hinh);
            $tintuc->Hinh = $Hinh;
        }else{
            $tintuc->Hinh = '';
        }
        $tintuc->save();
        return redirect('admin/tintuc/them')->with('thongbao','Bạn đã thêm tin thành công');
    }

    public function getSua($id){
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        $tintuc = TinTuc::find($id);
        return view('admin.tintuc.sua',['tintuc'=>$tintuc,'theloai'=>$theloai,'loaitin'=>$loaitin]);
    }

    public function postSua(Request $request,$id){
        $tintuc = TinTuc::find($id);
        $this->validate($request,
        [
            'LoaiTin'=>'required',
            'TieuDe'=>'required|min:3|unique:TinTuc,TieuDe',
            'TomTat'=>'required',
            'NoiDung'=>'required'
        ],
        [
            'LoaiTin.required'=>'Bạn chưa chọn loại tin',
            'TieuDe.required'=>'Bạn chưa chọn tiêu đề',
            'TieuDe.min'=>'Giới hạn ít nhất 3 từ',
            'TieuDe.unique'=>'Tiêu đề đã tồn tại',
            'Tomtat.required'=>'Bạn chưa nhập tóm tắt',
            'NoiDung.required'=>'Bạn chưa nhập nội dung'
        ]
        );
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;

        if($request->hasFile('Hinh')){
            $file = $request->file( 'Hinh');
            // kiểm tra loại ảnh
            $tag = $file->getClientOriginalExtension();
            if($tag!='jpg' && $tag!= 'png' && $tag!= 'jpeg'){
                return redirect('admin/tintuc/them')->with('loi','Bạn chỉ được chọn file jpg, jpeg, png thôi');
            }
            // kiểm tra tên
            $name = $file->getClientOriginalName();
            $Hinh = "_".$name;
            while(file_exists("upload/tintuc/".$Hinh)){
                $Hinh = "_".$name; // random cho ảnh k bao giờ trùng tên
            }

            $file->move("upload/tintuc",$Hinh);
            // xóa file cũ và lưu file mới
            unlink("upload/tintuc/".$tintuc->Hinh);
            $tintuc->Hinh = $Hinh;
        }
        $tintuc->save();
        return redirect('admin/tintuc/sua/'.$id)->with('thongbao','Bạn đã sửa tin thành công');
    }
    public function getXoa($id){
        $tintuc = TinTuc::find($id);
        $tintuc->delete();
        return redirect('admin/tintuc/danhsach')->with('thongbao','Bạn đã xóa thành công');
    }
}
