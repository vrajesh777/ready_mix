@extends('layout.master')
@section('main_content')

<script src="{{ asset('/js/print.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('/css/print.min.css') }}">

{{-- <button type="button" onclick="printJS('{{ url('public/assets/sample.pdf') }}')">
Print PDF
</button>


<embed src="{{ url('public/assets/sample.pdf') }}" id = "Pdf1" name="Pdf1" hidden>
<a onClick="document.getElementById('Pdf1')">Print file</a> --}}

<button type="button" id="printBtn">
Print PDF
</button>

<script type="text/javascript">
	
	function myPrint(){
	  printJS("{{ url('public/assets/sample.pdf') }}");

	  (function () {

        var beforePrint = function () {
            alert('Functionality to run before printing.');
        };

        var afterPrint = function () {
            alert('Functionality to run after printing');
        };

        if (window.matchMedia) {
            var mediaQueryList = window.matchMedia('print');

            mediaQueryList.addListener(function (mql) {
                //alert($(mediaQueryList).html());
                if (mql.matches) {
                    beforePrint();
                } else {
                    afterPrint();
                }
            });
        }

        window.onbeforeprint = beforePrint;
        window.onafterprint = afterPrint;

    }());


	}
	$('#printBtn').click(myPrint);


</script>



@endsection