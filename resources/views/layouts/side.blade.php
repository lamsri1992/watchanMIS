<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
            <img class="img img-fluid" src="{{ asset('img/wc_logo_1.png') }}">
        </div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ (request()->is('/')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
     <!-- Heading -->
     <div class="sidebar-heading">
        ระบบรายงานข้อมูล
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link {{ (request()->is('person/*')) ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseCiti"
            aria-expanded="true" aria-controls="collapseCiti">
            <i class="fa-solid fa-users"></i>
            <span>ข้อมูลประชากร</span>
        </a>
        <div id="collapseCiti" class="collapse {{ (request()->is('person/*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item text-xs {{ (request()->is('person/people')) ? 'active' : '' }}" href="{{ url('person/people') }}">
                    จำนวนประชากรแยกหมู่บ้าน
                </a>
                <a class="collapse-item text-xs {{ (request()->is('person/plan')) ? 'active' : '' }}" href="{{ url('#') }}">
                    ข้อมูลประชากรแยกตามสิทธิ์
                </a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ (request()->is('opd/*')) ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseOne"
            aria-expanded="true" aria-controls="collapseOne">
            <i class="fa-solid fa-hospital-user"></i>
            <span>ข้อมูลผู้ป่วยนอก</span>
        </a>
        <div id="collapseOne" class="collapse {{ (request()->is('opd/*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item text-xs {{ (request()->is('opd/refer*')) ? 'active' : '' }}" href="{{ url('opd/refer') }}">ข้อมูลการส่งต่อการรักษา</a>
                <a class="collapse-item text-xs {{ (request()->is('opd/diag*')) ? 'active' : '' }}" href="{{ url('opd/diag') }}">10 อันดับโรคผู้ป่วยนอก</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ (request()->is('report*')) ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseSta"
            aria-expanded="true" aria-controls="collapseSta">
            <i class="fa-solid fa-hand-holding-dollar"></i>
            <span>ศูนย์จัดเก็บรายได้</span>
        </a>
        <div id="collapseSta" class="collapse {{ (request()->is('report*') || request()->is('claim*')) ? 'show' : '' }}" 
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item text-xs {{ (request()->is('report') || request()->is('report/process')) ? 'active' : '' }}"
                    href="{{ route('report.index') }}">
                    ข้อมูลการเข้ารับบริการ
                </a>
                <a class="collapse-item text-xs {{ (request()->is('claim*')) ? 'active' : '' }}"
                    href="{{ route('claim.index') }}">
                    รายการเคลมค่ารักษาพยาบาล
                </a>
                <a class="collapse-item text-xs" href="http://172.20.55.254:8850/RPClient/index/" target="_blank">
                    Report Center 3.9
                </a>
                <a class="collapse-item text-xs" href="https://www.newcb.ktb.co.th/" target="_blank">
                    Report KTB Corporate
                </a>
            </div>
        </div>
    </li>
    <li class="nav-item {{ (request()->is('finance*')) ? 'active' : '' }}">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#financeModal">
            <i class="fa-solid fa-fw fa-comment-dollar"></i>
            <span>รายงานข้อมูลลูกหนี้</span>
        </a>
    </li>
    {{-- <li class="nav-item {{ (request()->is('visit*')) ? 'active' : '' }}">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#visitModal">
            <i class="fa-solid fa-fw fa-hospital"></i>
            <span>ข้อมูลการเข้ารับบริการ</span>
        </a>
    </li> --}}
    {{-- <li class="nav-item">
        <a class="nav-link {{ (request()->is('statement/*')) ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseSta"
            aria-expanded="true" aria-controls="collapseSta">
            <i class="fa-solid fa-comments-dollar"></i>
            <span>รายงานยอดเงินโอน</span>
        </a>
        <div id="collapseSta" class="collapse {{ (request()->is('statement/*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item text-xs {{ (request()->is('statement/ofc*')) ? 'active' : '' }}" href="{{ route('statement','ofc') }}">สิทธิ์ข้าราชการเบิกได้จ่ายตรง</a>
                <a class="collapse-item text-xs {{ (request()->is('statement/lgo*')) ? 'active' : '' }}" href="{{ route('statement','lgo') }}">สิทธิ์ข้าราชการ อปท.</a>
                <a class="collapse-item text-xs {{ (request()->is('statement/opa*')) ? 'active' : '' }}" href="{{ route('statement','opa') }}">สิทธิ์ UC (OP-AnyWhere)</a>
                <a class="collapse-item text-xs {{ (request()->is('statement/sso*')) ? 'active' : '' }}" href="{{ route('statement','sso') }}">สิทธิ์ประกันสังคม</a>
            </div>
        </div>
    </li> --}}
    {{-- <li class="nav-item {{ (request()->is('/supplies')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/supplies') }}">
            <i class="fa-solid fa-fw fa-box"></i>
            <span>รายงานข้อมูลพัสดุ</span>
        </a>
    </li> --}}
</ul>
<!-- End of Sidebar -->

<!--Finance Modal -->
<div class="modal fade" id="financeModal" tabindex="-1" aria-labelledby="financeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="financeModalLabel">
                    <i class="fa-solid fa-money-check-dollar"></i>
                    รายงานลูกหนี้
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('searchFinance') }}">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="fi_type" class="custom-select" required>
                            <option value="">-- เลือกรายงาน --</option>
                            <option value="1">รายงานลูกหนี้ผู้ป่วยใน</option>
                            <option value="0">รายงานลูกหนี้ผู้ป่วยนอก</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="plan[]" class="basic-multiple" multiple="multiple" required>
                            @foreach ($plans as $res)
                            <option value="{{ $res->r_plan_group_id }}">{{ $res->plan_group_description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fa-regular fa-calendar"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control basicDate" name="start" placeholder="วันที่เริ่มต้น" readonly required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fa-regular fa-calendar"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control basicDate" name="end" placeholder="วันที่สิ้นสุด" readonly required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-search"></i>
                            ค้นหาข้อมูล
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                            <i class="fa-solid fa-times-circle"></i>
                            ปิดหน้าต่าง
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@php
    $a_mthai[1] = 'มกราคม';
    $a_mthai[2] = 'กุมภาพันธ์';
    $a_mthai[3] = 'มีนาคม';
    $a_mthai[4] = 'เมษายน';
    $a_mthai[5] = 'พฤษภาคม';
    $a_mthai[6] = 'มิถุนายน';
    $a_mthai[7] = 'กรกฎาคม';
    $a_mthai[8] = 'สิงหาคม';
    $a_mthai[9] = 'กันยายน ';
    $a_mthai[10] = 'ตุลาคม';
    $a_mthai[11] = 'พฤศจิกายน';
    $a_mthai[12] = 'ธันวาคม';
@endphp
<!-- Visit Modal -->
<div class="modal fade" id="visitModal" tabindex="-1" aria-labelledby="visitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="visitModalLabel">
                    <i class="fa-solid fa-hospital"></i>
                    ข้อมูลการเข้ารับบริการ
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('searchVisit') }}">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="m_visit" class="custom-select" required>
                            <option value="">-- เลือกเดือน --</option>
                            @php
                                for($i=1;$i<=12;$i++){
                                    echo "<option value='$i'>$a_mthai[$i]</option>";
                                }
                            @endphp
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="y_visit" class="custom-select" required>
                            <option value="">-- เลือกปี พ.ศ. --</option>
                            <option value="2565">2565</option>
                            <option value="2564">2564</option>
                            <option value="2563">2563</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-search"></i>
                            ค้นหาข้อมูล
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                            <i class="fa-solid fa-times-circle"></i>
                            ปิดหน้าต่าง
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>