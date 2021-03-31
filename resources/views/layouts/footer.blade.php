 <!--   Core JS Files   -->
 <script src="{{URL::asset('dashboard/assets/js/core/jquery.min.js')}}"></script>
 <script src="{{URL::asset('dashboard/assets/js/core/popper.min.js')}}"></script>
 <script src="{{URL::asset('dashboard/assets/js/core/bootstrap.min.js')}}"></script>
 <script src="{{URL::asset('dashboard/assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
 <!--  Google Maps Plugin    -->
 <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
 <!-- Chart JS -->
 <script src="{{URL::asset('dashboard/assets/js/plugins/chartjs.min.js')}}"></script>
 <!--  Notifications Plugin    -->
 <script src="{{URL::asset('dashboard/assets/js/plugins/bootstrap-notify.js')}}"></script>
 <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
 <script src="{{URL::asset('dashboard/assets/js/paper-dashboard.min.js?v=2.0.1')}}" type="text/javascript"></script>
 <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
 <script src="{{URL::asset('dashboard/assets/demo/demo.js')}}"></script>
 <script src="{{ URL::asset('summernote/summernote-lite.js') }}" type="text/javascript"></script>
 <script src="{{ URL::asset('summernote/tam-emoji/js/config.js') }}" type="text/javascript"></script>
 <script src="{{ URL::asset('summernote/tam-emoji/js/tam-emoji.min.js') }}" type="text/javascript"></script>

 <script>
$(document).ready(function() {
    // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
    demo.initChartsPages();
});
$(document).ready(function() {
    document.emojiSource = '../../summernote/tam-emoji/img';
    $('.summernote').summernote({
        airMode: false,
        fontSizes: ['8', '9', '10', '11', '12', '14', '18'],
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['style']],
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize', 'fontname', 'fontsizeunit']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['color', ['forecolor', 'backcolor']],
            ['para', ['ul', 'ol', 'paragraph', 'style', 'height']],
            // ['height', ['height']],
            ['insert', ['link', 'picture', 'video', 'hr', 'table', 'emoji']],
            ['fullscreen', ['fullscreen']],
        ]
    });
});
 </script>