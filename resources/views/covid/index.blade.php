@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fa-regular fa-clipboard"></i>
                        ข้อมูลเคลม Covid-19
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ url('covid/process') }}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="">
                                    <i class="fa-regular fa-calendar"></i>
                                    เลือกวันที่
                                </label>
                                <div class="form-row">
                                    <div class="col-md-6">
                                      <input type="text" name="start" class="form-control basicDate" placeholder="วันที่เริ่มต้น" readonly>
                                    </div>
                                    <div class="col-md-6">
                                      <input type="text" name="end" class="form-control basicDate" placeholder="วันที่สิ้นสุด" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa-solid fa-search"></i>
                                    ค้นหาข้อมูล
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <small class="text-muted">
                            <i class="fa-solid fa-circle-info"></i>
                            ระบบจะทำการค้นหาข้อมูลจาก Hospital-OS โดยค้นหาข้อมูลจากทุกสิทธิ์การรักษา ยกเว้นต่างด้าว และใช้รหัส Z11.5 เป็นหลัก 
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection
