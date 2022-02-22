<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<title>MOOS - @yield('title')</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta content="" name="description" />
<meta content="" name="author" />
<script src="/js/moeda.js" type="text/javascript"></script>
<script src="/js/util.js" type="text/javascript"></script>
<script src="/js/date.js" type="text/javascript"></script>
<script src="/js/app.js" type="text/javascript"></script>
<link href="/css/app.css" rel="stylesheet" type="text/css"/>
<link rel="icon" type="image/png" href="/assets/img/favicon.png" sizes="32x32">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
<link href="/assets/plugins/bootstrap-tag/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<link href="/assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="/assets/plugins/jquery-datatable/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
<link href="/assets/plugins/datatables-responsive/css/datatables.responsive.css" rel="stylesheet" type="text/css" media="screen"/>    
<link href="/assets/plugins/jquery-metrojs/MetroJs.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css" />
<link href="/assets/plugins/shape-hover/css/demo.css" rel="stylesheet" type="text/css"/>
<link href="/assets/plugins/shape-hover/css/component.css" rel="stylesheet" type="text/css"/>
<link href="/assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" type="text/css"/>
<link href="/assets/plugins/owl-carousel/owl.theme.css" rel="stylesheet" type="text/css"/>
<link href="/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>

<link href="/assets/plugins/jquery-ricksaw-chart/css/rickshaw.css" type="text/css" media="screen" rel="stylesheet"/>
<!-- BEGIN CORE CSS FRAMEWORK -->
<link href="/assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/plugins/boostrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
<link href="/assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css"/>
<!-- END CORE CSS FRAMEWORK -->

<!-- BEGIN CSS TEMPLATE -->
<link href="/assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="/assets/css/responsive.css" rel="stylesheet" type="text/css"/>
<link href="/assets/css/custom-icon-set.css" rel="stylesheet" type="text/css"/>
<link href="/assets/css/magic_space.css" rel="stylesheet" type="text/css"/>
<link href="/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END CSS TEMPLATE -->
@yield('links')
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="condense-menu grey">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse ">
  <!-- BEGIN TOP NAVIGATION BAR -->
  <div class="navbar-inner">
    <div class="header-seperation">
      <ul class="nav pull-left notifcation-center" id="main-menu-toggle-wrapper" style="display:none">
        <li class="dropdown"> <a id="main-menu-toggle" href="#main-menu"  class="" >
          <div class="iconset top-menu-toggle-white"></div>
          </a> </li>
      </ul>
      <!-- BEGIN LOGO -->
      <a href="/"><img src="/assets/img/logo_3.png" class="logo" alt=""  data-src="/assets/img/logo_3.png" data-src-retina="/assets/img/logo_3.png" style="zoom: 22%" /></a>
      <!-- END LOGO -->
      <div class="pull-right invisivel-min-900"> 
              <div style="margin-top: 20px;margin-right: 20px;"> 
                  
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                           <h4><span class="semi-bold" style="margin-right: 5px">Sair</span></h4>
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                  
          
              </div>            
        
      </div>

    </div>

    <!--Inicio Logout -->
    <div class="pull-right invisivel-max-900"> 

              <div style="margin-top: 20px;margin-right: 20px;"> 
                
                  
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                           <h4><span class="semi-bold" style="margin-right: 5px">Sair</span><i class="fa  fa-power-off  fa-x ml-2"></i></h4>
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                  
          
              </div>            
        
      </div>       
    <!--Fim Logout -->

    <!-- END RESPONSIVE MENU TOGGLER -->
    <div class="header-quick-nav" >
      <!-- BEGIN TOP NAVIGATION MENU -->
      <div class="pull-left">
        <ul class="nav quick-section">
          <li class="quicklinks"> <a href="#" class="" id="layout-condensed-toggle" >
            <div class="iconset top-menu-toggle-dark"></div>
            </a> </li>
        </ul>
        <ul class="nav quick-section">
          <li class="quicklinks"> <a href="javascript:location.reload(); this.children().addClass('fa-spin');" class="" >
            <div class="iconset top-reload"></div>
            </a> </li>
          <li class="quicklinks"> <span class="h-seperate"></span></li>
          <li class="m-r-10 input-prepend inside search-form no-boarder"> <span class="add-on"> <span class="iconset top-search"></span></span>
            <input name="" type="text"  class="no-boarder " placeholder="Digite um nome" style="width:250px;">
          </li>
        </ul>
      </div>
      <!-- END TOP NAVIGATION MENU -->
      <!-- BEGIN CHAT TOGGLER -->
      
      <!-- END CHAT TOGGLER -->
    </div>
    <!-- END TOP NAVIGATION MENU -->
  </div>
  <!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container row-fluid">
  <!-- BEGIN SIDEBAR -->
  <div class="page-sidebar mini" id="main-menu">
    <!-- BEGIN MINI-PROFILE -->
    <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
      <div class="user-info-wrapper">
        <div class="user-info">
          <div class="greeting" style="color: white">Bem-vindo</div>
          <div class="username"><span>{{ Auth::user()->nome }} </span></div>
        </div>
      </div>
      <!-- END MINI-PROFILE -->
      <!-- BEGIN SIDEBAR MENU -->
      <p class="menu-title"> <span class="pull-right"><a href="javascript:;"></a></span></p>
          <ul>
            <li> 
              <img src="/assets/img/logo_moos_p.png" alt=""  data-src="/assets/img/logo_moos_p.png" data-src-retina="/assets/img/logo_moos_p.png" style="zoom: 5.4%; margin-top: 200px" />
            </li>
          </ul>
      <ul>
        @if(Auth::user()->isAdministrator() == 1)  
        <li class="start "> <a href="/" > <i class="icon-custom-home" style="color: white"></i> <span class="title">Dashboard</span> <span class="selected"></span> </a> 
		    </li>
        @endif
        <li class=""> <a href="javascript:;"> <i class="fa fa fa-credit-card" style="color: white"></i> <span class="title">Eventos</span> <span class="arrow"></span> </a>
            <ul class="sub-menu">
            @if(Auth::user()->isAdministratorOuGestor() == 1)  
              <li > <a href="/eventos">Eventos </a> </li>
            @endif  
            @if(Auth::user()->isAdministrator() == 1)  
              <li > <a href="/users">Usuários </a> </li>
              <li > <a href="/terminais">Terminais </a> </li>
            @endif 
              <li > <a href="/cartoes">Cartões </a> </li>
            </ul>
        </li>
        @if(Auth::user()->isAdministrator() == 1)  
        <li class=""> <a href="javascript:;"> <i class="fa fa-map-marker" style="color: white"></i> <span class="title">Geolocalização</span> <span class="arrow"></span> </a>
            <ul class="sub-menu">
                <li > <a href="/geolocalizacao/vendas/"> Geolocalização Vendas </a></li>
                <li > <a href="/geolocalizacao/creditos/"> Geolocalização Créditos </a></li>
            </ul>
        </li>
        @endif 
      </ul>
      <div class="clearfix"></div>
      <!-- END SIDEBAR MENU -->
    </div>
  </div>
  <div class="footer-widget">
    <div class="pull-right">
      <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i></a></div>
  </div>
  <!-- END SIDEBAR -->
  <!-- BEGIN PAGE CONTAINER-->
  <div class="page-content condensed">
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <div id="portlet-config" class="modal hide">
      <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button"></button>
        <h3>Widget Settings</h3>
      </div>
      <div class="modal-body"> Widget settings form goes here </div>
    </div>
    <div class="clearfix"></div>
    <div class="content sm-gutter">
      <div class="page-title">
      </div>
	   <!-- BEGIN DASHBOARD TILES -->
	  
	 <!-- END DASHBOARD TILES -->
   
   <!-- INICIO DO CONTEUDO -->
   <div>
       @yield('content')
   </div>
   <!-- FIM DO CONTEUDO -->

	</div>


	</div>
</div>  
</div>

<!-- END CONTAINER -->
<!-- BEGIN CORE JS FRAMEWORK-->
    
<!--[if lt IE 9]>
<script src="assets/plugins/respond.js"></script>
<![endif]-->



<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>

<script src="/assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="/assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="/assets/plugins/boostrapv3/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/plugins/breakpoints.js" type="text/javascript"></script>
<script src="/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
<script src="/assets/plugins/jquery-block-ui/jqueryblockui.js" type="text/javascript"></script>
<script src="/assets/plugins/jquery-lazyload/jquery.lazyload.min.js" type="text/javascript"></script>
<script src="/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js" type="text/javascript"></script>
<!-- END CORE JS FRAMEWORK -->
<!-- BEGIN PAGE LEVEL JS -->
<script src="/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js" type="text/javascript"></script>    
<script src="/assets/plugins/jquery-block-ui/jqueryblockui.js" type="text/javascript"></script>

<script src="/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
<script src="/assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
<script src="/assets/plugins/jquery-ricksaw-chart/js/raphael-min.js"></script>
<script src="/assets/plugins/jquery-ricksaw-chart/js/d3.v2.js"></script>
<script src="/assets/plugins/jquery-ricksaw-chart/js/rickshaw.min.js"></script>
<script src="/assets/plugins/jquery-sparkline/jquery-sparkline.js"></script>
<script src="/assets/plugins/skycons/skycons.js"></script>
<script src="/assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
<script src="/assets/plugins/owl-carousel/owl.carousel.min.js" type="text/javascript"></script>
<script src="/assets/plugins/jquery-datatable/js/jquery.dataTables.min.js" type="text/javascript" ></script>
<script src="/assets/plugins/jquery-flot/jquery.flot.js" type="text/javascript"></script>
<script src="/assets/plugins/jquery-flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="/assets/plugins/jquery-metrojs/MetroJs.min.js" type="text/javascript" ></script>
<script src="/assets/plugins/jquery-datatable/extra/js/dataTables.tableTools.min.js" type="text/javascript" ></script>
<script src="/assets/plugins/datatables-responsive/js/datatables.responsive.js" type="text/javascript"></script>
<script src="/assets/plugins/datatables-responsive/js/lodash.min.js" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.13/jquery.mask.min.js"></script>
<script src="/assets/plugins/jquery-inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
<script src="/assets/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>

<!-- END PAGE LEVEL PLUGINS -->

@yield('scripts')

<script src="/assets/js/datatables.js" type="text/javascript"></script>
<!-- BEGIN CORE TEMPLATE JS -->
<script src="/assets/js/core.js" type="text/javascript"></script>
<script src="/assets/js/chat.js" type="text/javascript"></script>
<script src="/assets/js/demo.js" type="text/javascript"></script>
<script src="/assets/js/dashboard_v2.js" type="text/javascript"></script>
<script src="/assets/js/bootbox.min.js" type="text/javascript"></script>
<script type="text/javascript">
        $(document).ready(function () {
            $(".live-tile,.flip-list").liveTile();
        });
</script>

<!-- END CORE TEMPLATE JS -->
</body>
</html>
