<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
        <img src="{{asset('backend/dist/img/logo.png')}}" alt="Lifestyle Admin Logo" class="brand-image"
            style="opacity: .8">
        <span class="brand-text font-weight-light">MeuRH Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
     

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{url('/admin/dashboard')}}" class="nav-link {{!isset($activeModule) || $activeModule=='dashboard' ? 'active': ''}}">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/admin/change-password')}}" class="nav-link {{isset($activeModule) && $activeModule=='passwordUpdate' ? 'active': ''}}">
                        <i class="fa fa-key nav-icon"></i>
                        <p>Change Password</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{url('/admin/candidate-list')}}" class="nav-link {{isset($activeModule) && $activeModule=='candidate' ? 'active': ''}}">
                        <i class="nav-icon fa fa-users"></i>
                        <p>Candidates</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/admin/company-list')}}" class="nav-link {{isset($activeModule) && $activeModule=='company' ? 'active': ''}}">
                        <i class="nav-icon fa fa-user-circle"></i>
                        <p>Company</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/admin/job-list')}}" class="nav-link {{isset($activeModule) && $activeModule=='job' ? 'active': ''}}">
                    <i class=" nav-icon fa fa-briefcase"></i>
                        <p>Job Management</p>
                    </a>
                </li>
               
               
                <li class="nav-item has-treeview {{isset($activeModule) && in_array($activeModule,['category','video']) ? 'menu-open': ''}}">
                    <a href="#" class="nav-link {{isset($activeModule) && in_array($activeModule,['category','video']) ? 'active': ''}}">
                        <i class="nav-icon fa fa-graduation-cap"></i>
                        <p>
                            Training
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('/admin/training-category-list')}}" class="nav-link {{isset($activeModule) && $activeModule=='category' ? 'active': ''}}">
                                <i class="nav-icon fa fa-bars"></i>
                                <p>Courses</p>
                            </a>
                        </li>
                    </ul>
                    <!-- <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{url('/admin/training-video-list')}}" class="nav-link {{isset($activeModule) && $activeModule=='video' ? 'active': ''}}">
                                <i class="nav-icon fa fa-youtube"></i>
                                <p>Videos</p>
                            </a>
                        </li>
                    </ul> -->
                </li>
                <li class="nav-item">
                    <a href="{{url('/admin/advertise-list')}}" class="nav-link {{isset($activeModule) && $activeModule == 'advertise' ? 'active': ''}}">
                    <i class="nav-icon fa fa-adn" aria-hidden="true"></i>
                        <p>Advertise  Management</p>
                    </a>

                </li>
                <li class="nav-item">
                    <a href="{{url('/admin/best-advertise-list')}}" class="nav-link {{ isset($activeModule) && $activeModule == 'bestAdvertise' ? 'active': ''}}">
                    <i class="nav-icon fa fa-adn" aria-hidden="true"></i>
                        <p>Best Add Management</p>
                    </a>

                </li>
                <li class="nav-item">
                    <a href="{{url('/admin/page-list')}}" class="nav-link {{isset($activeModule) && $activeModule == 'cmsPages' ? 'active': ''}}">
                        <i class="nav-icon fa fa-newspaper-o"></i>
                        <p>CMS Management</p>
                    </a>

                </li>
                <li class="nav-item has-treeview {{isset($activeModule) && in_array($activeModule,['paymentCms','paymentCmsCompany']) ? 'menu-open': ''}}">
                    <a href="#" class="nav-link {{isset($activeModule) && in_array($activeModule,['paymentCms','paymentCmsCompany']) ? 'active': ''}}">
                        <i class="nav-icon fa fa-cc-visa" aria-hidden="true"></i>
                        <p>
                            Payment Value
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('/admin/product-list')}}" class="nav-link {{isset($activeModule) && $activeModule=='paymentCms' ? 'active': ''}}">
                                <i class="nav-icon fa fa-bars"></i>
                                <p>Candidate Payment Value</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{url('/admin/payment-cms-list')}}" class="nav-link {{isset($activeModule) && $activeModule=='paymentCmsCompany' ? 'active': ''}}">
                                <i class="nav-icon fa fa-bars"></i>
                                <p>Employee Payment Value</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- <li class="nav-item"> --}}
                    {{-- <a href="{{url('/admin/payment-cms-list')}}" class="nav-link {{ isset($activeModule) && $activeModule == 'paymentCms' ? 'active': ''}}"> --}}
                    {{-- <a href="{{url('/admin/product-list')}}" class="nav-link {{ isset($activeModule) && $activeModule == 'paymentCms' ? 'active': ''}}">
                        <i class="nav-icon fa fa-cc-visa" aria-hidden="true"></i>
                            <p>Payment Value</p>
                        </a> --}}
                {{-- </li> --}}

                <li class="nav-item has-treeview {{isset($activeModule) && in_array($activeModule,['transaction','CandidateTransaction','CompanyTransaction']) ? 'menu-open': ''}}">
                    <a href="#" class="nav-link {{isset($activeModule) && in_array($activeModule,['transaction','CandidateTransaction','CompanyTransaction']) ? 'active': ''}}">
                        <i class="nav-icon fa fa-history"></i>
                        <p>
                            Transaction History
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('/admin/CandidateTransaction')}}" class="nav-link {{isset($activeModule) && $activeModule=='CandidateTransaction' ? 'active': ''}}">
                                <i class="nav-icon fa fa-bars"></i>
                                <p>Candidate Transactions</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{url('/admin/CompanyTransaction')}}" class="nav-link {{isset($activeModule) && $activeModule=='CompanyTransaction' ? 'active': ''}}">
                                <i class="nav-icon fa fa-bars"></i>
                                <p>Employee Transactions</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{url('/admin/screening-question-list')}}" class="nav-link {{isset($activeModule) && $activeModule == 'screeningQuestions' ? 'active': ''}}">
                        <i class="nav-icon fa fa-quora"></i>
                        <p>Screening Question</p>
                    </a>

                </li>

                 <li class="nav-item">
                    <a href="{{url('/admin/subscription-list')}}" class="nav-link {{isset($activeModule) && $activeModule == 'subscription' ? 'active': ''}}">
                        <i class="nav-icon fa fa-calendar"></i>
                        <p>Subscriptions</p>
                    </a>
                 </li>
                  <!-- <li class="nav-item">
                    <a href="{{url('/admin/post-list')}}" class="nav-link {{isset($activeModule) && $activeModule=='post' ? 'active': ''}}">
                        <i class="nav-icon fa fa-th-list"></i>
                        <p>Post Management</p>
                    </a>
                </li> -->

                <li class="nav-item has-treeview {{isset($activeModule) && in_array($activeModule,['reportedpost','reportedcomment']) ? 'menu-open': ''}}">
                    <a href="#" class="nav-link {{isset($activeModule) && in_array($activeModule,['reportedpost','reportedcomment']) ? 'active': ''}}">
                        <i class="nav-icon fa fa-ban"></i>
                        <p>
                            Abuse management
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('/admin/reported-post-list')}}" class="nav-link {{isset($activeModule) && $activeModule=='reportedpost' ? 'active': ''}}">
                                <i class="nav-icon fa fa-bug"></i>
                                <p>Reported Post</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{url('/admin/reported-comment-list')}}" class="nav-link {{isset($activeModule) && $activeModule=='reportedcomment' ? 'active': ''}}">
                                <i class="nav-icon fa fa-comments"></i>
                                <p>Reported Comment</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- oreder management -->
                <li class="nav-item has-treeview {{isset($activeModule) && in_array($activeModule,['addSubsOrder','order','payment']) ? 'menu-open': ''}}">
                    <a href="#" class="nav-link {{isset($activeModule) && in_array($activeModule,['addSubsOrder','order','payment']) ? 'active': ''}}">
                        <i class="nav-icon fa fa-ship"></i>
                        <p>
                            Order Management
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('/admin/order-list')}}" class="nav-link {{isset($activeModule) && $activeModule == 'order' ? 'active': ''}}">
                                <i class="nav-icon fa fa-shopping-cart"></i>
                                <p>Order List</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('/admin/add-subscription-order')}}" class="nav-link {{isset($activeModule) && $activeModule=='addSubsOrder' ? 'active': ''}}">
                                <i class="nav-icon fa fa-barcode"></i>
                                <p>Add Subscription</p>
                            </a>
                        </li>
                    </ul>
                     <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('/admin/payment-list')}}" class="nav-link {{isset($activeModule) && $activeModule == 'payment' ? 'active': ''}}">
                                <i class="nav-icon fa fa-cc-visa"></i>
                                <p>Payment Report</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Order management -->

                
                <li class="nav-item">
                    <form class="nav-item" action="{{url('admin/logout')}}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link">
                            <i class="fa fa-sign-out nav-icon"></i>
                            <p>Logout</p>
                        </button>
                    </form>
                </li>
                {{-- <li class="nav-header">SAMPLES</li> --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>