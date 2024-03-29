<div class="main-menu menu-fixed menu-accordion menu-shadow menu-light" data-scroll-to-active="true" style="touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
    <div class="navbar-header expanded">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto"><a class="navbar-brand" href="{{ route('index') }}"><span class="brand-logo">
                        <h2 class="brand-text">Alpha Digital</h2></a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x d-block d-xl-none text-primary toggle-icon font-medium-4">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-disc d-none d-xl-block collapse-toggle-icon primary font-medium-4">
                        <circle cx="12" cy="12" r="10"></circle>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg></a></li>
        </ul>
    </div>

    <div class="shadow-bottom" style="display: none;"></div>
    <div class="main-menu-content ps ps--active-y" style="height: 806.625px;">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <!------------------------------------------- Admin tasks --------------------------------------------------->
            @if(Auth::User()->hasRole('admin'))
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="{{route('admin')}}">
                    <i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Admin</span>
                </a>
            </li>
            @endif
            <!------------------------------------------- Alpha Digital --------------------------------------------------->
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Alpha
                        Digital</span>
                </a>
                <ul class="menu-content">
                    @php
                    $comp = \App\Models\Investor::where('investor_type', '=', 1)->first();
                    @endphp
                    @if ($comp != null)
                    <li>
                        <a href="{{ route('home', $comp->id) }}" class="d-flex align-items-center ">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="eCommerce">Dashboard</span>
                        </a>
                    </li>
                    @endif


                    <li>
                        {{-- href="{{ route('investor.create') }}" --}}
                        {{-- href="{{ route('investor.create') }}" --}}
                        <!-- <a class="d-flex align-items-center">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="eCommerce">Capital Investments</span>
                        </a> -->
                    </li>
                    <li>
                        <a href="{{ route('investment.create') }}" class="d-flex align-items-center">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="eCommerce">Add Balance</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('chartOfAccount.create') }}" class="d-flex align-items-center">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="eCommerce">Accounts</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('get-account-balances') }}" class="d-flex align-items-center">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="eCommerce">Account Balances</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('transfer-balances') }}" class="d-flex align-items-center">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="eCommerce">Transfer Balances</span>
                        </a>
                    </li>
                    <li class=" nav-item"><a href="{{ route('investor-transfer-queue') }}" class="d-flex align-items-center">
                            <i data-feather="circle"></i>
                            <span class=" menu-title text-truncate" data-i18n="comision">Funds Transfer Requests</span></a>
                    </li>
                    <li class=" nav-item"><a href="{{ route('investor-payment') }}" class="d-flex align-items-center">
                            <i data-feather="circle"></i>
                            <span class=" menu-title text-truncate" data-i18n="comision">Investors Payment</span></a>
                    </li>

                </ul>
            </li>
            <!------------------------------------------- HRM --------------------------------------------------->
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='user-plus'></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboards">HRM</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a class="d-flex align-items-center @if (request()->is('investor.create')) active text-white @endif" href="{{ route('register') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="eCommerce">Add Employee</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('users') }}" class="d-flex align-items-center ">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="eCommerce">Employees</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('payScale.create') }}" class="d-flex align-items-center ">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="eCommerce">Pay Scales</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('designation.create') }}" class="d-flex align-items-center ">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="eCommerce">Designations</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('paySalary.create') }}" class="d-flex align-items-center ">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="eCommerce">Pay Salary</span>
                        </a>
                    </li>


                </ul>
            </li>
            <!------------------------------------------- investor --------------------------------------------------->
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='users'></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboards">Investors</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a class="d-flex align-items-center @if (request()->is('investor.create')) active text-white @endif" href="{{ route('investor.create') }}">
                            {{-- <i data-feather="circle"></i> --}}
                            <span class="menu-item text-truncate" data-i18n="eCommerce">Add New</span>
                        </a>
                    </li>
                    @php
                    $inv = \App\Models\Investor::where('investor_type', '!=', 1)->get();
                    @endphp

                    @foreach ($inv as $investor)
                    <li>
                        <a href="{{ route('home', $investor->id) }}" class="d-flex align-items-center ">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="eCommerce">{{ $investor->prefix }}</span>
                        </a>
                    </li>
                    @endforeach

                </ul>
            </li>
            <!------------------------------------------- Customer--------------------------------------------------->

            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='user-plus'></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboards">Customer</span>
                </a>
                <ul class="menu-content">

                    <li class=" nav-item"><a href="{{ route('customer.create') }}" class="d-flex align-items-center">
                            <i data-feather="circle"></i>
                            <span class=" menu-title text-truncate" data-i18n="comision">Add Customer</span></a>
                    </li>
                    {{-- <li class=" nav-item"><a href="{{ route('customer-files') }}"
                    class="d-flex align-items-center">
                    <i data-feather="circle"></i>
                    <span class=" menu-title text-truncate" data-i18n="comision">Customer-docs</span></a>
            </li> --}}

        </ul>
        </li>
        <!------------------------------------------- Customer--------------------------------------------------->

        <li class=" nav-item">
            <a class="d-flex align-items-center" href="#">
                <i data-feather='user-plus'></i>
                <span class="menu-title text-truncate" data-i18n="Dashboards">Recovery Officer</span>
            </a>
            <ul class="menu-content">

                <li class=" nav-item"><a href="{{ route('ro-dashboard') }}" class="d-flex align-items-center">
                        <i data-feather="circle"></i>
                        <span class=" menu-title text-truncate" data-i18n="comision">Dashbaard</span></a>
                </li>

                {{-- <li class=" nav-item"><a href="{{ route('customer-files') }}"
                class="d-flex align-items-center">
                <i data-feather="circle"></i>
                <span class=" menu-title text-truncate" data-i18n="comision">Customer-docs</span></a>
        </li> --}}

        </ul>
        </li>
        <!------------------------------------------- Inventory --------------------------------------------------->
        <li class=" nav-item">
            <a class="d-flex align-items-center" href="#">
                <i data-feather='file-text'></i>
                <span class="menu-title text-truncate" data-i18n="Dashboards">Inventory</span>
            </a>

            <ul class="menu-content">
                <li class=" nav-item"><a href="{{ route('category.create') }}" class="d-flex align-items-center">
                        <i data-feather="circle"></i>
                        <span class=" menu-title text-truncate" data-i18n="comision">Define Category</span></a>
                </li>
                <li class=" nav-item"><a href="{{ route('item.create') }}" class="d-flex align-items-center">
                        <i data-feather="circle"></i>
                        <span class=" menu-title text-truncate" data-i18n="comision">Define Item</span></a>
                </li>

                <li class=" nav-item"><a href="{{ route('supplier.create') }}" class="d-flex align-items-center">
                        <i data-feather="circle"></i>
                        <span class=" menu-title text-truncate" data-i18n="comision">Define Supplier</span></a>
                </li>
                {{-- <li class=" nav-item"><a href="{{ route('purchase.create') }}" class="d-flex align-items-center">
                <i data-feather="circle"></i>
                <span class=" menu-title text-truncate" data-i18n="comision">Purchase Items</span></a>
        </li> --}}
        @php
        $inv_sales = \App\Models\Investor::all();
        @endphp

        <li class=" nav-item">
            <a class="d-flex align-items-center" href="#">
                <i data-feather="circle"></i>
                <span class="menu-title text-truncate" data-i18n="Dashboards">Reports</span>
            </a>
            <ul class="menu-content">

                @foreach ($inv_sales as $investor)
                <li>
                    <a href="{{ route('list-inventory', $investor->id) }}" class="d-flex align-items-center ">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="eCommerce">{{ $investor->prefix }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </li>

        </ul>
        </li>
        <!------------------------------------------- Sales --------------------------------------------------->
        <li class=" nav-item">
            <a class="d-flex align-items-center" href="#">
                <i data-feather='trending-up'></i>
                <span class="menu-title text-truncate" data-i18n="Dashboards">Sale</span>
            </a>
            <ul class="menu-content">
                @php
                $inv_sales = \App\Models\Investor::all();
                @endphp
                {{-- <li class=" nav-item"><a href="{{ route('customer.create') }}"
                class="d-flex align-items-center">
                <i data-feather="circle"></i>
                <span class=" menu-title text-truncate" data-i18n="comision">Add Customer</span></a>
        </li> --}}

        <li class=" nav-item"><a href="{{ route('sale.create') }}" class="d-flex align-items-center">
                <i data-feather="circle"></i>
                <span class=" menu-title text-truncate" data-i18n="comision">New Sale</span></a>
        </li>
        <li class=" nav-item"><a href="{{ route('sale-close') }}" class="d-flex align-items-center">
                <i data-feather="circle"></i>
                <span class=" menu-title text-truncate" data-i18n="comision"> Sale Close</span></a>
        </li>

        {{-- <li class=" nav-item"><a href="{{ route('sale-return') }}" class="d-flex align-items-center">
        <i data-feather="circle"></i>
        <span class=" menu-title text-truncate" data-i18n="comision">Sale Return</span></a>
        </li> --}}
        <li class=" nav-item"><a href="{{ route('search-sales') }}" class="d-flex align-items-center">
                <i data-feather="circle"></i>
                <span class=" menu-title text-truncate" data-i18n="comision">Search Sales</span></a>
        </li>
        <li class=" nav-item"><a href="{{ route('search-sales-post') }}" class="d-flex align-items-center">
                <i data-feather="circle"></i>
                <span class=" menu-title text-truncate" data-i18n="comision">Recieve
                    Installment</span></a>
        </li>
        <li class=" nav-item">
            <a class="d-flex align-items-center" href="#">
                <i data-feather="circle"></i>
                <span class="menu-title text-truncate" data-i18n="Dashboards">Reports</span>
            </a>
            <ul class="menu-content">

                @foreach ($inv_sales as $investor)
                <li>
                    <a href="{{ route('get-sales', $investor->id) }}" class="d-flex align-items-center ">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="eCommerce">{{ $investor->prefix }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </li>
        </ul>
        </li>

        <!------------------------------------------- receivables --------------------------------------------------->
        <li class=" nav-item">
            <a class="d-flex align-items-center" href="#">
                <i data-feather='arrow-down'></i>
                <span class="menu-title text-truncate" data-i18n="Dashboards">Receivables</span>
            </a>
            <ul class="menu-content">
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="#">
                        <i data-feather="circle"></i>
                        <span class="menu-title text-truncate" data-i18n="Dashboards">Reciepts</span>
                    </a>
                    <ul class="menu-content">
                        @php
                        $inv_sales = \App\Models\Investor::all();
                        @endphp
                        @foreach ($inv_sales as $investor)
                        <li class="nav-item">
                            <a class="d-flex align-items-center" href="#">
                                <!-- <i data-feather="circle"></i> -->
                                <span style="font-size: 12px;" class="menu-title text-truncate" data-i18n="Dashboards">{{ $investor->prefix }}</span>
                            </a>
                            <ul class="menu-content">
                                <li class="nav-item">
                                    <a class="d-flex align-items-center" href="#">
                                        <i data-feather="circle"></i>
                                        <span style="font-size: 12px;" class=" text-truncate" data-i18n="Dashboards">Due Installments</span>
                                    </a>

                                </li>
                                <li class="nav-item">
                                    <a class="d-flex align-items-center" href="#">
                                        <i data-feather="circle"></i>
                                        <span style="font-size: 12px;" class=" text-truncate" data-i18n="Dashboards">Cash Sales</span>
                                    </a>

                                </li>

                            </ul>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="#">
                        <i data-feather="circle"></i>
                        <span class="menu-title text-truncate" data-i18n="Dashboards">Reports</span>
                    </a>
                    <ul class="menu-content">
                        @php
                        $inv_sales = \App\Models\Investor::all();
                        @endphp
                        @foreach ($inv_sales as $investor)
                        <li>
                            <a href="{{ route('home', $investor->id) }}" class="d-flex align-items-center ">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="eCommerce">{{ $investor->prefix }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </li>
        <!------------------------------------------- Purchase --------------------------------------------------->
        <li class=" nav-item">
            <a class="d-flex align-items-center" href="#">
                <i data-feather='shopping-bag'></i>
                <span class="menu-title text-truncate" data-i18n="Dashboards">Purchase</span>
            </a>
            <ul class="menu-content">
                @php
                $inv_sales = \App\Models\Investor::all();
                @endphp
                <li class=" nav-item"><a href="{{ route('purchase.create') }}" class="d-flex align-items-center">
                        <i data-feather="circle"></i>
                        <span class=" menu-title text-truncate" data-i18n="comision">Purchase Items</span></a>
                </li>
                <li class=" nav-item"><a href="{{ route('purchase-return') }}" class="d-flex align-items-center">
                        <i data-feather="circle"></i>
                        <span class=" menu-title text-truncate" data-i18n="comision">Purchase Return</span></a>
                </li>
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="{{ route('get-purchases') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-title text-truncate" data-i18n="Dashboards">Reports</span>
                    </a>

                </li>
            </ul>
        </li>
        <!------------------------------------------- Payables --------------------------------------------------->
        <li class=" nav-item">
            <a class="d-flex align-items-center" href="#">
                <i data-feather='arrow-up'></i>
                <span class="menu-title text-truncate" data-i18n="Dashboards">Payables</span>
            </a>
            <ul class="menu-content">
                @php
                $inv_sales = \App\Models\Investor::all();
                @endphp
                <li class=" nav-item"><a href="{{ route('supplierPayment.create') }}" class="d-flex align-items-center">
                        <i data-feather="circle"></i>
                        <span class=" menu-title text-truncate" data-i18n="comision">Pay Supplier Bills</span></a>
                </li>
               
                <li class=" nav-item"><a href="{{ route('expensePayment.create') }}" class="d-flex align-items-center">
                        <i data-feather="circle"></i>
                        <span class=" menu-title text-truncate" data-i18n="comision">Pay Expenses</span></a>
                </li>
                <!-- <li class=" nav-item"><a href="{{ route('supplierPayment.create') }}" class="d-flex align-items-center">
                            <i data-feather="circle"></i>
                            <span class=" menu-title text-truncate" data-i18n="comision">Pay Investors</span></a>
                    </li> -->
                <!-- <li class=" nav-item">
                    <a class="d-flex align-items-center" href="{{ route('get-payables')}}">
                        <i data-feather="circle"></i>
                        <span class="menu-title text-truncate" data-i18n="Dashboards">Supplier Payables</span>
                    </a>
                    <ul class="menu-content">

                        @foreach ($inv_sales as $investor)
                        <li>
                            <a href="{{ route('get-payables')}}" class="d-flex align-items-center ">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="eCommerce">{{ $investor->prefix }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li> -->
                <!-- <li class=" nav-item"><a href="{{ route('search-payables') }}" class="d-flex align-items-center">
                        <i data-feather="circle"></i>
                        <span class=" menu-title text-truncate" data-i18n="comision"> search payables</span></a>
                </li> -->
               
                <li class=" nav-item"><a href="{{ route('payable-reports-menu') }}" class="d-flex align-items-center">
                        <i data-feather="circle"></i>
                        <span class=" menu-title text-truncate" data-i18n="comision">Reports</span></a>
                </li>
                
            </ul>
        </li>
        <!-- <li class=" nav-item"><a class="d-flex align-items-center">
                <span class=" menu-title text-truncate" data-i18n="comision">Commision</span></a>
            <ul class="menu-content">
                <li class=" nav-item"><a href="{{ route('commission.index') }}" class="d-flex align-items-center">
                        <i data-feather="circle"></i>
                        <span class=" menu-title text-truncate" data-i18n="comision">Reports</span></a>
                </li>
            </ul>


        </li> -->

        {{-- <li class=" nav-item"><a class="d-flex align-items-center">
                    <span class=" menu-title text-truncate" data-i18n="recovery">Recovery</span></a>
            </li> --}}


        <!------------------------------------------- Purchase --------------------------------------------------->
        <li class=" nav-item">
            <a class="d-flex align-items-center" href="#">
                <i data-feather='shopping-bag'></i>
                <span class="menu-title text-truncate" data-i18n="Dashboards">Expenses</span>
            </a>
            <ul class="menu-content">
                @php
                $inv_sales = \App\Models\Investor::all();
                @endphp
                <li class=" nav-item"><a href="{{ route('expense.create') }}" class="d-flex align-items-center">
                        <i data-feather="circle"></i>
                        <span class=" menu-title text-truncate" data-i18n="comision">Add Expense</span></a>
                </li>
                <li class=" nav-item"><a href="{{ route('expenseHead.create') }}" class="d-flex align-items-center">
                        <i data-feather="circle"></i>
                        <span class=" menu-title text-truncate" data-i18n="comision">Add Expense Head</span></a>
                </li>
                <li class=" nav-item"><a href="{{ route('show-expenses') }}" class="d-flex align-items-center">
                        <i data-feather="circle"></i>
                        <span class=" menu-title text-truncate" data-i18n="comision">Report</span></a>
                </li>

                <!-- removing for now will discuss -->
                <!-- <li class=" nav-item"><a href="{{ route('commission.index') }}" class="d-flex align-items-center">
                        <i data-feather="circle"></i>
                        <span class=" menu-title text-truncate" data-i18n="comision">comissions Reports</span></a>
                </li> -->

                <!-- <li class=" nav-item">
                        <a class="d-flex align-items-center" href="#">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Dashboards">Reports</span>
                        </a>
                        <ul class="menu-content">

                            @foreach ($inv_sales as $investor)
<li>
                                    <a href="{{ route('get-purchases', $investor->id) }}"
                                        class="d-flex align-items-center ">
                                        <i data-feather="circle"></i>
                                        <span class="menu-item text-truncate"
                                            data-i18n="eCommerce">{{ $investor->prefix }}</span>
                                    </a>
                                </li>
@endforeach
                        </ul>
                    </li> -->
            </ul>
        </li>
        </ul>
    </div>
</div>