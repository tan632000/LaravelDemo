<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;
class LoaiTinController extends Controller
{
    public function getdanhsach(){
        $loaitin = LoaiTin::all();
        return view('admin.loaitin.danhsach',['loaitin'=>$loaitin]);
    }
    public function getThem(){
        $theloai = TheLoai::all();
        return view('admin.loaitin.them',['theloai'=>$theloai]);
    }
    public function postThem(Request $request){

        $this->validate($request,
        [
            'Ten'=>'required|min:3|max:100|unique:LoaiTin,Ten',
            'TheLoai'=>'required'
        ],
        [
            'Ten.required'=>'Ban chua nhap ten loai tin',
            'Ten.unique'=>'Ten loai tin da bi trung',
            'Ten.min'=>'Min la 3',
            'Ten.max'=>'Max la 100',
            'Theloai.required'=>'Ban chua chon the loai'
        ]);
        $loaitin = new LoaiTin;
        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTitle($request->Ten);
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();
        return redirect('admin/loaitin/them')->with('thongbao','Thêm thành công');
    }
    public function getSua($id){
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::find($id);
        return view('admin.loaitin.sua',['loaitin'=>$loaitin,'theloai'=>$theloai]);
    }
    public function postSua(Request $request,$id){
        $loaitin = LoaiTin::find($id);
        $this->validate($request,
        [
            'Ten'=>'required|min:3|max:100|unique:LoaiTin,Ten'
        ],
        [
            'Ten.required'=>'Ban chua nhap ten loai tin',
            'Ten.unique'=>'Ten loai tin da bi trung',
            'Ten.min'=>'Min la 3',
            'Ten.max'=>'Max la 100'
        ]);
        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTitle($request->Ten);
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();
        return redirect('admin/loaitin/sua/'.$id)->with('thongbao','Sửa thành công');
    }
    public function getXoa($id){
        $loaitin = LoaiTin::find($id);
        $loaitin->delete();
        return redirect('admin/loaitin/danhsach')->with('thongbao','Xóa thành công');
    }
}
