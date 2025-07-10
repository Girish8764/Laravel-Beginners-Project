<style>
  .menu-arrow {
  transition: transform 0.3s ease;
}
.nav-link[aria-expanded="true"] .menu-arrow {
  transform: rotate(5deg);
}

</style>
@php
  $isAdmin = auth('admin')->check();
  $isSuperadmin = auth('superadmin')->check();
@endphp

<!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    @if($isAdmin)
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.students.index') }}">
          <i class="mdi mdi-account-group menu-icon"></i>
          <span class="menu-title">Manage Students</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#staff" aria-expanded="false" aria-controls="fees">
          <i class="mdi mdi-human-male-board menu-icon"></i>
          <span class="menu-title">Manage Staff</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="staff">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.staff.index') }}">All Staff</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.teacher-class.index') }}">Classs Allotment</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.teacher-subject.index') }}">Subject Allotment</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#fees" aria-expanded="false" aria-controls="fees">
          <i class="mdi mdi-currency-inr menu-icon"></i>
          <span class="menu-title">Manage Fees</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="fees">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('admin/fees') }}">Class Fees</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('admin/fees/deposit') }}">Fees Deposit</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <i class="mdi mdi-clipboard-text-outline menu-icon"></i>
          <span class="menu-title">Manage Exams</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{url('exam-timetable')}}">Exam Schedule</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{url('admin/admit-cards')}}">Admit Card</a></li>
            <!-- <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Exam Menu</a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Question paper</a></li> -->
          </ul>
        </div>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="mdi mdi-trophy-outline menu-icon"></i>
          <span class="menu-title">Manage Result</span>
        </a>
      </li> 
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="mdi mdi-note-outline menu-icon"></i>
          <span class="menu-title">Letter Pad</span>
        </a>
      </li> 
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="mdi mdi-book-outline menu-icon"></i>
          <span class="menu-title">Syllabus</span>
        </a>
      </li> 
        <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#others" aria-expanded="false" aria-controls="ui-basic">
          <i class="mdi mdi-clipboard-text-outline menu-icon"></i>
          <span class="menu-title">Others</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="others">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Board Form</a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">प्रपत्र 128</a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Income Certificate</a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Study Certificate</a></li>
          </ul>
        </div>
      </li> -->
      <li class="nav-item">
    <a class="nav-link {{ request()->is('admin/subjects*') ? 'active' : '' }}" href="{{ url('admin/subjects') }}">
      <i class="mdi mdi-book-open menu-icon"></i>
      <span class="menu-title">Manage Subjects</span>
    </a>
  </li>
  @endif
  @if($isSuperadmin)
    <li class="nav-item">
      <a class="nav-link" href="{{url('superadmin/dashboard')}}">
        <i class="mdi mdi-chart-line menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('superadmin/manage-admin')}}">
        <i class="mdi mdi-account-outline menu-icon"></i>
        <span class="menu-title">Manage Schools</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('superadmin/subjects')}}">
        <i class="mdi mdi-book-open-variant menu-icon"></i>
        <span class="menu-title">Manage Subjects</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('superadmin/sessions')}}">
        <i class="mdi mdi-calendar-range menu-icon"></i>
        <span class="menu-title">Manage Sessions</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('superadmin/pricing-plans')}}">
        <i class="mdi mdi-currency-inr menu-icon"></i>
        <span class="menu-title">Pricing Plans</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('superadmin/staff')}}">
        <i class="mdi mdi-human-male-board menu-icon"></i>
        <span class="menu-title">All Staff</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('superadmin/students')}}">
        <i class="mdi mdi-account-school menu-icon"></i>
        <span class="menu-title">All Students</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('superadmin/contacts')}}">
        <i class="mdi mdi-message-text menu-icon"></i>
        <span class="menu-title">Contact Messages</span>
      </a>
    </li>
  @endif
</nav>