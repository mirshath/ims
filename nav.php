<?php


$current_url = basename($_SERVER['REQUEST_URI'], ".php");


?>


<style>
    .nav-item.active .nav-link {
        color: white !important;
        background: rgb(203, 0, 0);
        background: radial-gradient(circle, rgba(203, 0, 0, 1) 0%, rgba(110, 4, 4, 1) 92%);
        border-radius: 5px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: none;
    }

    #navHover:hover .nav-link {
        color: white !important;
        background: rgb(203, 0, 0);
        background: radial-gradient(circle, rgba(203, 0, 0, 1) 0%, rgba(110, 4, 4, 1) 92%);
        border-radius: 5px;
        transition: background-color 0.3s ease;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: none;
    }
</style>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>



<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center mt-4 mb-4" href="index">
        <div class="sidebar-brand-icon rotate-n-15">
            <!-- <i class="fas fa-laugh-wink"></i> -->
        </div>
        <!-- <div class="sidebar-brand-text mx-3">IMS <sup>2</sup></div> -->
        <div class="sidebar-brand-text mx-3"><img src="http://184.174.39.59:216/img/logo4.png" class="img-fluid"></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= ($current_url == 'index') ? 'active' : '' ?>" id="navHover">
        <a class="nav-link" href="index">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->

    <!-- Heading -->
    <!-- <div class="sidebar-heading">
         Interface
     </div> -->

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?= ($current_url == 'create_lead' ||
                            $current_url == 'create_year' ||
                            $current_url == 'create_semester' ||
                            $current_url == 'create_criteria' ||
                            $current_url == 'create_universities' ||
                            $current_url == 'create_coordinators' ||
                            $current_url == 'create_program' ||
                            $current_url == 'create_lecturer' ||
                            $current_url == 'crea_module_table' ||
                            $current_url == 'create_batch' ||
                            $current_url == 'create_grade' ||
                            $current_url == 'create_currency' ||
                            $current_url == 'create_status' ||
                            $current_url == 'create_decision'
                        ) ? 'active' : '' ?>" id="navHover">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
            aria-expanded="true" aria-controls="collapseOne">
            <i class="fas fa-fw fa-cog"></i>
            <span>Master File</span>
        </a>
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Components</h6>
                <a class="collapse-item <?= ($current_url == 'create_lead') ? 'active' : '' ?>" href="create_lead">Lead Types</a>
                <a class="collapse-item <?= ($current_url == 'create_year') ? 'active' : '' ?>" href="./create_year">Year</a>
                <a class="collapse-item <?= ($current_url == 'create_semester') ? 'active' : '' ?>" href="./create_semester">Semester</a>
                <a class="collapse-item <?= ($current_url == 'create_criteria') ? 'active' : '' ?>" href="./create_criteria">Criteria</a>
                <a class="collapse-item <?= ($current_url == 'create_universities') ? 'active' : '' ?>" href="./create_universities">University</a>
                <a class="collapse-item <?= ($current_url == 'create_coordinators') ? 'active' : '' ?>" href="./create_coordinators">Coordinator</a>
                <a class="collapse-item <?= ($current_url == 'create_program') ? 'active' : '' ?>" href="./create_program">Program</a>
                <a class="collapse-item <?= ($current_url == 'create_lecturer') ? 'active' : '' ?>" href="./create_lecturer">Lecture</a>
                <a class="collapse-item <?= ($current_url == 'crea_module_table') ? 'active' : '' ?>" href="./crea_module_table">Module</a>
                <a class="collapse-item <?= ($current_url == 'create_batch') ? 'active' : '' ?>" href="./create_batch">Batch</a>
                <a class="collapse-item <?= ($current_url == 'create_grade') ? 'active' : '' ?>" href="./create_grade">Grade</a>
                <a class="collapse-item <?= ($current_url == 'create_currency') ? 'active' : '' ?>" href="./create_currency">Currency</a>
                <a class="collapse-item <?= ($current_url == 'create_status') ? 'active' : '' ?>" href="./create_status">Status</a>
                <a class="collapse-item <?= ($current_url == 'create_decision') ? 'active' : '' ?>" href="./create_decision">Decision</a>
            </div>
        </div>
    </li>


    <!-- ---------------------------------------------------------------------------------------------------------------------  -->
    <!-- ---------------------------------------------------------------------------------------------------------------------  -->
    <!-- ---------------------------------------------------------------------------------------------------------------------  -->

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item" id="navHover">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Transections</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Components</h6>
                <a class="collapse-item" href="addLeads">Add Lead</a>
                <a class="collapse-item" href="studentRegister">Student Registration</a>
                <a class="collapse-item" href="allocateProgram">Allocate Program</a>
            </div>
        </div>
    </li>


    <!-- ---------------------------------------------------------------------------------------------------------------------  -->
    <!-- ---------------------------------------------------------------------------------------------------------------------  -->
    <!-- ---------------------------------------------------------------------------------------------------------------------  -->


    <li class="nav-item" id="navHover">
        <a class="nav-link" href="tables">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li>


</ul>
<!-- End of Sidebar -->