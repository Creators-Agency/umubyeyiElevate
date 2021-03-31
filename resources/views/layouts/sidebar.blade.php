<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="https://www.creative-tim.com" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="../assets/img/logo-small.png">
            </div>
            <!-- <p>CT</p> -->
        </a>
        <a href="https://www.creative-tim.com" class="simple-text logo-normal">
            Creative Tim
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="active ">
                <a href="/">
                    <i class="nc-icon nc-bank"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li>
                <a href="{{URL::to('admin/category/list')}}">
                    <i class="nc-icon nc-diamond"></i>
                    <p>Category</p>
                </a>
            </li>
            <li>
                <a href="{{URL::to('admin/package/list')}}">
                    <i class="nc-icon nc-pin-3"></i>
                    <p>Package</p>
                </a>
            </li>
            <li>
                <a href="{{URL::to('admin/page/list')}}">
                    <i class="nc-icon nc-bell-55"></i>
                    <p>Page</p>
                </a>
            </li>
            <li>
                <a href="{{URL::to('admin/program/list')}}">
                    <i class="nc-icon nc-single-02"></i>
                    <p>Program</p>
                </a>
            </li>
            <li>
                <a href="./tables.html">
                    <i class="nc-icon nc-tile-56"></i>
                    <p>Account</p>
                </a>
            </li>
        </ul>
    </div>
</div>