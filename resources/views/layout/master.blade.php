<!-- Header -->
@include('layout._header')

<!-- Sidebar -->
@include('layout._sidebar')
<!-- /Sidebar -->

<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">
		@yield('main_content')
	</div>
</div>
<!-- /Page Wrapper -->

@include('layout._footer')